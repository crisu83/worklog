<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'project-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'key'); ?>
		<?php echo $form->textField($model,'key',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'key'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'parentId'); ?>
		<?php $this->widget('application.extensions.juiselectmenu.JuiSelectMenu', array(
			'model'=>$model,
			'attribute'=>'parentId',
			'items'=>CMap::mergeArray(array(0=>'None'), CHtml::listData($model->getParentOptions(),'id','name')), // we need the none option
			'options'=>array(
				'style'=>'dropdown',
			)
		)); ?>
		<?php echo $form->error($model,'parentId'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->