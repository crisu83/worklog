<?php

class EntryStartForm extends CFormModel
{
	public $projectId;
	public $name;
	public $comment;
	public $tags;
	
	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(
			array('projectId, name, comment', 'required'),
			array('name', 'length', 'max'=>255),
		);
	}
	
	/**
	 * Declares the attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'projectId'		=>'Project',
			'name'			=>'Name',
			'comment'		=>'Comment',
			'tags'			=>'Tags',
		);
	}
}
