<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="language" content="zh-CN" />
<title>事务审批</title>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/source/js/ExtJS/resources/css/ext-all.css" />
</head>
<body>
<div id="add_role_group"></div>

<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/source/js/ExtJS/ext-all.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/source/js/ExtJS/main.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/source/js/ExtJS/locale/ext-lang-zh_CN.js"></script>
<script type="text/javascript">
Ext.onReady(function(){
    window.myMask= new Ext.LoadMask(Ext.getBody(), {msg:"loading..."});     
    myMask.show();
});
<?php
    echo 'var action = "' . $action.'";';
    echo 'var status_arr = ' . json_encode($model->getStatus()) . ';';
?>


var status_store = build.array( status_arr );

Ext.onReady(function(){
Ext.QuickTips.init();

var required = '<span style="color:red;font-weight:bold" data-qtip="Required">*</span>';
var user = Ext.widget({
    xtype: 'form',
    frame: true,
    bodyPadding: '5 5 0',
    width: 500,
    height:150,
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
            labelWidth: 100,
            allowBlank:false,
            blankText:'此项不能为空'
        },
        width: '100%',
        layout : "form",
        items:[
            {
                xtype : 'combo',
                afterLabelTextTpl: required,
                fieldLabel: '状态',
                valueField:'value',
                displayField:'name',
                value: 1,
                store:new Ext.data.SimpleStore({
                    fields:['name','value'],
                    data : status_store
                }),
                name: 'Approve[status]'
            },{
                xtype: 'textfield',
                fieldLabel: '评论',
                name: 'Approve[comment]',
                afterLabelTextTpl: required
            }
        ]
    }],
    buttons: [{
        text: '提交',
        handler : function(){
             if (!user.getForm().isValid()) {
                 Ext.Msg.alert('提示', '请正确地填写必要数据');
                 return ;
             }
             user.getForm().submit({
                 waitMsg: '正在提交数据',
                 waitTitle: '提示',
                 url: action,
                 method: 'POST',
                 success: function(form, action) {
                     Ext.Msg.alert('提示', action.result.text,function(){
                        if(action.result.success  && typeof window.parent != window){
                            window.parent.location.reload();
                        }
                    });
                 },
                 failure: function(form, action) {
                     var msg=unescape(Ext.encode(action.result));
                     Ext.Msg.alert('提示', '原因如下：<br>'+msg);
                 }
             });
        }
    }]
});

user.render('add_role_group');

myMask.hide();
});
</script>

</body>
</html>