<?php

/**
 * This is the model class for table "entry".
 *
 * The followings are the available columns in table 'entry':
 * @property integer $id
 * @property integer $ownerId
 * @property integer $activityId
 * @property string $comment
 * @property string $startDate
 * @property string $endDate
 * @property integer $deleted
 *
 * Related records:
 * @property Activity $activity
 * @property User $owner
 */
class Entry extends CActiveRecord
{
	const STATE_STOPPED = 0;
	const STATE_RUNNING = 1;
	const STATE_PAUSED = 2;

	/**
	 * @property array list of tags associated to this entry.
	 */
	public $tags;

	/**
	 * @property integer the current state of this entry.
	 */
	public $state;

	/**
	 * @property integer the duration of this entry in seconds.
	 */
	public $duration;
	
	/**
	 * Returns the static model of the specified AR class.
	 * @return Entry the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'Entry';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('ownerId, activityId, comment', 'required'),
			array('ownerId, activityId', 'numerical', 'integerOnly'=>true),
			array('id, ownerId, activityId, comment, startDate, endDate', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
            'activity'  =>array(self::BELONGS_TO, 'Activity', 'activityId'),
            'owner'     =>array(self::BELONGS_TO, 'User', 'ownerId'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id'            =>'Id',
			'ownerId'       =>'Owner',
			'activityId'	=>'Activity',
			'comment'       =>'Comment',
			'tags'			=>'Tags',
			'duration'      =>'Duration',
			'startDate'     =>'Started',
			'endDate'       =>'Ended',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('comment',$this->comment,true);
		$criteria->compare('tags',$this->tags,true);
		$criteria->compare('startDate',$this->startDate,true);
		$criteria->compare('endDate',$this->endDate,true);

		$criteria->addSearchCondition('activity.name', $this->activityId);
		$criteria->with[] = 'activity';

		$criteria->addSearchCondition('owner.name', $this->ownerId);
		$criteria->with[] = 'owner';

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the entry states.
	 * @return array the states.
	 */
	public function getStates()
	{
		return array(
			self::STATE_STOPPED=>'Stopped',
			self::STATE_RUNNING=>'Running',
			self::STATE_PAUSED=>'Paused',
		);
	}

	/**
	 * Returns this entries state as a string.
	 * @throws Exception if the state is invalid.
	 * @return the state string.
	 */
	public function getStateAsString()
	{
		$states = $this->getStates();

		if( isset($states[ $this->state ])===false )
			throw new Exception(Yii::t('error', 'Invalid entry state "{state}"', array('{state}'=>$this->state)));

		return $states[ $this->state ];
	}

	/**
	 * Returns the tags for this entry.
	 * @param boolean $link whether to get the tags as links.
	 * @return array the tags.
	 */
	public function getTags($link=true)
	{
		$criteria = new CDbCriteria();
		$criteria->join = 'LEFT JOIN EntryTag t2 ON t.id=t2.tagId';
		$criteria->condition = 'entryId=:entryId';
		$criteria->params = array(':entryId'=>$this->id);
		$criteria->order = 'name ASC';
		
		$tags = Tag::model()->findAll($criteria);

		$names = array();
		foreach( $tags as $tag )
			$names[] = $link===true ? CHtml::link($tag->name, array('//tag/search', 'id'=>$tag->id)) : $tag->name;
		
		return $names;
	}

	/**
	 * Returns the tags for this entry as a string.
	 * @return string the tags.
	 */
	public function getTagsAsString()
	{
		$tags = $this->getTags();
		$string = count($tags)>0 ? implode(', ', $tags) : 'None';
		return $string;
	}

	/**
	 * Sets the tags for this entry.
	 * @param array $names the tags.
	 */
	public function setTags($names)
	{
		EntryTag::updateTags($names, $this->id);
	}

	/**
	 * Sets the state for this entry.
	 * @param integer $value the state.
	 */
	public function setState($value)
	{
		$this->state = $value;
	}

	/**
	 * Returns the state for this entry.
	 * @return the state.
	 */
	public function getState()
	{
		return $this->state;
	}

	/**
	 * Returns the duration of this entry.
	 * @return int|null the duration or null if start date or end date is null.
	 */
	public function getDuration()
	{
		if( $this->startDate!==null && $this->endDate!==null )
			return strtotime($this->endDate) - strtotime($this->startDate);
		else if( $this->startDate!==null )
			return time() - strtotime($this->startDate);
		else
			return null;
	}

	/**
	 * Returns the link to the associated actvity.
	 * @return string the link markup.
	 */
	public function getActivityLink()
	{
		return '<strong>'.$this->activity->project->key.'-'.$this->activity->id.'</strong> '.
				CHtml::link($this->activity->name, array('//activity/view', 'id'=>$this->activity->id));
	}

	/**
	 * Returns this entry as JSON.
	 * @return string the JSON.
	 */
	public function toJSON()
	{
		return CJSON::encode(array(
			'id'=>$this->id,
			'ownerId'=>$this->ownerId,
			'activityId'=>$this->activityId,
			'comment'=>$this->comment,
			'startDate'=>$this->startDate!==null ? strtotime($this->startDate) : null,
			'endDate'=>$this->endDate!==null ? strtotime($this->endDate) : null,
		));
	}

	/**
	 * Formats seconds as hours, minutes and seconds.
	 * @param integer $seconds the seconds.
	 * @return string the formatted time.
	 */
	public static function formatTime($seconds)
	{
		$hours = 0;
		$string = '';

		$minutes = $seconds>60 ? floor($seconds/60) : '< 1';

		if( $minutes>60 ) {
			$hours = floor($minutes/60);
			$minutes = $minutes % 60;
		}

		// Append the hours if necessary.
		if( $hours>0 ) {
			$string .= $hours.' h ';
		}

		// Append the minutes.
		$string .= $minutes.' min ';

		return $string;
	}
}