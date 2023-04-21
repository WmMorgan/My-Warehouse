<?php
namespace console\controllers;

use Yii;
use yii\console\Controller;

/**
 * Class RbacController
 * @package console\controllers
 */
class RbacController extends Controller
{
    /**
     * @throws \Exception
     */
    public function actionInit()
    {
        $auth = Yii::$app->authManager;

        $rule = new UserGroupRule;
        $auth->add($rule);

        $admin = $auth->createRole('admin');
        $admin->ruleName = $rule->name;
        $auth->add($admin);

        // another role here...
    }
}