<?php

namespace app\modules\product\models;

use app\modules\category\models\Category;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii\web\NotFoundHttpException;

/**
 * This is the model class for table "product".
 *
 * @property int $id
 * @property int $category_id
 * @property string $name
 * @property string $description
 * @property int $price
 * @property int $sale_price
 * @property int $quantity
 * @property string $measure
 * @property int $discount
 * @property string $created_at
 * @property string|null $updated_at
 *
 * @property Category $category
 */
class Product extends \yii\db\ActiveRecord
{
    public $new_sale_price;


    public function afterFind()
    {
        $this->getDiscountPrice();
        parent::afterFind();
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['category_id', 'name', 'price', 'sale_price', 'quantity', 'measure'], 'required'],
            [['category_id', 'price', 'sale_price', 'quantity', 'discount'], 'integer'],
            [['description'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 255],
            [['measure'], 'string', 'max' => 10],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::class, 'targetAttribute' => ['category_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_id' => 'Категория ID',
            'name' => 'Имя',
            'description' => 'Описание',
            'price' => 'Цена',
            'sale_price' => 'Цена продажи',
            'quantity' => 'Количество',
            'measure' => 'Мера',
            'discount' => 'Скидка',
            'created_at' => 'Создан в',
            'updated_at' => 'Обновлено в',
        ];
    }

    /**
     * @return array[]
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'value' => new Expression('NOW()'),
            ],
        ];
    }

    public function getMeasure() {
        return Yii::$app->getModule('product')->getMeasures()[$this->measure];
    }

    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
    }


    /**
     * @throws NotFoundHttpException
     * Товара нет в наличии!
     */
    public function checkStockQuantity() {
        $_cartProduct = Yii::$app->cart->getItem($this->id);
        if($this->quantity < 1)
            throw new NotFoundHttpException();

        if (!empty($_cartProduct) && $this->quantity == $_cartProduct->getQuantity())
            throw new NotFoundHttpException();
    }


    /**
     * @return float|int
     */
    public function getDiscountPrice() {
        $sale = $this->sale_price * $this->discount / 100;
        // new sale price
        $this->new_sale_price = $this->sale_price - $sale;

        return $this->new_sale_price;
    }

    /**
     * @return false|string
     */
    public function getSalePrice() {
        ob_start();
        if ($this->discount) {
            echo '<b style="color:#d00f0f">' . $this->new_sale_price . '</b> (<s>' . $this->sale_price . '</s>)';
        } else {
            echo $this->sale_price;
        }

        return ob_get_clean();
    }

}
