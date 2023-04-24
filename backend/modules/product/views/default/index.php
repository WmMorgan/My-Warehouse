<?php

use app\modules\product\models\Product;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\modules\product\models\ProductSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Продукты';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?= common\widgets\Alert::widget() ?>

    <div class="d-flex justify-content-end">
        <?= Html::beginForm([Url::to(['/product/multiple-edit'])], options: ['style' => "margin-right: 20px;"]); ?>
        <input id="values" name="values" value="0" type="hidden">
        <span><?= Html::submitButton('Изменить цени', ['class' => 'btn btn-warning']) ?></span>
        <?= Html::endForm(); ?>

        <span><?= Html::a('Создать продукт', ['create'], ['class' => 'btn btn-success']) ?></span>
    </div>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'id' => 'product',
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            ['class' => 'yii\grid\CheckboxColumn'],
            ['attribute' => 'category_id',
                'value' => 'category.name'],
            'name',
            'description:ntext',
            'price',
            [   'attribute' => 'sale_price',
                'value' => function ($model) {
                    return $model->getSalePrice();
                },
                'filter' => false,
                'format' => 'raw'
            ],
            //'quantity',
            [
                'class' => \app\modules\category\widgets\ActionCColumn::className(),
                'urlCreator' => function ($action, Product $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                }
            ],
        ],
    ]); ?>


</div>
<?php
$js = <<<JS
$('input[type="checkbox"]').bind('change', function() {
    var keys = $("#product").yiiGridView("getSelectedRows");
       var values = JSON.stringify(keys);
       $('#values').val(values);
    });
JS;

$this->registerJs($js);
?>
