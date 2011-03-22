<?php
$this->breadcrumbs=array(
	'Tag Categories',
	'Create',
);

$this->menu=array(
	array('label'=>'Manage Tag Categories', 'url'=>array('admin')),
);
?>

<h1>Create Tag Category</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>