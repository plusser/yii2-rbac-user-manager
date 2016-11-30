<?php 

use yii\helpers\Html;

$this->title = 'Редактировать роль ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Роли', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->name, ]];
$this->params['breadcrumbs'][] = 'Редактировать';

?>

<div class="role-update">

    <h1><?php echo Html::encode($this->title); ?></h1>

	<?php echo $this->render('_form', [
        'model' => $model,
    ]); ?>

</div>
