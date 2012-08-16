<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="language" content="zh-CN" />
<title>添加公告</title>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/source/js/ExtJS/resources/css/ext-all.css" />
<style type="text/css">
</style>
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
    echo 'var server_obj='.json_encode($select).';'; 
    echo 'var action="'.$action.'";'; 
?>

var server_store    = build.array( server_obj );
var time_after_5 = date.format( (new Date().valueOf()+5*60*1000),'ISO8601Long');
var time_after_10 = date.format( (new Date().valueOf()+10*60*1000),'ISO8601Long');
Ext.onReady(function(){
Ext.QuickTips.init();
var required = '<span style="color:red;font-weight:bold" data-qtip="Required">*</span>';
var server_form = Ext.widget({
    xtype: 'form',
    frame: true,
    bodyPadding: '5 5 0',
    width: 500,
    height:250,
    buttonAlign : 'right',
    labelAlign : 'right',
    fieldDefaults: {
        msgTarget: 'side',
        labelWidth: 52
    },
    defaultType: 'textfield',
    items: [{
        xtype: 'fieldset',
        defaultType: 'textfield',
        layout: 'anchor',
        defaults: {
            anchor: '100%',
            labelWidth: 110,
            columnWidth : 1,
            allowBlank:false,
            blankText:'此项不能为空',
            labelAlign: 'right'
        },
        width: '100%',
        layout : "column",
        items:[
            {
                xtype : 'combo',
                fieldLabel: '服务器',
                emptyText: '',
                valueField:'value',
                displayField:'name',
                editable : false,
                store:new Ext.data.SimpleStore({  
                    fields:['name','value'],  
                    data : server_store
                }),
                name:'Notice[server_id]',
                afterLabelTextTpl: required
            },
            {
                fieldLabel: '时间间隔(秒)',
                xtype: 'textfield',
                name: 'Notice[interval_time]',
                afterLabelTextTpl: required,
                vtype : 'Integer',
                validator : function(value){
                    if(parseInt(value , 10) < 60){
                        return '最小时间间隔为60秒';
                    }
                    return true;
                }
            },{
                xtype: 'datefield',
                fieldLabel: '公告发送开始时间',
                format:'Y-m-d H:i:s',
                editable : true,
                name: 'Notice[begin_time]',
                afterLabelTextTpl: required,
                value : time_after_5,
                validator : function(value){
                    var date = new Date();
                    var begin_time = new Date(value);
                    if( date.valueOf() > begin_time.valueOf() ){
                        return '公告发送开始时间应该大于当前时间';
                    }
                    return true;
                }
            },{
                xtype: 'datefield',
                fieldLabel: '公告发送结束时间',
                format:'Y-m-d H:i:s',
                editable : true,
                name: 'Notice[end_time]',
                afterLabelTextTpl: required,
                value : time_after_10,
                validator : function(value){
                    var begin_time = server_form.getForm().findField('Notice[begin_time]').getValue();
                    begin_time = begin_time == null ? 0 : begin_time.valueOf();
                    var interval_time = server_form.getForm().findField('Notice[interval_time]').getValue();
                    var end_time = value == null ? 0 : new Date(value).valueOf();
                    if((parseInt(begin_time || 0, 10) + parseInt(interval_time || 0, 10) * 1000) > end_time){
                        return '公告发送结束时间应该大于开始时间与间隔时间之和';
                    }
                    return true;
                }
            },{
                xtype: 'textarea',
                fieldLabel: '公告内容',
                name: 'Notice[content]',
                afterLabelTextTpl: required
            },{
                xtype: 'textfield',
                name: 'Notice[id]',
                hidden: true,
                hideLabel:true,
                value : 0,
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

window.server_form = server_form;
myMask.hide();
});
</script>

</body>
</html>