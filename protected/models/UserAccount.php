<?php

/**
 * This is the model class for table "UserAccount".
 *
 * The followings are the available columns in table 'UserAccount':
 * @property string $id
 * @property string $ownerId
 * @property string $firstName
 * @property string $lastName
 * @property string $defaultProjectId
 */
class UserAccount extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return UserAccount the static model class
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
		return 'UserAccount';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ownerId', 'required'),
			array('ownerId, defaultProjectId', 'length', 'max'=>10),
			array('firstName, lastName', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, ownerId, firstName, lastName, defaultProjectId', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'ownerId' => 'Owner',
			'firstName' => 'First Name',
			'lastName' => 'Last Name',
			'defaultProjectId' => 'Default Project',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('ownerId',$this->ownerId,true);
		$criteria->compare('firstName',$this->firstName,true);
		$criteria->compare('lastName',$this->lastName,true);
		$criteria->compare('defaultProjectId',$this->defaultProjectId,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}