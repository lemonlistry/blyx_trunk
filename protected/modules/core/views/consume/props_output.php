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
            xtype : 'datefield',
            labelWidth: 55,
            columnWidth : .2,
            fieldLabel: '开始日期',
            emptyText: '开始日期...',
            format: 'Y-m-d',
            name:'begintime',
            editable: false,
            value: date.getPreviouslyTime().lastMonth
        },
        {
            xtype : 'datefield',
            labelWidth: 55,
            columnWidth : .2,
            fieldLabel: '截止日期',
            emptyText: '查询截止日期...',
            format: 'Y-m-d',
            name:'endtime',
            editable: false,
            style: 'margin-left:15px;',
            value: date.getPreviouslyTime().yesterday
        },
        {
            xtype : 'combo',
            fieldLabel: '',
            labelWidth: 115,
            columnWidth : .2,
            valueField:'value',
            displayField:'name',
            value : server_arr[0][1],
            store : new Ext.data.SimpleStore({
                fields : ['name','value'],
                data : server_arr
            }),
            name:'server_id',
            forceSelection: true,
            triggerAction : 'all',
            allowBlank : false,
            blankText:'此项不能为空',
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
    SearchForm.getForm().submit({
      waitMsg: '正在提交数据',
      waitTitle: '提示',
      url: js_url_path+'/index.php?r=/core/consume/propsoutput',
      method: 'POST',
      success: function(form, action) {
           //drawTable(action.result.data);
          drawTable([{},{},{},{},{}]);
      },
      failure: function(form, action) {
          //formCallback.alert( action.result );
      }
    });
}


drawTable([{},{},{},{},{},{},{},{}]);


function drawTable( serverData ) {
    Ext.get('dataTable').update('');


    var struct = Ext.define('GoldStatStruct',{
        extend: 'Ext.data.Model',
        fields: [
            {name: 'a1', type:'string'}
        ],
    });
    var tableHeaderColumn = [
    {
        text: '范围',
        columns: [
            {
                text: '日期',
                dataIndex: 'date',
                width: 100,
            },
            {
                text: '服务器',
                dataIndex: 'server_id',
                width: 120,
            }
        ]
    },
    {
        text: 'NPC',
        columns: [
            {
                text: '购买道具',
                dataIndex: '',
                width: 80,
            }
        ]
    },
    {
        text: '副本',
        columns: [
            {
                text: '副本通关',
                dataIndex: '',
                width: 80,
            },{
                text: '挂机',
                dataIndex: '',
                width: 80,
            }
        ]
    },
    {
        text: '任务',
        columns: [
            {
                text: '任务奖励',
                dataIndex: '',
                width: 80,
            }
        ]
    },
    {
        text: '合成',
        columns: [
            {
                text: '合成装备',
                dataIndex: '',
                width: 80,
            }
        ]
    },
    {
        text: '世界BOSS',
        columns: [
            {
                text: '天罡北斗阵排名奖',
                dataIndex: '',
                width: 80,
            }, {
                text: '金刚伏魔圈排名奖',
                dataIndex: '',
                width: 80,
            }
        ]
    },
    {
        text: '十大恶人',
        columns: [
            {
                text: '战斗收益',
                dataIndex: '',
                width: 80,
            }
        ]
    },
    {
        text: '其他',
        columns: [
            {
                text: '新手礼包',
                dataIndex: '',
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
