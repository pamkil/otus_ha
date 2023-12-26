<?php

use yii\db\Migration;

/**
 * Class m190211_193112_create_tokens
 */
class m190211_193112_create_tokens extends Migration
{
    private $table = '{{%user_token}}';
    private $tableUser = '{{%user}}';

    public function safeUp()
    {
        $this->createTable($this->table, [
            'id' => 'uuid DEFAULT uuid_generate_v4() NOT NULL PRIMARY KEY',
            'user_id' => 'uuid NOT NULL',
            'token' => $this->text()->notNull()->unique(),
            'expired_at' => $this->dateTime()->notNull(),
            'created_at' => $this->dateTime()->notNull(),
            'updated_at' => $this->dateTime()->notNull(),
        ]);

        $this->addForeignKey(
            'fk-user_token-user_id',
            $this->table,
            'user_id',
            $this->tableUser,
            'id',
            'CASCADE',
            'RESTRICT'
        );
    }

    public function safeDown()
    {
        $this->dropTable($this->table);
    }
}
