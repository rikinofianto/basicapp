<?php

namespace app\modules\admin\models;

use PDO;
use Yii;
use yii\helpers\ArrayHelper;
use app\modules\admin\components\Helper;
use app\modules\admin\models\BaseModel;

class Tree extends BaseModel
{
    public $items = false;
    public $generateAfterSave = true;

    public function __isset($name)
    {
        if ($name == 'label') {
            return true;
        }
        return parent::__isset($name);
    }

    public function __get($name)
    {
        if ($name == 'label') {
            return str_repeat('--', $this->level) .' '. $this->getName();
        }
        return parent::__get($name);
    }

    public function getName()
    {
        return "";
    }

    public function pLeft()
    {
        return 'left';
    }

    public function pRight()
    {
        return 'right';
    }

    public function pKey()
    {
        return Helper::getPrimaryKeyName($this);
    }

    public function keyIsNumeric()
    {
        return false;
    }

    public function pParent()
    {
        return 'parent_id';
    }

    public function getData()
    {
        return static::find()->all()->orderBy("`path` ASC");
    }

    private $deletedObj = false;

    public function beforeDelete()
    {
        $this->deletedObj = [
            'left' => $this->{$this->pLeft()},
            'right' => $this->{$this->pRight()},
            'key' => $this->pKey() != null ? $this->{$this->pKey()} : null
        ];
        return parent::beforeDelete();
    }

    public function afterDelete()
    {
        parent::afterDelete();
        if ($this->deletedObj) {
            $sql = "DELETE from " . self::tableName() . " where "
                . "`{$this->pLeft()}` between :left and :right";

            if ($this->pKey() != null)
                $sql .= " and `{$this->pKey()}` = :key";

            $cmd = Yii::$app->db->createCommand($sql);
            $cmd->bindValue(':left', $this->deletedObj['left'], PDO::PARAM_INT);
            $cmd->bindValue(':right', $this->deletedObj['right'], PDO::PARAM_INT);

            if ($this->pKey() != null)
                $cmd->bindValue(':key', $this->deletedObj['key']);

            $cmd->execute();
            $this->rebuildAllTree($this->deletedObj['key'], 1);
        }
    }

    public static function nestedChild($data, $parent_id = null)
    {
        $model = new self;
        $pkField = Helper::getPrimaryKeyName($model);
        if (!empty($data)) {
            if (empty($parent_id)) {
                $listParent = ArrayHelper::map($data, $pkField, $model->pParent());
                $parent_id = min($listParent);
            }
            $list = [];
            foreach ($data as $d) {
                if ($d->{$model->pParent()} == $parent_id) {
                    $items = static::nestedChild($data, $d->{$pkField});
                    if ($items)
                        $d->items = $items;
//                    $d->attributes['items'] = $d->items;
                    $list[] = $d;
                }
            }
            return $list;
        }
        return null;
    }

    public function getOptionChild($columnName, $keyword, $showParent = true)
    {
        $list = [];
        $add_search_cond = [$columnName => $keyword];
        $add_cond = ['level' => 0];
        $cond = array_merge($add_search_cond, $add_cond);
        $parents = static::find($cond);
        if (!empty($parents)) {
            foreach ($parents as $p)
            {
                $child = $p->getChild($p->left, $p->right);
                if ($child && count($child) > 1)
                {
                    if (!$showParent)
                        unset($child[0]);
                    $list = array_merge($list, $child);
                }
            }
        }
        return $list;
    }

    public function getChild($left, $right)
    {
        return static::find()
            ->where([$this->pKey() => $this->{$this->pKey()}])
            ->andWhere(['>=', $this->pLeft(), $left])
            ->andWhere(['<=', $this->pLeft(), $right]);
    }

