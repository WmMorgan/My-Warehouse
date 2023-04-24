<?php

namespace console\controllers;

use Faker\Factory;
use Yii;

/**
 * Class DatafillController
 * @package console\controllers
 */
class DatafillController extends \yii\console\Controller
{
    /**
     * Заполнение базы ложной информацией для теста
     */
    public function actionInit() {
        $faker = Factory::create();

        $categories = [];
        for ($i=0; $i<10; $i++) {
            $categories[] = [$faker->colorName];
        }
        Yii::$app->db->createCommand()->batchInsert('category', ['name'], $categories)->execute();

        $products = [];
        for ($i=0; $i<50; $i++) {
            $products[] = [
                $faker->word,
                $faker->numberBetween(1, 10),
                $faker->text,
                $price = $faker->numberBetween(1000, 10000),
                $price-$faker->numberBetween(100, 500),
                $faker->numberBetween(1, 50),
                $faker->numberBetween(0, 3)];
        }
        Yii::$app->db->createCommand()->batchInsert('product',
            ['name', 'category_id', 'description', 'price', 'sale_price', 'quantity', 'measure'], $products)->execute();
        echo "========= Init success =========";
        return 0;
    }
}