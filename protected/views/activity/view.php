<?php
$this->breadcrumbs=array(
	'Assignments'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Activity', 'url'=>array('index')),
	array('label'=>'Create Activity', 'url'=>array('create')),
	array('label'=>'Update Activity', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Activity', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Activities', 'url'=>array('admin')),
);
?>

<h1>View Activity #<?php echo $model->id; ?></h1>

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

<h2>Entries</h2>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'assignment-entry-grid',
	'dataProvider'=>$entryDataProvider,
	'columns'=>array(
		array(
			'header'=>'#',
			'value'=>'$data->id',
		),
		array(
			'name'=>'assignmentId',
			'value'=>'$data->assignment->name',
		),
		array(
			'name'=>'ownerId',
			'value'=>'$data->owner->name',
		),
		'comment',
		array(
			'name'=>'tags',
			'type'=>'raw',
			'value'=>'$data->getTagsAsString()',
		),
		'startDate',
		'endDate',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
