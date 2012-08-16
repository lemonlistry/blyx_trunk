<div id="roleStatForm"></div>
<div id="forbidlist"></div>
<div id="statChart"></div>


<script type="text/javascript">
Ext.Loader.setConfig({enabled: true});
Ext.Loader.setPath('Ext.ux', js_source_path+'/source/js/ExtJS/ux/');
Ext.require([
    'Ext.ux.PreviewPlugin',
]);

<?php
echo 'var server_list = '.json_encode($select).';';
?>
var serverList = build.array( server_list );
Ext.onReady(function(){
var MyForbidForm = Ext.widget({
    xtype: 'form',
    frame: true,
    width: 'auto',
    height:35,
    fieldDefaults: {
        labelAlign: 'left',
        msgTarget: 'side',
        width : 200,
        style : 'margin-left:15px;'
    },
    layout : 'column',
    items:[
        /*{
            xtype : 'datefield',
            fieldLabel: '开始时间',
            labelWidth: 56,
            width :  200,
            name: 'begintime',
            format: 'Y-m-d',
            editable:false,
            allowBlank : false,
            blankText:'此项不能为空',
            listeners: {
                specialkey: {
                    fn: function(field,e) {
                        if(e.getKey() == Ext.EventObject.ENTER){
                            submit();
                        }
                    }
                }
            },
            value : date.getPreviouslyTime().lastMonth
        },
        {
            xtype : 'datefield',
            fieldLabel: '结束时间',
            labelWidth: 56,
            width :  200,
            name: 'endtime',
            format: 'Y-m-d',
            editable:false,
            allowBlank : false,
            blankText:'此项不能为空',
            listeners: {
                specialkey: {
                    fn: function(field,e) {
                        if(e.getKey() == Ext.EventObject.ENTER){
                            submit();
                        }
                    }
                }
            },
            value : date.getPreviouslyTime().today
        },*/
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
			width: 250,
			name: 'server_id'
		},
		/*{
			xtype : 'combo',
			valueField: 'value',
			displayField: 'name',
            editable: false,
			store: new Ext.data.SimpleStore({
				fields: ['name','value'],
				data: [['截止到当前日期',1],['今日新增',2]],
			}),
            value: 1,
            width: 130,
			name: 'server_group_id'
		},*/
        {
            xtype: 'button',
            style: 'margin-left:20px;',
            text: '查询',
            handler: function(){
                submit();
            }
        }
    ],
    renderTo : Ext.get("roleStatForm")
});

function submit(){
    if (!MyForbidForm.getForm().isValid()) return;
    var server_id = MyForbidForm.getForm().findField('server_id').getValue();
    myMask.show();
    Ext.Ajax.request({
        url: js_url_path + '/index.php?r=/core/player/dayrolelevel',
        method:'POST',
        params: {
            server_id: server_id
        },
        success: function(response){
            myMask.hide();
            var json = Ext.JSON.decode(response.responseText);
            var tableData = generateGridData( json );
            drawTable( tableData );
            //drawChart( tableData );
        },
        error: function(){
            myMask.hide();
        }
    });
}


function generateGridData( dataFromServer ){
    if( dataFromServer.constructor !== Array ){
        return [];
    }
    var column = {};
    var len = dataFromServer.length;
    len = len > 81 ? 81 : len;
    for( var i = 0; i< len; i++ ){
        column[i] = dataFromServer[i];
    }
    return [column];
}
function gernerateChartData( datafromtable ){
    var data = datafromtable[0];
    var result = [];
    for( i in data ){
        result.push( { name: i, peoples: data[i] } );
    }
    return result;
}

function drawTable( data ) {
    Ext.getDom('forbidlist').innerHTML = '';

    var dataModelColumn = [];
    var tableHeaderColumn = [];
    for(var i = 0; i<= 80; i++ ){
        dataModelColumn.push( { name: i, type:'string' } );
        tableHeaderColumn.push( {text: i, width: 55, dataIndex: i} );
    }
    Ext.define('forbidModel', {
        extend: 'Ext.data.Model',
        fields: dataModelColumn
    });
    var store = Ext.create('Ext.data.Store', {
        model: 'forbidModel',
        data: data,
    });
    initLogList();

    function initLogList(){
        var grid = Ext.create('Ext.grid.Panel', {
            store: store,
            viewConfig  : {
                enableTextSelection:true
            },
            columns: tableHeaderColumn,
            width: 'auto',
            renderTo: Ext.get('forbidlist'),
            tbar: [{
				text: '导出数据',
				handler: function(){
	                var url = js_url_path+'/index.php?r=core/player/DayRoleLevelExport';
	                var args = MyForbidForm.getForm().getValues();
	                var tmp = [];
	                for(var i in args ){
						tmp.push( i+'='+args[i]);
		            }
	                url += '&' + tmp.join('&');
	                window.open( url );
	            }
			}],
        });
        grid.addListener('celldblclick', cellclick);
        function cellclick(grid, rowIndex, columnIndex, e) {  
			var data = e.data;
			var chartData = [];
            for( i in data ){
				chartData.push({
					name: i,
					peoples: parseInt( data[i], 10 )
				});
            }
            drawChart( chartData );
        }  
    }
}




function drawChart( chartData ){
    if( typeof chartData == 'undefined' ||
		chartData.constructor !== Array || chartData.length == 0 ){
        return;
    }
    var targetDIV = Ext.get('statChart');
    targetDIV.update('');
    window.chartStore = Ext.create('Ext.data.JsonStore', {
        fields: ['name', 'peoples'],
        data: chartData
    });

    var chart = Ext.create('Ext.chart.Chart', {
        xtype: 'chart',
        animate: true,
        style: 'background:#fff',
        shadow: false,
        store: chartStore,
        axes: [{
            type: 'Numeric',
            position: 'left',
            fields: ['peoples'],
            label: {
               renderer: Ext.util.Format.numberRenderer('0,0'),
               rotate: {
                   degrees: 300
               },
            },
            title: '人数',
            minimum: 0
        }, {
            type: 'Category',
            position: 'bottom',
            fields: ['name'],
            title: '等级分布'
        }],
        series: [{
            type: 'column',
            axis: 'left',
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

    var panel = Ext.create('widget.panel', {
    	width: 'auto',
    	height: 600,
    	renderTo: targetDIV,
    	layout: 'fit',
    	items: chart
    });
}

myMask.hide();

});
</script>
