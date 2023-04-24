<?php

namespace app\modules\order\controllers;

use app\modules\order\models\Order;
use app\modules\product\models\Product;
use backend\controllers\BaseController;
use Yii;
use yii\db\Query;
use yii\web\NotFoundHttpException;

/**
 * Default controller for the `order` module
 */
class DefaultController extends BaseController
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $model = new Product();
        $cart = \Yii::$app->cart->getItems();

        return $this->render('index',
            ['model' => $model, 'cart' => $cart]);
    }

    /**
     * @param null $q
     * @param null $id
     * @return \string[][]
     */
    public function actionProductList($q = null, $id = null)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];
        if (!is_null($q)) {
            $query = new Query;
            $query->select('id, name AS text')
                ->from('product')
                ->where(['like', 'name', $q])
                ->limit(20);
            $command = $query->createCommand();
            $data = $command->queryAll();
            $out['results'] = array_values($data);
        } elseif ($id > 0) {
            $out['results'] = ['id' => $id, 'text' => Product::findOne($id)->name];
        }
        return $out;
    }

    /**
     * @return string
     */
    public function actionAddCartAjax()
    {
        $request = $this->request->post();
        $quantity = 1;
        if (!empty($request['product_id'])) {
            $product = Product::findOne($request['product_id']);
            $cart = \Yii::$app->cart;

            if ($request['minus'] == true) {
                $quantity = (int)$request['minus'];
                $quantity -= 1;
                if ($quantity < 1) $cart->remove($request['product_id']);
                $cart->change($request['product_id'], $quantity);
            } else {
                $product->checkStockQuantity();
                $cart->add($product, $quantity);
            }
            $cart = $cart->getItems();
            return $this->renderPartial('add-cart-ajax', ['cart' => $cart, 'model' => $product]);
        } else {
            $res = "Ajax failed";
            return $res;
        }

    }

    /**
     * Создать закази
     */
    public function actionCreateOrder()
    {
        if ($this->request->post()) {

            $cart = \Yii::$app->cart;
            $product = $cart->getItems();
            $json = [];

            $transaction = Yii::$app->db->beginTransaction();
            try {
                foreach ($product as $key => $value) {
                    $prod = $value->getProduct();
                    $json[] = ['id' => $prod->id, 'price' => $prod->getDiscountPrice(), 'quantity' => $value->getQuantity()];
                    $prod->quantity -= $value->getQuantity();
                    $prod->save(false);
                }
                $model = new Order();
                $model->products = serialize($json);
                if ($model->save()) {
                    $transaction->commit();
                    $cart->clear();
                }

                Yii::$app->session->setFlash('success', "Ваш заказ успешно создан");
                $this->redirect(['index']);
            } catch (\Exception $e) {
                $transaction->rollback();
                echo $e->getMessage();
            }

        } else {
            $this->redirect(['index']);
        }
    }


}
