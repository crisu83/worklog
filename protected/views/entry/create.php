<?php
$this->breadcrumbs=array(
	'Entries'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Entry', 'url'=>array('index')),
	array('label'=>'Manage Entries', 'url'=>array('admin')),
);
?>

<h1>Create Entry</h1>

<?php $this->widget('zii.widgets.CMenu', array(
    'items'=>$this->menu,
    'htmlOptions'=>array('class'=>'submenu'),
)); ?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>