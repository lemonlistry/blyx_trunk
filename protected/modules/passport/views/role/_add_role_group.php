<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="language" content="zh-CN" />
<title>添加角色类型</title>
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
	echo 'var data='.json_encode($model).';';
	echo 'var action="'.$action.'";';
?>


Ext.onReady(function(){
Ext.QuickTips.init();
 
var required = '<span style="color:red;font-weight:bold" data-qtip="Required">*</span>';
var role_group = Ext.widget({
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
			labelWidth: 150,
			allowBlank:false,
			blankText:'此项不能为空'
		},
		width: '100%',
		layout : "form",
		items:[
			{
				fieldLabel: '角色类型名称',
				xtype: 'textfield',
				name: 'RoleGroup[name]',
				afterLabelTextTpl: required,
				value: data.name,
				maxLength:20,
				maxLengthText:'此项长度不能超出20'
			},{
				xtype: 'textfield',
				fieldLabel: '角色类型描述',
				name: 'RoleGroup[desc]',
				afterLabelTextTpl: required,
				value : data.desc,
				maxLength:20,
				maxLengthText:'此项长度不能超出20'
			},{
				xtype: 'textfield',
				name: 'RoleGroup[id]',
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
			 if (!role_group.getForm().isValid()) {
				 Ext.Msg.alert('提示', '请正确地填写必要数据');
				 return ;
			 }
			 role_group.getForm().submit({
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

role_group.render('add_role_group');

myMask.hide();  
});
</script>

</body>
</html>