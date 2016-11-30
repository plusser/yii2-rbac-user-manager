<?php 

use yii\helpers\Html;

$this->title = 'Создать роль';
$this->params['breadcrumbs'][] = ['label' => 'Роли', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Создать';

?>

<div class="role-create">
    <h1><?php echo Html::encode($this->title); ?></h1>

    <?php echo $this->render('_form', [
        'model' => $model,
    ]); ?>

</div>
