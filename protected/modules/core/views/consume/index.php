<div id="search"></div>
<div id="dataTable"></div>
<div id="chartPie"></div>

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
    height:33,
    defaults: {
        anchor: '100%',
        labelWidth: 180
    },
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
        /*{
            xtype : 'combo',
            fieldLabel: '日期范围选择',
            labelwidth: 70,
            columnWidth : .25,
            emptyText: '日期范围选择...',
            valueField:'value',
            displayField:'name',
            value: '1',
            store:new Ext.data.SimpleStore({
                fields:['name','value'],
                data:[
                    ['截止到当前','0'],
                    ['当日消费','1']
                ]
            }),
            name : '',
            editable: false,
            style: 'margin-left:15px;'
        },*/
        {
            xtype : 'combo',
            fieldLabel: '',
            labelWidth: 115,
            columnWidth : .2,
            emptyText: '查询服务器...',
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
      url: js_url_path+'/index.php?r=/core/consume/index ',
      method: 'POST',
      success: function(form, action) {
           drawTable(action.result.data);
      },
      failure: function(form, action) {
          formCallback.alert( action.result );
      }
    });
}

var pieKeyValueDict = {
	0: '购买精力',
	1: '精炼洗髓',
	25: '随从黄金刷新',
	2: '解锁包格',
	3: '远程仓库&商店',
	4: '强化成功率100%',
	5: '强化秒CD',
	6: '重置英雄榜',
	7: '加速挂机',
	8: '兑换银两',
	10: '寻访',
	9: '解锁秘籍格',
	11: '合成装备',
	12: '药园扩地',
	13: '刷新种子',
	14: '药园秒CD',
	15: '武林大会增加次数',
	16: '武林大会秒CD',
	17: '世界BOSS复活',
	18: '世界BOSS鼓舞',
	19: '帮派招人',
	20: '帮派捐献',
	26: '帮派战鼓舞',
	21: '帮派战秒CD',
	22: '门派竞技鼓舞',
	23: '日常任务秒CD',
	24: '刷新星级',
	27: '日常任务一键完成',
	28: '充值大礼包'
};

