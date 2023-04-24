<?php

use yii\bootstrap5\Breadcrumbs;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\modules\product\models\Product $model */
/** @var ActiveForm $form */

$this->title = 'Изменить цену';
$this->params['breadcrumbs'][] = ['label' => 'Продукты', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="multiple-edit-index">
    <?php echo Breadcrumbs::widget([
        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
    ]); ?>
    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin([
        'action' => 'multiple-edit/store',
        'fieldConfig' => [
            'template' => "{input}\n{hint}\n{error}",
        ],
    ]);?>
    <div class="row">
        <div class="col-lg-4 font-weight-bold mb-lg-2"><?= current($models)->getAttributeLabel('name') ?></div>
        <div class="col-lg-2 font-weight-bold mb-lg-2"><?= current($models)->getAttributeLabel('price') ?></div>
        <div class="col-lg-2 font-weight-bold mb-lg-2"><?= current($models)->getAttributeLabel('sale_price') ?></div>
        <div class="col-lg-4"></div>
    <?php foreach ($models as $index => $model):
    ?>
        <div class="col-lg-4">
        <?= $form->field($model, "name[$index]")->textInput(['disabled' => true]) ?>
        </div>
        <div class="col-lg-2">
        <?= $form->field($model, "price[$index]") ?>
        </div>
        <div class="col-lg-2">
        <?= $form->field($model, "sale_price[$index]") ?>
        </div>
        <div class="col-lg-4"></div>

    <?php endforeach; ?>
        <div class="form-group">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div><!-- multiple-edit-index -->
