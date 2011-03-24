<?php
$this->breadcrumbs=array(
	'Entries',
	'Manage',
);

$this->menu=array(
	array('label'=>'Create Entry', 'url'=>array('create')),
);
?>

<h1>Manage Entries</h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'entry-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		array(
			'header'=>'#',
			'value'=>'$data->id',
		),
		array(
			'name'=>'activityId',
			'type'=>'raw',
			'value'=>'$data->getActivityLink()',
		),
		array(
			'name'=>'ownerId',
			'value'=>'$data->owner->name',
		),
		'comment',
		'startDate',
		'endDate',
		array(
			'class'=>'CButtonColumn',
			'template'=>'{update} {delete}',
		),
	),
)); ?>
