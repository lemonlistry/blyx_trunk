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
    if (!SearchForm.getForm().isValid()) return;
    var args = SearchForm.getForm().getValues();
    myMask.show();
    Ext.Ajax.request({
        url: js_url_path + '/index.php?r=/core/consume/giftgoldoutput',
        method:'POST',
        params: args,
        success: function(response){
            myMask.hide();
            var json = Ext.JSON.decode(response.responseText);
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
            {name: 'fetching_finishing_dungeon_award', type:'int'},
            {name: 'fetch_auto_finishing_dungeon__award', type:'int'},
            {name: 'signup', type:'int'},
            {name: 'receive_gift_bag', type:'int'},
            {name: 'get_system_target_award', type:'int'},
            {name: 'recharge_award', type:'int'},
            {name: 'partner_award', type:'int'},
            {name: 'level_up_award', type:'int'},
            {name: 'arena_award', type:'int'},
            {name: 'vip_award', type:'int'},
            {name: 'use_item', type:'int'}
        ],
    });
    var tableHeaderColumn = [
    {
        text: '范围',
        columns: [
            {
                text: '日期',
                dataIndex: 'time',
                width: 100
            },
            {
                text: '服务器',
                dataIndex: 'serverId',
                width: 120
            }
        ]
    },
    {
        text: '副本',
        columns: [
            {
                text: '副本通关',
                dataIndex: 'fetching_finishing_dungeon_award',
                width: 80
            },{
                text: '挂机',
                dataIndex: 'fetch_auto_finishing_dungeon__award',
                width: 80
            }
        ]
    },
    {
        text: '签到',
        columns: [
            {
                text: '签到收益',
                dataIndex: 'signup',
                width: 80
            }
        ]
    },
    {
        text: '其他',
        columns: [
            {
                text: '首3日登陆',
                dataIndex: 'receive_gift_bag',
                width: 80
            }
        ]
    },
    {
        text: '江湖目标',
        columns: [
            {
                text: '目标奖励',
                dataIndex: 'get_system_target_award',
                width: 80
            }
        ]
    },
    {
        text: '开服活动',
        columns: [
            {
                text: '充值有礼',
                dataIndex: 'recharge_award',
                width: 80
            },{
                text: '随从大比拼',
                dataIndex: 'partner_award',
                width: 80
            },{
                text: '全服冲级赛',
                dataIndex: 'level_up_award',
                width: 80
            },{
                text: '武林争霸赛',
                dataIndex: 'arena_award',
                width: 80
            },{
                text: 'VIP等级活动',
                dataIndex: 'vip_award',
                width: 80
            }
        ]
    },
    {
        text: '使用物品',
        columns: [
            {
                text: '礼金丹',
                dataIndex: 'use_item',
                width: 80
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
