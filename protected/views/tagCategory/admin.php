<?php
$this->breadcrumbs=array(
	'Tag Categories',
);

$this->menu=array(
	array('label'=>'Create Tag Category', 'url'=>array('create')),
);
?>

<h1>Tag Categories</h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'tag-category-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		array(
			'name'=>'id',
			'header'=>'#',
		),
		'name',
		array(
			'class'=>'CButtonColumn',
			'template'=>'{update} {delete}',
		),
	),
)); ?>
