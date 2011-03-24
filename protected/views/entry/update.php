<?php
$this->breadcrumbs=array(
	'Entries',
	$model->id,
	'Update',
);

$this->menu=array(
	array('label'=>'Create Entry', 'url'=>array('create')),
	array('label'=>'View Entry', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Entries', 'url'=>array('admin')),
);
?>

<h1>Update Entry #<?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>