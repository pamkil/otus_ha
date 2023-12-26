<?php

namespace console\migrations\migration;

use Yii;
use yii\base\InvalidConfigException;
use yii\db\Exception;
use yii\db\Migration as MigrationBase;
use yii\rbac\DbManager;

/**
 * Class m191002_172948_create_notification
 */
class Migration extends MigrationBase
{
    public function uuidPrimaryKey()
    {
        return $this->getDb()->getSchema()
            ->createColumnSchemaBuilder('uuid DEFAULT uuid_generate_v4()', null)
            ->notNull()
            ->append('PRIMARY KEY');
    }

    public function uuid()
    {
        return $this->getDb()->getSchema()
            ->createColumnSchemaBuilder('uuid', null);
    }

    /**
     * @param string ...$columns
     * @return string
     */
    protected function addPrimaryByColumns(string ...$columns): string
    {
        $cols = [];
        foreach ($columns as $column) {
            $cols[] = "[[$column]]";
        }
        $cols = implode(', ', $cols);

        return "PRIMARY KEY ($cols)";
    }

    protected function addForeign(
        string $localNameColumn,
        string $referenceColumn,
        string $referenceTable,
        string $onDelete = 'CASCADE',
        string $onUpdate = 'CASCADE',
    ): string {
        return 'FOREIGN KEY ([[' . $localNameColumn . ']]) REFERENCES '
            . $referenceTable . ' ([[' . $referenceColumn . ']])'
            . $this->buildFkClause(
                $onDelete ? ('ON DELETE ' . $onDelete) : '',
                $onUpdate ? ('ON UPDATE ' . $onUpdate) : '',
            );
    }

    protected function buildFkClause($delete = '', $update = ''): string
    {
        return implode(' ', ['', $delete, $update]);
    }

    /**
     * Не реализованно в полном объем
     * @param $name
     * @param $table
     * @throws Exception
     */
    public function dropForeignKeyIfExist($name, $table): void
    {
        $tableSchema = Yii::$app->db->schema->getTableSchema($table, true);

        if ($tableSchema && array_key_exists($name, $tableSchema->foreignKeys)) {
            $time = $this->beginCommand("drop foreign key $name IF EXISTS from table $table");
            $this->db->createCommand()->dropForeignKey($name, $table)->execute();
            $this->endCommand($time);
        }
    }

    protected function dropTableIfExist(string $table): void
    {
        $tableSchema = Yii::$app->db->schema->getTableSchema($table, true);

        if ($tableSchema !== null) {
            $time = $this->beginCommand("drop table if exists $table");
            $sql = 'DROP TABLE IF EXISTS ' . $this->db->quoteTableName($table);
            $this->db->createCommand($sql)->execute();
            $this->endCommand($time);
        }
    }

    /**
     * @return DbManager
     * @throws InvalidConfigException
     */
    protected function getAuthManager(): DbManager
    {
        $authManager = Yii::$app->getAuthManager();
        if (!$authManager instanceof DbManager) {
            throw new InvalidConfigException(
                'You should configure "authManager" component to use database before executing this migration.'
            );
        }

        return $authManager;
    }
}
