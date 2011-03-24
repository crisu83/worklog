<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
	
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/default.css" />

	<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/namespaces.js"></script>
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/WorkLog.js"></script>
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/worklog/Base.js"></script>
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/worklog/components/App.js"></script>
</head>

<body>

<div class="container" id="page">

	<div id="header">
		<div id="logo"><?php echo CHtml::encode(Yii::app()->name); ?></div>
	</div><!-- header -->

	<div id="mainmenu">
		<?php $this->widget('zii.widgets.CMenu',array(
			'items'=>array(
				array('label'=>'Dashboard', 'url'=>array('/site/index'), 'visible'=>!Yii::app()->user->isGuest),
				array('label'=>'Account', 'url'=>array('/user/account', 'id'=>Yii::app()->user->id), 'visible'=>!Yii::app()->user->isGuest),
				array('label'=>'Entries', 'url'=>array('/entry/user', 'id'=>Yii::app()->user->id), 'visible'=>!Yii::app()->user->isGuest),
				array('label'=>'Login', 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest),
				array('label'=>'Logout ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest)
			),
		)); ?>
	</div><!-- mainmenu -->

	<?php if( Yii::app()->user->isAdmin===true ): ?>
		<div id="adminmenu">
			<?php $this->widget('zii.widgets.CMenu',array(
				'htmlOptions'=>array('class'=>'plain-menu'),
				'items'=>array(
					array('label'=>'Administration:'),
					array('label'=>'Entries', 'url'=>array('/entry/admin')),
					array('label'=>'Activities', 'url'=>array('/activity/admin')),
					array('label'=>'Projects', 'url'=>array('/project/admin')),
					array('label'=>'Tags', 'url'=>array('/tag/admin')),
					array('label'=>'Users', 'url'=>array('/user/admin')),
				),
			)); ?>	
		</div>
	<?php endif; ?>

	<div id="clock">
		<?php echo date('H:i:s'); ?>
	</div>

	<div class="clear">&nbsp;</div>

	<?php $this->widget('zii.widgets.CBreadcrumbs', array(
		'links'=>$this->breadcrumbs,
	)); ?><!-- breadcrumbs -->

	<?php echo $content; ?>

	<div id="footer">
		Copyright &copy; WorkLog <?php echo date('Y'); ?>.<br/>
		All Rights Reserved.<br/>
		<?php echo Yii::powered(); ?>
	</div><!-- footer -->

</div><!-- page -->

<script type="text/javascript">

	(function($) {

		WorkLog.app = WorkLog.component.App;
		WorkLog.app.run();

		var Foo = Class.extend({
			foo: function() {
				console.log('foo');
			}
		});
		
	})(jQuery);

</script>

</body>
</html>