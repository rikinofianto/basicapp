<?php

namespace app\modules\admin\components\bll;

use Yii;

class UserService implements \app\modules\admin\components\bll\IUserService
{
    private $userGroupProvider;
    private $userProvider;
    private $groupProvider;

    public function __construct()
    {
        Yii::$container->setSingleton('app\modules\admin\components\dal\IUserGroupProvider',
            'app\modules\admin\components\dal\UserGroupProvider');
        Yii::$container->setSingleton('app\modules\admin\components\dal\IUserProvider',
            'app\modules\admin\components\dal\UserProvider');
        Yii::$container->setSingleton('app\modules\admin\components\dal\IMenuGroupProvider',
            'app\modules\admin\components\dal\GroupProvider');

        $this->userGroupProvider = Yii::$container->get('app\modules\admin\components\dal\IUserGroupProvider');
        $this->userProvider = Yii::$container->get('app\modules\admin\components\dal\IUserProvider');
        $this->groupProvider = Yii::$container->get('app\modules\admin\components\dal\IMenuGroupProvider');
    }

    public function userSearchInstance()
    {
        return $this->userProvider->userSearchInstance();
    }

    public function login($model)
    {
        if (!empty($model)) {
            return Yii::$app->getUser()->login($this->userProvider->findByUsername($model->username),
                $model->rememberMe ? 3600 * 24 * 30 : 0);
        }
        return false;
    }

    public function createUser($model)
    {
        if (!empty($model)) {
            return $this->userProvider->createUser($model);
        }
        return false;
    }

    public function changePassword($model)
    {
        if (!empty($model)) {
            return $this->userProvider->changePassword($model);
        }
        return false;
    }

    public function getRedirectUrl($userId)
    {
        $result = [];
        if (!empty($userId)) {
            $group = $this->userGroupProvider->findByGroupId($userId);
            if (!empty($group)) {
                foreach ($group as $key => $value) {
                    $result[$value->group_id] = !empty($value->group->url) ? $value->group->url : '';
                }
            }
        }
        return $result;
    }

    public function getAllGroup($order = 'group_id')
    {
        return $this->groupProvider->getAllGroup($order);
    }

    public function setGroup($model)
    {
        $result = [];
        if (!empty($model->userGroup)) {
            foreach ($model->userGroup as $key => $value) {
                $result[] = $value->group_id;
            }
        }
        return $result;
    }

    public function createAllUserGroup($post, $model)
    {
        if (!empty($post) && !empty($model)) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $user = $this->userProvider->createUser($model);
                $this->saveAllUserGroup($post, $user->id);
                $transaction->commit();
                return true;
            } catch(\Exception $e) {
                $transaction->rollback();
            }
        }
        return false;
    }

    public function updateAllUserGroup($post, $userId)
    {
        if (!empty($post) && !empty($userId)) {
            $this->userGroupProvider->deleteAllUserGroup($userId);
            $this->saveAllUserGroup($post, $userId);
        }
        return false;
    }

    private function saveAllUserGroup($post, $userId)
    {
        if (!empty($post['group_id'])) {
            foreach ($post['group_id'] as $key => $value) {
                $this->userGroupProvider->saveUserGroup($userId, $value);
            }
            return true;
        }
        return false;
    }

    public function sendEmail($email)
    {
        if (!empty($email)) {
            if ($user = $this->userProvider->passwordResetRequest($email)) {
                return Yii::$app->mailer->compose([
                        'html' => 'passwordResetToken-html',
                        'text' => 'passwordResetToken-text'],
                        ['user' => $user])
                    ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
                    ->setTo($email)
                    ->setSubject('Password reset for ' . Yii::$app->name)
                    ->send();
            }
        }
        return false;
    }

    public function resetPassword($password)
    {
        if (!empty($password)) {
            return $this->userProvider->resetPassword($password);
        }
        return false;
    }
}
