<?php
$this->breadcrumbs=array(
	'Tags',
	$model->name,
	'Update',
);

$this->menu=array(
	array('label'=>'Create Tag', 'url'=>array('create')),
	array('label'=>'Manage Tags', 'url'=>array('admin')),
);
?>

<h1>Update Tag #<?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>