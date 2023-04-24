<?php

use eseperio\gridview\ExportableGridview as GridView;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Остатки';
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    .export {
        float: right;
        margin-bottom: 20px;
    }
</style>
<div class="morgan">

    <h1><?= Html::encode($this->title) ?></h1>
    <?= common\widgets\Alert::widget() ?>

    <div class="d-flex justify-content-end">
        <?= Html::beginForm([Url::to(['/product/remains/make-discount'])], options: ['style' => "margin-bottom: 20px;"]); ?>
        <input id="values" name="values" value="0" type="hidden">
        <span><?= Html::submitButton('Сделать скидку %', ['class' => 'btn btn-warning']) ?></span>
        <?= Html::endForm(); ?>
    </div>
    <?php
    echo GridView::widget([
        'id' => 'remains',
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            ['class' => 'yii\grid\CheckboxColumn'],
            'name',
            [
                'attribute' => 'quantity',
                'value' => function ($model, $key, $index, $column) {
                    return $model->quantity . ' ' . $model->getMeasure();
                },
                'format' => 'raw',
                'filter' => false
            ],
            ['attribute' => 'price', 'filter' => false],
            ['attribute' => 'sale_price',
                'value' => function ($model) {
                    return $model->getSalePrice();
                },
                'filter' => false,
                'format' => 'raw'
            ],
            ['attribute' => 'discount', 'filter' => false],
        ],
        'layout' => '{export} {summary} {items} {pager}',
        'fileName' => 'Остатки.xls',
        'exportLinkOptions' => ['label' => 'Скачать xls', 'class' => 'export btn btn-primary', 'target' => '_blank']
    ]);

    ?>

</div>

<?php
$js = <<<JS
$('input[type="checkbox"]').bind('change', function() {
    var keys = $("#remains").yiiGridView("getSelectedRows");
       var values = JSON.stringify(keys);
       $('#values').val(values);
    });
JS;

$this->registerJs($js);
?>

