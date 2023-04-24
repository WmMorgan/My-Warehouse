<?php


namespace app\modules\order\controllers;


use app\modules\order\models\Order;
use backend\controllers\BaseController;

class ReportByDateController extends BaseController
{

    public function actionIndex()
    {
        if ($this->request->isAjax && !empty($this->request->post()['date'])) {
            $total = Order::getDailyOrderTotal($this->request->post()['date']);
            $amount = Order::getDailyOrderAmount($this->request->post()['date']);
            return $this->renderPartial('index', compact('amount', 'total'));
        } else {
            return '404';
        }
    }

}