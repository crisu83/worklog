<?php
$this->breadcrumbs=array(
	'Tags',
	'Create',
);

$this->menu=array(
	array('label'=>'Manage Tags', 'url'=>array('admin')),
);
?>

<h1>Create Tag</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>