    public function afterSave($insert, $changedAttributes)
    {
        $havePk = isset($this->primaryKey) && !empty($this->primaryKey);
        if ($havePk) {
            $path = ($this->path != '' ? $this->path . "/" : "" ) . $this->primaryKey;
            $command = Yii::$app->db->createCommand();
            if ($this->isNewRecord) {
                $pkName = Helper::getPrimaryKeyName($this);
                $updatedColumn = ['path' => $path];
                if ($this->keyIsNumeric() && $this->pKey() != null && $this->level == 0) {
                    $updatedColumn[$this->pKey()] = $this->primaryKey;
                }

                $command->update(self::tableName(), $updatedColumn, $pkName . '=:id', [':id' => $this->primaryKey]);
            }
            $this->rebuildAllTree($this->pKey() ? $this->{$this->pKey()} : null, 1);
        }
        return true && parent::afterSave($insert, $changedAttributes);
    }

    public function beforeSave($insert)
    {
        $this->level = 0;

        $pId = $this->pParent();
        $this->{$pId} = !$this->hasAttribute($pId) || empty($this->{$pId}) ? -1 : $this->{$pId};
        $root_id = false;

        if ($this->keyIsNumeric() && $this->pKey() != null)
            $this->{$this->pKey()} = 0;

        $left = $this->pLeft();
        $right = $this->pRight();

        if ($this->{$pId} != null) {
            //var_dump($this->{$pId});exit;
            $parent = static::findOne($this->{$pId});
            //var_dump("<pre>",$parent);
            if (!empty($parent)) {
                var_dump("expression");
                $pk = isset($this->primaryKey) && !empty($this->primaryKey) ? '/' . $this->primaryKey : '';

                $this->path = $parent->path . $pk;
                $chunk_path = explode('/', $this->path);
                $this->level = count(array_filter($chunk_path));
                // var_dump('<pre>', $this->path, $chunk_path, $this->level);exit;
                if ($this->isNewRecord) {

                    $this->{$left} = $parent->{$right};
                } else {
                    if ($parent->primaryKey != $this->parent_id) {
                        $this->{$left} = $parent->{$right};
                    } else {
                        $this->level = count(explode('/', $this->path)) - 1;
                    }
                }
                $root_id = $chunk_path[0];

                if ($this->keyIsNumeric() && $this->pKey() != null)
                    $this->{$this->pKey()} = $parent->{$this->pKey()};
            }
        }

        $this->{$left} = !$this->hasAttribute($left) || empty($this->{$left}) || !isset($this->{$left}) ? 1 : $this->{$left};
        $this->{$right} = $this->{$left} + 1;
        // var_dump($this->left, $this->right, $this->level);exit;
          //exit;
        return true ;
    }

    public function getOption($model = null, $showAll = false)
    {
        $fPk = Helper::getPrimaryKeyName($model);

        $result = self::find()->where(['is not', $fPk, null]);

        if ($model != null && !$model->isNewRecord) {
            $result->andWhere(['<>', $fPk, $model->primaryKey]);
        }

        if ($model->pKey() === null && !$showAll) {
            $result->andWhere(['>', 'level', 0]);
        }

        return $result->orderBy('`path` asc')->all();
    }

    public function getRootId($type = '')
    {
        $pKey = $this->pKey();
        $node = static::find()->where(['is not', $pKey, null]);

        if (!empty($pKey) && !empty($type)) {
            $node->andWhere(['=', $this->pKey(), $type]);
        }

        $node->andWhere(['=', $this->pParent(), -1]);

        if (!empty($node->one())) {
            return $node->one()->primaryKey;
        }
        return null;
    }

