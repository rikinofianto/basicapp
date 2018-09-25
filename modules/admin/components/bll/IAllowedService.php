<?php

namespace app\modules\admin\components\bll;

interface IAllowedService
{
    public function routeInstance();
    public function add($route);
    public function remove($route);
}