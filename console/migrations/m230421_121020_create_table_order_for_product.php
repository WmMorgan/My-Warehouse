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
	`products` JSON NOT NULL,
	`type` INT NOT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SQL;
        Yii::$app->db->createCommand($sql)->execute();

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m230421_121020_create_table_order_for_product cannot be reverted.\n";
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
