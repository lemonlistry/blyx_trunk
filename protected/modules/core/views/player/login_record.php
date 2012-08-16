<div id="NewForm"></div>
<div id="dataList"></div>
<div id="costCount"></div>


<script type="text/javascript">
<?php
echo 'var server_list = '.json_encode($select).';';
?>
var serverList = build.array( server_list );


Ext.onReady(function(){

//查询表单
var NewForm = Ext.widget({
	xtype: 'form',
	frame: true,
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
            style: 'margin-left:15px;',
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
			style: 'margin-left:15px;'
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
			style: 'margin-left:15px;',
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
			xtype : 'combo',
			width: 80,
			valueField:'value',
			displayField:'name',
			value:'',
			store:new Ext.data.SimpleStore({
				fields:['name','value'],
				data:[
					['VIP等级',''],
					['VIP1',1],
					['VIP2',2],
					['VIP3',3],
					['VIP4',4],
					['VIP5',5],
					['VIP6',6],
					['VIP7',7],
					['VIP8',8],
					['VIP9',9],
					['VIP10',10]
				]
			}),
			name:'vip_level',
			style: 'margin-left:15px;',
			editable: false
		},
		{
			xtype : 'combo',
			width: 80,
			valueField:'value',
			displayField:'name',
			value:'',
			store:new Ext.data.SimpleStore({
				fields:['name','value'],
				data:[
					['黄钻等级',''],
					['黄钻1',1],
					['黄钻2',2],
					['黄钻3',3],
					['黄钻4',4],
					['黄钻5',5],
					['黄钻6',6],
					['黄钻7',7]
				]
			}),
			name:'yellow_vip_level',
			style: 'margin-left:15px;',
			editable: false
		},
		{
			xtype : 'textfield',
			width: 200,
			emptyText: '角色名',
			name:'role_name',
			style: 'margin-left:15px;'
		},
		{
			xtype : 'textfield',
			width: 200,
			emptyText: '账号名',
			name:'user_account',
			style: 'margin-left:15px;',
			hidden: true
		},
		{
			xtype : 'button',
			width: 80,
			text: '查询',
			style: 'margin-left:15px;',
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
    /*if( args.search_type == '0' && args.user_account == '' ){
    	Ext.Msg.alert('提示', '请填写账号名');
    	return ;
    }
    if( args.search_type == '1' && args.role_name == '' ){
    	Ext.Msg.alert('提示', '请填写角色名');
    	return ;
    }*/
    drawTable( args );
}


function drawTable( options ){
	var targetDiv = Ext.get("dataList");

	Ext.define('LogDataStruct', {
		extend: 'Ext.data.Model',
		fields: [
			{name: 'role_id', type:'string'},
			{name: 'role_name', type:'string'},
			{name: 'role_level', type:'string'},
			{name: 'role_type', type:'string'},
			{
				name: 'server_id',
				type:'string',
				convert: function( v, r ){
					return server_list[v];
				}
			},
			{
				name: 'time',
				type: 'string',
				convert: function (value, record) {
                    return date.format(value,'ISO8601Long');

                }
            },
			{name: 'vip_level', type:'string'},
            {name: 'logout_time', type:'string'},
            {name: 'online_time', type:'string'},
			{name: 'year_vip_level', type:'string'},
			{name: 'yellow_vip_level', type:'string'}
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
			url: js_url_path+'/index.php?r=/core/player/loginrecord',
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
				{text: '服务器', width:130, dataIndex:'server_id'},
				{text: '账号名', width:200, dataIndex:'role_id'},
				{text: '角色名', width:100, dataIndex:'role_name'},
				{text: '登录时间', width:140, dataIndex:'time'},
				{text: '登录时等级', width:80, dataIndex:'role_level'},
				{text: '黄钻等级', width:80, dataIndex:'yellow_vip_level'},
				{text: '年VIP等级', width:80, dataIndex:'year_vip_level'},
				{text: 'VIP等级', width:70, dataIndex:'vip_level'},
				{text: '下线时间', width:70, dataIndex:'logout_time'},
				{text: '在线时长', width:70, dataIndex:'online_time'},
				{text: '登录IP', width:70, dataIndex:''},
				{text: '登录地域', width:70, dataIndex:''}
			],
			width: 'auto',
			tbar: [{
				text: '导出数据',
				handler: function(){
	                var url = js_url_path+'/index.php?r=core/player/loginrecordexport';
	                var args = NewForm.getForm().getValues(true);
	                url += '&' + args;
	                window.open( url );
	            }
			}],
			renderTo: targetDiv
		});
	}
}






myMask.hide();
});
</script>