<?php 

use yii\helpers\Html;

$F = function($item){
	return $item->name . ' (' . (empty($item->description) ? '...' : $item->description) . ')';
};

?>

<ul style="list-style-type: decimal; margin: 20px 0px;">
<?php foreach($permissionList as $item){ ?>
	<li><?php echo $F($item); ?></li>
<?php } ?>
</ul>
