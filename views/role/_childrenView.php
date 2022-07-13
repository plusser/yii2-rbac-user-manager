<?php 

use yii\helpers\Html;

$F = function($item){
    return $item->name . ' (' . (empty($item->description) ? '...' : $item->description) . ')';
};

?>

<ul style="list-style-type: decimal; margin: 20px 0px;">
<?php foreach($children as $item){ ?>
    <li><?php echo Html::a($F($item), [$item->type == $item::TYPE_ROLE ? 'role/view' : 'permission/view', 'id' => $item->name], ['target' => '_blank', ]); ?></li>
<?php } ?>
</ul>
