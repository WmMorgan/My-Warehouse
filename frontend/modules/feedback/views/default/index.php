<?php
/**
 * @author C_Morgan
 */


use yii\grid\GridView;

echo GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
    ]
]);