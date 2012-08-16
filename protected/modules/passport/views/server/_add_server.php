<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="language" content="zh-CN" />
<title>添加服务器</title>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/source/js/ExtJS/resources/css/ext-all.css" />
<style type="text/css">
#search-player{
    width:500px;
    height:540px;
    margin:0 auto;
}
.tips{
    line-height:25px;
    padding-left:25px;
}
.firm{
    color:red;
    font-weight:bold;
}
</style>
</head>
<body>
<h4 class="tips">注:服务器ID添加之后，<span class="firm">不可编辑</span></h4>
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
    echo "var data = " . json_encode($model) . ";";
    echo "var flag = '" . $model->getIsNewRecord() . "';";
    echo 'var status_arr = ' . json_encode($model->getServerStatus()) . ';';
    echo 'var type_arr = ' . json_encode($model->getServerType()) . ';';
    echo 'var recommand_arr = ' . json_encode($model->getServerRecommend()) . ';';
    echo "var action = '" . $action . "';";
?>

var status_store    = build.array( status_arr ),
    type_store      = build.array( type_arr ),
    recommand_store = build.array( recommand_arr );

build.convert2Int(['status','recommend','type'],data);




Ext.onReady(function(){
Ext.QuickTips.init();
var required = '<span style="color:red;font-weight:bold" data-qtip="Required">*</span>';
var server_form = Ext.widget({
    xtype: 'form',
    frame: true,
    bodyPadding: '5 5 0',
    width: 500,
    height:540,
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
            labelWidth: 150,
            allowBlank:false,
            blankText:'此项不能为空'
        },
        width: '100%',
        layout : "form",
        items:[
            {
                fieldLabel: '服务器ID',
                xtype: 'textfield',
                name: 'Server[server_id]',
                afterLabelTextTpl: required,
                vtype:'Integer',
                value : data.server_id,
                disabled : !flag
            },
            {
                fieldLabel: '游戏名称',
                xtype: 'textfield',
                name: 'Server[gname]',
                afterLabelTextTpl: required,
                value:data.gname,
                maxLength:19,
                maxLengthText:'游戏名称过长'
            },{
                xtype: 'textfield',
                fieldLabel: '服务器名称',
                name: 'Server[sname]',
                afterLabelTextTpl: required,
                value:data.sname,
                maxLength:33,
                maxLengthText:'服务器名称长度超出33'
            },{
                xtype: 'datefield',
                format:'Y-m-d H:i:s',
                fieldLabel: '开服时间',
                editable: true,
                name: 'Server[create_time]',
                afterLabelTextTpl: required,
                value : data.create_time
            },{
                xtype: 'combo',
                fieldLabel: '服务器状态',
                emptyText: '服务器状态',
                name: 'Server[status]',
                afterLabelTextTpl: required,
                value: data.status ,
                editable: false,
                valueField:'value',
                displayField:'name',
                store:new Ext.data.SimpleStore({
                    fields:['name','value'],
                    data:status_store
                })
            },{
                xtype: 'combo',
                fieldLabel: '服务器标记',
                name: 'Server[recommend]',
                afterLabelTextTpl: required,
                value:data.recommend ,
                emptyText: '服务器标记',
                editable: false,
                valueField:'value',
                displayField:'name',
                store:new Ext.data.SimpleStore({
                    fields:['name','value'],
                    data:recommand_store
                })

            },{
                xtype: 'combo',
                fieldLabel: '服务器类型',
                name: 'Server[type]',
                afterLabelTextTpl: required,
                value:data.type ,
                emptyText: '服务器类型',
                editable: false,
                valueField:'value',
                displayField:'name',
                store:new Ext.data.SimpleStore({
                    fields:['name','value'],
                    data:type_store
                })
            },{
                xtype: 'textfield',
                fieldLabel: '数据库地址',
                name: 'Server[db_ip]',
                afterLabelTextTpl: required,
                value:data.db_ip,
                vtype:'IPAddress'
            },{
                xtype: 'textfield',
                fieldLabel: '数据库端口',
                name: 'Server[db_port]',
                afterLabelTextTpl: required,
                value:data.db_port,
                vtype:'Integer'
            },{
                xtype: 'textfield',
                fieldLabel: '数据库名称',
                name: 'Server[db_name]',
                afterLabelTextTpl: required,
                value:data.db_name,
                maxLength:19,
                maxLengthText:'数据库名长度超出19'
            },{
                xtype: 'textfield',
                fieldLabel: '数据库账号名',
                name: 'Server[db_user]',
                afterLabelTextTpl: required,
                value:data.db_user,
                maxLength:19,
                maxLengthText:'数据库账号名长度超出19'
            },{
                xtype: 'textfield',
                fieldLabel: '数据库密码',
                name: 'Server[db_passwd]',
                afterLabelTextTpl: required,
                value:data.db_passwd,
                maxLength:19,
                maxLengthText:'数据库密码长度超出19'
            },{
                xtype: 'textfield',
                fieldLabel: 'web服务器IP',
                name: 'Server[web_ip]',
                afterLabelTextTpl: required,
                value:data.web_ip,
                vtype:'IPAddress'
            },{
                xtype: 'textfield',
                fieldLabel: 'web服务器端口',
                name: 'Server[web_socket_port]',
                afterLabelTextTpl: required,
                value:data.web_socket_port,
                vtype:'Integer'
            },{
                xtype: 'textfield',
                fieldLabel: '网关服务器IP',
                name: 'Server[gateway_ip]',
                afterLabelTextTpl: required,
                value:data.gateway_ip,
                vtype:'IPAddress'
            },{
                xtype: 'textfield',
                fieldLabel: '网关服务器端口',
                name: 'Server[gateway_socket_port]',
                afterLabelTextTpl: required,
                value:data.gateway_socket_port,
                vtype:'Integer'
            },{
                xtype: 'textfield',
                name: 'Server[id]',
                hidden: true,
                hideLabel:true,
                value:data.id,
                allowBlank:true
            }
        ]
    }],
    buttons: [{
        text: '提交',
        handler : function(){
             if (!server_form.getForm().isValid()) {
                 Ext.Msg.alert('提示', '请正确地填写必要数据');
                 return ;
             }
             server_form.getForm().submit({
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
    }],
    renderTo : Ext.get('search-player')
});


myMask.hide();
});
</script>

</body>
</html>
