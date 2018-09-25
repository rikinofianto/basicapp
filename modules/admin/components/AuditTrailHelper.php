<?php

namespace app\modules\admin\components;

use Yii;
use app\modules\admin\behaviors\LoggableBehavior;


class AuditTrailHelper
{

    public function leaveTrailForUpdate($before, $after, $model)
    {
        $event = new LoggableBehavior();
        foreach ($after as $key => $value){
            if($before[$key] != $value)
            {
                $event->attach($model);
                $event->leaveTrail('Update', $key, $value, $before[$key],$after['name']);
            }
        }
    }

    public function leaveTrailForAssign($id,$items,$model)
    {
        $event = new LoggableBehavior();
        foreach ($items as $k){
            
                $event->attach($model);
                $event->leaveTrail('CREATE', null, null, null, $id);
                $event->attach($model);
                $event->leaveTrail('SET','parent' ,$id , null, $id);
                $event->attach($model);
                $event->leaveTrail('SET','child' ,$k, null, $id);
            
        }
    }

    public function leaveTrailForRemove($id,$items,$model)
    {
        $event = new LoggableBehavior();
        foreach ($items as $k){
            
                $event->attach($model);
                $event->leaveTrail("DELETE", null, null, null, $id);
                $event->attach($model);
        }
    }

    public function leaveTrailForDelete($id,$model)
    {
        $event = new LoggableBehavior();
        $event->attach($model);
        $event->leaveTrail("DELETE", null, null, null, $id);
    }

    public function leaveTrailForCreate($model,$post)
    {
        $event = new LoggableBehavior();
        $event->attach($model);
        $event->leaveTrail('CREATE', null, null, null, $post['name']);
        foreach ($post as $key => $value){
            $event->attach($model);
            $event->leaveTrail('SET',$key ,$value , null, $post['name']);
        }
    }

    public function leaveTrailForCreateRoute($model,$post)
    {

        $event = new LoggableBehavior();

        $event->leaveTrail('CREATE', null, null, null, $post, 'app\modules\admin\models\route');
        
        $event->leaveTrail('SET','name' ,$post , null, $post, 'app\modules\admin\models\route');
        
    }

    public function leaveTrailForAssignRoute($model, $routes)
    {
         $event = new LoggableBehavior();
         foreach ($routes as $key) {
             self::leaveTrailForCreateRoute($model, $key);
         }
    }

    public function leaveTrailForRemoveRoute($model,$routes)
    {
        $event = new LoggableBehavior();
        foreach ($routes as $r) {
            $event->leaveTrail('DELETE', null, null, null, $r, 'app\modules\admin\models\route');
        }
    }

    public function leaveTrailForAssignAssignment($items, $id)
    {
    
        $event = new LoggableBehavior();
        foreach ($items as $r ) {
            $event->leaveTrail('CREATE', null, null, null, $id, 'app\modules\admin\models\assignment');
            $event->leaveTrail('SET','item_name' ,$r , null, $id, 'app\modules\admin\models\assignment');
            $event->leaveTrail('SET','user_id' ,$id , null, $id, 'app\modules\admin\models\assignment');
        }
    }

     public function leaveTrailForRemoveAssignment($items, $id)
    {
        $event = new LoggableBehavior();
        foreach ($items as $r ) {
            $event->leaveTrail('DELETE', null, null, null, $id, 'app\modules\admin\models\assignment');
        }
    }

    public function leaveTrailForLogin($model)
    {
        $event = new LoggableBehavior();
        $model->id = -1;
        $event->attach($model);
        $event->leaveTrail('LOGIN', 'Login');
    }

    public function leaveTrailForLogOut($model)
    {
        $event = new LoggableBehavior();
        $model->id = -1;
        $event->attach($model);
        $event->leaveTrail('LOGOUT', 'Logout');
    }

}