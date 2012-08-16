<div id="search"></div>
<div id="dataTable"></div>
<script type="text/javascript">
<?php 
    echo "var infoData = " . json_encode($list) . ';';
?>
Ext.onReady(function() {

	var dataStruct = {
		fields : ['name','data1'],
		data :[
		{
			name:'2012-05-01',
			data1:10
		},
		{
			name:'2012-05-02',
			data1:20
		},
		{
			name:'2012-05-03',
			data1:30
		},
		{
			name:'2012-05-04',
			data1:40
		},
		{
			name:'2012-05-05',
			data1:50
		}]
    };
    window.gernerate=function() {
        var arr=[]
		for(var i=1;i<=25;i++){
			arr.push({
				name:'2012-06-'+i,
				data1:parseInt(Math.random()*1000,10)
			});
		}
		return {
			fields:['name','data1'],
			data:arr
		};
    }
    dataStruct= gernerate();
    window.store1 = Ext.create('Ext.data.JsonStore',dataStruct);
    
    
});
</script>


<script type="text/javascript">
<?php 
    echo 'var server_obj='.json_encode($select).';'; 
?>
var server_arr    = build.array( server_obj );

Ext.Loader.setConfig({
    enabled: true
});
Ext.Loader.setPath('Ext.ux', js_source_path+'/source/js/ExtJS/ux');
Ext.require([
     'Ext.ux.CheckColumn'
]);
Ext.onReady(function(){

//查询表单

	var required = '<span style="color:red;font-weight:bold" data-qtip="Required">*</span>';
	var SearchForm = Ext.widget({
        xtype: 'form',
        frame: true,
        width: 'auto',
        height:35,
        fieldDefaults: {
            labelAlign: 'left',
            msgTarget: 'side',
            width : 250,
            labelWidth : 60,
            style : 'margin-left:15px;',
        },
        layout : "column",
        items: [{
                xtype:'datefield',
                fieldLabel: '开始日期',
                afterLabelTextTpl: required,
    			emptyText: '查询开始日期...',
    			format: 'Y-m-d',
    			allowBlank : false, 
    			blankText:'此项不能为空',
    			editable:false,
    			name:'begintime',
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
            },{
            	xtype:'datefield',
                fieldLabel: '结束日期',
                editable:false,
                afterLabelTextTpl: required,
				format: 'Y-m-d',
				allowBlank : false, 
				blankText:'此项不能为空',
				name:'endtime',
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
            },{
                fieldLabel: '选择服务器',
                afterLabelTextTpl: required,
                xtype : 'combo', 
				valueField:'value',
				displayField:'name',
				value : server_arr[0][1],
				store : new Ext.data.SimpleStore({  
					fields : ['name','value'],  
					data : server_arr
				}),
				name : 'server_id',
				allowBlank : false, 
				blankText : '此项不能为空',
				editable : false,  
				labelWidth : 80,
                width : 270,
                listeners: {
    	            specialkey: {
    	                fn: function(field,e) {
                            if(e.getKey() == Ext.EventObject.ENTER){
                                submit();
                            }
    	                }
    	            }
    	        },
            },
            {
                xtype : 'button',
                text : '查询',
                style : 'margin-left:15px;',
                width : '80',
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
      url: js_url_path+'/index.php?r=/core/statistic/index ',
      method: 'POST',
      success: function(form, action) {
          var data = action.result.data,arr=[];
          for( var i in data){
              arr.push(data[i]);
          }
          action.result.data = arr;
          drawTable(action.result.data);
      },
      failure: function(form, action) {
          var msg=unescape(Ext.encode(action.result));
          Ext.Msg.alert('提示', '原因如下：<br>'+msg);
      }
    });
}





function drawTable( data ){
    Ext.get('dataTable').update('');

    for(var m = 0; m < data.length; m++ ){
        var n1=0,n2=0,d=data[m];
        for( n in d ){
            if( n == 'date' ) continue;
            n1++;
            if( d[n] == '0' || d[n] == '' ) n2++; 
        }
        if( n1 == n2 ){
            for( n in d ){
                if( n == 'date' ) continue;
                data[m][n] = '';
            }
        }
    }
    
	var dataStruct1=[
	{
		text:'注册用户数',
		width: 70,
		dataIndex:'register_tot'
	},
	{
		text:'创建角色数',
		width: 70,
		dataIndex:'create_tot'
	},
	{
		text:'开通率',
		width: 50,
		dataIndex:'role_rate'
	},
	{
		text:'今日登录数(DAU)',
		width: 70,
		dataIndex:'login_tot'
	},
	{
		text:'登录IP数',
		width: 70,
		dataIndex:''
	},
	{
		text:'登录角色数',
		width: 70,
		dataIndex:''
	},
	{
		text:'登录率',
		width: 50,
		dataIndex:''
	},
	{
		text:'>=10级角色数',
		width: 90,
		dataIndex:''
	},
	{
		text:'百分比',
		width: 50,
		dataIndex:''
	},
	{
		text:'>=30级角色数',
		width: 90,
		dataIndex:''
	},
	{
		text:'百分比',
		width: 50,
		dataIndex:''
	}];
	
	var dataStruct2=[
	{
		text:'注册数用户数',
		width: 80,
		dataIndex:'register_day'
	},
	{
		text:'创建角色数',
		width: 70,
		dataIndex:'create_day'
	},
	{
		text:'今日登录数',
		width: 50,
		dataIndex:'login_day'
	},
	{
		text:'登录IP数',
		width: 70,
		dataIndex:''
	},
	{
		text:'登录角色数',
		width: 70,
		dataIndex:''
	},
	{
		text:'登录率',
		width: 50,
		dataIndex:'role_day_rate'
	},
	{
		text:'>=10级角色数',
		width: 90,
		dataIndex:''
	},
	{
		text:'百分比',
		width: 50,
		dataIndex:''
	},
	{
		text:'>=30级角色数',
		width: 90,
		dataIndex:''
	},
	{
		text:'百分比',
		width: 50,
		dataIndex:''
	}];
    
	Ext.define('LoginStruct',{
        extend: 'Ext.data.Model',
        fields: [
           { name: 'date', type:'string' },
           { name: 'register_tot', type:'string'},
           { name: 'register_day', type:'string'},
           { name: 'login_tot', type:'string'},
           { name: 'create_tot', type:'string'},
           { name: 'create_day', type:'string'},
           { name: 'role_rate', type:'string'},
           { name: 'role_day_rate', type:'string'}
        ]
    });

	var store = Ext.create('Ext.data.Store', {
		model: LoginStruct,
		data:data
	});
	Ext.create('Ext.grid.Panel', {
		store: store,
		viewConfig  : {
			enableTextSelection:true  
        },		
        tbar: [{
			text: '导出数据',
			handler: function(){
                var url = js_url_path+'/index.php?r=core/statistic/registerloginexport';
                var begintime = SearchForm.getForm().findField('begintime').getValue();
                var endtime = SearchForm.getForm().findField('endtime').getValue();
                var server_id = SearchForm.getForm().findField('server_id').getValue();
                if( !begintime || !endtime  ){
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
		CellSelectionModel:true,
		columns: [
			{
				text:'范围',
				columns:[
					{
						text:'日期',
						dataIndex:'date',
						width: 100
					}
				],
			},
			{
				text:'截止到当前日期(总账号角色数)',
				columns: dataStruct1,
			},
			{
				text:'今日新增(新账号角色数)',
				columns: dataStruct2,
			}
		],
		width: 'auto',
		renderTo: Ext.get('dataTable')
	});
}




//图表统计
var chart1 = Ext.create('Ext.chart.Chart',{
	xtype: 'chart',
	animate: false,
	store: store1,
	insetPadding: 30,
	axes: [{
		type: 'Numeric',
		minimum: 0,
		position: 'left',
		fields: ['data1'],
		title: '登录人数',
		grid: true,
		label: {
			renderer: Ext.util.Format.numberRenderer('0,0'),
			font: '10px Arial'
		}
	}, {
		type: 'Category',
		position: 'bottom',
		fields: ['name'],
		title: false,
		label: {
			font: '11px Arial',
			renderer: function(name) {
				//return name.substr(0, 3) + ' 07';
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
	width: 1000,
	height: 300,
	title: '注册登录图表',
	//renderTo: Ext.getBody(),
	layout: 'fit',
	tbar: [{
		text: '下载数据表',
		handler: function(){ downloadChart(chart1); }
	}],
	items: chart1
});






myMask.hide();
});
</script>
