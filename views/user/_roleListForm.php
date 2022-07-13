<?php 

use yii\helpers\Html;

$F = function($item, $userRoleList){
    return $item->name . ' (' . (empty($item->description) ? '...' : $item->description) . ')' . (isset($userRoleList[$item->name]) ? ((is_object($UI = $userRoleList[$item->name]) && $UI->createdAt) ? date(' [d-m-Y H:i:s]', (int) $UI->createdAt) : ' [новая]') : '');
};

?>

<ul style="list-style-type: decimal; margin: 20px 0px;">
<?php foreach($itemList as $item){ ?>
    <li><?php echo Html::checkbox('User[roleList][' . $item->name . ']', isset($userRoleList[$item->name]), ['value' => $item->name, 'id' => $id = 'User_roleList_' . $item->name, ]); ?>&nbsp;&nbsp;<?php echo Html::label($F($item, $userRoleList), $id); ?>
    </li>
<?php } ?>
</ul>
