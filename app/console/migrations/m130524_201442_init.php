<?php


use console\migrations\migration\Migration;

class m130524_201442_init extends Migration
{
    private string $user = '{{%user}}';

    public function safeUp()
    {
        $this->db->createCommand('CREATE EXTENSION IF NOT EXISTS "uuid-ossp";')->execute();

        $this->createTable($this->user, [
            'id' => $this->uuidPrimaryKey(),
            'password_hash' => $this->text()->notNull(),
            'first_name' => $this->text(),
            'second_name' => $this->text(),
            'birthdate' => $this->dateTime(),
            'biography' => $this->text(),
            'city' => $this->text(),
            'created_at' => $this->dateTime()->notNull(),
            'updated_at' => $this->dateTime()->notNull(),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable($this->user);
    }
}
