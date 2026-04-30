<?php
class My_model extends BaseModel
{
    /* Configuration by Inheriting */

    // The regular PK Key in App
    protected $primaryKey = 'id';
    // Timestamps on
    protected $timestamps = true;
    // Soft Deleted on
    const SOFT_DELETED = 'is_deleted';

    protected function _globalScopes()
    {
        // Global Scope...
    }

    protected function _attrEventBeforeInsert(&$attributes)
    {
        // Insert Behavior...
    }

    // Other Behaviors...
}
