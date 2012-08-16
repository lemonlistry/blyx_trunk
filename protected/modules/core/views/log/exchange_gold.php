<div id="NewForm"></div>
<div id="search"></div>
<div id="costCount"></div>


<script type="text/javascript">

Ext.onReady(function(){

var NewForm = Ext.widget({
	xtype: 'form',
	frame: true,
	height:35,
	defaultType: 'textfield',
	layout: 'column',
	items:[
		{
			xtype : 'datefield', 
			labelWidth: 55,
			width: 170,
			fieldLabel: '开始日期',
			emptyText: '',
			format: 'Y-m-d',
			name:'',
			editable: false
		},
		{
			xtype : 'datefield', 
			labelWidth: 55,
			width: 170,
			fieldLabel: '截止日期',
			emptyText: '',
			format: 'Y-m-d',
			name:'',
			style: 'margin-left:15px;',
			editable: false
		},
		{
			xtype : 'combo', 
			fieldLabel: '',
			labelWidth: 80,
			width: 150,
			emptyText: '',
			valueField:'value',
			displayField:'name',
			value:'0',
			store:new Ext.data.SimpleStore({  
				fields:['name','value'],  
				data:[
					['选择来源','0'],
					['腾讯QQ','1'],
					['91玩家','2'],
				]
			}),  
			name:'',
			editable: false,
			style: 'margin-left:15px;'
		},
		{
			xtype : 'combo', 
			fieldLabel: '',
			labelWidth: 80,
			width: 150,
			emptyText: '',
			valueField:'value',
			displayField:'name',
			value:'0',
			store:new Ext.data.SimpleStore({  
				fields:['name','value'],  
				data:[
					['账号名查询','0'],
					['角色名查询','1'],
				]
			}),  
			name:'',
			editable: false,
			style: 'margin-left:15px;'
		},
		{
			xtype : 'textfield', 
			labelWidth: 80,
			width: 250,
			fieldLabel: '请输入角色名',
			name:'',
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
          text: '导出TXT',
          width: 80,
          style: 'margin-left:15px;'
      }
	],
    renderTo: Ext.get('NewForm')
});


//数据表格
(function(){

	function drawTable( data ){
		var store = Ext.create('Ext.data.Store', {
			fields:['a1', 'a2','a3','a4','a5','a6'],
			data:data
		});

		Ext.create('Ext.grid.Panel', {
			title: '',
			store: store,
			viewConfig  : {
				enableTextSelection:true  
        	},
			columns: [
				{text: '通行证ID',  width:90,dataIndex:'a6'},
				{text: '账号名', width:100, dataIndex:'a1'},
				{text: '角色ID', width:100, dataIndex:'a3'},
				{text: '角色名', width:100, dataIndex:'a1'},
				{text: '货币名称', width:100, dataIndex:'a1'},
				{text: '兑换时间', width:100, dataIndex:'a1'},
				{text: '兑换数量', width:100, dataIndex:'a1'},
				{text: '兑换汇率', width:100, dataIndex:'a1'},
				{text: '黄金', width:100, dataIndex:'a1'},
				{text: '平台货币', width:100, dataIndex:'a1'},
				{text: '单号', width:100, dataIndex:'a1'},
			],
			renderTo: Ext.get('costCount')
		});
	}
	var dataCount = [
             	{
             		'a1':'',
             		'a2':'',
             		'a3':'',
             		'a6':'',
             	}
    ];
    for(var j=1;j<=11;j++){
		var a=(function( a,b ){
			return {
				'a1':'','a2':'','a3':'',
				'a6':'',
			};
		})(dataCount[0],j);
		dataCount.push(a);
	}
    drawTable(dataCount);
})();








myMask.hide();
});
</script>
