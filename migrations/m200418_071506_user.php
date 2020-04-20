<?php

use yii\db\Migration;

/**
 * Class m200418_071506_user
 */
class m200418_071506_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user}}', [
            'id'                   => $this->primaryKey(),
            'email'                => $this->string(255)->notNull(),
            'password'             => $this->string(60)->notNull(),
            'authKey'              => $this->string(32)->notNull(),
            'accessToken'          => $this->string(32)->null(),
            'name'                 => $this->string(255)->null(),
            'surname'              => $this->string(255)->null(),
            'phone'                => $this->string(255)->null(),
            'sex'                  => $this->string(255)->null(),
            'birthday'             => $this->date()->null(),
            'created_at'           => $this->integer()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%user}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200418_071506_user cannot be reverted.\n";

        return false;
    }
    */
}
