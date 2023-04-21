<?php


use yii\db\Migration;

/**
 * Class m180322_183353_add_admin_user
 */
class m230421_095324_add_admin_account_to_user_table extends Migration
{

    /**
     * Table name
     *
     * @var string
     */
    private $_user = "{{%user}}";

    /**
     * Runs for the migate/up command
     *
     * @return null
     */
    public function safeUp()
    {
        $time = time();
        $password_hash = Yii::$app->getSecurity()->generatePasswordHash('admin');
        $auth_key = Yii::$app->security->generateRandomString();
        $table = $this->_user;

        $sql = <<<SQL
        INSERT INTO {$table}
        (`username`, `email`,`password_hash`, `auth_key`, `created_at`, `updated_at`, `group`)
        VALUES
        ('admin', 'admin@yoursite.com',  '$password_hash', '$auth_key', {$time}, {$time}, '1')
SQL;
        Yii::$app->db->createCommand($sql)->execute();

    }

    /**
     * Runs for the migate/down command
     *
     * @return null
     */
    public function safeDown()
    {
        $this->delete($this->_user, ['username' => 'admin']);

    }

}
