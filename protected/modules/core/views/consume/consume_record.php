<div id="NewForm"></div>
<div id="dataList"></div>

<script type="text/javascript">
<?php
echo 'var server_list = '.json_encode($select).';';
echo 'var consume_list = '.json_encode($consume).';';
?>
var serverList = build.array( server_list );

var consume_dic={
	"角色属性" :[
		['购买精力','111'],
		['兑换银两','111'],
		['开包裹格子','111'],
		['远程开商店','111'],
		['远程开仓库','111'],
		['仓库格子','111'],
		['洗髓','111'],
	],
	"随从" :[
   		['刷新伙伴','111'],
   	],
   	"拜访" :[
      	['秘籍格子','111'],
      	['寻访','111'],
	],
	"强化装备" :[
   		['强化装备','111'],
   		['一键合成','111'],
   		['清除强化cd','111'],
   	],
   	"药园" :[
		['开地块','111'],
		['刷新种子','111'],
		['清除地块cd','111'],
	],
	"任务副本" :[
   		['武林大会挑战次数','111'],
   		['加速挂机','111'],
   		['一键完成日常任务','111'],
   		['刷新精英副本','111'],
   		['刷新任务星级','111'],
   		['清理武林大会cd','111'],
   		['清除日常任务cd','111'],
   		['世界boss鼓舞','111'],
   		['世界boss复活','111'],
   	],
   	"门派帮派" :[
    	['帮会战鼓舞','111'],
       	['招聘帮众','111'],
       	['帮会贡献','111'],
       	['帮会战复活','111'],
       	['门派战鼓舞','111'],
    ],
    "开服活动" :[
        ['开礼包','111'],
	]
};


Ext.onReady(function(){

	//查询表单
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
				width: 100,
				emptyText: '账号名',
				name:'user_account',
				style: 'margin-left:7px;',
				hidden: true
			},
			{
				xtype : 'combo',
				valueField: 'name',
				displayField: 'name',
	            editable: false,
	            //allowBlank : false,
	            emptyText:'消费类型',
	            //value:'角色属性',
				store: new Ext.data.SimpleStore({
					fields: ['name'],
					data: (function(){
						var consume_arr = [];
						for( var i in consume_dic){
							var tmp = [];
							tmp.push(i);
							consume_arr.push(tmp);
						}
						return consume_arr;
					})()
				}),
				width: 130,
				name: 'consume_type_parent',
				style: 'margin-left:7px;',
				listeners: {
					change: function(field,e){
						var combo = Ext.get('consume_type').update('');
						var combox = new Ext.form.ComboBox({
			                width: 130,
			                emptyText: '消费子类型',
			                editable: false,
			                name:'consume_type',
			                id:'consume_type',
			                valueField:'value',
			                displayField:'name',
			                store:new Ext.data.SimpleStore({
			                    fields:['name','value'],
			                    data: consume_dic[e]
			                }),
							value:'',
							renderTo: combo,
			            });
					}
				},
				value:''
			},
			{
				xtype:'combo',
				id: 'consume_type',
				name:'consume_type',
				width:130,
				emptyText: '消费子类型',
				editable: false,
				valueField:'value',
                displayField:'name',
                store:new Ext.data.SimpleStore({
                    fields:['name','value'],
                    data: [],
                }),
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
			{
				name: 'server_id',
				type:'string',
				convert: function( v, r ){
					return server_list[v];
				}
			},
			{name: 'openid', type:'string'},
			{name: 'role_name', type:'string'},
			{name: 'ts', type:'string'},
			{
                name: 'payItem',
                type:'string',
                convert: function( v, r ){
					return consume_list[v] ||  v;
				}
            },
			{name: 'balance', type:'string'},
			{name: 'billno', type:'string'}
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
			url: js_url_path+'/index.php?r=/core/consume/consumerecord',
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
				{text: '服务器',  width:120,dataIndex:'server_id'},
				{text: '账号名', width:250, dataIndex:'openid'},
				{text: '角色名', width:110, dataIndex:'role_name'},
				{text: '消费时间', width:140, dataIndex:'ts'},
				{text: '消费类型', width:120, dataIndex:'payItem'},
				{text: '消费金额', width:70, dataIndex:'balance'},
				{text: '订单号', width:60, dataIndex:'billno'}
			],
			tbar: [{
				text: '导出数据',
				handler: function(){
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