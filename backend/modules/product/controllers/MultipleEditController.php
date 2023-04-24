<?php


namespace app\modules\product\controllers;


use app\modules\product\models\MultipleEditForm;
use backend\controllers\BaseController;
use Yii;
use yii\base\Model;
use yii\web\NotFoundHttpException;

class MultipleEditController extends BaseController
{

    public function actionIndex() {

        if ($this->request->isPost &&
            isset($this->request->post()['values']) == true &&
            $this->request->post()['values'] == true) {

            $values = str_replace(['[', ']'], '', explode(",", $this->request->post()['values']));
            $models = [];
            $formModel = new MultipleEditForm();
            foreach ($values as $key => $v) {
                $formModel->getForm($v);
                $models[$v] = $formModel;
            }

            return $this->render('index', [
                'models' => $models,
            ]);
        } else {
            Yii::$app->session->setFlash('error', "Сначала выберите продукты");
            return $this->redirect(['/product']);
        }
    }

    public function actionStore() {

        try {
            $post = Yii::$app->request->post('MultipleEditForm');
            $_post = [];
            foreach ($post as $k => $value) {
                foreach ($value as $key => $v) {
                    $_post[$key][$k] = $v;
                    $models[$key] = new MultipleEditForm();
                }
            }
            if (MultipleEditForm::loadMultiple($models, $_post, '') && MultipleEditForm::validateMultiple($models)) {
                foreach ($models as $model) {
                    $model->save();
                }
                Yii::$app->session->setFlash('success', "Цены на продукцию успешно сохранены");
                $this->redirect(['/product']);
            }

        } catch (\Exception $e) {
            throw new NotFoundHttpException($e->getMessage());
        }
    }

}