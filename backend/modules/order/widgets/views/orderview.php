<?php

use yii\helpers\Html;
use yii\helpers\Url;

if (!empty($cart)):
?>
<table class="table table-striped table-bordered detail-view">
    <tbody>
    <tr>
        <?php
        foreach ($attr as $value):
            echo '<th>' . $model->getAttributeLabel($value) . '</th>';
        endforeach;
        ?>
        <th><?= $model->getAttributeLabel('quantity') ?></th>
        <th>*</th>
        <th>Итог</th>
    </tr>

    <?php foreach ($cart as $key => $val):
        $pro = $val->getProduct();
        ?>
        <tr>
            <?php foreach ($attr as $value):
                // sotuv narxini chegirma bo'yicha olamiz.
                if ($value == 'sale_price'):
                    echo '<td>'.$pro->getSalePrice() .'</td>';
                else:
                ?>

                <!-- -->
                <td><?= $pro->{$value} ?></td>
            <?php
                endif;
                endforeach; ?>
            <td><?= $val->getQuantity() ?> <?= $pro->getMeasure() ?></td>
            <td><button onclick="addToCart('<?=$key?>', '<?=$val->getQuantity()?>')" class="btn btn-danger" data-id="<?=$key?>"><i class="fas fa-minus"></i></button>
                <button onclick="addToCart('<?=$key?>')" class="btn btn-success" data-id="<?=$key?>"><i class="fas fa-plus"></i></button></td>
            <th><?= $val->getCost()?></th>
        </tr>
    <?php endforeach;
    $jami = Yii::$app->cart->getTotalCost();
    ?>
    <tr style="background-color: rgb(103, 255, 0, 22%)">
    <th colspan="3">Итог:</th>
    <th colspan="2"><?= number_format($jami, 0, ' ')?> $</th>
    </tr>
    </tbody>
</table>
    <div class="d-flex justify-content-end mb-5">
        <?php
        echo Html::beginForm(['create-order']);
        echo Html::submitButton('Подтвердить', ['class' => 'btn btn-success']);
        echo Html::endForm();
        ?>
    </div>
<?php
endif;

$ajax_url = Url::to(['add-cart-ajax']);
$js = <<<JS
    
$("#plus").on('click', function(e) {
    var select_product_id = $("#search").val();
    addToCart(select_product_id);
});


function addToCart(id, quantity = null) {
            $.ajax({
                type: "POST",
                url: "$ajax_url",
                data: {product_id: id, minus: quantity},
                success: function (response) {
                    $("#add-cart-response").html(response);
                },
                error: function (exception, status, error) {
                    if (exception.status == 404) {
                        alert("Товара нет в наличии!");
                    }
                }
            });
        }

JS;
$this->registerJs($js, \yii\web\View::POS_END);