<?php
$this->pageTitle='Account | '.Yii::app()->name;

$this->breadcrumbs=array(
	'Account'
);
?>

<h1>Account</h1>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'user-account-form',
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($account,'firstName'); ?>
		<?php echo $form->textField($account,'firstName',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($account,'firstName'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($account,'lastName'); ?>
		<?php echo $form->textField($account,'lastName',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($account,'lastName'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->