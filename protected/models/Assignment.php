<?php

/**
 * This is the model class for table "Assignment".
 *
 * The followings are the available columns in table 'Assignment':
 * @property integer $id
 * @property integer $projectId
 * @property string $name
 * @property string $created
 * @property string $updated
 * @property integer $deleted
 */
class Assignment extends CActiveRecord
{
	/**
	 * @property array list of tags associated to this entry.
	 */
	public $tags;

	/**
	 * Returns the static model of the specified AR class.
	 * @return Assignment the static model class
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
		return 'Assignment';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('projectId, name', 'required'),
			array('projectId, deleted', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>255),
			array('tags', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, projectId, name, tags, created, updated, deleted', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
			'project'=>array(self::BELONGS_TO, 'Project', 'projectId'),
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
			'projectId'		=>'Project',
			'name'			=>'Name',
			'tags'			=>'Tags',
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
		$criteria->compare('projectId',$this->projectId);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('created',$this->created,true);
		$criteria->compare('updated',$this->updated,true);
		$criteria->compare('deleted',$this->deleted);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}