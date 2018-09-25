<?php

namespace app\modules\admin\Models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use app\modules\admin\behaviors\LoggableBehavior;

class BaseModel extends ActiveRecord
{
    public function behaviors()
    {
        return [
            'app\modules\admin\behaviors\LoggableBehavior'
        ];
    }

    public function beforeSave($insert)
    {
        if ($this->isNewRecord) {
            if ($this->hasAttribute('created_at')) {
                $this->created_at = date('Y-m-d H:i:s');
            }
        } else {
            if ($this->hasAttribute('updated_at')) {
                $this->updated_at = date('Y-m-d H:i:s');
            }
        }
        return parent::beforeSave($insert);
    }
}
