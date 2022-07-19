<?php

use yii\helpers\Html;

$F = function($item){
    return is_object($role = Yii::$app->authManager->getRole($item->roleName)) ? Html::a($role->name . ' (' . (empty($role->description) ? '...' : $role->description) . ')' . date(' [d-m-Y H:i:s]', (int) $item->createdAt), ['role/view', 'id' => $role->name], ['target' => '_blank']) : '';
};

?>

<ul style="list-style-type: decimal; margin: 20px 0px;">
<?php foreach($roleList as $item){ ?>
    <li><?php echo $F($item); ?></li>
<?php } ?>
</ul>
