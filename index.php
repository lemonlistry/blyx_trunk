<?php
header("Content-type:text/html;charset=utf-8");
// change the following paths if necessary
$yii=dirname(__FILE__).'/framework/yii.php';
//$config=dirname(__FILE__).'/protected/config/main.php';
// remove the following lines when in production mode
defined('YII_DEBUG') or define('YII_DEBUG',true);
// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);

require_once($yii);
$config = CMap::mergeArray(require dirname(__FILE__).'/protected/config/main.php', require dirname(__FILE__).'/protected/config/db_config.php');
Yii::createWebApplication($config)->run();
