<?php
$this->breadcrumbs=array(
	'Activities',
	'Create',
);

$this->menu=array(
	array('label'=>'Manage Activities', 'url'=>array('admin')),
);
?>

<h1>Create Activity</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>