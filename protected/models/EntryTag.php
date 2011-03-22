<?php

/**
 * This is the model class for table "EntryTag".
 *
 * The followings are the available columns in table 'EntryTag':
 * @property integer $id
 * @property integer $entryId
 * @property integer $tagId
 */
class EntryTag extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return EntryTag the static model class
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
		return 'EntryTag';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
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
			'id'            => 'Id',
			'entryId'		=> 'Entry',
			'tagId'			=> 'Tag',
		);
	}
	
	/**
	 * Updates the tags linked to a specific entry.
	 * @param mixed the tag names.
	 * @param integer the entry id.
	 */
	public static function updateTags($names, $entryId)
	{
		if( is_string($names) )
			$names = array($names);
		
		$entryTags = EntryTag::model()->findAllByAttributes(array(
			'entryId'=>$entryId,
		));
		
		foreach( $entryTags as $entryTag )
			$entryTag->delete();
		
		$criteria = new CDbCriteria();
		$criteria->addInCondition('name',$names);
		
		$tags = Tag::model()->findAll($criteria);
		
		$tagIdNameMap = array();
		foreach( $tags as $tag )
			$tagIdNameMap[ $tag->id ] = $tag->name;
		
		foreach( $names as $name )
		{
			// Make sure that the name isn't empty
			// and that the tag doesn't already exist.
			if( !empty($name) && !in_array($name, $tagIdNameMap) )
			{
				$tag = new Tag();
				$tag->name = $name;
				if( $tag->save(false)===false )
					throw new Exception(Yii::t('error', 'Failed to update entry tags with message "Saving the tag failed".'));

				// Add the tag to the tag id map.
				$tagIdNameMap[ $tag->id ] = $tag->name;
			}
		}

		// Create the tags for the entry.
		$tagIdList = array_keys($tagIdNameMap);
		foreach( $tagIdList as $tagId )
		{
			$tag = new EntryTag();
			$tag->entryId = $entryId;
			$tag->tagId = $tagId;
			if( $tag->save(false)===false )
				throw new Exception(Yii::t('error', 'Failed to update entry tags with message "Saving the entry tag failed".'));
		}
	}
}
