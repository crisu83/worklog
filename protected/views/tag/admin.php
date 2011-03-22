<?php
$this->breadcrumbs=array(
	'Tags'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Tag', 'url'=>array('index')),
	array('label'=>'Create Tag', 'url'=>array('create')),
	array('label'=>'Tag Categories', 'url'=>array('//tagCategory/admin')),
);
?>

<h1>Manage Tags</h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'tag-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		array(
			'name'=>'id',
			'header'=>'#',
		),
		'name',
		array(
			'name'=>'categoryId',
			'value'=>'$data->category->name',
		),
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