    public function saveOrder($type = '', $nodes = [], $parentId = null, $left = 0, $level = 0, $path = '')
    {
        if (!empty($nodes)) {
            if (empty($type) && !empty($pKey)) {
                $key = $this->{$this->pKey()};
                if (!empty($key))
                    $type = $key;
            }

            if (empty($parentId)) {
                $this->_bufferTree = null;
                $parentId = $this->getRootId($type);
                if ($parentId === false) {
                    return false;
                }
                $path = $parentId;
                $left = 2;
                $level = 1;
            }

            $fieldPk = Helper::getPrimaryKeyName(new self);

            foreach ($nodes as $node) {
                $right = $left + 1;
                if (isset($node['children'])) {
                    $right = $this->saveOrder($type, $node['children'], $node['id'], $right, $level + 1, $path . (empty($path) ? '' : '/') . $node['id']);
                }
                $sql = "UPDATE `%s` SET `%s` = %s, `%s` = %s, `%s` = %s, `%s` = %s, `%s` = '%s' WHERE `%s` = '%s';";
                $this->_bufferTree .= sprintf($sql, self::tableName(), $this->pLeft(), $left,
                        $this->pRight(), $right,
                        $this->pParent(), $parentId,
                        'level', $level,
                        'path', $path . (empty($path) ? '' : '/') . $node['id'],
                        $fieldPk, $node['id']);
                $left = $right + 1;
            }

            if (($level == 0 || $level == 1) && !empty($this->_bufferTree)) {
                $cmd = Yii::$app->db->createCommand($this->_bufferTree);
                $cmd->execute();
            }
            return $right + 1;
        }
        return false;
    }

    public function rebuild($type = '', $parentId = null, $left = 0, $level = 0, $path = '')
    {
        $pKey = $this->pKey();
        if (empty($type) && !empty($pKey)) {
            $key = $this->{$this->pKey()};
            if (!empty($key))
                $type = $key;
        }

        if (empty($parentId)) {
            $this->_bufferTree = null;
            $parentId = $this->getRootId($type);
            if ($parentId === false) {
                return false;
            }
            $left = 1;
            $path = $parentId;
        }

        $childs = self::find()
            ->where(['=', $this->pParent(), $parentId])
            ->orderBy($this->pLeft())
            ->all();

        $right = $left + 1;
        $fieldPk = Helper::getPrimaryKeyName($this);

        if (!empty($childs)) {
            foreach ($childs as $child) {
                $pk = $child->{$fieldPk}; //{$this->pKey()};
                $right = $this->rebuild($type, $pk, $right, $level + 1, $path . (empty($path) ? '' : '/') . $pk);
                if ($right === false) {
                    return false;
                }

            }
        }

        $sql = "UPDATE %s SET `%s` = %s, `%s` = %s, `%s` = %s, `%s` = '%s' WHERE `%s` = '%s';";
        $this->_bufferTree .= sprintf($sql, self::tableName(), $this->pLeft(), $left,
                $this->pRight(), $right,
                'level', $level,
                'path', $path,
                $fieldPk, $parentId);

        if ($level == 0 && !empty($this->_bufferTree)) {
            $cmd = Yii::$app->db->createCommand($this->_bufferTree);
            $cmd->execute();
        }
        return $right + 1;
    }

    public function rebuildAllTree($pk, $left = 1)
    {
        $this->rebuild();
    }

    private function findParent($nodes)
    {
        foreach($nodes as $data){
            if($data->parent_id == -1 && $data->left == 1)
                return $data->primaryKey;
        }
        return false;
    }

    private $_bufferTree = null;

    public function rebuildTree($nodes, $pk, $left = 1)
    {
        $right = $left + 1;
        if ($nodes && is_array($nodes)) {
            foreach ($nodes as $node) {
                if ($node->{$this->pParent()} == $pk) {
                    $right = $this->rebuildTree($nodes, $node->primaryKey, $right);
                }
            }
            $fPk = Helper::getPrimaryKeyName(new self);
            $sql = "UPDATE `{self::tableName()}` SET `{$this->pLeft()}` = {$left}, `{$this->pRight()}` = {$right}"
                . " WHERE {$fPk} = {$pk};";

            $this->_bufferTree .= $sql;
        }
        return $right + 1;
    }

    public function getParent($id)
    {
        $cur = static::findOne($id);
        if (!empty($cur)) {
            // $criteria->select = $pk;
            return static::find()
                ->where(['>=', $this->pLeft(), 0])
                ->andWhere(['<=', $this->pLeft, $cur->{$this->pLeft()}])
                ->all();
        }
        return null;
    }

}
