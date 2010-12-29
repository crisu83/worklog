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
			array('tags, startDate, endDate', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, ownerId, assignmentId, comment, tags, startDate, endDate', 'safe', 'on'=>'search'),
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
}