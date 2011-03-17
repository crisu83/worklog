<?php
$this->breadcrumbs=array(
	'Entries',
);
?>

<h1>Entries</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
