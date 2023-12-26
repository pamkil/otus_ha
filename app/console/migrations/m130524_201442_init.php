<?php

use yii\db\Migration;

class m130524_201442_init extends Migration
{
    private $table = '{{%user}}';
    public function safeUp()
    {
        $this->db->createCommand('CREATE EXTENSION IF NOT EXISTS "uuid-ossp";')->execute();

        $this->createTable($this->table, [
            'id' => 'uuid DEFAULT uuid_generate_v4() NOT NULL PRIMARY KEY',
            'username' => $this->text()->notNull()->unique(),
            'auth_key' => $this->text()->notNull(),
            'password_hash' => $this->text()->notNull(),
            'password_reset_token' => $this->text()->unique(),
            'email' => $this->text()->notNull()->unique(),
            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at' => $this->dateTime()->notNull(),
            'updated_at' => $this->dateTime()->notNull(),
            'deleted_at' => $this->dateTime(),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable($this->table);
    }
}
