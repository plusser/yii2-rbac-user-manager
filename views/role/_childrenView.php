<?php 

use yii\helpers\Html;

$F = function($item){
	return $item->name . ' (' . (empty($item->description) ? '...' : $item->description) . ')';
};

?>

<ul style="list-style-type: decimal; margin: 20px 0px;">
<?php foreach($children as $item){ ?>
	<li><?php echo $item->type == $item::TYPE_ROLE ? Html::a($F($item), ['role/view', 'id' => $item->name], ['target' => '_blank', ]) : $F($item); ?></li>
<?php } ?>
</ul>
