<?php

namespace app\modules\admin\components\dal;

interface ILoginProvider
{
    public function findByUsername($username);
}
