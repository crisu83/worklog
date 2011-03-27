<?php Yii::app()->getClientScript()->registerScript('tagautocomplete',
	'$("#EntryStartForm_tags").tagautocomplete({
		'.(count($model->tags)>0 ? 'value: '.json_encode($model->tags).',' : '').'
		source: "'.Yii::app()->createUrl('tag/juiAutoComplete').'"
	});',
	CClientScript::POS_READY); ?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm'); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'projectId'); ?>
		<?php $this->widget('application.extensions.juiselectmenu.JuiSelectMenu',array(
			'debug'=>true,
			'model'=>$model,
			'attribute'=>'projectId',
			'items'=>$projectOptions,
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
				'minLength'=>'2',
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
		<?php echo CHtml::label('Tags', 'EntryStartForm[tags]'); ?>
		<?php echo CHtml::textField('EntryStartForm[tags]', '', array('id'=>'EntryStartForm_tags', 'wrap'=>'off', 'rows'=>1, 'size'=>60)); ?>
	</div>

	<div class="row buttons">
		<?php $this->widget('zii.widgets.jui.CJuiButton', array(
			'name'=>'submit',
			'caption'=>'Start',
		)); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->