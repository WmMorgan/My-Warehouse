<?php
namespace app\modules\product\controllers;


use app\modules\product\models\MakeDiscount;
use app\modules\product\models\ProductSearch;
use backend\controllers\BaseController;
use Yii;
use yii\web\NotFoundHttpException;

/**
 * Class RemainsController
 * @package app\modules\product\controllers
 */
class RemainsController extends BaseController {

    public function actionIndex() {
        $searchModel = new ProductSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionMakeDiscount() {

        if ($this->request->isPost &&
            isset($this->request->post()['values']) == true &&
            $this->request->post()['values'] == true) {

            $values = str_replace(['[', ']'], '', explode(",", $this->request->post()['values']));
            $models = [];
            $formModel = new MakeDiscount();
            foreach ($values as $key => $v) {
                $formModel->getForm($v);
                $models[$v] = $formModel;
            }

            return $this->render('make-discount', [
                'models' => $models,
            ]);
        } else {
            Yii::$app->session->setFlash('error', "Сначала выберите продукты");
            return $this->redirect(['/product/remains']);
        }
    }

    public function actionDiscountStore() {

        try {
            $post = Yii::$app->request->post('MakeDiscount');
            $_post = [];
            foreach ($post as $k => $value) {
                foreach ($value as $key => $v) {
                    $_post[$key][$k] = $v;
                    $models[$key] = new MakeDiscount();
                }
            }
            if (MakeDiscount::loadMultiple($models, $_post, '') && MakeDiscount::validateMultiple($models)) {
                foreach ($models as $model) {
                    $model->save();
                }
                Yii::$app->session->setFlash('success', "Скидки успешно установлены");
                $this->redirect(['/product/remains']);
            }

        } catch (\Exception $e) {
            throw new NotFoundHttpException($e->getMessage());
        }
    }

}