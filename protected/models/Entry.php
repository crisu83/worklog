<?php

/**
 * This is the model class for table "entry".
 *
 * The followings are the available columns in table 'entry':
 * @property integer $id
 * @property integer $ownerId
 * @property integer $assignmentId
 * @property string $comment
 * @property string $tags
 * @property string $startDate
 * @property string $endDate
 * @property integer $deleted
 */
class Entry extends CActiveRecord
{
	/**
	 *
	 * FIXME: Possibly move to a form model?
	 */
	public $startTimeHours;
	public $startTimeMinutes;
	public $endTimeHours;
	public $endTimeMinutes;
	
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
			array('ownerId, assignmentId, comment, startDate, endDate', 'required'),
			array('ownerId, assignmentId', 'numerical', 'integerOnly'=>true),
			array('tags', 'safe'),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, ownerId, assignmentId, comment, tags, startDate, endDate', 'safe', 'on'=>'search'),
		);
	}
	
	/**
	 * This is the 'validateTimeHours' validator as declared in rules().
	 * @param string the name of the attribute to be validated.
	 * @param array additional parameters.
	 */
	public function validateTimeHours($attribute, $params)
	{
		if( $this->{$attribute}<0 )
			$this->addError($attribute, 'Hours cannot be less than 0.');
		else if( $this->{$attribute}>23 )
			$this->addError($attribute, 'Hours cannot be greater than 23.');
	}
	
	/**
	 * This is the 'validateTimeMinutes' validator as declared in rules().
	 * @param string the name of the attribute to be validated.
	 * @param array additional parameters.
	 */
	public function validateTimeMinutes($attribute, $params)
	{
		if( $this->{$attribute}<0 )
			$this->addError($attribute, 'Minutes cannot be less than 0.');
		else if( $this->{$attribute}>59 )
			$this->addError($attribute, 'Minutes cannot be greater than 59.');
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
	 * Creates a mysql date from parts.
	 * @param string the date (yy-mm-dd)
	 * @param int the amount of hours.
	 * @param int the amount of minutes.
	 * @param int the amount of seconds.
	 * @return string the mysql date.
	 * 
	 * FIXME: Improve this because the arguments do not really make any sense,
	 * the method should be more generic and maybe even moved to a different class.
	 */
	public static function createMySQLDate($date, $hour, $minute, $second=null)
	{
		// Make sure that the date has been given
		// before starting to create a date.
		if( $date!=='' )
		{
			// Explode the date into parts
			// and extract the year, month and day.
			$dateParts = explode('-', $date);
			list($year, $month, $day) = $dateParts; // evil list() muahaha!

			// Convert the date into a timestamp.
			$timestamp = mktime($hour, $minute, $second, $month, $day, $year);

			// Return the timestamp in mysql date format.
			$date = date('Y-m-d H:i:s', $timestamp);
		}
		
		return $date;
	}
	
	/**
	 * Parses the start date into three different fields
	 * (date, hours and minutes).
	 */
	public function parseStartDate()
	{
		$timestamp = strtotime($this->startDate);
		$this->startDate = date('Y-m-d', $timestamp);
		$this->startTimeHours = date('H', $timestamp);
		$this->startTimeMinutes = date('i', $timestamp);
	}
	
	/**
	 * Parses the end date into three different fields
	 * (date, hours and minutes).
	 */
	public function parseEndDate()
	{
		$timestamp = strtotime($this->endDate);
		$this->endDate = date('Y-m-d', $timestamp);
		$this->endTimeHours = date('H', $timestamp);
		$this->endTimeMinutes = date('i', $timestamp);
	}
}