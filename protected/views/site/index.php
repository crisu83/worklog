<?php $this->pageTitle=Yii::app()->name; ?>

<h2>Dashboard</h2>

<div class="dashboard">

	<?php if( $entry!==null ): ?>

		<fieldset>
			<legend><?php echo CHtml::encode($entry->getStateAsString()); ?></legend>
			<div class="assignment"><strong><?php echo CHtml::encode($entry->assignment->project->key); ?>-<?php echo CHtml::encode($entry->assignment->id); ?></strong> <?php echo CHtml::encode($entry->assignment->name); ?></div>
			<div class="comment"><em><?php echo CHtml::encode($entry->comment); ?></em></div>
			<div class="tags"><strong>Tags</strong> <?php echo $entry->getTagsAsString(); ?></div>
			<div class="started"><strong>Started</strong> <?php echo CHtml::encode(date('H:i:s', strtotime($entry->startDate))); ?></div>
			<div class="duration"><strong>Duration</strong> <?php echo CHtml::encode(round((time() - strtotime($entry->startDate)) / 60)); ?> minutes</div>
			<div class="links">
				<?php if( $entryState===Entry::STATE_RUNNING ): ?>
					<?php $this->widget('zii.widgets.jui.CJuiButton', array(
						'name'=>'pause-button',
						'buttonType'=>'link',
						'caption'=>'Pause',
						'url'=>array('//entry/pause'),
					)); ?>
				<?php else: ?>
					<?php $this->widget('zii.widgets.jui.CJuiButton', array(
						'name'=>'resume-button',
						'buttonType'=>'link',
						'caption'=>'Resume',
						'url'=>array('//entry/resume'),
					)); ?>
				<?php endif; ?>

				<?php $this->widget('zii.widgets.jui.CJuiButton', array(
					'name'=>'stop-button',
					'buttonType'=>'link',
					'caption'=>'Stop',
					'url'=>array('//entry/stop'),
				)); ?>
				
			</div>
		</fieldset>

	<?php else: ?>

		<p><?php $this->widget('zii.widgets.jui.CJuiButton', array(
			'name'=>'start-button',
			'buttonType'=>'link',
			'caption'=>'Start',
			'url'=>array('//entry/start'),
		)); ?></p>

	<?php endif; ?>

	<h3>Recent entries</h3>

	<?php $this->widget('zii.widgets.grid.CGridView', array(
		'id'=>'recent-entries-grid',
		'dataProvider'=>$dataProvider,
		'columns'=>array(
			array(
				'name'=>'assignmentId',
				'type'=>'raw',
				'value'=>'"<strong>".$data->assignment->project->key."-".$data->assignment->id."</strong> ".$data->assignment->name',
			),
			'comment',
			array(
				'name'=>'tags',
				'type'=>'raw',
				'value'=>'$data->getTagsAsString()',
			),
			array(
				'name'=>'Duration',
				'value'=>'round($data->getDuration() / 60)." minutes"',
			),
			array(
				'header'=>'Start Time',
				'value'=>'date("H:i:s", strtotime($data->startDate))',
			),
			array(
				'header'=>'End Time',
				'value'=>'date("H:i:s", strtotime($data->endDate))',
			),
			array(
				'class'=>'CButtonColumn',
			),
		),
	)); ?>

</div>