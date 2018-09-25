<?php

namespace app\modules\admin\components\dal;

interface IResetProvider
{
    public function findByPasswordResetToken($token);
}
