<div id="search"></div>
<div id="dataTable"></div>
<div id="onlineChart"></div>

<script type="text/javascript">

<?php
echo 'var server_list = '.json_encode($select).';';
?>
var serverList = build.array( server_list );


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
	width: 'atuo',
	height: 33,
	layout : "column",
	items:[
		{
			xtype : 'datefield',
			width: 200,
			emptyText: '查询截止天数...',
			format: 'Y-m-d',
			name:'end_day',
			editable: false,
			value: date.getPreviouslyTime().today
		},
		{
			xtype : 'combo',
			width: 150,
			valueField:'value',
			displayField:'name',
			value:'0',
			store:new Ext.data.SimpleStore({
				fields:['name','value'],
				data:[
					['峰值','0'],
					['谷值','1'],
					['平均值','2'],
				]
			}),
			name:'type',
			allowBlank : false,
			blankText:'此项不能为空',
			editable: false,
			style: 'margin-left:15px;'
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
			width: 150,
			name: 'server_id',
			style: 'margin-left:15px;'
		},
		{
            xtype: 'button',
            style: 'margin-left:20px;',
            text: '查询',
            style: 'margin-left:15px;',
            handler: function(){
                submit();
            }
        }
	],
	renderTo: Ext.get('search')
});

function submit(){
    if (!SearchForm.getForm().isValid()) {
        Ext.Msg.alert('提示', '请正确地填写必要数据');
        return ;
    }
    var args = SearchForm.getForm().getValues();
    myMask.show();
    Ext.Ajax.request({
        url: js_url_path + '/index.php?r=/core/player/houronline',
        method:'POST',
        params: args,
        success: function(response){
            myMask.hide();
            var json = Ext.JSON.decode(response.responseText);
            var tableData = [];
            for( var i in json ){
				var dayCol = json[i];
				var countA = 0;
				for( var j in dayCol ){
					if( dayCol[j] ==0 ){
						countA++;
					}
				}
				if( countA == 24 ){
					for( var k in dayCol ){
						dayCol[k] = '';
					}
				}
				dayCol[ 'date' ] =  i;
				tableData.push( dayCol );
            }
            drawTable( tableData );
        },
        error: function(){
            myMask.hide();
        }
    });
}



function drawTable( data ){
	var targetDiv = Ext.get('dataTable');
	targetDiv.update('');
	
	var dataModelColumn = [];
    var tableHeaderColumn = [];
    dataModelColumn.push( { name: 'date', type:'string' } );
    tableHeaderColumn.push( {text: '日期', width: 90, dataIndex: 'date'} );
    for(var i = 1; i<= 24; i++ ){
        dataModelColumn.push( { name: i, type:'string' } );
        tableHeaderColumn.push( {text: i, width: 45, dataIndex: i} );
    }

	Ext.define('forbidModel', {
        extend: 'Ext.data.Model',
        fields: dataModelColumn
    });

	var store = Ext.create('Ext.data.Store', {
		model: forbidModel,
		data:data
	});
	var grid = Ext.create('Ext.grid.Panel', {
		store: store,
		frame: true,
		columns: tableHeaderColumn,
		width: 'auto',
		tbar: [{
			text: '导出数据',
			handler: function(){
                var url = js_url_path+'/index.php?r=core/player/houronlineexport';
                var args = SearchForm.getForm().getValues();
                var tmp = [];
                for(var i in args ){
					tmp.push( i+'='+args[i]);
	            }
                url += '&' + tmp.join('&');
                window.open( url );
            }
		}],
		renderTo: targetDiv
	});

	grid.addListener('celldblclick', cellclick);
    function cellclick(grid, rowIndex, columnIndex, e) {  
		var data = e.data;
		var day = data.date;
		var chartData = [];
		for(var i in data ){
			if( i == 'date' ){
				continue;
			}
			if( data[i] == '' ){
				break;
			}
			chartData.push( {name: i, data1: parseInt( data[i], 10) } );
		}
		drawChart( { data: chartData, title: day } );
    }
}




function drawChart( options ){
	var targetDiv = Ext.get('onlineChart');
	targetDiv.update('');

	if( options.data.length == 0 ){
		targetDiv.update('<h2 style="color:red;">暂无图表数据!</h2>');
		return ;
	}

	var store = Ext.create('Ext.data.JsonStore', {
    	fields: ['data1', 'name'],
        data: options.data
    });
	var chart1 = Ext.create('Ext.chart.Chart',{
		xtype: 'chart',
		animate: true,
		store: store,
		insetPadding: 30,
		axes: [{
			type: 'Numeric',
			minimum: 0,
			position: 'left',
			fields: ['data1'],
			title: '人数',
			grid: true,
			label: {
				renderer: Ext.util.Format.numberRenderer('0,0'),
				font: '10px Arial'
			}
		}, {
			type: 'Category',
			position: 'bottom',
			fields: ['name'],
			title: options.title + '(小时在线人数走势)',
			label: {
				font: '11px Arial',
				renderer: function(name) {
					return name;
				}
			}
		}],
		series: [{
			type: 'line',
			axis: 'left',
			xField: 'name',
			yField: 'data1',
			listeners: {
			  itemmouseup: function(item) {
				  Ext.example.msg('Item Selected', item.value[1] + ' visits on ' + Ext.Date.monthNames[item.value[0]]);
			  }
			},
			tips: {
				trackMouse: true,
				width: 80,
				height: 60,
				renderer: function(storeItem, item) {
					this.setTitle(storeItem.get('name'));
					this.update(storeItem.get('data1'));
				}
			},
			style: {
				fill: '#38B8BF',
				stroke: '#38B8BF',
				'stroke-width': 3
			},
			markerConfig: {
				type: 'circle',
				size: 4,
				radius: 4,
				'stroke-width': 0,
				fill: '#38B8BF',
				stroke: '#38B8BF'
			}
		}]
	});
	
	
	var panel1 = Ext.create('widget.panel', {
		width: 'auto',
		height: 400,
		renderTo: targetDiv,
		layout: 'fit',
		items: chart1
	});
}






myMask.hide();
});
</script>