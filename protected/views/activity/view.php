<?php
$this->breadcrumbs=array(
	'Activities'=>array('index'),
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

<h1>Activity #<?php echo $model->id; ?></h1>

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

<hr class="divider" />

<h2>Entries</h2>

<p class="hint">Below you can see all entries associated with this activity.</p>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'assignment-entry-grid',
	'dataProvider'=>$entryDataProvider,
	'columns'=>array(
		array(
			'header'=>'#',
			'value'=>'$data->id',
		),
		array(
			'name'=>'activityId',
			'value'=>'$data->activity->name',
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
