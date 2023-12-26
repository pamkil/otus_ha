<?php
/**
 * This view is used by console/controllers/MigrateController.php
 * The following variables are available in this view:
 */

/* @var $className string the new migration class name */

echo "<?php\n";
?>

use console\migrations\migration\Migration;

class <?= $className ?> extends Migration
{
    public const TABLE_NAME = '';
    private string $table = '{{%' . self::TABLE_NAME . '}}';
    private string $user = '{{%user}}';

    public function safeUp()
    {
        $authManager = $this->getAuthManager();

        $this->createTable($this->table, [
            'id' => $this->uuidPrimaryKey(),
            'user_id' => $this->uuid()->null(),
            'created_at' => $this->dateTime()->notNull(),
            'updated_at' => $this->dateTime()->notNull(),
            'deleted_at' => $this->dateTime(),
            $this->addForeign('user_id', 'id', $this->user, 'SET NULL'),
        ]);
    }

    public function safeDown()
    {
        $this->dropTableIfExist($this->table);
    }
}
