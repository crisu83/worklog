<div class="form">

<?php $form=$this->beginWidget('CActiveForm'); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'projectId'); ?>
		<?php $this->widget('application.extensions.juiselectmenu.JuiSelectMenu',array(
			'debug'=>true,
			'model'=>$model,
			'attribute'=>'projectId',
			'items'=>CHtml::listData(Project::model()->findAll('deleted=0'),'id','name'),
			'options'=>array(
				'style'=>'dropdown',
			),
		)); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php $this->widget('zii.widgets.jui.CJuiAutoComplete',array(
			'model'=>$model,
			'attribute'=>'name',
			'source'=>"js:
function(request,response) {
	$.ajax({
		method: 'post',
		url: '".Yii::app()->createUrl('activity/juiAutoComplete')."',
		data: { 
			term: request.term,
			project: $('#EntryStartForm_projectId-button .ui-selectmenu-status').text()
		},
		dataType: 'json',
		success: function(data) {
			response(data);
		}
	});
}",
			'options'=>array(
				'minLength'=>'1',
			),
			'htmlOptions'=>array(
				'size'=>60,
			),
		)); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'comment'); ?>
		<?php echo $form->textArea($model,'comment',array('rows'=>6,'cols'=>50)); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'tags'); ?>
		<?php $i=0; while( $i++<Yii::app()->params['tagFieldCount'] ): ?>
			<?php $this->widget('zii.widgets.jui.CJuiAutoComplete',array(
				'model'=>$model,
				'attribute'=>'tags['.($i-1).']',
				'source'=>Yii::app()->createUrl('tag/juiAutoComplete'),
				'options'=>array(
					'minLength'=>'2',
				),
				'htmlOptions'=>array(
					'class'=>'tag-field',
				),
			)); ?>
		<?php endwhile; ?>
	</div>

	<div class="row buttons">
		<?php $this->widget('zii.widgets.jui.CJuiButton', array(
			'name'=>'submit',
			'caption'=>'Start',
		)); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->