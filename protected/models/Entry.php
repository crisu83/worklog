<?php

/**
 * This is the model class for table "entry".
 *
 * The followings are the available columns in table 'entry':
 * @property integer $id
 * @property integer $ownerId
 * @property integer $assignmentId
 * @property string $comment
 * @property string $startDate
 * @property string $endDate
 * @property integer $deleted
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
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ownerId, assignmentId, comment', 'required'),
			array('ownerId, assignmentId', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, ownerId, assignmentId, comment, startDate, endDate', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
            'assignment'	=>array(self::BELONGS_TO, 'Assignment', 'assignmentId'),
            'owner'			=>array(self::BELONGS_TO, 'User', 'ownerId'),
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
			'assignmentId'	=>'Assignment',
			'comment'       =>'Comment',
			'tags'			=>'Tags',
			'duration'      =>'Duration',
			'startDate'     =>'Start Date',
			'endDate'       =>'End Date',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('ownerId',$this->ownerId);
		$criteria->compare('assignmentId',$this->assignmentId);
		$criteria->compare('comment',$this->comment,true);
		$criteria->compare('tags',$this->tags,true);
		$criteria->compare('startDate',$this->startDate,true);
		$criteria->compare('endDate',$this->endDate,true);

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

	public function getDuration()
	{
		if( $this->startDate!==null && $this->endDate!==null )
			return strtotime($this->endDate) - strtotime($this->startDate);
		else
			return null;
	}
}