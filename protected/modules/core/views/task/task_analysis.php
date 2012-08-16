<div id="search"></div>
<div id="statChart"></div>

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
        url: js_url_path + '/index.php?r=/core/task/taskanalysis',
        method:'POST',
        params: {
            serverId: server_id
        },
        success: function(response){
            myMask.hide();
            var json = Ext.JSON.decode(response.responseText);
            var totalCount = 0;
            for( var i in json ){
				totalCount += json[i];
            }
            window.totalCount = totalCount;
            var data = handlerServerData( json );
            data = data.reverse();
            drawChart( data );
        },
        error: function(){
            myMask.hide();
        }
    });
}

var testData = [{name:'Mon',peoples:1000},{name:'Tue',peoples:200},{name:'Wedn',peoples:100}];
function TestData(){
    var result = [];
    for( var i = 0; i<= 200;i++ ){
        var rnd  = parseInt( Math.random()*10000, 10 );
        result.push({ name: i, peoples: rnd });
    }
    return result;
}
function handlerServerData( serverData ){
    var result = [];
    for( i in serverData ){
        result.push( {name: i, peoples: serverData[i] } );
    }
    return result;
}
//openChartWindow( [1] );

function drawChart( data ){
    if( typeof data == 'undefined' ||
            data.constructor !== Array || data.length == 0 ){
        return;
    }
    var targetDIV = Ext.get('statChart');
    targetDIV.update('');
    window.chartStore = Ext.create('Ext.data.JsonStore', {
        //fields: ['name', 'peoples'],
    	fields: ['peoples', 'name'],
        data: data
    });

    var chart = Ext.create('Ext.chart.Chart', {
        xtype: 'chart',
        animate: false,
        style: 'background:#fff',
        shadow: false,
        store: chartStore,
        axes: [{
            type: 'Numeric',//Category
            position: 'bottom',
            fields: ['peoples'],//name
            title: '人数'
        },{
            type: 'Category',//Numeric
            position: 'left',
            fields: ['name'],//peoples
            /*label: {
               renderer: Ext.util.Format.numberRenderer('0,0')
            },*/
            title: '任务',
            minimum: 0
        }],
        series: [{
            type: 'bar',
            axis: 'bottom',
            highlight: true,
            tips: {
                trackMouse: true,
                width: 150,
                height: 70,
                renderer: function(storeItem, item) {
                    var val = storeItem.get('peoples');
                    var name = storeItem.get('name');
                    var percent = parseInt( val / window.totalCount * 10000)/100 + '%'
                    this.setTitle('任务:'+ name + '<br>人数:' + val + '<br>百分比:' + percent);
                }
            },
            label: {
                display: 'outside',
                field: 'peoples',//peoples
                renderer: Ext.util.Format.numberRenderer('0'),
                orientation: 'horizontal',
                color: '#000',
                'text-anchor': 'middle',
                contrast: true
            },
            xField: 'name',//name
            yField: 'peoples',//peoples
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

    /*window.chartWin = Ext.create('Ext.Window', {
        width: 3500,
        height: 770,
        x: 0,
        y: 33,
        minHeight: 400,
        minWidth: 550,
        hidden: false,
        maximizable: true,
        title: '任务分析',
        renderTo: Ext.getBody(),
        layout: 'fit',
        tbar: [{
            text: '导出数据',
            handler: function() {
            }
        }],
        items: chart
    });
    //window.chartWin.maximize();
    */

    var panel = Ext.create('widget.panel', {
    	width: 'auto',
    	height: 3500,
    	renderTo: targetDIV,
    	layout: 'fit',
    	items: chart
    });
}



myMask.hide();
});
</script>
