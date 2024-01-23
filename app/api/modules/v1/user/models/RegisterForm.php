<?php

declare(strict_types=1);

namespace api\modules\v1\user\models;

use Carbon\Carbon;
use OpenApi\Annotations as OA;
use Yii;
use yii\base\Model;

/**
 * @OA\Schema( title="Форма регистрации пользователя")
 *
 * @property-read User|null $user
 */
class RegisterForm extends Model
{
    /**
     * @OA\Property(
     *     property="first_name",
     *     type="string",
     *     description="",
     *     title="first_name",
     * )
     */
    public ?string $first_name;

    /**
     * @OA\Property(
     *     property="second_name",
     *     type="string",
     *     description="",
     *     title="second_name",
     * )
     */
    public ?string $second_name;

    /**
     * @OA\Property(
     *     property="birthdate",
     *     type="string",
     *     description="format: YYYY-mm-dd",
     *     title="birthdate",
     * )
     */
    public ?string $birthdate;

    /**
     * @OA\Property(
     *     property="biography",
     *     type="string",
     *     description="",
     *     title="biography",
     * )
     */
    public ?string $biography;

    /**
     * @OA\Property(
     *     property="city",
     *     type="string",
     *     description="",
     *     title="city",
     * )
     */
    public ?string $city;

    /**
     * @OA\Property(
     *     property="password",
     *     type="string",
     *     description="",
     *     title="password phrase",
     * )
     */
    public ?string $password;


    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [
                ['first_name', 'second_name', 'birthdate', 'city', 'password', 'biography'],
                'string',
            ],
        ];
    }

    public function createUser(): string|null
    {
        $password_hash = Yii::$app->security->generatePasswordHash($this->password);
        $nowDate = Carbon::now()->toDateTimeString();
        $userId = Yii::$app->db->createCommand(
            <<<SQL
                insert into "user" (
                    "password_hash",
                    "first_name",
                    "second_name",
                    "birthdate",
                    "biography",
                    "city",
                    "created_at",
                    "updated_at"
                )
                values (
                    :password_hash,
                    :first_name,
                    :second_name,
                    :birthdate,
                    :biography,
                    :city,
                    :created_at,
                    :updated_at
                )
                RETURNING id;
            SQL,
            [
                ':password_hash' => $password_hash,
                ':first_name' => $this->first_name,
                ':second_name' => $this->second_name,
                ':birthdate' => $this->birthdate,
                ':biography' => $this->biography,
                ':city' => $this->city,
                ':created_at' => $nowDate,
                ':updated_at' => $nowDate,
            ],
        )
            ->queryScalar();

        return $userId;
    }
}
