<?php

/**
 * This is the model class for table "user".
 *
 * The followings are the available columns in table 'user':
 * @property integer $id
 * @property string $name
 * @property string $password
 * @property string $created
 * @property string $updated
 * @property integer $deleted
 */
class User extends CActiveRecord
{
    /**
     * @property string the password hash.
     */
    private static $_passwordHash = 'JXnPbQkcISHdCv0LGraBMu5KejA1ZEl';
    
	/**
	 * Returns the static model of the specified AR class.
	 * @return User the static model class
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
		return 'User';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, password', 'required'),
			array('name, password', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, password, created, updated', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
			'account'	=>array(self::HAS_ONE, 'UserAccount', 'ownerId'),
			'projects'  =>array(self::MANY_MANY, 'Project', 'ProjectUser(projectId, userId)'),
		);
	}
    
    /**
     * @return array model behaviors.
     */
    public function behaviors()
    {
        return array(
            'AuditBehavior'=>'application.components.AuditBehavior',
        );
    }

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id'            =>'Id',
			'name'          =>'Name',
			'password'      =>'Password',
			'created'       =>'Created',
			'updated'		=>'Updated',
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('created',$this->created,true);
		$criteria->compare('updated',$this->updated,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
    
    /**
     * Actions to be taken before saving the record.
     */
    public function beforeSave()
    {
        // We need to encrypt the password before saving.
        $this->password = $this->encryptPassword($this->password);
        
        return parent::beforeSave();
    }
    
    /**
     * Compares the given password against 
     * the password saved for the user.
     * @param string the password to validate.
     * @return boolean whether the password is valid.
     */
    public function validatePassword($password)
    {       
        return $this->password===$this->encryptPassword($password);
    }
    
    /**
     * Encrypts the given password.
     * @param string the password to encrypt.
     * @return string the encrypted password.
     */
    protected function encryptPassword($password)
    {
       return md5($password.self::$_passwordHash);
    }
}
