<?php
use yii\helpers\Html;
?>
<li class="dd-item" data-id="<?php echo $menu->menu_id?>">
    <button class="pull-right btn btn-success btn-xs fa fa-chevron-down pull-right" aria-hidden="true" data-toggle="collapse" href="#item-menu-<?php echo $menu->menu_id?>" aria-expanded="true" aria-controls="item-menu-<?php echo $menu->menu_id?>"></button>
    <div class="dd-handle">
        <div class=" panel panel-success">
            <div class="handle-head panel-heading"><?php echo $menu->label?> <span class="pull-right"><i>(<?php echo $menu->menu_url?>)</i></span> </div>
            <div class="panel-collapse collapse dd-nodrag" id="item-menu-<?php echo $menu->menu_id?>" role="tabpanel" aria-labelledby="item-menu-<?php echo $menu->menu_id?>">
            <div class="panel panel-default">
            <div class="panel-body">
                <div class="form-group">
                    <label><i><?php echo Yii::t('rbac-admin', 'Menu Label');?></i></label>
                    <input type="text" class="form-control input-sm" name="Menu[item][<?php echo $i ?>][label]" value="<?php echo $menu->label?>" placeholder="<?php echo Yii::t('rbac-admin', 'Menu Label');?>">
                </div>
                <div class="form-group">
                    <label><i><?php echo Yii::t('rbac-admin', 'Description');?></i></label>
                    <input type="text" class="form-control input-sm" name="Menu[item][<?php echo $i ?>][description]" value="<?php echo $menu->description?>" placeholder="<?php echo Yii::t('rbac-admin', 'Menu Description');?>">
                </div>
                <div class="form-group">
                    <label><i><?php echo Yii::t('rbac-admin', 'URL');?></i></label>
                    <input type="text" class="form-control input-sm" name="Menu[item][<?php echo $i ?>][menu_url]" value="<?php echo $menu->menu_url?>" placeholder="<?php echo Yii::t('rbac-admin', 'URL');?>">
                </div>
                <div class="form-group">
                    <label><i><?php echo Yii::t('rbac-admin', 'Icon Class');?></i></label>
                    <input type="text" class="form-control input-sm" name="Menu[item][<?php echo $i ?>][class]" value="<?php echo $menu->class?>" placeholder="<?php echo Yii::t('rbac-admin', 'Icon Class');?>">
                </div>
                <div class="form-group">
                    <div style="position:relative">
                        <label><i><?php echo Yii::t('rbac-admin', 'Group');?></i></label>
                        <?php
                        if (!empty($listGroup)) {
                            echo Html::beginTag('div', ['class' => 'group']);
                            $checked = false;
                            foreach ($listGroup as $key => $value) {
                                if (!empty($menu->menuGroups)) {
                                    foreach ($menu->menuGroups as $k => $v) {
                                        if ($key == $v->group_id) {
                                            $checked = true;
                                            break;
                                        } else {
                                            $checked = false;
                                        }
                                    }
                                }
                                echo Html::beginTag('div', ['class' => 'checkbox']);
                                echo Html::beginTag('label');
                                echo Html::checkbox('Menu[item][' . $i . '][group][]', $checked, ['value' => $key]);
                                echo Html::encode($value);
                                echo Html::endTag('label');
                                echo Html::endTag('div');
                            }
                            echo Html::endTag('div');
                        }
                        ?>
                    </div>
                </div>
                <div class="col-md-12">
                    <a href="javascript:void(0)" aria-hidden="true" data-toggle="collapse" href="#item-menu-<?php echo $menu->menu_id?>" aria-expanded="true" aria-controls="item-menu-<?php echo $menu->menu_id?>" class="text-danger remove-menu" data-id="<?php echo $menu->menu_id ?>" menu-type="<?php echo $menuType ?>">Remove</a>
                    |
                    <a aria-hidden="true" data-toggle="collapse" href="#item-menu-<?php echo $menu->menu_id?>" aria-expanded="true" aria-controls="item-menu-<?php echo $menu->menu_id?>" class="text-muted">Cancel</a>
                </div>
            </div>
            </div>
            </div>
        </div>
        <input type="hidden" name="Menu[item][<?php echo $i ?>][menu_parent]" class="hasparent" value="<?php echo $menu->menu_parent?>">
        <input type="hidden" name="Menu[item][<?php echo $i ?>][dummy_id]" class="dummy-id" value="<?php echo $menu->menu_parent?>">
        <input type="hidden" name="Menu[item][<?php echo $i ?>][menu_custom]" value="<?php echo $menu->menu_custom?>">
        <input type="hidden" name="Menu[item][<?php echo $i ?>][menu_id]" value="<?php echo $menu->menu_id?>">
        <input type="hidden" name="Menu[item][<?php echo $i ?>][menu_order]" class="menu-order" value="<?php echo $menu->menu_order?>">
        <input type="hidden" name="Menu[item][<?php echo $i ?>][level]" class="level" value="<?php echo $menu->level?>">
    </div>
    <?php
        echo "<ol class='dd-list'>";
        $i = 0;
        foreach ($childMenus as $key => $childMenu) {
            if ($childMenu->menu_parent == $menu->menu_id) {
                echo $this->render('_view', [
                    'menu' => $childMenu,
                    'listGroup' => $listGroup,
                    'menuType' => $menuType,
                    'childMenus' => $childMenus,
                    'i' => $i
                ]);
            }
            $i++;
        }
        echo "</ol>";
    ?>
</li>