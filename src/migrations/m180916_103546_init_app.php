<?php

use yii\db\Migration;

/**
 * Class m180916_103546_init_app
 */
class m180916_103546_init_app extends Migration
{
    /**
     * {@inheritdoc}
     * @throws \yii\base\Exception
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull()->unique(),
            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string()->unique(),
            'email' => $this->string()->notNull()->unique(),
            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at' => $this->integer()->unsigned()->notNull(),
            'updated_at' => $this->integer()->unsigned()->notNull(),
        ], $tableOptions);

        $this->insert('{{%user}}', array(
            'email' => 'test@test.dev',
            'username' => 'test',
            'password_hash' => Yii::$app->security->generatePasswordHash('test'),
            'auth_key' => Yii::$app->security->generateRandomString(),
            'created_at' => $time = time(),
            'updated_at' => $time,
        ));

        $this->createTable('{{%link}}', [
            'id' => $this->primaryKey(),
            'url' => $this->string()->notNull(),
            'hash' => $this->string()->notNull()->unique(),
            'counter' => $this->integer()->notNull()->defaultValue(0),
            'expiration' => $this->dateTime(),
            'created' => $this->dateTime()->notNull()->comment('Дата создания'),
            'created_by' => $this->integer(11)->notNull()->comment('Пользователь'),
        ], $tableOptions);

        $this->addForeignKey('fk_link_created_by', '{{%link}}', 'created_by', '{{%user}}', 'id', 'CASCADE', 'CASCADE');
        $this->createIndex('idx_fk_link_created_by', '{{%link}}', 'created_by');

        $this->createTable('{{%link_stat}}', [
            'id' => $this->primaryKey(),
            'link_id' => $this->integer(11)->notNull(),
            'datetime' => $this->dateTime()->notNull(),
            'ip' => $this->string(11)->notNull(),
            'country' => $this->string(),
            'city' => $this->string(),
            'user_agent' => $this->string()->notNull(),
            'os' => $this->string(),
            'os_version' => $this->string(),
            'browser' => $this->string(),
            'browser_version' => $this->string(),
        ], $tableOptions);

        $this->addForeignKey('fk_link_stat_link_id', '{{%link_stat}}', 'link_id', '{{%link}}', 'id', 'CASCADE', 'CASCADE');
        $this->createIndex('idx_fk_link_stat_link_id', '{{%link_stat}}', 'link_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        try {
            $this->dropTable('{{%link_stat}}');
            $this->dropTable('{{%link}}');
            $this->dropTable('{{%user}}');
            return true;
        } catch (\Exception $exception) {
            echo "m180916_103546_init_app cannot be reverted.\n";
            return false;
        }
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180916_103546_init_app cannot be reverted.\n";

        return false;
    }
    */
}
