<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
    'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
    'name'=>'platform',
    'charset' => 'utf-8',
    'language' => 'zh_cn',
    'timeZone' => 'Asia/Shanghai',

    // preloading 'log' component
    'preload'=>array('log'),

    // autoloading model and component classes
    'import'=>array(
        'application.models.*',
        'application.components.*',
        'ext.YiiMongoDbSuite.*',
        'ext.YiiMongoDbSuite.extra.*',
        'ext.MongoDocument',
        'ext.ActiveForm',
        'ext.ActiveRecord',
        'ext.FormModel',
        'ext.Html5',
        'ext.Tree',
    ),

    'modules'=>array(
        // uncomment the following to enable the Gii tool
        /*
        'gii'=>array(
            'class'=>'system.gii.GiiModule',
            'password'=>'Enter Your Password Here',
             // If removed, Gii defaults to localhost only. Edit carefully to taste.
            'ipFilters'=>array('127.0.0.1','::1'),
        ),
        */
        'gii'=>array(
            'class'=>'system.gii.GiiModule',
            'password'=>'1',
            // add additional generator path
            'generatorPaths'=>array(
                'ext.YiiMongoDbSuite.gii'
            ),
        ),
        'passport',     //运维模块 系统信息 账号 密码 
        'core',         //运营模块  核心数据分析
        'install',      //数据初始化模块
        'restfulApi',   //api模块 提交接口供游戏请求
        'service',      //客服模块 包含玩家交互 以及GM管理
        'log',          //日志模块
        'realtime',     //实时数据查询模块
        'cron',         //计划任务模块
        'approve',      //事务审批模块
        'tools',        //日常维护模块
    ),

    'defaultController' => 'passport',
    'homeUrl' => array('/passport/role/rolelist'),
    // application components
    'components'=>array(
        'user'=>array(
            // enable cookie-based authentication
            'class'=>'WebUser',
            'allowAutoLogin'=>true,
        ),
        // uncomment the following to enable URLs in path-format

        'urlManager'=>array(
            'urlFormat'=>'path',
            'showScriptName'=>false,
            'rules'=>array(
                '<controller:\w+>/<id:\d+>'=>'<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
                '<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
            ),
        ),

        //Yii::App()->webBrowser->get("http://example.com");
        //Yii::App()->webBrowser->getResponseText();
//        'webBrowser' => array(
//            'class'     => 'application.components.DGWebBrowser.DGWebBrowser',
//            'adapter'    => 'sockets' // curl | sockets | fopen
//        ),

        'clientScript' => array(
            'class' => 'CClientScript',
            'corePackages' => require(__DIR__ . '/packages.php'),
            'coreScriptUrl' => '/source',
        ),
        
        'cache'=>array(
            'class'=>'CMemCache',
            'servers'=>array(
                array(
                    'host' => '127.0.0.1',
                    'port' => 11211,
                    'weight' => 60,
                ),
            ),
        ),

        //mongodb://username:pwd@host:port/db
        'mongodb' => array(
            'class'             => 'EMongoDB',
            'connectionString'  => 'mongodb://platform:111111@localhost:27017/platform',
            'dbName'            => 'platform',
            'fsyncFlag'         => false,
            'safeFlag'          => false,
            'useCursor'         => false,
        ),

        /*
        'mongodb_passport' => array(
            'class'             => 'EMongoDB',
            'connectionString'  => 'mongodb://platform:111111@localhost:27017/passport',
            'dbName'            => 'passport',
            'fsyncFlag'         => false,
            'safeFlag'          => false,
            'useCursor'         => false,
        ),
        
        'db_passport'=>array(
            'connectionString' => 'mysql:host=localhost;dbname=passport',
            'emulatePrepare' => true,
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
            'tablePrefix' => 'bl_',
        ),
        */
        
        'db'=>array(
            'class' => 'CDbConnection',
            'connectionString' => 'mysql:host=localhost;dbname=platform',
            'emulatePrepare' => true,
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
            'schemaCachingDuration' => 3600,
        ),
        
        'errorHandler'=>array(
            // use 'site/error' action to display errors
            'errorAction'=>'site/error',
        ),
        'log'=>array(
            'class'=>'CLogRouter',
            'routes'=>array(
                array(
                    'class'=>'CFileLogRoute',
                    'levels'=>'error, warning, info, profiler, trace', //
                ),
                // uncomment the following to show log messages on web pages
                /*
                array(
                    'class'=>'CWebLogRoute',
                ),
                */
            ),
        ),
    ),

    // application-level parameters that can be accessed
    // using Yii::app()->params['paramName']
    'params'=>array(
        'adminEmail'=>'webmaster@example.com',
        'socket_password'=>'boluo123', //socket通讯密码
        'socket_ip'=>'172.16.2.74', //socket通讯IP
        'socket_port'=>'20005', //socket通讯端口
        'version'=>'1.0.0', //版本号
    ),
);