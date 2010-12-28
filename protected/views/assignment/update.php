<?php
$this->breadcrumbs=array(
	'Assignments'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Assignment', 'url'=>array('index')),
	array('label'=>'Create Assignment', 'url'=>array('create')),
	array('label'=>'View Assignment', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Assignments', 'url'=>array('admin')),
);
?>

<h1>Update Assignment #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CMenu', array(
    'items'=>$this->menu,
    'htmlOptions'=>array('class'=>'submenu'),
)); ?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>