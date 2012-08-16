<div id="search"></div>
<div id="dataTable"></div>

<script type="text/javascript">
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
    layout : "column",
    items:[
        {
            xtype : 'checkbox', 
            labelWidth: 80,
            width: 110,
            fieldLabel: '排除测试账号',
            name:''
        },{
            xtype : 'datefield', 
            labelWidth: 55,
            width: 180,
            fieldLabel: '选择年月',
            format: 'Y-m-d',
            editable: false,
            name:'',
            style: 'margin-left:15px;'
        },{
            xtype : 'combo', 
            fieldLabel: '',
            labelWidth: 115,
            width: 150,
            emptyText: '选择服务器...',
            valueField:'value',
            displayField:'name',
            value:'0',
            store:new Ext.data.SimpleStore({  
                fields:['name','value'],  
                data:[
                    ['全部服务器','0'],
                    ['服务器1','1'],
                    ['服务器2','2'],
                ]
            }),  
            name:'',
            editable: false,
            style: 'margin-left:15px;'
        },
        {
            xtype: 'button',
            text: '查询',
            width: 80,
            style: 'margin-left:15px;'
        },
        {
            xtype: 'button',
            text: '导出Excel',
            width: 80,
            style: 'margin-left:15px;'
        },
        {
            xtype: 'button',
            text: '打印清单',
            width: 80,
            style: 'margin-left:15px;'
        },
    ],
    renderTo: Ext.get('search')
});


function drawTable( data ){
    var goldStruct = [
    {
        text:'日期',
        width: 110,
        dataIndex:'a1'
    },
    {
        text:'服务器名称',
        width: 125,
        dataIndex:'a1'
    },
    {
        text:'充值人数',
        width: 125,
        dataIndex:'a1'
    },
    {
        text:'充值次数',
        width: 125,
        dataIndex:'a1'
    },
    {
        text:'玩家充值(元)',
        width: 125,
        dataIndex:'a1'
    },
    {
        text:'玩家兑换黄金',
        width: 125,
        dataIndex:'a1'
    },
    {
        text:'系统赠送黄金',
        width: 125,
        dataIndex:'a1'
    },
    {
        text:'玩家消费金额',
        width: 125,
        dataIndex:'a1'
    }];
    
    Ext.define('goldModel',{
        extend: 'Ext.data.Model',
        fields: [
	       { name: 'a1', type:'string' }
        ]
    });
    var store = Ext.create('Ext.data.Store', {
    	model: goldModel,
    	data:data
    });
    
    Ext.create('Ext.grid.Panel', {
        title: '',
        store: store,
        viewConfig  : {
			enableTextSelection:true  
        },
        tbar: [{
			text: '导出数据',
			handler: function(){
                /*var url = js_url_path+'/index.php?r=core/statistic/retentionrateexport';
                var begintime = SearchForm.getForm().findField('begintime').getValue();
                var endtime = SearchForm.getForm().findField('endtime').getValue();
                var server_id = SearchForm.getForm().findField('server_id').getValue();
                if( !begintime || !endtime || !server_id ){
                    Ext.MessageBox.alert('提示','请先选择要导出的参数！(时间、服务器)');
                    return ;
                }
                begintime = date.format(begintime,'ISO8601Short');
                endtime = date.format(endtime,'ISO8601Short')
                url += '&begintime='+begintime+'&endtime='+endtime+'&server_id='+server_id;
                window.open( url );*/
            }
		}],
        frame: true,
        columns: goldStruct,
        renderTo: Ext.get('dataTable')
    });
}

var data = [{a1:''}];
for(var i=0;i<11;i++){
    data.push( data[0]);
}
drawTable( data );









myMask.hide();
});
</script>
