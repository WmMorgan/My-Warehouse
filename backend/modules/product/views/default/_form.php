<?php

use app\modules\category\models\Category;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\modules\product\models\Product $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="product-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-lg-6">
            <?php
            // получаем всех авторов
            $category = Category::find()->all();
            // формируем массив, с ключем равным полю 'id' и значением равным полю 'name'
            $items = ArrayHelper::map($category,'id','name');
            $params = [
                'prompt' => 'Выберите категория'
            ];
            echo $form->field($model, 'category_id')->dropDownList($items,$params);

            ?>
        </div>
        <div class="col-lg-6">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-lg-6">
        <?= $form->field($model, 'price')->textInput() ?>
        </div>
        <div class="col-lg-6">
        <?= $form->field($model, 'sale_price')->textInput() ?>
        </div>
        <div class="col-lg-6">
        <?= $form->field($model, 'quantity')->textInput() ?>
        </div>
        <div class="col-lg-2">
        <?= $form->field($model, 'measure')->dropDownList(Yii::$app->getModule('product')->getMeasures()) ?>
        </div>
        <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>


        <div class="form-group">
            <?= Html::submitButton('Создать', ['class' => 'btn btn-success']) ?>
        </div>

    </div>
</div>

<?php ActiveForm::end(); ?>

</div>
