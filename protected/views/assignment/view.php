<?php
$this->breadcrumbs=array(
	'Assignments'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Assignment', 'url'=>array('index')),
	array('label'=>'Create Assignment', 'url'=>array('create')),
	array('label'=>'Update Assignment', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Assignment', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Assignments', 'url'=>array('admin')),
);
?>

<h1>View Assignment #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CMenu', array(
    'items'=>$this->menu,
    'htmlOptions'=>array('class'=>'submenu'),
)); ?>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		array(
			'name'=>'projectId',
			'value'=>$model->project->name,
		),		
		'name',		
		'created',
		'updated',
	),
)); ?>
