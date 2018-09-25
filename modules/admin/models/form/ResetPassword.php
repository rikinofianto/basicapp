<?php

namespace app\modules\admin\models\form;

use Yii;
use app\modules\admin\models\User;
use yii\base\InvalidParamException;
use yii\base\Model;

/**
 * Password reset form
 */
class ResetPassword extends Model
{
    public $password;
    /**
     * @var User
     */
    private $_user;
    private $resetProvider;

    /**
     * Creates a form model given a token.
     *
     * @param  string $token
     * @param  array $config name-value pairs that will be used to initialize the object properties
     * @throws \yii\base\InvalidParamException if token is empty or not valid
     */
    public function __construct($token, $config = [])
    {
        Yii::$container->setSingleton('app\modules\admin\components\dal\IResetProvider',
            'app\modules\admin\components\dal\UserProvider');
        $this->resetProvider = Yii::$container->get('app\modules\admin\components\dal\IResetProvider');

        if (empty($token) || !is_string($token)) {
            throw new InvalidParamException('Password reset token cannot be blank.');
        }
        $this->_user = $this->resetProvider->findByPasswordResetToken($token);
        if (!$this->_user) {
            throw new InvalidParamException('Wrong password reset token.');
        }
        parent::__construct($config);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['password', 'required'],
            ['password', 'string', 'min' => 6],
        ];
    }
}
