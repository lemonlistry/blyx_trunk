<?php return array("components"=>array('db1' => array(
    'class' => 'CDbConnection',
    'connectionString' => 'mysql:host=172.16.7.4;dbname=ljh;port=3306',
    'emulatePrepare' => true,
    'username' => 'root',
    'password' => '111111',
    "charset" => "utf8",
),'db4' => array(
    'class' => 'CDbConnection',
    'connectionString' => 'mysql:host=172.16.6.242;dbname=ljh;port=3306',
    'emulatePrepare' => true,
    'username' => 'ljh_blyx',
    'password' => '111111',
    "charset" => "utf8",
),));