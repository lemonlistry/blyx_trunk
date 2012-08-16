<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="language" content="zh-CN" />
<title>添加节点</title>
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
    echo "var model=".json_encode($model).";";
    echo 'var action="'.$action.'";';
    echo 'var flow_list='.json_encode($flow_list).';';
    echo 'var user_list='.json_encode($user_list).';';
?>

var flow_list_arr = build.array( flow_list );
var user_list_arr = build.array( user_list );
build.convert2Int('flow_id',model);



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
            labelWidth: 150,
            allowBlank:false,
            blankText:'此项不能为空'
        },
        width: '100%',
        layout : "form",
        items:[
            {
                xtype: 'combo',
                fieldLabel: '流程',
                emptyText: '流程',
                name: 'Node[flow_id]',
                afterLabelTextTpl: required,
                value : model.flow_id,
                editable: false,
                valueField:'value',
                displayField:'name',
                store:new Ext.data.SimpleStore({  
                    fields:['name','value'],  
                    data:flow_list_arr
                })
            },
            {
                fieldLabel: '名称',
                xtype: 'textfield',
                name: 'Node[name]',
                afterLabelTextTpl: required,
                value : name
            },
            {
                xtype: 'combo',
                fieldLabel: '用户',
                emptyText: '用户',
                name: 'Node[user_id]',
                afterLabelTextTpl: required,
                editable: false,
                valueField:'value',
                displayField:'name',
                store:new Ext.data.SimpleStore({  
                    fields:['name','value'],  
                    data : user_list_arr
                })
            },
            {
                xtype: 'textfield',
                name: 'Node[id]',
                hidden: true,
                hideLabel:true,
                value : "<?php echo $model->isNewRecord ? 0 : $model->id; ?>",
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
    }],
    renderTo : Ext.get('search-player')
});

myMask.hide();  
});
</script>

</body>
</html>