function drawTable( serverData ) {
    Ext.get('dataTable').update('');

    for(var m = 0; m < serverData.length; m++ ){
        var n1=0,n2=0,d=serverData[m];
        for( n in d ){
            if( n == 'date' || n == 'server_id' ) continue;
            n1++;
            if( d[n] == '0' || d[n] == '' || d[n] == null ) n2++;
        }
        for( n in d ){
            if( n == 'date' || n == 'server_id' ) continue;
            serverData[m][n] = n1 == n2 ? ' '
                    : ( serverData[m][n] == '' ? 0 : serverData[m][n]);
        }
        if( n1 != n2 ){
            for( var j = 0; j <= 28; j++ ){
                if(typeof serverData[m][j] != 'undefined' ) {
                    if(/-\d*/g.test( serverData[m][j] )){
                        serverData[m][j] = serverData[m][j].replace(/-/,'');
                    }
                    continue;
                };
                serverData[m][j] = 0;
            }
        }
    }

    var dayGoldIndexs = [];
    dayGoldIndexs.push({ name: 'date', type:'string' });
    dayGoldIndexs.push({
        name: 'server_id',
        type:'string',
        convert: function( value, record ){
             return server_obj[value];
        }
    });
    for( var i = 0; i <= 28; i++ ){
        dayGoldIndexs.push({
            name: i + '',
            type:'int'
        });
    }
    dayGoldIndexs.push({
        name: 'sum',
        type:'string',
        convert: function( v ){
            if( v == ' ') return '';
            return (-1 * parseInt(v||0, 10)) || 0;
        }
	});
    var struct = Ext.define('GoldStatStruct',{
        extend: 'Ext.data.Model',
        fields: dayGoldIndexs,
            /*[
           { name: 'date', type:'string' },
           {
               name: 'server_id',
               type:'string',
               convert: function( value, record ){
                    return server_obj[value];
               }
           },
           { name: '0', type:'string' },
           { name: '1', type:'string' },
           { name: '2', type:'string' },
           { name: '3', type:'string' },
           { name: '4', type:'string' },
           { name: '5', type:'string' },
           { name: '6', type:'string' },
           { name: '7', type:'string' },
           { name: '8', type:'string' },
           { name: '9', type:'string' },
           { name: '10', type:'string' },
           { name: '11', type:'string' },
           { name: '12', type:'string' },
           { name: '13', type:'string' },
           { name: '14', type:'string' },
           { name: '15', type:'string' },
           { name: '16', type:'string' },
           { name: '17', type:'string' },
           { name: '18', type:'string' },
           { name: '19', type:'string' },
           { name: '20', type:'string' },
           { name: '21', type:'string' },
           { name: '22', type:'string' },
           { name: '23', type:'string' },
           { name: '24', type:'string' },
           { name: '25', type:'string' },
           { name: '26', type:'string' },
           { name: '27', type:'string' },
		   { name: 'sum', type:'string'}
        ]*/
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
        text: '精力',
        columns: [
            {
                text: '购买精力',
                dataIndex: '0',
                width: 80,
            }
        ]
    },
    {
        text: '洗髓',
        columns: [
            {
                text: '精炼洗髓',
                dataIndex: '1',
                width: 70,
            }
        ]
    },
    {
        text: '随从',
        columns: [
            {
                text: '黄金刷新',
                dataIndex: '25',
                width: 70,
            }
        ]
    },
    {
        text: '背包仓库',
        columns:[
            {
                text: '解锁包格',
                dataIndex: '2',
                width: 70,
            },
            {
                text: '远程仓库&商店',
                dataIndex: '3',
                width: 100,
            }
        ]
    },
    {
        text:'强化',
        columns: [
            {
                text: '成功率100%',
                dataIndex: '4',
                width: 90,
            },
            {
                text: '秒CD',
                dataIndex: '5',
                width: 50,
            }
        ]
    },
    {
        text:'合成',
        columns: [
            {
                text: '合成装备',
                dataIndex: '11',
                width: 70,
            }
        ]
    },
    {
        text:'副本',
        columns: [
            {
                text: '重置英雄榜',
                dataIndex: '6',
                width: 70,
            },
            {
                text: '加速挂机',
                dataIndex: '7',
                width: 70,
            }
        ]
    },
    {
        text:'钱庄',
        columns: [
            {
                text: '兑换银两',
                dataIndex: '8',
                width: 70,
            }
        ]
    },
    {
        text:'拜访',
        columns: [
            {
                text: '寻访',
                dataIndex: '10',
                width: 50,
            },
            {
                text: '解锁秘籍格',
                dataIndex: '9',
                width: 70,
            }
        ]
    },
    {
        text:'药园',
        columns: [
            {
                text: '扩地',
                dataIndex: '12',
                width: 50,
            },
            {
                text: '刷新种子',
                dataIndex: '13',
                width: 70,
            },
            {
                text: '秒CD',
                dataIndex: '14',
                width: 50,
            }
        ]
    },
    {
        text:'武林大会',
        columns: [
            {
                text: '增加次数',
                dataIndex: '15',
                width: 70,
            },
            {
                text: '秒CD',
                dataIndex: '16',
                width: 50,
            }
        ]
    },
    {
        text:'世界BOSS',
        columns: [
            {
                text: '复活',
                dataIndex: '17',
                width: 50,
            },
            {
                text: '鼓舞',
                dataIndex: '18',
                width: 50,
            }
        ]
    },
    {
        text:'帮派',
        columns: [
            {
                text: '招人',
                dataIndex: '19',
                width: 50,
            },
            {
                text: '捐献',
                dataIndex: '20',
                width: 50,
            }
        ]
    },
    {
        text:'帮派战',
        columns: [
            {
                text: '鼓舞',
                dataIndex: '26',
                width: 50,
            },
            {
                text: '秒CD',
                dataIndex: '21',
                width: 50,
            }
        ]
    },
    {
        text:'门派竞技',
        columns: [
            {
                text: '鼓舞',
                dataIndex: '22',
                width: 50,
            }
        ]
    },
    {
        text:'日常任务',
        columns: [
            {
                text: '秒CD',
                dataIndex: '23',
                width: 50,
            },
            {
                text: '刷新星级',
                dataIndex: '24',
                width: 70,
            },
            {
                text: '一键完成',
                dataIndex: '27',
                width: 80
            }
        ]
    },
    {
        text:'开启礼包',
        columns: [
            {
                text: '充值大礼包',
                dataIndex: '28',
                width: 70,
            }
        ]
    },
    {
        text: '汇总',
        dataIndex: 'sum',
        width: 70
    }
    ];


    var store = Ext.create('Ext.data.Store',{
        model: 'GoldStatStruct',
        data: serverData
    });


    var grid = Ext.create('Ext.grid.Panel', {
        title: '',
        store: store,
        viewConfig  : {
            enableTextSelection:true
        },
        tbar: [{
			text: '导出数据',
			handler: function(){
                var url = js_url_path+'/index.php?r=core/consume/costtypeexport';
                var begintime = SearchForm.getForm().findField('begintime').getValue();
                var endtime = SearchForm.getForm().findField('endtime').getValue();
                var server_id = SearchForm.getForm().findField('server_id').getValue();
                if( !begintime || !endtime ){
                    Ext.MessageBox.alert('提示','请先选择要导出的参数！(时间、服务器)');
                    return ;
                }
                begintime = date.format(begintime,'ISO8601Short');
                endtime = date.format(endtime,'ISO8601Short')
                url += '&begintime='+begintime+'&endtime='+endtime+'&server_id='+server_id;
                window.open( url );
            }
		}],
        frame: true,
        columns: tableHeaderColumn,
        renderTo: Ext.get('dataTable')
    });
    grid.addListener('celldblclick', cellclick);
    function cellclick(grid, rowIndex, columnIndex, e) {  
		var data = e.data;
		var sum = data.sum;
		var pieData = [];
		var countZero = 0;
		for(var i in data ){
			if( i == 'date' || i == 'server_id' || i == 'sum' ){
				continue;
			}
			if( data[i] == 0 ){
				countZero++;
			}
			var val = data[i];
			var name = pieKeyValueDict[i] + '(' + parseInt( val / sum * 10000)/100 + '%'+ ')';
			pieData.push({ name: name, data1: val });
		}
		if( countZero == 29 ){
			Ext.Msg.alert('提示','当天的数据为空，图表显示数据的操作取消!');
			return;
		}
        drawPie({ data: pieData, title: '', targetId: 'chartPie' });
    }
}





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
	    height: 400,
	    title: options.title,
	    renderTo: target,
	    layout: 'fit',
	    items: chart
	});
}

myMask.hide();
});
</script>
