<?php
$this->breadcrumbs=array(
	'Tag Categories',
	$model->name,
	'Update',
);

$this->menu=array(
	array('label'=>'Create Tag Category', 'url'=>array('create')),
	array('label'=>'Manage Tag Categories', 'url'=>array('admin')),
);
?>

<h1>Update Tag Category #<?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>