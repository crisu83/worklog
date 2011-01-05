<?php
$this->breadcrumbs=array(
	'Entries'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Entry', 'url'=>array('index')),
	array('label'=>'Create Entry', 'url'=>array('create')),
);
?>

<h1>Manage Entries</h1>

<?php $this->widget('zii.widgets.CMenu', array(
    'items'=>$this->menu,
    'htmlOptions'=>array('class'=>'submenu'),
)); ?>

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
			'name'=>'assignmentId',
			'value'=>'$data->assignment->name',
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
		),
	),
)); ?>
