<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="language" content="zh-CN" />
<title>修改密码</title>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/source/js/ExtJS/resources/css/ext-all.css" />
</head>
<body>
<div id="changpass"></div>

<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/source/js/ExtJS/ext-all.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/source/js/ExtJS/main.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/source/js/ExtJS/locale/ext-lang-zh_CN.js"></script>
<script type="text/javascript">
<?php
    echo 'var action="'.$action.'";';
?>
var myMask= new Ext.LoadMask(Ext.getBody(), {msg:"loading..."});
myMask.show();
Ext.onReady(function(){
Ext.QuickTips.init();

var required = '<span style="color:red;font-weight:bold" data-qtip="Required">*</span>';
var role = Ext.widget({
	xtype: 'form',
	id: '',
	frame: true,
	title: '',
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
			blankText:'此项不能为空',
			afterLabelTextTpl: required,
		},
		width: '100%',
		layout : "form",//column
		items:[
			{
				fieldLabel: '原密码',
				inputType:'password',
				name: 'old_password',
			},{
				fieldLabel: '新密码',
				inputType:'password',
				name: 'new_password',
				id: 'new_password',
				minLength:6,
                                minLengthText:'密码长度最少6位！',
                                maxLength:20,
                                maxLengthText:'密码长度最多20位！'
			},{
				fieldLabel: '确认新密码',
				inputType:'password',
				name: 'confirm_password',
                                vtype:'Password',
                                initialPassField : 'new_password'
			}
		]
	}],
	buttons: [{
		text: '提交',
		handler : function(){
			 if (!role.getForm().isValid()) {
				 Ext.Msg.alert('提示', '请正确地填写必要数据');
				 return ;
			 }
			 role.getForm().submit({
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

role.render('changpass');

myMask.hide();
});
</script>

</body>
</html>