<?php
$this->pageTitle=Yii::app()->name;

if( $entry!==null )
{
	Yii::app()->clientScript->registerScript('WorkLog#site.index', "
		WorkLog.app.setActiveEntryData({$entry->toJSON()});
	");
}
?>

<h1>Dashboard</h1>

<div class="dashboard">

	<?php if( empty($projectOptions)===false ): ?>

		<?php if( $entry!==null ): ?>

			<fieldset>
				<legend><?php echo CHtml::encode($entry->getStateAsString()); ?></legend>
				<div class="activity"><strong><?php echo CHtml::encode($entry->activity->project->key); ?>-<?php echo CHtml::encode($entry->activity->id); ?></strong> <?php echo CHtml::encode($entry->activity->name); ?></div>
				<div class="comment"><em><?php echo CHtml::encode($entry->comment); ?></em></div>
				<div class="tags"><strong>Tags</strong> <?php echo $entry->getTagsAsString(); ?></div>
				<div class="started"><strong>Started</strong> <?php echo CHtml::encode(date('H:i', strtotime($entry->startDate))); ?></div>
				<div class="duration"><strong>Duration</strong> <span id="entryDuration"><?php echo CHtml::encode(Entry::formatTime($entry->getDuration())); ?></span></div>
				<div class="links">
					<?php if( $entry->getState()===Entry::STATE_RUNNING ): ?>
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

			<p class="hint">Start logging your work using the form below.</p>

			<?php $this->renderPartial('//entry/_start', array(
				'model'=>$model,
				'projectOptions'=>$projectOptions,
			)); ?>
	
		<?php endif; ?>

		<hr class="divider" />

		<h3>Recent Entries</h3>

		<p class="hint">Below you can see your most recent entries.</p>

		<?php $this->widget('zii.widgets.CListView', array(
			'dataProvider'=>$dataProvider,
			'itemView'=>'//entry/_view',
		)); ?>

	<?php else: ?>

		<p>No projects available.</p>

		<p>Start by creating one <?php echo CHtml::link('here', array('//project/create')); ?>.</p>

	<?php endif; ?>

</div>