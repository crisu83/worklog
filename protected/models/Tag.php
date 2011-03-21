<?php

/**
 * This is the model class for table "Tag".
 *
 * The followings are the available columns in table 'Tag':
 * @property integer $id
 * @property string $categoryId
 * @property string $name
 *
 * @property TagCategory
 */
class Tag extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Tag the static model class
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
		return 'Tag';
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
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, categoryId, name', 'safe', 'on'=>'search'),
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
			'category'=>array(self::BELONGS_TO, 'TagCategory', 'categoryId'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id'			=>'Id',
			'name'			=>'Name',
			'categoryId'    =>'Category',
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
		//$criteria->compare('categoryId',$this->category->name,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}

	public function getCategoryName()
	{
		return $this->category instanceof TagCategory ? $this->category->name : '';
	}

	/**
	 * Converts a comma-separated string to an array.
	 * @param $tags the tags.
	 * @return array the tags.
	 */
	public static function string2array($tags)
	{
		return preg_split('/\s*,\s*/',trim($tags),-1,PREG_SPLIT_NO_EMPTY);
	}

	/**
	 * Converts an array to a comma-separated string.
	 * @param $tags the tags.
	 * @return string the tags.
	 */
	public static function array2string($tags)
	{
		return implode(', ',$tags);
	}
}