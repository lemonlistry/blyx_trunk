<div id="NewForm"></div>
<div id="dataList"></div>

<script type="text/javascript">
<?php
echo 'var server_list = '.json_encode($select).';';

?>

var serverList = build.array( server_list );
var type_list = {
	"0": "获得",
	"1": "使用",
	"2": "变更",
	"3": "买卖",
	"4": "副本奖励",
	"5": "任务"
};
var typeList = build.array( type_list );

Ext.onReady(function(){

	var NewForm = Ext.widget({
		xtype: 'form',
		frame: true,
		id:'giftgold_form',
		width: 'auto',
		height:33,
		layout : "column",
		items:[
			{
	            xtype : 'datefield',
	            width: 160,
	            labelWidth: 55,
	            fieldLabel: '开始日期',
	            format: 'Y-m-d',
	            name:'begintime',
	            editable: false,
	            value: date.getPreviouslyTime().lastMonth
	        },
	        {
	            xtype : 'datefield',
	            width: 160,
	            labelWidth: 55,
	            fieldLabel: '截止日期',
	            format: 'Y-m-d',
	            name:'endtime',
	            editable: false,
	            style: 'margin-left:7px;',
	            value: date.getPreviouslyTime().yesterday
	        },
	        {
				xtype : 'combo',
				valueField: 'value',
				displayField: 'name',
	            editable: false,
	            allowBlank : false,
	            blankText:'请选择服务器',
				store: new Ext.data.SimpleStore({
					fields: ['name','value'],
					data: serverList
				}),
				value: serverList[0][1],
				width: 130,
				name: 'server_id',
				style: 'margin-left:7px;'
			},
			{
				xtype : 'combo',
				width: 100,
				valueField:'value',
				displayField:'name',
				value:'1',
				store:new Ext.data.SimpleStore({
					fields:['name','value'],
					data:[
						['账号名查询','0'],
						['角色名查询','1'],
					]
				}),
				name:'search_type',
				blankText:'此项不能为空',
				style: 'margin-left:7px;',
				editable: false,
				listeners: {
					change: function(field,e){
						var form = NewForm.getForm();
						var role_name_text = form.findField('role_name');
						var user_account_text = form.findField('user_account');
						role_name_text.setValue('');
						user_account_text.setValue('');
						if( e == '0' ){
							user_account_text.show();
							role_name_text.hide();
						}else{
							user_account_text.hide();
							role_name_text.show();
						}
					}
				}
			},
			{
				xtype : 'textfield',
				width: 100,
				emptyText: '角色名',
				name:'role_name',
				style: 'margin-left:7px;'
			},
			{
				xtype : 'textfield',
				width: 140,
				emptyText: '账号名',
				name:'user_account',
				style: 'margin-left:7px;',
				hidden: true
			},
			{
				xtype : 'textfield',
				width: 140,
				emptyText: '物品名称',
				name:'item_name',
				style: 'margin-left:7px;'
			},
			{
				xtype : 'combo',
				width: 100,
				valueField:'value',
				displayField:'name',
				value:0,
				store:new Ext.data.SimpleStore({
					fields:['name','value'],
					data:typeList
				}),
				editable: false,
				style: 'margin-left:7px;',
				name: 'items_type'
			},
			{
				xtype : 'button',
				width: 60,
				text: '查询',
				style: 'margin-left:7px;',
				handler: function(){
					submit();
				}
			},
		],
		renderTo: Ext.get('NewForm')
	});




function submit(){
    if (!NewForm.getForm().isValid()) {
        Ext.Msg.alert('提示', '请正确地填写必要数据');
        return ;
    }
    var args = NewForm.getForm().getValues();
    drawTable( args );
}



function drawTable( options ){
	var targetDiv = Ext.get("dataList");

	Ext.define('LogDataStruct', {
		extend: 'Ext.data.Model',
		fields: [
			{name: 'user_account', type:'string'},
			{name: 'role_name', type:'string'},
			{
				name: 'type',
				type:'string',
				convert: function(v){
					return type_list[v];
				}
			},
			{name: 'item_children_type', type:'string'},
			{name: 'item_name', type:'string'},
			{name: 'time', type:'string'},
		]
	});
	myMask.show();
	var currentPage = page.get() || 1;
	currentPage = parseInt( currentPage,10 );
	var startpage = (currentPage-1) * window.config.$page;
	var store = Ext.create('Ext.data.Store', {
		model: 'LogDataStruct',
		proxy: {
			type: 'ajax',
			url: js_url_path+'/index.php?r=/core/log/itemrecord',
			extraParams: options,
			reader: {
				root: 'dataList',
				totalProperty: 'dataCount'
			}
		},
		pageSize: window.config.$page,
		currentPage: currentPage
	});
	store.load({
		params:{
			page: currentPage,
			start: startpage,
        	limit: window.config.$page
		}
	});
	store.on('load',function(){
		myMask.hide();
		//page.set( store.currentPage );
		initLogList();
	});

	function initLogList(){
		targetDiv.update('');
		Ext.create('Ext.grid.Panel', {
			title: '',
			store: store,
			viewConfig  : {
				enableTextSelection:true
	        },
			bbar: Ext.create('Ext.PagingToolbar', {
				store: store,
				displayInfo: true,
				displayMsg: '第{0}-{1}条(共{2}条)',
				emptyMsg: "<b style='color:red;'>查询结果为空</b>"
			}),
			loadMask: true,
			columns: [
				{text: '账号名',  width:120,dataIndex:'user_account'},
				{text: '角色名',  width:120,dataIndex:'role_name'},
				{text: '物品类型',  width:120,dataIndex:''},
				{text: '物品子类',  width:120,dataIndex:''},
				{text: '物品名称',  width:120,dataIndex:'item_name'},
				{text: '变更时间',  width:120,dataIndex:'time'},
				{text: '变更方式',  width:120,dataIndex:'type'},
				{text: '变更子类',  width:120,dataIndex:''},
				{text: '系统变量',  width:120,dataIndex:''}
			],
			tbar: [{
				text: '导出数据',
				handler: function(){
					return;
	                var url = js_url_path+'/index.php?r=core/consume/consumerecordexport';
	                var args = NewForm.getForm().getValues(true);
	                url += '&' + args;
	                window.open( url );
	            }
			}],
			width: 'auto',
			renderTo: targetDiv
		});
	}
}


myMask.hide();
});
</script>
