<?php

use yii\db\Migration;

/**
 * Class m230421_114253_create_category_table_for_product
 */
class m230421_114253_create_category_table_for_product extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $sql = <<<SQL
CREATE TABLE `category` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(255) NOT NULL UNIQUE,
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
        echo "m230421_114253_create_category_table_for_product cannot be reverted.\n";
        $this->dropTable('{{category}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230421_114253_create_category_table_for_product cannot be reverted.\n";

        return false;
    }
    */
}
