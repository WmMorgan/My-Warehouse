<?php


namespace app\modules\product\models;


use yii\base\Model;

/**
 * Class MultipleEditForm
 * @package app\modules\product\models
 */
class MultipleEditForm extends \yii\base\Model
{
    public $name = [];
    public $price = [];
    public $sale_price = [];
    public $id;

    public function rules()
    {
        return [
            [['price', 'sale_price'], 'required'],
            [['price', 'sale_price'], 'integer'],
        ];
    }

    /**
     * @param $id
     */
    public function getForm($id) {
        $product = Product::findOne($id);
        $this->price[$id] = $product->price;
        $this->name[$id] = $product->name;
        $this->sale_price[$id] = $product->sale_price;
    }

    /**
     * @param array $models
     * @param array $data
     * @param null $formName
     * @return bool
     */
    static function loadMultiple($models, $data, $formName = null)
    {
        foreach ($models as $i => $model) {
        $model->id = $i;
        }
            return parent::loadMultiple($models, $data, $formName);
    }

    /**
     * Цены на продукцию успешно сохранены
     */
    public function save() {
        $model = Product::findOne($this->id);
        $model->price = $this->price;
        $model->sale_price = $this->sale_price;
        $model->save();
    }


    public function attributeLabels()
    {
        return [
           'name' => "Имя",
           'price' => "Цена",
           'sale_price' => "Цена продажи",
        ];
    }
}