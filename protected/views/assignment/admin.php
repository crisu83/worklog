<?php
$this->breadcrumbs=array(
	'Assignments'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Assignment', 'url'=>array('index')),
	array('label'=>'Create Assignment', 'url'=>array('create')),
);
?>

<h1>Manage Assignments</h1>

<?php $this->widget('zii.widgets.CMenu', array(
    'items'=>$this->menu,
    'htmlOptions'=>array('class'=>'submenu'),
)); ?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'assignment-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		array(
			'header'=>'#',
			'value'=>'$data->id',
		),
		array(
			'name'=>'projectId',
			'value'=>'$data->project->name',
		),		
		'name',
		'created',
		'updated',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
