<?php


namespace backend\controllers;


use yii\filters\AccessControl;
use yii\web\Controller;

class BaseController extends Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                ],
            ]
        ];
    }

}