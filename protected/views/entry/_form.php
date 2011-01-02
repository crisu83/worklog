<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'entry-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'assignmentId'); ?>
		<?php $this->widget('application.extensions.juiselectmenu.JuiSelectMenu', array(
			'model'=>$model,
			'attribute'=>'assignmentId',
			'items'=>CHtml::listData(Assignment::model()->findAll('deleted=0'),'id','name'),
			'options'=>array(
				'style'=>'dropdown',
			)
		)); ?>
		<?php echo $form->error($model,'assignmentId'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ownerId'); ?>
		<?php $this->widget('application.extensions.juiselectmenu.JuiSelectMenu', array(
			'model'=>$model,
			'attribute'=>'ownerId',
			'items'=>CHtml::listData(User::model()->findAll('deleted=0'),'id','name'),
			'options'=>array(
				'style'=>'dropdown',
			)
		)); ?>
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
		<?php echo $form->textField($model,'startDate',array('class'=>'date-field','maxlength'=>20)); ?>
		<?php echo $form->error($model,'startDate'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'endDate'); ?>
		<?php echo $form->textField($model,'endDate',array('class'=>'date-field','maxlength'=>20)); ?>
		<?php echo $form->error($model,'endDate'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?> | <?php echo CHtml::link('Cancel', array('entry/index')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->