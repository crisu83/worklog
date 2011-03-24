<?php
$this->breadcrumbs=array(
	'Entries',
	'Create',
);

$this->menu=array(
	array('label'=>'Manage Entries', 'url'=>array('admin')),
);
?>

<h1>Create Entry</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>