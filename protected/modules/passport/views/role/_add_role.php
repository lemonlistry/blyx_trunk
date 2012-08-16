<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="language" content="zh-CN" />
<title>添加角色</title>
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
    echo "var group_id=".json_encode($group_list).";";
    echo "var model = " . json_encode($model) . ";";
    echo 'var action="'.$action.'";';
?>

var group_id_arr = build.array( group_id );
build.convert2Int(['group_id'],model);


Ext.onReady(function(){
Ext.QuickTips.init();

var required = '<span style="color:red;font-weight:bold" data-qtip="Required">*</span>';
var role = Ext.widget({
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
			labelWidth: 70,
			allowBlank:false,
			blankText:'此项不能为空'
		},
		width: '100%',
		layout : "form",
		items:[
			{
				xtype : 'combo',
				afterLabelTextTpl: required,
				fieldLabel: '角色类型',
                emptyText: '角色类型',
				valueField:'value',
				displayField:'name',
	            editable:false,
				value: model.group_id,
				store:new Ext.data.SimpleStore({
					fields:['name','value'],
					data : group_id_arr
				}),
				name: 'Role[group_id]'
			},{
				xtype: 'textfield',
				fieldLabel: '角色名称',
				name: 'Role[name]',
				afterLabelTextTpl: required,
				value : model.name,
				maxLength:20,
				maxLengthText:'此项长度不能超出20'
			},{
				xtype: 'textfield',
				fieldLabel: '角色描述',
				name: 'Role[desc]',
				afterLabelTextTpl: required,
				value : model.desc,
				maxLength:20,
				maxLengthText:'此项长度不能超出20'
			},{
				xtype: 'textfield',
				name: 'Role[id]',
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
	}],
	renderTo : Ext.get('add_role_group')
});

myMask.hide();
});
</script>

</body>
</html>