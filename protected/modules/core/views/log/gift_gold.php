<div id="NewForm"></div>
<div id="dataList"></div>

<script type="text/javascript">
<?php
echo 'var server_list = '.json_encode($select).';';
echo 'var children_type='.json_encode($children_type).';';
echo 'var consume_type='.json_encode($type).';';

?>
var serverList = build.array( server_list );

var consume_dic={
	"角色属性" :[
		['购买精力','0'],
		['精炼洗髓','1'],
		['购买背包格','2'],
		['远程仓库','3'],
		['兑换银两','8'],
	],
	"随从" :[
   		['黄金刷新','23'],
   	],
   	"拜访" :[
      	['寻访','10'],
      	['购买秘籍格','9']
	],
	"强化装备" :[
   		['保证成功率100%','4'],
   		['秒CD','5'],
   		['合成装备','11']
   	],
   	"药园" :[
		['扩地','12'],
      	['刷新银两','13'],
      	['秒CD','14'],
	],
	"任务副本" :[
   		['增加挑战次数','15'],
   		['武林大会秒CD','16'],
   		['复活','17'],
   		['鼓舞','18'],
   		['重置英雄榜','6'],
   		['加速挂机','7'],
   		['日常任务秒CD','21'],
   		['日常任务刷星级','22'],
   		['日常任务一键完成','25']
   	],
   	"门派帮派" :[
    	['帮派战鼓舞','24'],
       	['秒CD','19'],
       	['门派竞技鼓舞','20']
    ],
    "开服活动" :[
        ['充值大礼包','26']
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
				valueField: 'value',
				displayField: 'name',
	            editable: false,
	            width: 100,
	            style: 'margin-left:7px;',
	            emptyText:'产出/消费',
				store: new Ext.data.SimpleStore({
					fields: ['name','value'],
					data: [['产出','0'],['消费','1']]
				}),
				name:'output_consume'
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
    var consume_name = args.consume_type;
    if( typeof args.consume_type_parent != 'undefined' && args.consume_type_parent ){
    	var consume_store_data = consume_dic[ args.consume_type_parent ];
        for( var i = 0;i< consume_store_data.length;i++ ){
    		if( consume_name === consume_store_data[i][0] ){
    			args.consume_type = consume_store_data[i][1];
    			break;
    		}
        }
    }

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
                    return v;
				}
			},
			{name: 'user_account', type:'string'},
			{name: 'role_name', type:'string'},
			{
				name: 'time',
				type:'string',
				convert: function(v){
					return date.format(v,'ISO8601Long');
				}
			},
			{
				name: 'children_type',
				type:'string',
				convert: function(v){
					return children_type[v];
				}
			},
			{
				name: 'type',
				type:'string',
				convert: function(v){
					return consume_type[v];
				}
			},
			{name: 'num', type:'string'}
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
			url: js_url_path+'/index.php?r=/core/log/giftgold',
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
				{text: '账号名', width:250, dataIndex:'user_account'},
				{text: '角色名', width:110, dataIndex:'role_name'},
				{text: '消费时间', width:140, dataIndex:'time'},
				{text: '消费类型', width:60, dataIndex:'type'},
				{text: '消费子类', width:100, dataIndex:'children_type'},
				{text: '消费金额', width:60, dataIndex:'num'}
			],
			tbar: [{
				text: '导出数据',
				handler: function(){
	                var url = js_url_path+'/index.php?r=core/log/giftgoldexport';
	                var args = NewForm.getForm().getValues();
	                if( !args.role_name && !args.user_account ){
						Ext.Msg.alert('提示','用户名或账号名不能为空!');
						return ;
		            }
	                var consume_name = args.consume_type;
	                if( typeof args.consume_type_parent != 'undefined' && args.consume_type_parent ){
	                	var consume_store_data = consume_dic[ args.consume_type_parent ];
	                    for( var i = 0;i< consume_store_data.length;i++ ){
	                		if( consume_name === consume_store_data[i][0] ){
	                			args.consume_type = consume_store_data[i][1];
	                			break;
	                		}
	                    }
	                }
	                var tmp = [];
	                for(var i in args ){
						tmp.push( i+'='+args[i]);
		            }
	                url += '&' + tmp.join('&');
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