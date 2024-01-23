<?php

declare(strict_types=1);

namespace common\helpers;

use yii\db\ActiveRecord;

class Creator
{
    /**
     * @param ActiveRecord|string $class
     * @param array $row
     * @return ActiveRecord
     */
    public static function createModel(ActiveRecord $class, array $row): ActiveRecord
    {
        $model = $class::instantiate($row);
        /** @var ActiveRecord $modelClass */
        $modelClass = get_class($model);
        $modelClass::populateRecord($model, $row);

        return $model;
    }
}
