<div class="entry-view">

	<div class="left-column">

		<div class="assignment"><?php echo $data->getHeader(); ?></div>

		<div class="comment"><?php echo CHtml::encode($data->comment); ?></div>

		<?php /*<div class="tags"><strong><?php echo CHtml::encode($data->getAttributeLabel('tags')); ?> </strong><?php echo $data->getTagsAsString(); ?></div>*/ ?>

	</div>

	<div class="right-column">

		<div class="owner"><?php echo CHtml::link($data->owner->name, array('user/view', 'id'=>$data->owner->id)); ?></div>

		<div class="times">
			<?php echo $data->getDuration(); ?> minutes |
			<?php echo CHtml::encode(date('H:i', strtotime($data->startDate))); ?> - <?php echo CHtml::encode(date('H:i', strtotime($data->endDate))); ?> |
			<?php echo CHtml::encode(date('Y-m-d', strtotime($data->startDate))); ?>
		</div>

	</div>

	<div class="clear">&nbsp;</div>

</div>