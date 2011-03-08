<?php $this->beginContent('//layouts/main'); ?>
<div class="container">
	<div id="content">
		<div id="submenu">
			<?php $this->widget('zii.widgets.CMenu', array(
				'items'=>$this->menu,
			)); ?>
		</div>
		<?php echo $content; ?>
	</div><!-- content -->
</div>
<?php $this->endContent(); ?>