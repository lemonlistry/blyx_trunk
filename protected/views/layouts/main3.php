<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="language" content="zh-CN" />
    <title><?php echo Yii::app()->name; ?></title>
    

    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/source/js/ExtJS/resources/css/ext-all.css" /> 
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/source/js/ExtJS/layout-browser.css" />
	
    
	
</head>
<body>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/source/js/ExtJS/ext-all.js"></script>
<script type="text/javascript">

var js_url_path = '<?php echo Yii::app()->params['js_url_path']; ?>';
var js_source_path = '<?php echo Yii::app()->request->baseUrl; ?>';

Ext.onReady(function(){
    window.myMask= new Ext.LoadMask(Ext.getBody(), {msg:"loading..."});     
    myMask.show();
});

</script>

<?php echo $content; ?>




<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/source/js/ExtJS/main.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/source/js/ExtJS/layout-browser.js"></script>
<script type="text/javascript">
//Ext.BLANK_IMAGE_URL ="/source/js/ExtJS/resources/themes/images/default/tree/s.gif";

var top_admin = '<p id="welcome" style="float:right;">欢迎您，<?php echo Yii::app()->user->name; ?>！<a href="<?php echo $this->createUrl('/passport/default/updatepassword'); ?>" class="js-dialog-link" data-height="190" data-width="515">更改密码</a>|<a href="<?php echo $this->createUrl('/passport/default/logout'); ?>">退出</a></p>'; 

window.onload=function(){
    ChangePass();
    cashTreePos();
}

function cashTreePos(){
    var treeBody =document.getElementById('treeview-1012');
    if( window.tree_cid == 'undefined'){
        window.tree_cid=1;
    }else{
        window.tree_cid++;
    }
    if( window.tree_cid >10) return;
    if( treeBody == null ){
        setTimeout(function(){
            cashTreePos();
        },300);
    }else{
        treeBody.onscroll=function(){
            var pos = treeBody.scrollTop;
            Ext.Cookies.set("currentPos", pos);  
        }
    }
}

function ChangePass(){
    if( typeof window.changePass_cid == 'undefined'){
        window.changePass_cid=1;
    }else{
        window.changePass_cid++;
    }
    if( window.changePass_cid >10 ) return ;
    var len = Ext.select('.js-dialog-link').elements.length;
    if( len!= 0){
        window.initLink();
    }else{
        setTimeout(function(){
            ChangePass();
        },500);
    }
}

</script>
</body>
</html>