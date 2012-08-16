<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="language" content="zh-CN" />
<title>添加礼包</title>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/source/js/ExtJS/resources/css/ext-all.css" />
</head>
<body>
<div id="search-player"></div>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/source/js/ExtJS/ext-all.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/source/js/ExtJS/main.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/source/js/ExtJS/locale/ext-lang-zh_CN.js"></script>
<script type="text/javascript">
var js_url_path = '<?php echo Yii::app()->params['js_url_path']; ?>';
Ext.onReady(function(){
    window.myMask= new Ext.LoadMask(Ext.getBody(), {msg:"loading..."});
    myMask.show();
});


<?php
    echo 'var server_obj='.json_encode($select).';';
    echo 'var action="'.$action.'";';
?>
var server_arr = build.array( server_obj );
Ext.onReady(function(){
Ext.QuickTips.init();

var required = '<span style="color:red;font-weight:bold" data-qtip="Required">*</span>';
var forbidden_form = Ext.widget({
    xtype: 'form',
    id: '',
    frame: true,
    title: '',
    bodyPadding: '5 5 0',
    width: 500,
    height:240,
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
            labelWidth: 100,
            allowBlank:false,
            blankText:'此项不能为空',
            width: 455
        },
        width: '100%',
        layout : "column",//column
        items:[
            {
                xtype: 'combo',
                fieldLabel: '服务器',
                name: 'Gift[server_id]',
                afterLabelTextTpl: required,
                value : '',
                emptyText: '服务器类型',
                editable: false,
                valueField:'value',
                displayField:'name',
                store:new Ext.data.SimpleStore({
                    fields:['name','value'],
                    data:server_arr
                }),
                value: server_arr[0][1]
            },
            {
                fieldLabel: '角色名称',
                xtype: 'textfield',
                name: 'Gift[role_name]',
                afterLabelTextTpl: required,
                value : '',
                maxLength:255,
                maxLengthText:'此项长度不能超出255'
            },
            {
                fieldLabel: '礼包名称',
                xtype: 'textfield',
                name: 'Gift[name]',
                afterLabelTextTpl: required,
                value : '',
                maxLength:255,
                maxLengthText:'此项长度不能超出255'
            },
            {
                fieldLabel: '物品ID',
                xtype: 'textfield',
                name: 'Gift[item_id]',
                afterLabelTextTpl: required,
                value : '',
                vtype:'Integer',
                width: 320,
                listeners: {
                    blur: function(){
                        var id = forbidden_form.getForm().findField('Gift[item_id]').getValue();
                        if( !id ) return ;
                        myMask.show();
                        Ext.Ajax.request({
                            url: js_url_path + '/index.php?r=/service/gift/getgiftnamebyid',
                            method:'POST',
                            params: {
                                item_id : id
                            },
                            success: function(response){
                                myMask.hide();
                                var json = Ext.JSON.decode( response.responseText );
                                var target = forbidden_form.getForm().findField('item_name_server');
                                window.item_id_isValid = json.success;
                                target.setValue( json.text );
                            }
                        });
                    }
                },
            },
            {
                xtype: 'textfield',
                width: 125,
                readOnly: true,
                name: 'item_name_server',
                style: 'margin-left:10px;',
                allowBlank:false
            },
            {
                fieldLabel: '数量',
                xtype: 'textfield',
                name: 'Gift[num]',
                afterLabelTextTpl: required,
                value : '',
                vtype:'Integer'
            },
            {
                fieldLabel: '有效时间',
                xtype: 'textfield',
                name: 'Gift[time]',
                afterLabelTextTpl: required,
                value : '',
                vtype:'Integer'
            }
        ]
    }],
    buttons: [{
        text: '提交',
        handler : function(){
             if (!forbidden_form.getForm().isValid()) {
                 Ext.Msg.alert('提示', '请正确地填写必要数据');
                 return ;
             }
             if( !window.item_id_isValid ) {
                 Ext.Msg.alert('提示', '无效的礼包ID');
                 return ;
             }
             var role_name = forbidden_form.getForm().findField('Gift[role_name]').getValue();
             if(!role_name ){
                 Ext.Msg.alert('提示', '请输入角色名称');
                 return ;
             }
             forbidden_form.getForm().submit({
                 waitMsg: '正在提交数据',
                 waitTitle: '提示',
                 url: action ,
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

forbidden_form.render('search-player');

myMask.hide();
});
</script>

</body>
</html>