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
		<style>
			div.tag-auto-complete { position:relative; }
			div.tag-auto-complete input { height:18px; margin:0px; padding:2px; resize:none; }
			div.tag-auto-complete ul {
				position:absolute;
				top:0;
				left:0;
				height:100%;
				padding:0;
				margin:0 0 0 4px;
				cursor:text;
				list-style:none;
				clear:both;
			}
			div.tag-auto-complete ul li {
				float:left;
				margin:4px 4px 0 0;
				padding:0 0 0 4px;
				background-color:#fff08f;
				/* color:#ffffff; */
				border:1px solid #d3d3d3;
				-moz-border-radius:4px;
				border-radius:4px;
			}
			div.tag-auto-complete ul li div {
				float:right;
				margin:0 0 0 4px;
				padding:0 4px;
				background-color:#f0f0f0;
				border-left:1px solid #d3d3d3;
				-moz-border-radius-topright:4px;
				-moz-border-radius-bottomright:4px;
				border-top-right-radius:4px;
				border-bottom-right-radius:4px;
				color:#a0a0a0;
				font-weight:bold;
				cursor:pointer;
			}

		</style>
		<script type="text/javascript">
			// tag/juiAutoComplete
			$(document).ready(function() {

				$.widget('ui.tagAutoComplete', {
					_create: function() {
						var input = $(this.element);
						var name = input.attr('name');
						input.attr('name', null);

						input.wrap('<div class="tag-auto-complete">');
						var container = $(this.element).parent();
						container.append('<ul class="tac-presentation"></ul>');
						var presentation = container.children('.tac-presentation');

						$(this.element).keydown(function(event) {
							var ac = $(this).data('autocomplete');
							var menu = ac.menu;

							// Do not let the field blur if the auto complete list is open and were pushing TAB.
							switch(event.keyCode) {
								case $.ui.keyCode.TAB:
									if( menu.element.is(':visible')===true ) {
										if( menu.active===undefined ) {
											// TODO: Get the first item from the list.
										}

										event.preventDefault();
									}
								break;
								case $.ui.keyCode.BACKSPACE:

									if( $(ac.element).val()==='' ) {
										presentation.children('li:last').remove();
										updateInputPadding();
									}
								break;
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
								//this.value = terms.join(' ');

								var itemStr = '<li>'+ui.item.value+' <div>x</div>';

								if( name ) {
									var valueCount = container.find('ul li input[name^="'+name+'"]').length;
									itemStr += '<input type="hidden" name="'+name+'['+valueCount+']" value="'+ui.item.value+'" />';
								}

								itemStr += '</li>';

								// Append a new item to presentation.
								presentation.append(itemStr);

								// Update the padding of the input, so that the text appears next to the presentation.
								updateInputPadding();

								// Clear the input value.
								this.value = '';

								return false;
							}
						});

						function updateInputPadding() {
							input.css('padding-left', (presentation.width()+2)+'px');
						}

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