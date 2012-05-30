<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="language" content="zh-CN" />
    <title><?php echo Yii::app()->name; ?></title>
    <link href="<?php echo Yii::app()->request->baseUrl;?>/css/passport/global.css?v=<?php echo Yii::app()->params['version']; ?>" rel="stylesheet" type="text/css" />
</head>
<body>
<div id="container">

    <div id="banner"><h1>管理平台</h1></div>
    
    <div id="nav">
        <ul>
            <li class="inactive" id="other"><a href="#">管理操作</a></li>
            <li class="inactive" id="about"><a href="#">管理操作</a></li>
            <li class="inactive" id="user"><a href="#">管理操作</a></li>
            <li class="inactive" id="news"><a href="#">管理操作</a></li>
            <li class="inactive" id="mars"><a href="#">管理操作</a></li>
            <li class="inactive" id="jielong"><a href="#">管理操作</a></li>
            <li class="inactive" id="box"><a href="#">管理操作</a></li>
            <li class="inactive" id="school"><a href="#">管理操作</a></li>
            <li class="active" id="config"><a href="#">管理操作</a></li>
        </ul>
    </div>
    
    <div id="main">
        <div id="welcome">欢迎您 , <?php echo Yii::app()->user->name; ?> !</div>
        <div id="adminop">
            <ul>
                <li><a href="<?php echo $this->createUrl('/passport/default/logout'); ?>">退出</a></li>
            </ul>
        </div>
    </div>
    
    <div>
        <div id="menu">
            <ul>
                <li><img src="<?php echo Yii::app()->request->baseUrl;?>/images/passport/li.jpg" />&nbsp;&nbsp;&nbsp; <a href="#">操作一</a></li>
                <li><img src="<?php echo Yii::app()->request->baseUrl;?>/images/passport/li.jpg" />&nbsp;&nbsp;&nbsp; <a href="#">操作二</a></li>
                <li><img src="<?php echo Yii::app()->request->baseUrl;?>/images/passport/li.jpg" />&nbsp;&nbsp;&nbsp; <a href="#">操作三</a></li>
                <li><img src="<?php echo Yii::app()->request->baseUrl;?>/images/passport/li.jpg" />&nbsp;&nbsp;&nbsp; <a href="#">操作四</a></li>
            </ul>
        </div>
        <?php echo $content; ?>
    </div>
    
</div>

<div id="bottom">
    Copyright &copy; 2009-<?php echo date('Y'); ?> By blyx . All Rights Reserved.<br/>
    <p>版本：<?php echo Yii::app()->params['version']; ?> &nbsp;&nbsp; 执行时间：<?php echo printf("%.2f", Yii::getLogger()->getExecutionTime()); ?>秒 </p>
</div>

<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl;?>/js/jquery/jquery-1.7.2.min.js?v=<?php echo Yii::app()->params['version']; ?>"></script>

</body>
</html>