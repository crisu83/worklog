<?php
$this->breadcrumbs=array(
	'Assignments'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Assignment', 'url'=>array('index')),
	array('label'=>'Manage Assignments', 'url'=>array('admin')),
);
?>

<h1>Create Assignment</h1>

<?php $this->widget('zii.widgets.CMenu', array(
    'items'=>$this->menu,
    'htmlOptions'=>array('class'=>'submenu'),
)); ?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>