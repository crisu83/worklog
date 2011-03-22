<?php

class SiteController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		// Redirect non-logged in users to the login page.
		if( Yii::app()->user->isGuest )
			$this->redirect(array('//site/login'));

		$model = new EntryStartForm();

		// Entry start form has been submitted.
		if( isset($_POST['EntryStartForm']) )
		{
			$model->attributes = $_POST['EntryStartForm'];
			$model->tags = $_POST['EntryStartForm']['tags'];

			// Attempt to find an activity associated with the entry.
			$activity = Activity::model()->findByAttributes(array(
				'name'=>$model->name,
			));

			// New entries needs to create an associated activity.
			if( $activity===null )
			{
				$activity = new Activity();
				$activity->projectId = $model->projectId;
				$activity->name = $model->name;
				$activity->save(false);
			}

			$entry = new Entry();
			$entry->ownerId = Yii::app()->user->id;
			$entry->activityId = $activity->id;
			$entry->comment = $model->comment;
			$entry->startDate = empty($entry->startDate) ? date('Y-m-d H:i:s') : $entry->startDate;
			$entry->endDate = empty($entry->endDate) ? null : $entry->endDate;

			// Attempt to save the entry.
			if( $entry->save() )
			{
				$entry->setState(Entry::STATE_RUNNING); // entry is now running
				$entry->setTags($model->tags);
				Yii::app()->user->setEntry($entry); // set the active entry for the web user
				$this->redirect(Yii::app()->homeUrl);
			}
			// Saving the entry failed.
			else
				throw new Exception(Yii::t('error', 'Failed to start entry with message "Saving entry failed".'));
		}

		$entry = Yii::app()->user->getEntry();

		$entryState = $entry instanceof Entry ? $entry->getState() : null;

		$criteria = new CDbCriteria();
		$criteria->addCondition('ownerId=:userId');
		$criteria->addCondition('endDate IS NOT NULL');
		$criteria->params[':userId'] = Yii::app()->user->id;
		//$criteria->order = 'id DESC';

		$dataProvider = new CActiveDataProvider('Entry', array(
			'criteria'=>$criteria
		));

		$this->render('index',array(
			'model'=>$model,
			'entry'=>$entry,
			'entryState'=>$entryState,
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
	    if($error=Yii::app()->errorHandler->error)
	    {
	    	if(Yii::app()->request->isAjaxRequest)
	    		echo $error['message'];
	    	else
	        	$this->render('error', $error);
	    }
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$headers="From: {$model->email}\r\nReply-To: {$model->email}";
				mail(Yii::app()->params['adminEmail'],$model->subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
				$this->redirect(Yii::app()->user->returnUrl);
		}
		// display the login form
		$this->render('login',array('model'=>$model));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
}