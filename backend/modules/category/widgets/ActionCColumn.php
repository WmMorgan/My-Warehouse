<?php

namespace app\modules\category\widgets;

/**
 * Class ActionCColumn
 * @package app\modules\category\widgets
 */
class ActionCColumn extends \yii\grid\ActionColumn {

    public $icons = [
        'eye-open' => '<i class="far fa-eye"></i>',
        'pencil' => '<i class="far fa-edit"></i>',
        'trash' => '<i class="fas fa-trash"></i>',
        ];

}

