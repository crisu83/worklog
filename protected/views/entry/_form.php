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
		<?php /*$this->widget('zii.widgets.jui.CJuiDatePicker', array(
			'model'=>$model,
			'attribute'=>'startDate',
			'options'=>array(
				'dateFormat'=>'yy-mm-dd',
			),
			'htmlOptions'=>array(
				'class'=>'date-field',
				'maxlength'=>20,
			),
			'themeUrl'=>Yii::app()->request->baseUrl.'/css/jui',
			'theme'=>'redmond',
		));*/ ?>
		<?php echo $form->textField($model,'startDate',array('class'=>'date-field','maxlength'=>20)); ?>
		<?php echo $form->error($model,'startDate'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'endDate'); ?>
		<?php /*$this->widget('zii.widgets.jui.CJuiDatePicker', array(
			'model'=>$model,
			'attribute'=>'endDate',
			'options'=>array(
				'dateFormat'=>'yy-mm-dd',
			),
			'htmlOptions'=>array(
				'class'=>'date-field',
				'maxlength'=>20,
			),
			'themeUrl'=>Yii::app()->request->baseUrl.'/css/jui',
			'theme'=>'redmond',
		));*/ ?>
		<?php echo $form->textField($model,'endDate',array('class'=>'date-field','maxlength'=>20)); ?>
		<?php echo $form->error($model,'endDate'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?> | <?php echo CHtml::link('Cancel', array('entry/index')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->