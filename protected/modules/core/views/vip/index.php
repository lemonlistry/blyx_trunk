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
        /*
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
		},*/
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
    var args = NewForm.getForm().getValues();
    drawTable( args );
}



function drawTable( options ){
	var targetDiv = Ext.get("dataList");

	Ext.define('LogDataStruct', {
		extend: 'Ext.data.Model',
		fields: [
			{name: 'date', type:'string'},
			{
				name: 'server_id',
				type:'string',
				convert: function( v, r ){
					return server_list[v];
				}
			},
			{name: 'exchange_silver', type:'string'},
			{name: 'giftgold_consume', type:'string'},
			{name: 'giftgold_product', type:'string'},
			{name: 'gold_cost', type:'string'},
			{name: 'logintimes', type:'string'},
            {name: 'vip_level', type:'string'},
			{name: 'silver_consume', type:'string'},
			{name: 'silver_product', type:'string'},
			{name: 'user_account', type:'string'},
			{
				name: 'gold_consume_detail',
				type:'string',
				convert: function( v, r ){
					return '<a href="javascript:void(0)" style="color:green;" rel="gold_consume_detail" data-title="黄金消费明细" data-width="525" data-height="360">查看</a>';
				}
			},
			{
				name: 'sliver_consume_detail',
				type:'string',
				convert: function( v, r ){
					return '<a href="javascript:void(0)" style="color:green;" rel="sliver_consume_detail" data-title="银两消费明细" data-width="525" data-height="120">查看</a>';
				}
			},
			{
				name: 'game_data_detail',
				type:'string',
				convert: function( v, r ){
					return '<a href="javascript:void(0)" style="color:green;" rel="game_data_detail" data-title="游戏数据信息" data-width="525" data-height="140">查看</a>';
				}
			},
			{
				name: 'player_property',
				type:'string',
				convert: function( v, r ){
					return '<a href="javascript:void(0)" style="color:green;" rel="player_property">查看</a>';
				}
			},
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
			url: js_url_path+'/index.php?r=/core/vip/index',
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
		initLogList();
	});



	function initLogList(){
		targetDiv.update('');
		var vipTable = Ext.create('Ext.grid.Panel', {
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
				{text: '日期', width:80, dataIndex:'date'},
				{text: '服务器', width:100, dataIndex:'server_id'},
				{text: '账号名', width:240, dataIndex:'user_account'},
                {text: 'VIP等级', width:50, dataIndex:'vip_level'},
				/*
                {text: '黄钻等级', width:100, dataIndex:'aaa'},
				{text: '帮派名称', width:100, dataIndex:'aaa'},
				{text: '帮派职位', width:100, dataIndex:'aaa'},
                */
				{text: '登录次数', width:70, dataIndex:'logintimes'},
                /*
				{text: '在线时长', width:100, dataIndex:'aaa'},
				{text: '黄金充值', width:100, dataIndex:'aaa'},
                */
				{text: '黄金消费', width:80, dataIndex:'gold_cost'},
				{text: '礼金收益', width:80, dataIndex:'giftgold_product'},
				{text: '礼金消耗', width:80, dataIndex:'giftgold_consume'},
				{text: '钱庄兑换次数', width:90, dataIndex:'exchange_silver'},
				{text: '银两收益', width:80, dataIndex:'silver_product'},
				{text: '银两消耗', width:80, dataIndex:'silver_consume'},
				{text: '黄金消费明细', width:100, align: 'center',dataIndex:'gold_consume_detail'},
				{text: '银两消费详细', width:100, align: 'center',dataIndex:'sliver_consume_detail'},
				{text: '游戏数据', width:100, align: 'center',dataIndex:'game_data_detail'},
				{text: '玩家属性', width:100, align: 'center',dataIndex:'player_property'}
			],
			width: 'auto',
			tbar: [{
				text: '导出数据',
				handler: function(){
					return ;
	                var url = js_url_path+'/index.php?r=core/player/loginrecordexport';
	                var args = NewForm.getForm().getValues(true);
	                url += '&' + args;
	                window.open( url );
	            }
			}],
			renderTo: targetDiv
		});
		vipTable.on('cellclick',function(a,b,c,d,e,f){
			var btn_el = b.getElementsByTagName('a');
			if( btn_el.length == 0){
				return ;
			}
			var server_id;
			for(var i in server_list){
				if( server_list[i] == d.data.server_id ){
					server_id = i;
				}
			}
			var args = [
					'begintime='+d.data.date,
					'user_account='+d.data.user_account,
					'server_id='+server_id
			];
			var rel = btn_el[0].rel;
			var url = '';
			if( rel == 'gold_consume_detail' ){
				url = js_url_path+'/index.php?r=core/vip/vipgold';
			}else if( rel == 'sliver_consume_detail' ){
				url = js_url_path+'/index.php?r=core/vip/vipsilver';
			}else if( rel == 'game_data_detail' ){
				url = js_url_path+'/index.php?r=core/vip/vipgame';
			}else if( rel == 'player_property' ){
				url = js_url_path+'/index.php?r=realtime/default/playerinfo';
				args.shift();
				args.push('search_type=1');
				url += '&' + args.join('&');
				window.open(url);
				return ;
			}else{
				return ;
			}
			url += '&' + args.join('&');
			//window.open( url );
			var data_set = btn_el[0].dataset;
			var options = {
				width: data_set.width,
				height: data_set.height,
				title: data_set.title,
				src: url,
			};
			openWindow( options );
		});
	}
}






myMask.hide();
});
</script>
