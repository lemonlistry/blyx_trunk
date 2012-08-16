<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="language" content="zh-CN" />
    <title><?php echo Yii::app()->name; ?></title>
    <?php 
        Yii::app()->clientScript->registerCoreScript('extjs');
    ?>
</head>
<body>

<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/source/js/ExtJS/locale/ext-lang-zh_CN.js"></script>
<script type="text/javascript">
var js_url_path = '<?php echo Yii::app()->params['js_url_path']; ?>';
var js_source_path = '<?php echo Yii::app()->request->baseUrl; ?>';
Ext.onReady(function(){
    window.myMask= new Ext.LoadMask(Ext.getBody(), {msg:"loading..."});     
    myMask.show();
});
</script>
  
        <?php echo $content; ?>


<script type="text/javascript">
var executeTime = '执行时间：<?php echo printf("%.2f", Yii::getLogger()->getExecutionTime()); ?>秒';
typeof console != 'undefined' && console.log(executeTime);
</script>
</body>
</html>