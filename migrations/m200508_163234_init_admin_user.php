<?php

use yii\db\Migration;

/**
 * Class m200508_163234_init_admin_user
 */
class m200508_163234_init_admin_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->insert('{{%user}}', [
            'username' => 'admin',
            'auth_key' => Yii::$app->getSecurity()->generateRandomString(),
            'password_hash' => Yii::$app->getSecurity()->generatePasswordHash('admin'),
            'email' => 'javlonbek0591@gmail.com',
            'created_at' => time(),
            'updated_at' => time(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->delete('{{%user}}', ['username' => 'admin']);
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200508_163234_init_admin_user cannot be reverted.\n";

        return false;
    }
    */
}
