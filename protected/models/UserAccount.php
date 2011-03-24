<?php

/**
 * This is the model class for table "UserAccount".
 *
 * The followings are the available columns in table 'UserAccount':
 * @property string $id
 * @property string $userId
 * @property string $firstName
 * @property string $lastName
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
		return array(
			array('userId', 'required'),
			array('userId', 'length', 'max'=>10),
			array('firstName, lastName', 'length', 'max'=>255),
			array('id, userId, firstName, lastName', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
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
			'userId' => 'User',
			'firstName' => 'First Name',
			'lastName' => 'Last Name',
		);
	}
}
