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
			'source'=>"js:function(request,response) {
				$.ajax({
					method: 'post',
					url: '".Yii::app()->createUrl('assignment/juiAutoComplete')."',
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
		<script type="text/javascript">
			// tag/juiAutoComplete
			$(document).ready(function() {

				$.widget('ui.tagAutoComplete', {
					_create: function() {

						$(this.element).keydown(function(event) {
							// Do not let the field blur if the auto complete list is open and were pushing TAB.
							if( event.keyCode===$.ui.keyCode.TAB ) {
								var menu = $(this).data('autocomplete').menu;
								if( menu.element.is(':visible')===true ) {
									if( menu.active===undefined ) {
										console.log(menu.first());
										console.log($(this).data('autocomplete'))
									}

									event.preventDefault();
								}
							}
						});

						$(this.element).autocomplete({
							source: function(request, response) {
								var realTerm = split(request.term).pop();

								// Don't try to search with empty term.
								if( !realTerm ) {
									return false;
								}

								$.ajax({
									url: '<?php echo Yii::app()->createUrl('tag/juiAutoComplete'); ?>',
									data: { term: realTerm },
									dataType: 'json',
									success: function(data) {
										response(data);
									}
								});
							},
							focus: function() {
								// Prevent value inserted on focus.
								return false;
							},
							select: function(event, ui) {
								var terms = split( this.value );
								// Remove the search term.
								terms.pop();

								// Add selected item.
								terms.push(ui.item.value);

								// Add placeholder to get the space at the end.
								terms.push('');
								this.value = terms.join(' ');
								return false;
							}
						});

						/**
						 * Function that splits the given value with space.
						 * @param val the value to split.
						 */
						function split(val) {
							// Split with the separator.
							return val.split(/ \s*/);
						}
					}
				});

				$('#EntryStartForm_tags').tagAutoComplete();
			});
		</script>

		<?php echo $form->labelEx($model, 'tags'); ?>
		<?php echo $form->textField($model, 'tags[]'); ?>
	</div>

	<div class="row buttons">
		<?php $this->widget('zii.widgets.jui.CJuiButton', array(
			'name'=>'submit',
			'caption'=>'Start',
		)); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->