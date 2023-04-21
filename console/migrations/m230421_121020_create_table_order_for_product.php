<?php

use yii\db\Migration;

/**
 * Class m230421_121020_create_table_order_for_product
 */
class m230421_121020_create_table_order_for_product extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $sql = <<<SQL
CREATE TABLE `order` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`product_id` INT NOT NULL,
	`quantity` INT NOT NULL,
	`type` INT NOT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SQL;
        Yii::$app->db->createCommand($sql)->execute();
        Yii::$app->db->createCommand("ALTER TABLE `order` ADD CONSTRAINT `order_fk0` FOREIGN KEY (`product_id`) REFERENCES `product`(`id`);
")->execute();


    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m230421_121020_create_table_order_for_product cannot be reverted.\n";
        $this->dropForeignKey('order_fk0', 'order');
        $this->dropTable('{{order}}');

    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230421_121020_create_table_order_for_product cannot be reverted.\n";

        return false;
    }
    */
}
