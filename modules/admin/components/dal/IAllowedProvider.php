<?php

namespace app\modules\admin\components\dal;

interface IAllowedProvider
{
    public function add($route);
    public function remove($route);
}