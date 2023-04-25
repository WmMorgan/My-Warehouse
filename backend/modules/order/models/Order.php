<?php

namespace app\modules\order\models;

use app\modules\product\models\Product;
use Yii;

/**
 * This is the model class for table "order".
 *
 * @property int $id
 * @property string $products
 * @property int $type
 * @property string $created_at
 * @property string|null $updated_at
 */
class Order extends \yii\db\ActiveRecord
{
    const SELL = "Продана";
    const OUT = "Выпущена";

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'order';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['products', 'type'], 'required'],
            [['products', 'created_at', 'updated_at'], 'safe'],
            [['type'], 'integer'],
        ];
    }

    public function beforeValidate()
    {
        if ($this->type === null)
            $this->type = 1;

        return parent::beforeValidate();
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'products' => 'Products',
            'type' => 'Type',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function getType() {
        return $this->type == 1 ? self::SELL : self::OUT;
    }

    /**
     * @param false $date
     * @return false|int|string|null
     */
    static function getDailyOrderTotal($date = null) {
        return self::find()
            ->select([new \yii\db\Expression('COUNT(id) as total')])
            ->where(['DATE(created_at)'=>$date ?? new \yii\db\Expression('CURDATE()')])
            ->scalar();
    }

    /**9
     * @param null $date
     * @return float|int
     */
    static function getDailyOrderAmount($date = null) {
        $tell = self::find()
            ->where(['DATE(created_at)'=>$date ?? new \yii\db\Expression('CURDATE()')])->all();
        $amount = [];
       foreach ($tell as $_amount) {
           $product = unserialize($_amount->products);
           foreach ($product as $price) {
               $amount[] = $price['price'] * $price['quantity'];
           }
       }
       return array_sum($amount);
    }

}
