<?php

declare(strict_types=1);

namespace common\models;

use Carbon\Carbon;
use common\helpers\Creator;
use Yii;
use yii\base\Exception;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * User model
 *
 * @property string $id [uuid]
 * @property string $first_name
 * @property string $second_name
 * @property string $birthdate
 * @property string $biography
 * @property string $password_reset_token
 * @property string $city
 * @property integer $created_at [timestamp(0)]
 * @property integer $updated_at [timestamp(0)]
 * @property-read string $password write-only password
 */
class User extends ActiveRecord implements IdentityInterface
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%user}}';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors(): array
    {
        $behaviors = parent::behaviors();
        $behaviors['timestamp'] = [
            'class' => TimestampBehavior::class,
            'value' => Carbon::now()->toDateTimeString(),
        ];

        return $behaviors;
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [
                [
                    'first_name',
                    'second_name',
                    'birthdate',
                    'biography',
                    'city',
                ],
                'string',
            ],
            [
                ['password'],
                'safe',
            ],
        ];
    }

    /**
     * {@inheritdoc}
     * @throws \yii\db\Exception
     */
    public static function findIdentity($id)
    {
        $row = Yii::$app->db->createCommand(
            <<<SQL
                select "id", "first_name", "second_name", "birthdate", "biography", "city", "created_at", "updated_at"
                from "user"
                where "id" = :id
            SQL,
        )
            ->bindValues(['id' => $id])
            ->queryOne();

        if ($row) {
            return Creator::createModel(new static(), $row);
        }

        return null;
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken(
        $token,
        $type = null,
    ): ActiveRecord|IdentityInterface|null {
        return self::findIdentity($token);
    }

    /**
     * {@inheritdoc}
     */
    public function getId(): int|string
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     * @throws Exception
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     * @throws Exception
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }


    /**
     * @return ActiveQuery
     */
    public function getProfile(): ActiveQuery
    {
        return $this->hasMany(ProjectUser::class, ['user_id' => 'id'])
            ->inverseOf('user');
    }
}
