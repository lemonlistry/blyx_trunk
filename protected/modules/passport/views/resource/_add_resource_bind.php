<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="language" content="zh-CN" />
<title>添加资源绑定</title>
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
	echo "var resource_list=".json_encode($resource_list).";";
	echo 'var action="'.$action.'";';
    echo "var model = " . json_encode($model) . ";";
?>

var resource_list_arr = build.array( resource_list );
build.convert2Int('resource_id',model);

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
				xtype : 'combo',
				afterLabelTextTpl: required,
				fieldLabel: '资源类型',
	            emptyText: '资源类型',
				valueField:'value',
				displayField:'name',
	            editable:false,
				value: model.resource_id,
				store:new Ext.data.SimpleStore({
					fields:['name','value'],
					data : resource_list_arr
				}),
				name: 'ResourceRelate[resource_id]'
			},{
				xtype: 'textfield',
				fieldLabel: '资源路径',
				name: 'ResourceRelate[path]',
				afterLabelTextTpl: required,
				value : model.path,
				maxLength:100,
				maxLengthText:'此项长度不能超出100'
			},{
				xtype: 'textfield',
				name: 'ResourceRelate[id]',
				hidden: true,
				hideLabel:true,
				value:model.id,
				allowBlank:true
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
				     formCallback.alert( action.result );
				 },
				 failure: function(form, action) {
				     formCallback.alert( action.result );
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