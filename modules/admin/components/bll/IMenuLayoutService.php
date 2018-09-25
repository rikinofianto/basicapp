<?php

namespace app\modules\admin\components\bll;

interface IMenuLayoutService
{
    public function getMenuCache($type = 'backend-menu');
}
