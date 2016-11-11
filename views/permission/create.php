<?php 

use yii\helpers\Html;

$this->title = 'Создать разрешение';
$this->params['breadcrumbs'][] = ['label' => 'Разрешения', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Создать';
?>
<div class="permission-create">
    <h1><?php echo Html::encode($this->title); ?></h1>

    <?php echo $this->render('_form', [
        'model' => $model,
    ]); ?>

</div>
