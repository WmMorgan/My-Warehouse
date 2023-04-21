<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\modules\feedback\models\Feedback $model */
/** @var ActiveForm $form */

$this->title = 'Feedback';
?>
<style>
    .help-block {
        width: 100%;
        margin-top: 0.25rem;
        font-size: 0.875em;
        color: var(--bs-form-invalid-color);
    }
</style>
<div class="row justify-content-center mt-5">
    <h1 class="text-center">-- Feedback --</h1>

<div class="col-lg-6">
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name') ?>
    <?= $form->field($model, 'email') ?>
    <?= $form->field($model, 'phone') ?>
    <?= $form->field($model, 'message') ?>

    <?= $form->field($model, 'verifyCode')->widget(\yii\captcha\Captcha::classname(), [
        'captchaAction' => '/feedback/send/captcha'
    ]) ?>

    <div class="form-group mt-2">
        <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>

</div>
</div>
