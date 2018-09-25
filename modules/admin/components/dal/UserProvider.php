<?php

namespace app\modules\admin\components\dal;

use Yii;
use app\modules\admin\models\User;
use app\modules\admin\models\searchs\User as UserSearch;

class UserProvider implements
    \app\modules\admin\components\dal\IUserProvider,
    \app\modules\admin\components\dal\ILoginProvider,
    \app\modules\admin\components\dal\IResetProvider,
    \app\modules\admin\components\dal\IMessageUserProvider
{
    private static $user;

    public function userSearchInstance()
    {
        return new UserSearch();
    }

    public function findByUsername($username)
    {
        return User::findOne(['username' => $username, 'status' => User::STATUS_ACTIVE]);
    }

    public function createUser($model)
    {
        $user = new User();
        $user->username = $model->username;
        $user->email = $model->email;
        $user->setPassword($model->password);
        $user->generateAuthKey();
        if ($user->validate() && $user->save()) {
            return $user;
        }
        return false;
    }

    public function changePassword($model)
    {
        $user = Yii::$app->user->identity;
        $user->setPassword($model->newPassword);
        $user->generateAuthKey();
        return $user->save();
    }

    /**
     * Sends an email with a link, for resetting the password.
     *
     * @return boolean whether the email was send
     */
    public function passwordResetRequest($email)
    {
        /* @var $user User */
        $user = User::findOne([
            'status' => User::STATUS_ACTIVE,
            'email' => $email,
        ]);

        if (!empty($user)) {
            if (!User::isPasswordResetTokenValid($user->password_reset_token)) {
                $user->generatePasswordResetToken();
            }

            if ($user->save()) {
                return $user;
            }
        }

        return false;
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public function findByPasswordResetToken($token)
    {
        if (!User::isPasswordResetTokenValid($token)) {
            return null;
        }

        return self::$user = User::findOne([
            'password_reset_token' => $token,
            'status' => User::STATUS_ACTIVE,
        ]);
    }

    /**
     * Resets password.
     *
     * @return boolean if password was reset.
     */
    public function resetPassword($password)
    {
        $user = self::$user;
        $user->setPassword($password);
        $user->removePasswordResetToken();

        return $user->save(false);
    }

    /**/
    public function searchUser($user = null)
    {
        return User::find()->andFilterWhere(['like', 'username', $user])->all();
    }
}
