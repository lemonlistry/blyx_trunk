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
            name:'server_id',
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
    var server_id = SearchForm.getForm().findField('server_id').getValue();
    myMask.show();
    Ext.Ajax.request({
        url: js_url_path + '/index.php?r=/core/task/getTask',
        method:'POST',
        params: {
            serverId: server_id
        },
        success: function(response){
            myMask.hide();
            var json = Ext.JSON.decode(response.responseText);
            console.log( json );
        },
        error: function(){
            myMask.hide();
        }
    });
}

drawTable([{}]);
function drawTable( data ) {
    Ext.getDom('dataTable').innerHTML = '';

    var dataModelColumn = [];
    var tableHeaderColumn = [];
    for(var i = 0; i<= 60; i++ ){
        dataModelColumn.push( { name: i, type:'string' } );
        tableHeaderColumn.push( {text: i, width: 55, dataIndex: i} );
    }
    Ext.define('forbidModel', {
        extend: 'Ext.data.Model',
        fields: [
            { name: 'server_id', type:'string' },
            { name: 'interval_1', type:'string' }
	    ]
    });
    var store = Ext.create('Ext.data.Store', {
        model: 'forbidModel',
        data: data,
    });
    initLogList();

    function initLogList(){
        Ext.create('Ext.grid.Panel', {
            store: store,
            viewConfig  : {
                enableTextSelection:true
            },
            columns: [
                {text: '服务器名称', width: 100, dataIndex: 'server_id'},
                {text: "0's - 5's", width: 100, dataIndex: 'interval_1'},
                {text: "5's - 10's", width: 100, dataIndex: 'interval_1'},
                {text: "10's - 15's", width: 100, dataIndex: 'interval_1'},
                {text: "15's - 20's", width: 100, dataIndex: 'interval_1'},
                {text: "20's - 25's", width: 100, dataIndex: 'interval_1'},
                {text: "25's - 30's", width: 100, dataIndex: 'interval_1'},
                {text: "超时", width: 100, dataIndex: 'interval_1'}
	        ],
            width: 'auto',
            renderTo: Ext.get('dataTable')
        });
    }
}


openChartWindow([
	{name:'0-5',peoples:Math.random()*1000},
    {name:'5-10',peoples:Math.random()*1000},
    {name:'10-15',peoples:Math.random()*1000},
    {name:'15-20',peoples:Math.random()*1000},
    {name:'20-25',peoples:Math.random()*1000},
    {name:'25-30',peoples:Math.random()*1000},
    {name:'超时',peoples:Math.random()*1000}
]);

function openChartWindow( data ){
    if( typeof window.chartWin != 'undefined' ){
        window.chartWin.destroy();
    }
    if( typeof data == 'undefined' ||
            data.constructor !== Array || data.length == 0 ){
        return;
    }
    
    window.chartStore = Ext.create('Ext.data.JsonStore', {
        fields: ['name', 'peoples'],
        data: data
    });
    
    var chart = Ext.create('Ext.chart.Chart', {
        xtype: 'chart',
        animate: false,
        style: 'background:#fff',
        shadow: false,
        store: chartStore,
        axes: [{
            type: 'Numeric',
            position: 'left',
            fields: ['peoples'],
            label: {
               renderer: Ext.util.Format.numberRenderer('0,0')
            },
            title: '',
            minimum: 0
        }, {
            type: 'Category',
            position: 'bottom',
            fields: ['name'],
            title: '战斗'
        }],
        series: [{
            type: 'column',
            axis: 'left',
            highlight: true,
            tips: {
                trackMouse: true,
                width: 100,
                height: 45,
                renderer: function(storeItem, item) {
                  //this.setTitle('任务:'+storeItem.get('name') + '<br>人数:' + storeItem.get('peoples'));
                }
            },
            label: {
                display: 'outside',
                field: 'peoples',
                renderer: Ext.util.Format.numberRenderer('0'),
                orientation: 'horizontal',
                color: '#000',
                'text-anchor': 'middle',
                contrast: true
            },
            xField: 'name',
            yField: 'peoples',
            renderer: function(sprite, record, attr, index, store) {
                var fieldValue = Math.random() * 20 + 10;
                var value = (record.get('peoples') >> 0) % 5;
                var color = ['rgb(213, 70, 121)', 
                             'rgb(44, 153, 201)', 
                             'rgb(146, 6, 157)', 
                             'rgb(49, 149, 0)', 
                             'rgb(249, 153, 0)'][value];
                return Ext.apply(attr, {
                    fill: color
                });
            }
        }]
    });

    window.chartWin = Ext.create('Ext.Window', {
        width: 1100,
        height: 770,
        x: 0,
        y: 33,
        minHeight: 400,
        minWidth: 550,
        hidden: false,
        maximizable: true,
        title: '战斗过程分析',
        renderTo: Ext.getBody(),
        layout: 'fit',
        style:'z-index:9999;',
        tbar: [{
            text: '导出数据',
            handler: function() {
            }
        }],
        items: chart
    });
    window.chartWin.maximize();
}



myMask.hide();
});
</script>
