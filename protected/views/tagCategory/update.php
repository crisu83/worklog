<?php
$this->breadcrumbs=array(
	'Tag Categories'=>array('admin'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Tag Category', 'url'=>array('index')),
	array('label'=>'Create Tag Category', 'url'=>array('create')),
	array('label'=>'Manage Tag Categories', 'url'=>array('admin')),
);
?>

<h1>Update Tag Category #<?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>