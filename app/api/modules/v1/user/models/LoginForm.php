<?php

declare(strict_types=1);

namespace api\modules\v1\user\models;

use Carbon\CarbonImmutable;
use Exception;
use Lcobucci\Clock\SystemClock;
use OpenApi\Annotations as OA;
use Yii;
use yii\base\Model;
use yii\web\IdentityInterface;

/**
 * @OA\Schema(required={"id","password"}, title="Форма входа пользователя")
 */
class LoginForm extends Model
{
    /**
     * @OA\Property(
     *     property="id",
     *     type="string",
     *     description="username of User",
     *     title="username",
     * )
     */
    public ?string $id;

    /**
     * @OA\Property(
     *     property="password",
     *     type="string",
     *     description="password of User",
     *     title="password",
     * )
     */
    public ?string $password;

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [['id', 'password'], 'required'],
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params): void
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Incorrect username or password.');
            }
        }
    }

    /**
     * @throws Exception
     */
    public function auth(): string|null
    {
        if (!$this->validate()) {
            return null;
        }
        $userId = $this->getUser()->id;
        $expire = Yii::$app->params['token_access_expire'];

        $jwt = Yii::$app->jwt;
        $dateNow = CarbonImmutable::instance(SystemClock::fromUTC()->now());
        $dateExpire = $dateNow->addSeconds($expire);
        $tokenBuilder = $jwt->getBuilder()
            ->canOnlyBeUsedAfter($dateNow)
            ->identifiedBy($userId)
            ->issuedAt($dateNow)
            ->expiresAt($dateExpire);

        foreach ($data ?? [] as $name => $value) {
            $tokenBuilder->withClaim($name, $value);
        }

        return $tokenBuilder->getToken(
            $jwt->getConfiguration()->signer(),
            $jwt->getConfiguration()->signingKey(),
        )
            ->toString();
    }

    public function getUser(): IdentityInterface
    {
        if ($this->_user === null) {
            $this->_user = User::findIdentity($this->id);
        }

        return $this->_user;
    }
}
