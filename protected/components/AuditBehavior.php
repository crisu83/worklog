<?php

class AuditBehavior extends CActiveRecordBehavior
{
    /**
     * Actions to be taken before saving the record.
     */
    public function beforeSave()
    {
        $now = date('Y-m-d H:i:s');
        $userId = Yii::app()->user->id;
        
        // We are creating a new record.
        if( $this->owner->isNewRecord )
        {
            if( $this->owner->hasAttribute('created') )
               $this->owner->created = $now;
            
            if( $this->owner->hasAttribute('creatorId') )
               $this->owner->creatorId = $userId;
        }
        // We are updating an existing record.
        else
        {
            if( $this->owner->hasAttribute('updated') )
                $this->owner->updated = $now;
            
            if( $this->owner->hasAttribute('updaterId') )
               $this->owner->updaterId = $userId;
        }
    }
}
