<?php
/**
 * @author C_Morgan
 */

// The controller action that will render the list
$url = \yii\helpers\Url::to(['product-list']);

// The widget
use app\modules\order\widgets\OrderView;
use kartik\select2\Select2;

// or kartik\select2\Select2
use yii\bootstrap5\Breadcrumbs;
use yii\helpers\Html;
use yii\web\JsExpression;


$this->title = 'Создать заказ';
$this->params['breadcrumbs'][] = ['label' => 'Продукты', 'url' => ['/product']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <?php echo Breadcrumbs::widget([
        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
    ]); ?>
    <h1><?= Html::encode($this->title) ?></h1>
    <?= common\widgets\Alert::widget() ?>

    <div class="col-lg-6">
        <?php
        echo Select2::widget([
            'id' => "search",
            'name' => 'product',
//    'data' => $data,
            'options' => ['placeholder' => 'Поиск продукта...'],
            'pluginOptions' => [
                'allowClear' => true,
                'minimumInputLength' => 3,
                'language' => [
                    'errorLoading' => new JsExpression("function () { return 'Waiting for results...'; }"),
                ],
                'ajax' => [
                    'url' => $url,
                    'dataType' => 'json',
                    'data' => new JsExpression('function(params) { return {q:params.term}; }')
                ],
                'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                'templateResult' => new JsExpression('function(product) { return product.text; }'),
                'templateSelection' => new JsExpression('function (product) { return product.text; }'),
            ],
        ]);
        ?>
    </div>
    <div class="col-lg-1">
        <button id="plus" class="btn btn-warning"><i class="fas fa-plus"></i></button>
    </div>
</div>

<div class="row mt-5">
    <div id="add-cart-response" class="col-lg-10">
        <?= OrderView::widget([
            'model' => $model,
            'cart' => $cart,
            'attributes' => ['name', 'sale_price'],
        ]); ?>
    </div>
</div>




