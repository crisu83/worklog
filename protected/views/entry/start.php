<h1>Start Entry</h1>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm'); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'projectId'); ?>
		<?php echo $form->dropDownList($model,'projectId',CHtml::listData(Project::model()->findAll('deleted=0'),'id','name')); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
			'name'=>'name',
			'source'=>Yii::app()->createUrl('assignment/juiAutoComplete'),
			// additional javascript options for the autocomplete plugin
			'options'=>array(
				'minLength'=>'2',
			),
			'htmlOptions'=>array(
				'size'=>60,
			)
		)); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'comment'); ?>
		<?php echo $form->textArea($model,'comment',array('rows'=>6, 'cols'=>50)); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'tags'); ?>
		<?php echo $form->textField($model,'tags',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row buttons">
		<?php $this->widget('zii.widgets.jui.CJuiButton', array(
			'name'=>'submit',
			'caption'=>'Start',
		)); ?>
		<?php /*echo CHtml::submitButton('Start');*/ ?> | <?php echo CHtml::link('Cancel', Yii::app()->homeUrl); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->