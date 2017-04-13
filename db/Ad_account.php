<?php
/**
 * Table Definition for ad_account
 */
require_once 'DB/DataObject.php';

class DataObject_Ad_account extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'ad_account';          // table name
    public $id;                              // int(4)  primary_key not_null
    public $nombre;                          // varchar(255)  
    public $act_fanpage;                     // varchar(255)  
    public $id_fanpage;                      // varchar(255)  

    function table()
    {
         return array(
             'id' =>  DB_DATAOBJECT_INT + DB_DATAOBJECT_NOTNULL,
             'nombre' =>  DB_DATAOBJECT_STR,
             'act_fanpage' =>  DB_DATAOBJECT_STR,
             'id_fanpage' =>  DB_DATAOBJECT_STR,
         );
    }

    function keys()
    {
         return array('id');
    }

    function sequenceKey() // keyname, use native, native name
    {
         return array('id', true, false);
    }

    function defaults() // column default values 
    {
         return array(
             '' => null,
         );
    }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
