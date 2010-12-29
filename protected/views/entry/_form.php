<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/dyndatetime/jquery.dynDateTime.min.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/dyndatetime/lang/calendar-en.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScript('dynDateTime', "
jQuery('.dyndatetime').dynDateTime({
	showsTime: true,
	ifFormat: '%Y-%m-%d %H:%M',
	electric: false,
	singleClick: false,
	displayArea: '.siblings(\'.dtcDisplayArea\')',
	button: '.next()'
});
"); ?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'entry-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'assignmentId'); ?>
		<?php echo $form->dropDownList($model,'assignmentId',CHtml::listData(Assignment::model()->findAll('deleted=0'),'id','name')); ?>
		<?php echo $form->error($model,'assignmentId'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ownerId'); ?>
		<?php echo $form->dropDownList($model,'ownerId',CHtml::listData(User::model()->findAll('deleted=0'),'id','name')); ?>
		<?php echo $form->error($model,'ownerId'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'comment'); ?>
		<?php echo $form->textArea($model,'comment',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'comment'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'tags'); ?>
		<?php echo $form->textField($model,'tags',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'tags'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'startDate'); ?>
		<?php echo $form->textField($model, 'startDate', array('size'=>20,'maxlength'=>20,'class'=>'dyndatetime')); ?>
		<?php echo $form->error($model,'startDate'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'endDate'); ?>
		<?php echo $form->textField($model, 'endDate', array('size'=>20,'maxlength'=>20,'class'=>'dyndatetime')); ?>
		<?php echo $form->error($model,'endDate'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?> | <?php echo CHtml::link('Cancel', array('entry/index')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->