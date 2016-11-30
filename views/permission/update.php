<?php 

use yii\helpers\Html;

$this->title = 'Редактировать разрешение ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Разрешения', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->name, ]];
$this->params['breadcrumbs'][] = 'Редактировать';

?>

<div class="permission-update">

    <h1><?php echo Html::encode($this->title); ?></h1>

	<?php echo $this->render('_form', [
        'model' => $model,
    ]); ?>

</div>
