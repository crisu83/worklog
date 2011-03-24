<?php
$this->breadcrumbs=array(
	'Projects',
	'Create',
);

$this->menu=array(
	array('label'=>'Manage Project', 'url'=>array('admin')),
);
?>

<h1>Create Project</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>