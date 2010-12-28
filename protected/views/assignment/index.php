<?php
$this->breadcrumbs=array(
	'Assignments',
);

$this->menu=array(
	array('label'=>'Create Assignment', 'url'=>array('create')),
	array('label'=>'Manage Assignments', 'url'=>array('admin')),
);
?>

<h1>Assignments</h1>

<?php $this->widget('zii.widgets.CMenu', array(
    'items'=>$this->menu,
    'htmlOptions'=>array('class'=>'submenu'),
)); ?>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
