<?php

use yii\helpers\Html;

$F = function($item){
    return is_object($permission = Yii::$app->authManager->getPermission($item->name)) ? Html::a($permission->name . ' (' . (empty($permission->description) ? '...' : $permission->description) . ')' . date(' [d-m-Y H:i:s]', (int) $item->createdAt), ['permission/view', 'id' => $permission->name], ['target' => '_blank']) : '';
};

?>

<ul style="list-style-type: decimal; margin: 20px 0px;">
<?php foreach($permissionList as $item){ ?>
    <li><?php echo $F($item); ?></li>
<?php } ?>
</ul>
