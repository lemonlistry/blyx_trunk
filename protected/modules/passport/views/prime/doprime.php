<style type="text/css">
body{
	background:#DFE9F6
}
#checked_user li{
	float:left;
	padding:5px;
	color:blue;
}
h4{
	padding:5px;
	font-weight:bold;
	font-size:20px;
	font-family:'Tahoma','微软雅黑';
}
</style>
<div id="doprime"></div>
<h4>已授权限人员:</h4>
<ul id='checked_user'></ul>

<script type="text/javascript">
<?php
	echo 'var resource_list='.json_encode($resource_list).';';
	echo 'var rolename="'.$current_role['name'].'";';
	echo 'var current_role_id="'.$current_role['id'].'";';
	echo 'var prime='.json_encode($prime).';';
	echo 'var checked_user='.json_encode($checked_user).';';



?>

var resource_list_arr=[]
for(var i=0;i<resource_list.length;i++){
	var col = resource_list[i];
	var chk = current_role_id == '1' || prime.contain( col.id );
	resource_list_arr.push({
	    boxLabel: col.name,
	    name: 'Resource['+col.id+']',
	    inputValue: '1',
	    checked : chk
	});
}
resource_list_arr.push({
	xtype: 'textfield',
	name: 'role_id',
	hidden: true,
	hideLabel:true,
	value:current_role_id,
	allowBlank:true
});


Ext.onReady(function(){

var doprime = Ext.widget({
	xtype: 'form',
	frame: true,
	bodyPadding: '5 5 0',
	width: 900,
    height:550,
	fieldDefaults: {
		msgTarget: 'side',
		labelWidth: 52
	},
	defaultType: 'textfield',
	items: [{
		xtype: 'fieldset',
		title: '当前所选角色：'+rolename,
		defaultType: 'checkbox',
		layout: 'anchor',
		defaults: {
			anchor: '100%',
			columnWidth : .22
		},
		width: '100%',
		layout: 'column',
		items:resource_list_arr
	}],
	buttons: [{
		text: '保存授权',
        disabled: current_role_id == 1 ? true : false,
		handler : function(){
          	myMask.show();
          	doprime.getForm().submit({
    				 waitMsg: '正在提交数据',
    				 waitTitle: '提示',
    				 url: js_url_path+'/index.php?r=/passport/prime/updateprime',
    				 method: 'POST',
    				 success: function(form, action) {
     					 myMask.hide();
      					 formCallback.alert( action.result );
    				 },
    				 failure: function(form, action) {
     					 myMask.hide();
      					 formCallback.alert( action.result );
    				 }
    		});
    	}
	},
	{
		text: '重置',
        handler : function(){
            this.up('form').getForm().reset();
        }
	}]
});
doprime.render('doprime');


(function(){
	var html = [];
	for(var i=0;i<checked_user.length;i++){
		html.push('<li>'+checked_user[i].username+'</li>');
	}
	html = html.join('');
	Ext.get('checked_user').update( html );
})();

myMask.hide();
});
</script>