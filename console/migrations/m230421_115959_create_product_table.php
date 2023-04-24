<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%product}}`.
 */
class m230421_115959_create_product_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $sql = <<<SQL
CREATE TABLE `product` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`category_id` INT NOT NULL,
	`name` VARCHAR(255) NOT NULL,
	`description` TEXT NOT NULL,
	`price` INT NOT NULL,
	`sale_price` INT NOT NULL,
	`quantity` INT NOT NULL,
	`measure` VARCHAR(10) NOT NULL,
	`discount` INT NOT NULL DEFAULT '0',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SQL;
        Yii::$app->db->createCommand($sql)->execute();
        Yii::$app->db->createCommand("ALTER TABLE `product` ADD CONSTRAINT `product_fk0` FOREIGN KEY (`category_id`) REFERENCES `category`(`id`);")->execute();

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('product_fk0', 'product');
        $this->dropTable('{{product}}');
    }
}
