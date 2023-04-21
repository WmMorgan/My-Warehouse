<?php

namespace app\modules\feedback\controllers;

use app\modules\feedback\models\FeedbackSearch;
use Yii;
use yii\web\Controller;

/**
 * Default controller for the `feedback` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new FeedbackSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->get());

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

}
