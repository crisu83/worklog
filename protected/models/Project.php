<?php

/**
 * This is the model class for table "project".
 *
 * The followings are the available columns in table 'project':
 * @property integer $id
 * @property string $name
 * @property string $created
 * @property string $updated
 * @property integer $deleted
 */
class Project extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Project the static model class
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
		return 'Project';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name', 'required'),
			array('name', 'length', 'max'=>255),
			array('parentId', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, created, updated', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
			'parent'	=>array(self::BELONGS_TO, 'Project', 'parentId'),
            'users'     =>array(self::MANY_MANY, 'User', 'ProjectUser(projectId, userId)'),
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
			'id'			=>'Id',
			'parentId'		=>'Parent',
			'name'			=>'Name',
			'created'		=>'Created',
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
		$criteria->compare('created',$this->created,true);
		$criteria->compare('updated',$this->updated,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
	
	public function getParentOptions()
	{
		if( $this->isNewRecord )
			$parents = Project::model()->findAll('deleted=0');
		else
			$parents = Project::model()->findAll('id!=? AND deleted=0', array($this->id));
		
		$options = array(''=>'None');
		foreach( $parents as $parent )
			$options[ $parent->id ] = $parent->name;
		
		return $options;
	}
	
	public function getParentName()
	{
		return $this->parent instanceof Project ? $this->parent->name : null;
	}
}