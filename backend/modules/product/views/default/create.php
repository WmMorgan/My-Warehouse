<?php

use yii\bootstrap5\Breadcrumbs;
use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\modules\product\models\Product $model */

$this->title = 'Создать продукт';
$this->params['breadcrumbs'][] = ['label' => 'Продукты', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="product-create">
            <?php echo Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]); ?>
            <h1><?= Html::encode($this->title) ?></h1>

            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>

        </div>
    </div>
