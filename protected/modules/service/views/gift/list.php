<div id="search"></div>


<div style="clear:both;"></div>
<div id="list"></div>

<script type="text/javascript">

Ext.onReady(function(){

var searchForm = Ext.widget({
    xtype: 'form',
    frame: true,
    width: 'auto',
    height:33,
    layout : "column",
    items:[
        {
            xtype : 'datefield',
            width:200,
            labelWidth:70,
            fieldLabel: '开始日期',
            format: 'Y-m-d',
            name:'begintime',
            editable: false,
            value: date.getPreviouslyTime().lastMonth
        },
        {
            xtype : 'datefield',
            width:200,
            labelWidth:70,
            fieldLabel: '截止日期',
            format: 'Y-m-d',
            name:'endtime',
            editable: false,
            style: 'margin-left:7px;',
            value: date.getPreviouslyTime().yesterday
        },
        {
            xtype : 'textfield',
            width: 200,
            emptyText: '角色名',
            name:'role_name',
            style: 'margin-left:7px;'
        },
        {
            xtype : 'button',
            width: 60,
            text: '查询',
            style: 'margin-left:7px;',
            handler: function(){
                submit();
            }
        },
        {
            xtype : 'button',
            width: 60,
            text: '添加礼包',
            style: 'margin-left:7px;',
            handler: function(){
				openWindow({
					src : js_url_path+'/index.php?r=service/gift/addgift',
					title:'添加礼包',
					width:520,
					height:280
				});
            }
        }
    ],
    renderTo: Ext.get('search')
});

function submit(){
    var args = searchForm.getForm().getValues();
    drawTable( args );
}

	
function drawTable( options ){
	var targetDiv = Ext.get('list');
	targetDiv.update('');
    Ext.define('serverStruct', {
        extend: 'Ext.data.Model',
        fields: [
            {name: 'role_id', type:'string'},
            {
                name: 'role_name',
                type:'string',
                convert: function (value, record) {
                    return value ||　' ';
                }
            },
            {name: 'sname', type: 'string'},
            {name: 'name', type: 'string'},
            {name: 'item_name',type: 'string'},
            {name: 'time', type: 'string'},
            {name: 'num',type: 'string'},
            {
                name: 'create_time',
                type: 'string',
                convert: function (value, record) {
                    return date.format(value,'ISO8601Long');
                }
            },
            {name: 'status', type: 'string'},
            {name: 'tran_status',type: 'string'}
        ]
    });



    myMask.show();
	var currentPage = page.get() || 1;
	//解决翻页按钮状态错误bug,c_page = parseInt( c_page );
	currentPage = parseInt( currentPage,10 );
	var startpage = (currentPage-1) * window.config.$page;
	var store = Ext.create('Ext.data.Store', {
		model: 'serverStruct',
		proxy: {
			type: 'ajax',
			url: js_url_path+'/index.php?r=/service/gift/list',
			extraParams: options,
			reader: {
				root: 'dataList',
				totalProperty: 'dataCount'
			},
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
	});

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
        columns: [
            {text: '编号', width:60,dataIndex:'id'},
            {text: '服务器名字', width:120, dataIndex:'sname'},
            {text: '有效时间', width:80, dataIndex:'time'},
            {text: '角色ID',width:160,  dataIndex:'role_id'},
            {text: '角色名称',width:220,  dataIndex:'role_name'},
            {text: '礼包名称', width:120, dataIndex:'name'},
            {text: '物品名称',width:70,  dataIndex:'item_name'},
            {text: '数量', width:60, dataIndex:'num'},
            {text: '状态', width:60, dataIndex:'tran_status'},
            {text: '创建时间', width:140, dataIndex:'create_time'},
            {
                xtype:'actioncolumn',
                width:40,
                text:'操作',
                items: [{
                    icon: js_source_path+'/source/js/ExtJS/shared/icons/fam/delete.gif',
                    tooltip: 'Delete',
                    handler: function(grid, rowIndex, colIndex) {
                        var _id = store.getAt(rowIndex).get('id');
                        var url = js_url_path+'/index.php?r=/service/gift/deletegift';
                        ajaxCallBack.alert({
                            params : {
                                id : _id
                            },
                            url : url
                        });
                    },
                    getClass:function(v,m,r,rIndex,cIndex,store){
                        if(r.data.status != 0){
                            return 'x-hidden';
                        }
                    }
                }]
            }
        ],
        width: 'auto',
        renderTo: targetDiv
    });
}

submit();
	
myMask.hide();

});
</script>

