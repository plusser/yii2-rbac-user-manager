<?php 

use yii\helpers\Html;

$F = function($item){
	return $item->name . ' (' . (empty($item->description) ? '...' : $item->description) . ')';
};

$modelChildren = $model->children;

?>

<ul style="list-style-type: decimal; margin: 20px 0px;">
<?php foreach($children as $item){if($item->name != $model->name){ ?>
	<li><?php echo Html::checkbox('RoleForm[children][' . $item->name . ']', isset($modelChildren[$item->name]), ['value' => $item->type, 'id' => $id = 'RoleForm_children_' . $item->name, ]); ?>&nbsp;&nbsp;<?php echo Html::label($F($item), $id); ?></li>
<?php }} ?>
</ul>

