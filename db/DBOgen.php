<?php
require_once('DBO.php');

function regenerateDataObject()
{
    require_once 'DB/DataObject/Generator.php';
    $generator = new DB_DataObject_Generator;
    $generator->start();
}

regenerateDataObject();
?>