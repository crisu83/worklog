<div class="entry-view">

	<div class="activity column float-left">
		<?php echo $data->getActivityLink(); ?>
	</div>

	<?php /*<div class="tags"><strong><?php echo CHtml::encode($data->getAttributeLabel('tags')); ?> </strong><?php echo $data->getTagsAsString(); ?></div>*/ ?>

	<div class="comment column float-left">
		<?php echo CHtml::encode($data->comment); ?>
	</div>

	<?php /*<div class="owner"><?php echo CHtml::link($data->owner->name, array('user/view', 'id'=>$data->owner->id)); ?></div>*/ ?>


	<div class="duration column float-right text-right">
		<?php echo Entry::formatTime($data->getDuration()); ?>
	</div>

	<div class="datetime column float-right">
		<?php echo CHtml::encode(date('H:i', strtotime($data->startDate))); ?> -&rsaquo; <?php echo CHtml::encode(date('H:i', strtotime($data->endDate))); ?> |
		<span class="date"><?php echo CHtml::encode(date('Y-m-d', strtotime($data->startDate))); ?></span>
	</div>
	
	<div class="clear">&nbsp;</div>

</div>