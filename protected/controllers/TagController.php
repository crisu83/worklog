<?php

class TagController extends Controller
{
	public function actionIndex()
	{
		$this->render('index');
	}

	public function actionJuiAutoComplete($term)
	{
		$criteria = new CDbCriteria();
		$criteria->addSearchCondition('name',$term);
		
		$tags = Tag::model()->findAll($criteria);
		
		if( $tags!==array() )
		{
			$names = array();
			foreach( $tags as $tag )
				$names[] = $tag->name;
			
			echo CJSON::encode($names);
		}
		
		// Terminate the application.
		Yii::app()->end();
	}
}