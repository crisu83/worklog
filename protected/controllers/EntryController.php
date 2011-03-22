<?php

class EntryController extends Controller
{
	/**
	 * @property string the default layout for the views.
	 */
	public $layout='//layouts/column1';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','start','pause','resume','stop','user'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Entry;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Entry']))
		{
			$model->attributes=$_POST['Entry'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Entry']))
		{
			$model->attributes=$_POST['Entry'];
			$model->tags = $_POST['Entry']['tags'];
			if($model->save())
			{
				$model->setTags($model->tags);
				$this->redirect(array('view','id'=>$model->id));
			}
		}
		
		$model->tags = $model->getTags();

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Entry');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Entry('search');
		$model->unsetAttributes(); // clear any default values
		if(isset($_GET['Entry']))
			$model->attributes=$_GET['Entry'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Starts an entry for the logged in user.
	 * @throws Exception if saving the entry fails.
	 */
	public function actionStart()
	{
		$model = new EntryStartForm();
		
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
		
		$this->render('start', array(
			'model'=>$model,
		));
	}

	/**
	 * Pauses the current entry for the logged in user.
	 * @throws Exception if saving the entry fails.
	 */
	public function actionPause()
	{
		$entry = Yii::app()->user->getEntry();
		$entry->endDate = date('Y-m-d H:i:s');

		// Attempt to save the entry.
		if( $entry->save() )
			$entry->setState(Entry::STATE_PAUSED); // entry is now paused
		// Saving the entry failed.
		else
			throw new Exception(Yii::t('error', 'Failed to pause entry with message "Saving entry failed".'));

		$this->redirect(Yii::app()->homeUrl);
	}

	/**
	 * Resumes the paused entry for the logged in user.
	 * @throws Exception if saving the entry fails.
	 */
	public function actionResume()
	{
		// Get the paused entry from the web user.
		$pausedEntry = Yii::app()->user->getEntry();

		// Create a new entry similar to the paused one.
		$entry = new Entry();
		$entry->ownerId = Yii::app()->user->id;
		$entry->activityId = $pausedEntry->activity->id;
		$entry->comment = $pausedEntry->comment;
		$entry->startDate = date('Y-m-d H:i:s');
		$entry->endDate = null;

		// Attempt to save the entry.
		if( $entry->save() )
		{
			$entry->setState(Entry::STATE_RUNNING); // entry is now running
			$entry->setTags($pausedEntry->getTags(false));
			Yii::app()->user->setEntry($entry); // set the active entry for the web user
			$this->redirect(Yii::app()->homeUrl);
		}
		// Saving the entry failed.
		else
			throw new Exception(Yii::t('error', 'Failed to resume entry with message "Saving entry failed".'));
	}

	/**
	 * Stops the current entry for the logged in user.
	 * @throws Exception if saving the entry fails.
	 */
	public function actionStop()
	{
		$entry = Yii::app()->user->getEntry();

		// Make sure that the entry is not paused
		// because then we do not want to update the end date.
		if( $entry->getState()!==Entry::STATE_PAUSED )
		{
			$entry->endDate = date('Y-m-d H:i:s');

			// Attempt to save the entry.
			if( $entry->save() )
				Yii::app()->user->flushEntry();
			// Saving the entry failed.
			else
				throw new Exception(Yii::t('error', 'Failed to stop entry with message "Saving entry failed".'));
		}

		$this->redirect(Yii::app()->homeUrl);
	}

	public function actionUser($id)
	{
		$criteria = new CDbCriteria();
		$criteria->addCondition('ownerId=:userId');
		$criteria->params[':userId'] = $id;

		$dataProvider = new CActiveDataProvider('Entry',array(
			'criteria'=>$criteria,
		));
		
		$this->render('user',array(
			'dataProvider'=>$dataProvider,
		));
	}
	
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Entry::model()->findByPk((int)$id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='entry-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
