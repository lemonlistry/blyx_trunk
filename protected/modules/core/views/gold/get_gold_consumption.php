<style type='text/css'>
.c-red{color:red;}
</style>
<div id="search"></div>
<div id="dataTable"></div>
<p style="color:red;">*注( 礼金 / 黄金 )</p>
<div id="pieChart">
	<div id='pie1' style="width:50%;float:left;"></div>
	<div id='pie2' style="width:50%;float:left;"></div>
</div>

<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/source/js/ExtJS/Multi-column-Legend.js"></script>
<script type="text/javascript">
<?php 
    echo 'var server_obj='.json_encode($select).';'; 
?>
var server_arr    = build.array( server_obj );
Ext.Loader.setConfig({
    enabled: true
});
Ext.Loader.setPath('Ext.ux', js_source_path+'/source/js/ExtJS/ux/');
Ext.require([
     'Ext.ux.CheckColumn'
]);
Ext.onReady(function(){


var SearchForm = Ext.widget({
    xtype: 'form',
    frame: true,
    height:35,
    fieldDefaults: {
        msgTarget: 'side',
        labelWidth: 52
    },
    defaults: {
        anchor: '100%',
        labelWidth: 180
    },
    width: '100%',
    layout : "column",
    items:[
		{
		    xtype : 'combo',
		    width: 150,
		    valueField:'value',
		    displayField:'name',
		    value : 0,
		    store : new Ext.data.SimpleStore({  
		        fields : ['name','value'],
		        data : [['截止到当前总量',0],['按天查询',1]]
		    }),  
		    name:'search_type',
		    forceSelection: true,
		    triggerAction : 'all',
		    editable: false,
		    listeners: {
                change: {
                    fn: function(field,e){
                    	var begin = SearchForm.getForm().findField('begintime');
    					var end = SearchForm.getForm().findField('endtime');
    					if( e == 1 ){
    						begin.show();
    						end.show();
    					}else{
    						begin.hide();
    						end.hide();
    					}
                    }
                }
            }
		},
		{
		    xtype : 'datefield',
		    labelWidth: 55,
		    width:200,
		    fieldLabel: '开始日期',
		    emptyText: '开始日期...',
		    format: 'Y-m-d',
		    name:'begintime',
		    editable: false,
		    value: date.getPreviouslyTime().lastMonth,
		    style: 'margin-left:15px;',
		    hidden: true
		},
		{
		    xtype : 'datefield',
		    labelWidth: 55,
		    width:200,
		    fieldLabel: '截止日期',
		    emptyText: '查询截止日期...',
		    format: 'Y-m-d',
		    name:'endtime',
		    editable: false,
		    style: 'margin-left:15px;',
		    hidden: true,
		    value: date.getPreviouslyTime().yesterday
		},
        {
            xtype : 'combo', 
            fieldLabel: '',
            labelWidth: 115,
            width: 250,
            valueField:'value',
            displayField:'name',
            value : server_arr[0][1],
            store : new Ext.data.SimpleStore({  
                fields : ['name','value'],  
                data : server_arr
            }),  
            name:'serverId',
            forceSelection: true,
            triggerAction : 'all',
            allowBlank : false,
            blankText:'请选择服务器',
            editable: false,
            style: 'margin-left:15px;'
        },
        {
            xtype: 'button',
            text: '查询',
            width: 70,
            style: 'margin-left:15px;',
            handler : function(){
                submit();
            }
        }
    ],
    renderTo : Ext.get('search')
});



function submit(){
    if (!SearchForm.getForm().isValid()) return;
    var args = SearchForm.getForm().getValues();
    myMask.show();
    Ext.Ajax.request({
        url: js_url_path + '/index.php?r=/core/gold/getgoldconsumption',
        method:'POST',
        params: args,
        success: function(response){
            myMask.hide();
            var json = Ext.JSON.decode(response.responseText);
            var handlerJson = handlerServerData(json);
            //window.server_id_value = parseInt(args.serverId,10);
            drawTable( handlerJson );
        },
        error: function(){
            myMask.hide();
        }
    });
}

function handlerServerData( serverData ){
	if( typeof serverData != 'object' 
		|| serverData.constructor != Array 
		|| serverData.length == 0 ){
		return;
	}
	var result = [];
	for(var i = 0,len = serverData.length; i< len; i++){
		var list = serverData[i];
		for(var j in list){
			if( j=='time' || j == 'serverId'){
				continue;
			}
			list[j] = list[j].gift_gold + ' / ' + list[j].gold;
		}
		result.push( list );
	}
    return result;
}



var pieKeyValueDict = {
	buy_vitality: '购买精力',
	level2_xisui: '精炼洗髓',
	level3_xisui: '白金洗髓',
	refresh_partner: '黄金刷新',
	buy_excellent_partner: '一键史诗',
	unlock_package_slot: '购买背包格',
	unlock_store_slot: '购买仓库格',
	remote_open_store: '远程仓库',
	remote_open_shop: '远程道具店',
	ensure_strengthen_success: '保证成功率100%',
	clear_strengthen_cd: '强化秒CD',
	refresh_elite_dungeon: '重置英雄榜',
	accelerate_auto_fighting: '加速挂机',
	exchange_silver: '兑换银两',
	seek_hight_level_master: '寻访',
	unlock_book_slot: '购买秘籍格',
	synthesis_equipment: '合成装备',
	unlock_earth: '扩地',
	refresh_silver_seed: '刷新银两',
	refresh_excellent_silver_seed: '一键满星银两',
	refresh_exp_seed: '刷新经验',
	refresh_excellent_exp_seed: '一键满星经验',
	clear_earth_cd: '药园秒CD',
	add_challenge_times: '增加挑战次数',
	clear_challenge_cd: '武林大会秒CD',
	revive_in_world_boss: '复活',
	encourage_in_world_boss: '世界BOSS鼓舞',
	send_faction_enrollment_notification: '招人',
	donate_to_faction: '捐献',
	encourage_in_faction: '帮派战鼓舞',
	rivive_in_faction_battle: '帮派战秒CD',
	encourage_in_clan_fight: '门派竞技鼓舞',
	clear_daily_task_cd: '日常任务秒CD',
	refresh_daily_task: '刷新星级',
	auto_finish_daily_task: '日常任务一键完成',
	recharge_gift_bag: '充值大礼包'
};

function drawTable( serverData ) {
    Ext.get('dataTable').update('');
    
    
    var struct = Ext.define('GoldStatStruct',{
        extend: 'Ext.data.Model',
        fields: [
            {name: 'time', type:'string'},
            {
                name: 'serverId', 
                type:'string',
                convert: function(v,r){
                    return server_obj[v];
                }
            },
            {name: 'buy_vitality', type:'string'},
            {name: 'level2_xisui', type:'string'},
            {name: 'level3_xisui', type:'string'},
            {name: 'refresh_partner', type:'string'},
            {name: 'buy_excellent_partner', type:'string'},
            {name: 'unlock_package_slot', type:'string'},
            {name: 'unlock_store_slot', type:'string'},
            {name: 'remote_open_store', type:'string'},
            {name: 'remote_open_shop', type:'string'},
            {name: 'ensure_strengthen_success', type:'string'},
            {name: 'clear_strengthen_cd', type:'string'},
            {name: 'refresh_elite_dungeon', type:'string'},
            {name: 'accelerate_auto_fighting', type:'string'},
            {name: 'exchange_silver', type:'string'},
            {name: 'seek_hight_level_master', type:'string'},
            {name: 'unlock_book_slot', type:'string'},
            {name: 'synthesis_equipment', type:'string'},
            {name: 'unlock_earth', type:'string'},
            {name: 'refresh_silver_seed', type:'string'},
            {name: 'refresh_excellent_silver_seed', type:'string'},
            {name: 'refresh_exp_seed', type:'string'},
            {name: 'refresh_excellent_exp_seed', type:'string'},
            {name: 'clear_earth_cd', type:'string'},
            {name: 'add_challenge_times', type:'string'},
            {name: 'clear_challenge_cd', type:'string'},
            {name: 'revive_in_world_boss', type:'string'},
            {name: 'encourage_in_world_boss', type:'string'},
            {name: 'send_faction_enrollment_notification', type:'string'},
            {name: 'donate_to_faction', type:'string'},
            {name: 'encourage_in_faction', type:'string'},
            {name: 'rivive_in_faction_battle', type:'string'},
            {name: 'encourage_in_clan_fight', type:'string'},
            {name: 'clear_daily_task_cd', type:'string'},
            {name: 'refresh_daily_task', type:'string'},
            {name: 'auto_finish_daily_task', type:'string'},
            {name: 'recharge_gift_bag', type:'string'}
        ],
    });
    var tableHeaderColumn = [
    {
        text: '范围',
        columns: [
            {
                text: '日期',
                dataIndex: 'time',
                width: 100,
            },
            {
                text: '服务器',
                dataIndex: 'serverId',
                width: 120,
            }
        ]
    },
    {
        text: '精力',
        columns: [
            {
                text: '购买精力',
                dataIndex: 'buy_vitality',
                width: 120
            }
        ]
    },
    {
        text: '洗髓',
        columns: [
            {
                text: '精炼洗髓',
                dataIndex: 'level2_xisui',
                width: 120
            },{
                text: '白金洗髓',
                dataIndex: 'level3_xisui',
                width: 120
            }
        ]
    },
    {
        text: '随从',
        columns: [
            {
                text: '黄金刷新',
                dataIndex: 'refresh_partner',
                width: 120
            },{
                text: '一键史诗',
                dataIndex: 'buy_excellent_partner',
                width: 120
            }
        ]
    },
    {
        text: '背包仓库',
        columns: [
            {
                text: '购买背包格',
                dataIndex: 'unlock_package_slot',
                width: 120
            },{
                text: '购买仓库格',
                dataIndex: 'unlock_store_slot',
                width: 120
            },{
                text: '远程仓库',
                dataIndex: 'remote_open_store',
                width: 120
            },{
                text: '远程道具店',
                dataIndex: 'remote_open_shop',
                width: 120
            }
        ]
    },
    {
        text: '强化',
        columns: [
            {
                text: '保证成功率100%',
                dataIndex: 'ensure_strengthen_success',
                width: 120
            },{
                text: '秒CD',
                dataIndex: 'clear_strengthen_cd',
                width: 120
            }
        ]
    },
    {
        text: '副本',
        columns: [
            {
                text: '重置英雄榜',
                dataIndex: 'refresh_elite_dungeon',
                width: 120
            },{
                text: '加速挂机',
                dataIndex: 'accelerate_auto_fighting',
                width: 120
            }
        ]
    },
    {
        text: '钱庄',
        columns: [
            {
                text: '兑换银两',
                dataIndex: 'exchange_silver',
                width: 120
            }
        ]
    },
    {
        text: '拜访',
        columns: [
            {
                text: '寻访',
                dataIndex: 'seek_hight_level_master',
                width: 120
            },{
                text: '购买秘籍格',
                dataIndex: 'unlock_book_slot',
                width: 120
            }
        ]
    },
    {
        text: '合成',
        columns: [
            {
                text: '合成装备',
                dataIndex: 'synthesis_equipment',
                width: 120
            }
        ]
    },
    {
        text: '药园',
        columns: [
            {
                text: '扩地',
                dataIndex: 'unlock_earth',
                width: 120
            },{
                text: '刷新银两',
                dataIndex: 'refresh_silver_seed',
                width: 120
            },{
                text: '一键满星银两',
                dataIndex: 'refresh_excellent_silver_seed',
                width: 120
            },{
                text: '刷新经验',
                dataIndex: 'refresh_exp_seed',
                width: 120
            },{
                text: '一键满星经验',
                dataIndex: 'refresh_excellent_exp_seed',
                width: 120
            },{
                text: '秒CD',
                dataIndex: 'clear_earth_cd',
                width: 120
            }
        ]
    },
    {
        text: '武林大会',
        columns: [
            {
                text: '增加挑战次数',
                dataIndex: 'add_challenge_times',
                width: 120
            },{
                text: '秒CD',
                dataIndex: 'clear_challenge_cd',
                width: 120
            }
        ]
    },
    {
        text: '世界BOSS',
        columns: [
            {
                text: '复活',
                dataIndex: 'revive_in_world_boss',
                width: 120
            },{
                text: '鼓舞',
                dataIndex: 'encourage_in_world_boss',
                width: 120
            }
        ]
    },
    {
        text: '帮派',
        columns: [
            {
                text: '招人',
                dataIndex: 'send_faction_enrollment_notification',
                width: 120
            },{
                text: '捐献',
                dataIndex: 'donate_to_faction',
                width: 120
            }
        ]
    },
    {
        text: '帮派战',
        columns: [
            {
                text: '鼓舞',
                dataIndex: 'encourage_in_faction',
                width: 120
            },{
                text: '秒CD',
                dataIndex: 'rivive_in_faction_battle',
                width: 120
            }
        ]
    },
    {
        text: '门派竞技',
        columns: [
            {
                text: '鼓舞',
                dataIndex: 'encourage_in_clan_fight',
                width: 120
            }
        ]
    },
    {
        text: '日常任务',
        columns: [
            {
                text: '秒CD',
                dataIndex: 'clear_daily_task_cd',
                width: 120
            },{
                text: '刷新星级',
                dataIndex: 'refresh_daily_task',
                width: 120
            },{
                text: '一键完成',
                dataIndex: 'auto_finish_daily_task',
                width: 120
            }
        ]
    },
    {
        text: '开启礼包',
        columns: [
            {
                text: '充值大礼包',
                dataIndex: 'recharge_gift_bag',
                width: 120
            }
        ]
    }    
    ];

    var store = Ext.create('Ext.data.Store',{
        model: 'GoldStatStruct',
        data: serverData
    });

    var grid = Ext.create('Ext.grid.Panel', {
        store: store,
        viewConfig  : {
            enableTextSelection:true  
        },
        frame: true,
        columns: tableHeaderColumn,
        tbar: [{
			text: '导出数据',
			handler: function(){
                var url = js_url_path+'/index.php?r=core/gold/GoldConsumptionExport';
                var args = SearchForm.getForm().getValues();
                var tmp = [];
                for(var i in args ){
					tmp.push( i+'='+args[i]);
	            }
                url += '&' + tmp.join('&');
                window.open( url );
            }
		}],
        renderTo: Ext.get('dataTable')
    });
    grid.addListener('celldblclick', cellclick);
    function cellclick(grid, rowIndex, columnIndex, e) {  
		var data = e.data;
		var chartDataGifts = [];
		var chartDataGold = [];
		var totalGifts = 0;
		var totalGolds = 0;
		for( m in data ){
			if( m == 'serverId' || m == 'time' ){
				continue;
            }
			var col = data[m].split('/');
			totalGifts += parseInt( col[0], 10 );
			totalGolds += parseInt( col[1], 10 );
		}
        for( i in data ){
            if( i == 'serverId' || i == 'time' ){
				continue;
            }
            var col = data[i].split('/');
            var GiftValue = parseInt( col[0], 10 );
            var GoldValue = parseInt( col[1], 10 );
            var Giftname = pieKeyValueDict[i] + '(' + parseInt( GiftValue / totalGifts * 10000)/100 + '%'+ ')';
            var Goldname = pieKeyValueDict[i] + '(' + parseInt( GoldValue / totalGolds * 10000)/100 + '%'+ ')';
        	chartDataGifts.push({
				name: Giftname,
				data1: GiftValue
			});
        	chartDataGold.push({
				name: Goldname,
				data1: GoldValue
			});
        }
        if(totalGolds == 0){
        	Ext.get('pie2').update('无数据');
        }else{
        	drawPie({
            	data: chartDataGold,
            	title: '黄金消耗比例',
            	targetId: 'pie2'
            });
        }
        if(totalGifts == 0){
        	Ext.get('pie1').update('无数据');
        }else{
        	drawPie({
            	data: chartDataGifts,
            	title: '礼金消耗比例',
            	targetId: 'pie1'
            });
        }
        
        
    }  
}



/*var testData = [
	{name:'one',data1: parseInt( Math.random()*1000 ) },
	{name:'two',data1: parseInt( Math.random()*1000 ) },
	{name:'three',data1: parseInt( Math.random()*1000 ) }
];
var testData2 = [
            	{name:'aa',data1: parseInt( Math.random()*1000 ) },
            	{name:'bb',data1: parseInt( Math.random()*1000 ) },
            	{name:'cc',data1: parseInt( Math.random()*1000 ) }
            ];

drawPie({
	data: testData,
	title: '黄金消耗比例',
	targetId: 'pie1'
});
drawPie({
	data: testData2,
	title: '礼金消耗比例',
	targetId: 'pie2'
});*/

function drawPie( options ){
	var target = Ext.get( options.targetId );
	target.update('');
	var store = Ext.create('Ext.data.JsonStore', {
    	fields: ['data1', 'name'],
        data: options.data
    });
	var donut = false,
    chart = Ext.create('Ext.chart.Chart', {
        xtype: 'chart',
        animate: true,
        store: store,
        shadow: true,
        legend: {
            position: 'right',
            itemSpacing:5,
			padding:5
        },
        insetPadding: 20,
        theme: 'Base:gradients',
        series: [{
            type: 'pie',
            field: 'data1',
            showInLegend: true,
            //donut: donut,
            tips: {
              trackMouse: true,
              width: 200,
              height: 28,
              renderer: function(storeItem, item) {
                var total = 0;
                store.each(function(rec) {
                    total += rec.get('data1');
                });
                //this.setTitle( pieKeyValueDict[storeItem.get('name')] + ': ' + Math.round(storeItem.get('data1') / total * 100) + '%');
                this.setTitle( storeItem.get('name') );
              }
            },
            highlight: {
              segment: {
                margin: 20
              }
            },
            /*label: {
                field: 'name',
                display: 'rotate',
                contrast: true,
                font: '13px Arial'
            }*/
        }]
    });


	var panel1 = Ext.create('widget.panel', {
	    width: 'auto',
	    height: 500,
	    title: options.title,
	    renderTo: target,
	    layout: 'fit',
	    items: chart
	});
}



myMask.hide();
});
</script>
