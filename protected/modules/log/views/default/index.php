<div id="search-player"></div>
<div id="loglist"></div>


<script type="text/javascript">
Ext.Loader.setConfig({enabled: true});
Ext.Loader.setPath('Ext.ux', js_source_path+'/source/js/ExtJS/ux/');
Ext.require([
    'Ext.ux.PreviewPlugin'
]);
Ext.onReady(function(){


var logForm = Ext.widget({
    xtype: 'form',
    frame: true,
    width: 'auto',
    height:35,
    layout : "column",
    fieldDefaults: {
        labelAlign: 'left',
        msgTarget: 'side',
        width : 260,
        labelWidth : 60,
        style : 'margin-left:15px;'
    },
    items:[
		{
			xtype : 'datefield',
		    fieldLabel: '开始时间',
		    name: 'begintime',
		    format: 'Y-m-d H:m:s',
            editable : false,
            listeners: {
	            specialkey: {
	                fn: function(field,e) {
                        if(e.getKey() == Ext.EventObject.ENTER){
                            submit();
                        }
	                }
	            }
	        }
		},{
		    xtype: 'datefield',
		    fieldLabel: '结束时间',
		    name: 'endtime',
		    format: 'Y-m-d H:m:s',
		    editable : false,
		    listeners: {
	            specialkey: {
	                fn: function(field,e) {
                        if(e.getKey() == Ext.EventObject.ENTER){
                            submit();
                        }
	                }
	            }
	        }
		},{
		    xtype: 'textfield',
		    fieldLabel: '用户',
		    name: 'operator',
		    listeners: {
	            specialkey: {
	                fn: function(field,e) {
                        if(e.getKey() == Ext.EventObject.ENTER){
                            submit();
                        }
	                }
	            }
	        }
		},{
			xtype : 'combo',
			width: 150,
			valueField:'value',
			displayField:'name',
			emptyText: '请选择模块',
			value:'',
			store:new Ext.data.SimpleStore({
				fields:['name','value'],
				data:[
					['passport','passport'],
					['core','core'],
					['install','install'],
					['restfulApi','restfulApi'],
					['service','service'],
					['log','log'],
					['realtime','realtime'],
					['cron','cron'],
					['approve','approve'],
					['tools','tools'],
                    ['' , ''],
				]
			}),
			name:'moudel',
			allowBlank : false,
			editable: false,
			style: 'margin-left:15px;'
		},
		{
			xtype : 'button',
            style:'margin-left:20px;',
            text:'查询',
            handler : function(){
                //var v=this.up('form').getForm().getValues(true);
                //Ext.Msg.alert('Submitted Values', v );
                //return ;
                submit();
        	}
        }
    ],
    renderTo : Ext.get('search-player')
});

function submit(){
	var begintime = logForm.getForm().findField('begintime').getValue();
	var endtime = logForm.getForm().findField('endtime').getValue();
	var operator = logForm.getForm().findField('operator').getValue();
	var moudel = logForm.getForm().findField('moudel').getValue();
    if( !begintime && !endtime && !operator && !moudel){
        Ext.Msg.alert('提示','您总得输入点东西再查询吧!');
        return ;
    }
	drawTable(begintime,endtime,operator,moudel);
}




function drawTable(start,end,operator,moudel){
	start = start || '';
	end = end || '';
	operator = operator || '';
	moudel = moudel || '';
	Ext.getDom('loglist').innerHTML = '';

	Ext.define('LogDataStruct', {
		extend: 'Ext.data.Model',
		fields: [
			{name: 'id', type:'string'},
			{name: 'module', type: 'string'},
			{
                name: 'msg',
                type: 'string',
                convert: function (value, record) {
                    if( /异常|错误|失败/g.test(value) ){
                        return '<span style="color:red;">'+value+'</span>';
                    }
                    return value;
                }
            },
			{name: 'operator', type: 'string'},
			{
				name: 'create_time',
				type: 'string',
				convert: function (value, record) {
                    return date.format(value,'ISO8601Long');

                }
            }
		]
	});
	myMask.show();
	var currentPage = page.get() || 1;
	//解决翻页按钮状态错误bug,c_page = parseInt( c_page );
	currentPage = parseInt( currentPage,10 );
	var startpage = (currentPage-1) * window.config.$page;
	var store = Ext.create('Ext.data.Store', {
		model: 'LogDataStruct',
		proxy: {
			type: 'ajax',
			url: js_url_path+'/index.php?r=/log/default/loglist',
			extraParams: {
				begintime : start,
				endtime : end,
				operator : operator,
				moudel : moudel
			},
			reader: {
				/*
				返回的json格式如下：
				{"dataCount":10,"dataList":[{"name":"zhangh","age":"24"}]}
				*/
				root: 'dataList',//json格式中存储数据数组的对象
				totalProperty: 'dataCount'//json格式中存储总数据量的对象
			}
		},
		pageSize: window.config.$page,
		currentPage: currentPage
	});
	store.load({
		params:{
			page: currentPage,
			start: startpage,
        	limit: window.config.$page
		}
	});
	store.on('load',function(){
		myMask.hide();
		page.set( store.currentPage );
		initLogList();
	});

	function initLogList(){
		Ext.get('loglist').update('');
		Ext.create('Ext.grid.Panel', {
			title: '',
			store: store,
			viewConfig  : {
				enableTextSelection:true
	        },
			bbar: Ext.create('Ext.PagingToolbar', {
				store: store,
				displayInfo: true,
				displayMsg: '第{0}-{1}条(共{2}条)',
				emptyMsg: "<b style='color:red;'>查询结果为空</b>"
			}),
			loadMask: true,
			columns: [
				{text: '序号',  dataIndex:'id'},
				{text: '模块',  width:130,dataIndex:'module'},
				{text: '记录',  width:250,dataIndex:'msg'},
				{text: '操作者',  dataIndex:'operator'},
				{text: '创建时间',width:180,  dataIndex:'create_time'},
				{
					xtype:'actioncolumn',
					width:40,
                    text : '信息',
                    align: 'center',
					items: [{
						icon: js_source_path+'/source/js/ExtJS/shared/icons/fam/book.png',  // Use a URL in the icon config
						tooltip: 'Edit',
						handler: function(grid, rowIndex, colIndex) {
							var record = store.getAt(rowIndex);
	                        var id = record.get('id');
							openWindow({
								title:'日志信息',
								width:'800',
								height:'240',
								className:'test',
								src:js_url_path+'/index.php?r=/log/default/look/id/'+id
							});
						}
					}]
				}
			],
			width: 'auto',
			renderTo: Ext.get('loglist')
		});
	}
}


drawTable();


myMask.hide();

});
</script>
