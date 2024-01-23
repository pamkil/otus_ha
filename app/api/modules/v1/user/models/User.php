<?php

declare(strict_types=1);

namespace api\modules\v1\user\models;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(title="Пользователь")
 */
class User extends \common\models\User
{
    /**
     * @OA\Property(property="id", type="string", format="uuid")
     * @OA\Property(property="first_name", type="string")
     * @OA\Property(property="second_name", type="string")
     * @OA\Property(property="birthdate", type="string")
     * @OA\Property(property="biography", type="string")
     * @OA\Property(property="city", type="string")
     *
     * @return array
     */
    public function fields(): array
    {
        return [
            'id',
            'first_name',
            'second_name',
            'birthdate',
            'biography',
            'city',
        ];
    }
}
