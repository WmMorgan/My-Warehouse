<?php
namespace app\modules\order\widgets;

use yii\base\Widget;
use yii\helpers\Html;
use yii\web\NotFoundHttpException;

class OrderView extends Widget
{
    public $model;
    public $cart;
    public $attributes = [];

    public function init()
    {
        parent::init();
        if (empty($this->attributes) || empty($this->model)) {
            throw new NotFoundHttpException('Заполните параметры виджета');
        }
    }

    public function run()
    {
        return $this->render('orderview',
            [
                'model' => $this->model,
                'cart' => $this->cart,
                'attr' => $this->attributes,
                ]);
    }
}