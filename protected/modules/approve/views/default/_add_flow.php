<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="language" content="zh-CN" />
<title>添加添加流程</title>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/source/js/ExtJS/resources/css/ext-all.css" /> 

</head>
<body>
<div id="search-player"></div>

<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/source/js/ExtJS/ext-all.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/source/js/ExtJS/main.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/source/js/ExtJS/locale/ext-lang-zh_CN.js"></script>
<script type="text/javascript">
Ext.onReady(function(){
    window.myMask= new Ext.LoadMask(Ext.getBody(), {msg:"loading..."});     
    myMask.show();
});
<?php
    echo "var action = '" . $action . "';";
?>
Ext.onReady(function(){
Ext.QuickTips.init();
 
var required = '<span style="color:red;font-weight:bold" data-qtip="Required">*</span>';
var mg_form = Ext.widget({
    xtype: 'form',
    frame: true,
    bodyPadding: '5 5 0',
    width: 500,
    height:160,
    buttonAlign : 'right',
    labelAlign : 'right',
    fieldDefaults: {
        msgTarget: 'side',
        labelWidth: 52
    },
    defaultType: 'textfield',
    items: [{
        xtype: 'fieldset',
        title: '',
        defaultType: 'textfield',
        layout: 'anchor',
        defaults: {
            anchor: '100%',
            labelWidth: 80,
            allowBlank:false,
            blankText:'此项不能为空'
        },
        width: '100%',
        layout : "form",
        items:[
            {
                fieldLabel: '标签',
                xtype: 'textfield',
                name: 'Flow[tag]',
                afterLabelTextTpl: required,
                value : '',
                maxLength:25,
				maxLengthText:'此项长度不能超出25'
            },
            {
                fieldLabel: '名称',
                xtype: 'textfield',
                name: 'Flow[name]',
                afterLabelTextTpl: required,
                value : '',
                maxLength:255,
				maxLengthText:'此项长度不能超出255'
            },
            {
                fieldLabel: '描述',
                xtype: 'textfield',
                name: 'Flow[desc]',
                afterLabelTextTpl: required,
                value : '',
                maxLength:255,
				maxLengthText:'此项长度不能超出255'
            },
            {
                xtype: 'textfield',
                name: 'Flow[id]',
                hidden: true,
                hideLabel:true,
                value : '',
                allowBlank:true
            }
        ]
    }],
    buttons: [{
        text: '提交',
        handler : function(){
             if (!mg_form.getForm().isValid()) {
                 Ext.Msg.alert('提示', '请正确地填写必要数据');
                 return ;
             }
             mg_form.getForm().submit({
                 waitMsg: '正在提交数据',
                 waitTitle: '提示',
                 url: action,
                 method: 'POST',
                 success: function(form, action) {
                     formCallback.alert( action.result );
                 },
                 failure: function(form, action) {
                     formCallback.alert( action.result );
                 }
             });
        }
    }]
});

mg_form.render('search-player');

myMask.hide();  
});
</script>

</body>
</html>