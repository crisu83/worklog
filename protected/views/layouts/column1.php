<?php $this->beginContent('//layouts/main'); ?>
<div class="container">
	<div id="content">
		<div id="submenu">
			<?php $this->widget('zii.widgets.CMenu', array(
				'htmlOptions'=>array('class'=>'plain-menu'),
				'items'=>$this->menu,
			)); ?>
		</div>
		<?php echo $content; ?>
	</div><!-- content -->
</div>
<?php $this->endContent(); ?>