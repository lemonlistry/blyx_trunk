<div id="search"></div>
<div id="dataTable"></div>


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
    if (!SearchForm.getForm().isValid()) {
        Ext.Msg.alert('提示', '请正确地填写必要数据');
        return ;
    }
    var args = SearchForm.getForm().getValues();
    myMask.show();
    Ext.Ajax.request({
        url: js_url_path + '/index.php?r=/core/silver/getSilverProduction',
        method:'POST',
        params: args,
        success: function(response){
            myMask.hide();
            var json = Ext.JSON.decode(response.responseText);
            json.date = date.getPreviouslyTime().today;
            json.server_id = server_obj[ parseInt( args.serverId, 10 ) ];
            drawTable( json );
        },
        error: function(){
            myMask.hide();
        }
    });
}





function drawTable( serverData ) {
    Ext.get('dataTable').update('');


    var struct = Ext.define('GoldStatStruct',{
        extend: 'Ext.data.Model',
        fields: [
            {name: 'time', type:'string'},
            {
				name: 'serverId', 
				type:'string',
				convert: function(v){
					return server_obj[v];
				}
			},
			{name: 'sell_item', type:'string'},
			{name: 'fetch_fighting_dungeon_award', type:'string'},
			{name: 'fetch_auto_fighting_dungeon_award', type:'string'},
			{name: 'exchange_silver', type:'string'},
			{name: 'submit_task', type:'string'},
			{name: 'sell_book', type:'string'},
			{name: 'harvest_medicine', type:'string'},
			{name: 'arena_award', type:'string'},
			{name: 'chanllenge_opponent', type:'string'},
			{name: 'fight_world_boss', type:'string'},
			{name: 'kill_world_boss', type:'string'},
			{name: 'world_boss_rank', type:'string'},
			{name: 'faction_salary', type:'string'},
			{name: 'rand_award_in_faction_battle', type:'string'},
			{name: 'killing_award_in_faction_battle', type:'string'},
			{name: 'fight_in_clan_fight', type:'string'},
			{name: 'winner_of_party_fight', type:'string'},
			{name: 'top3_of_party', type:'string'},
			{name: 'signup', type:'string'},
			{name: 'fight_with_demons', type:'string'},
			{name: 'title_award', type:'string'},
			{name: 'newbie_gift_bag', type:'string'},
			{name: 'system_target_award', type:'string'},
			{name: 'award_of_recharge', type:'string'},
			{name: 'award_of_levelup', type:'string'},
			{name: 'award_of_partner', type:'string'},
			{name: 'award_of_arena', type:'string'},
			{name: 'award_of_vip', type:'string'},
			{name: 'yellow_newbie', type:'string'},
			{name: 'yellow_vip_per_day', type:'string'},
			{name: 'yellow_vip_upgrade', type:'string'},
			{name: 'silver_medicine', type:'string'},
			{name: 'vip_award', type:'string'}
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
        text: 'NPC',
        columns: [
            {
                text: '出售道具',
                dataIndex: 'sell_item',
                width: 80,
            }
        ]
    },
    {
        text: '副本',
        columns: [
            {
                text: '副本战斗',
                dataIndex: 'fetch_fighting_dungeon_award',
                width: 80,
            },
            {
                text: '挂机',
                dataIndex: 'fetch_auto_fighting_dungeon_award',
                width: 80,
            }
        ]
    },
    {
        text: '钱庄',
        columns: [
            {
                text: '兑换银两',
                dataIndex: 'exchange_silver',
                width: 80,
            }
        ]
    },
    {
        text: '任务',
        columns: [
            {
                text: '任务奖励',
                dataIndex: 'submit_task',
                width: 80,
            }
        ]
    },
    {
        text: '拜访',
        columns: [
            {
                text: '出售秘籍',
                dataIndex: 'sell_book',
                width: 80,
            }
        ]
    },
    {
        text: '药园',
        columns: [
            {
                text: '种植银两',
                dataIndex: 'harvest_medicine',
                width: 80,
            }
        ]
    },
    {
        text: '武林大会',
        columns: [
            {
                text: '每日奖励',
                dataIndex: 'arena_award',
                width: 80,
            },{
                text: '每次挑战',
                dataIndex: 'chanllenge_opponent',
                width: 80,
            }
        ]
    },
    {
        text: '世界BOSS',
        columns: [
            {
                text: '天罡金刚战斗',
                dataIndex: 'fight_world_boss',
                width: 80,
            },{
                text: '天罡金刚杀奖',
                dataIndex: 'kill_world_boss',
                width: 80,
            },{
                text: '天罡金刚排名',
                dataIndex: 'world_boss_rank',
                width: 80,
            }
        ]
    },
    {
        text: '帮派',
        columns: [
            {
                text: '帮派俸禄',
                dataIndex: 'faction_salary',
                width: 80,
            }
        ]
    },
    {
        text: '帮派战',
        columns: [
            {
                text: '帮派排名奖',
                dataIndex: 'rand_award_in_faction_battle',
                width: 80,
            },{
                text: '击杀排名奖',
                dataIndex: 'killing_award_in_faction_battle',
                width: 80,
            }
        ]
    },
    {
        text: '门派竞技',
        columns: [
            {
                text: '战斗收益',
                dataIndex: 'fight_in_clan_fight',
                width: 80,
            },{
                text: '门派战冠军',
                dataIndex: 'winner_of_party_fight',
                width: 80,
            },{
                text: '各门派前三',
                dataIndex: 'top3_of_party',
                width: 80,
            }
        ]
    },
    {
        text: '签到',
        columns: [
            {
                text: '签到收益',
                dataIndex: 'signup',
                width: 80,
            }
        ]
    },
    {
        text: '十大恶人',
        columns: [
            {
                text: '战斗收益',
                dataIndex: 'fight_with_demons',
                width: 80,
            }
        ]
    },
    {
        text: '称号',
        columns: [
            {
                text: '称号俸禄',
                dataIndex: 'title_award',
                width: 80,
            }
        ]
    },
    {
        text: '其他',
        columns: [
            {
                text: '新手礼包',
                dataIndex: 'newbie_gift_bag',
                width: 80,
            }
        ]
    },
    {
        text: '江湖目标',
        columns: [
            {
                text: '目标奖励',
                dataIndex: 'system_target_award',
                width: 80,
            }
        ]
    },
    {
        text: '开服活动',
        columns: [
            {
                text: '充值有礼',
                dataIndex: 'award_of_recharge',
                width: 80,
            },{
                text: '全服冲级赛',
                dataIndex: 'award_of_levelup',
                width: 80,
            },{
                text: '随从大比拼',
                dataIndex: 'award_of_partner',
                width: 80,
            },{
                text: '武林争霸赛',
                dataIndex: 'award_of_arena',
                width: 80,
            },
        ]
    },
    {
        text: '黄钻',
        columns: [
			{
			    text: 'VIP等级活动',
			    dataIndex: 'award_of_vip',
			    width: 80,
			},
            {
                text: '黄钻新手奖励',
                dataIndex: 'yellow_newbie',
                width: 80,
            },{
                text: '黄钻每日奖励',
                dataIndex: 'yellow_vip_per_day',
                width: 80,
            },{
                text: '黄钻升级奖励',
                dataIndex: 'yellow_vip_upgrade',
                width: 80,
            }
        ]
    },
    {
        text: 'VIP',
        columns: [
            {
                text: 'VIP等级奖励',
                dataIndex: 'vip_award',
                width: 80,
            }
        ]
    },
    {
        text: '使用物品',
        columns: [
            {
                text: '银两丹',
                dataIndex: 'silver_medicine',
                width: 80,
            }
        ]
    }



    ];


    var store = Ext.create('Ext.data.Store',{
        model: 'GoldStatStruct',
        data: serverData
    });

    Ext.create('Ext.grid.Panel', {
        store: store,
        viewConfig  : {
            enableTextSelection:true
        },
        frame: true,
        columns: tableHeaderColumn,
        renderTo: Ext.get('dataTable')
    });
}




myMask.hide();
});
</script>
