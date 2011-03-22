<?php
$this->breadcrumbs=array(
	'Entries'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Entry', 'url'=>array('index')),
	array('label'=>'Create Entry', 'url'=>array('create')),
	array('label'=>'Update Entry', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Entry', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Entries', 'url'=>array('admin')),
);
?>

<h1>Entry #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		array(
			'name'=>'ownerId',
			'value'=>$model->owner->name,
		),
		array(
			'name'=>'assignmentId',
			'value'=>$model->assignment->name,
		),
		'comment',
		array(
			'name'=>'tags',	
			'value'=>implode(', ', $model->getTags()),
		),
		'startDate',
		'endDate',
	),
)); ?>
