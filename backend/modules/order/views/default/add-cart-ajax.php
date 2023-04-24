<?php

use app\modules\order\widgets\OrderView;

?>

<?= OrderView::widget([
    'model' => $model,
    'cart' => $cart,
    'attributes' => ['name', 'sale_price'],
]); ?>
