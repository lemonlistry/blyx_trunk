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
        url: js_url_path + '/index.php?r=/core/consume/silverconsume',
        method:'POST',
        params: args,
        success: function(response){
            myMask.hide();
            var json = Ext.JSON.decode(response.responseText);
            //json.date = date.getPreviouslyTime().today;
            //json.server_id = server_obj[ parseInt( args.serverId, 10 ) ];
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
            {name: 'xisui', type:'string'},
            {name: 'buy_item', type:'string'},
            {name: 'refresh_partner', type:'string'},
            {name: 'strengthen_equipment', type:'string'},
            {name: 'upgrade_formation', type:'string'},
            {name: 'visit_master', type:'string'},
            {name: 'create_faction', type:'string'},
            {name: 'apply_faction_battale', type:'string'}
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
        text: '洗髓',
        columns: [
            {
                text: '普通洗髓',
                dataIndex: 'xisui',
                width: 100,
            }
        ]
    },
    {
        text: 'NPC',
        columns: [
            {
                text: '购买道具',
                dataIndex: 'buy_item',
                width: 100,
            }
        ]
    },
    {
        text: '随从',
        columns: [
            {
                text: '银两刷新',
                dataIndex: 'refresh_partner',
                width: 100,
            }
        ]
    },
    {
        text: '强化',
        columns: [
            {
                text: '强化装备',
                dataIndex: 'strengthen_equipment',
                width: 100,
            }
        ]
    },
    {
        text: '阵法',
        columns: [
            {
                text: '升级阵法',
                dataIndex: 'upgrade_formation',
                width: 100,
            }
        ]
    },
    {
        text: '拜访',
        columns: [
            {
                text: '拜访NPC',
                dataIndex: 'visit_master',
                width: 100,
            }
        ]
    },
    {
        text: '帮派',
        columns: [
            {
                text: '创建帮派',
                dataIndex: 'create_faction',
                width: 100,
            }
        ]
    },
    {
        text: '帮派战',
        columns: [
            {
                text: '报名',
                dataIndex: 'apply_faction_battale',
                width: 100,
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
