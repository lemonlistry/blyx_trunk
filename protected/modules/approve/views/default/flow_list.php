<?php 
    echo Html5::link('添加流程', array('/approve/default/addflow'), array(
        'class' => 'js-dialog-link js-link-btn',
        'data-height'=>'200',
        'data-width'=>'515'
    )); 
?>
<div id="list"></div>
<script type="text/javascript">
<?php
    echo "var current_page = '". $current_page ."';";
?>
Ext.onReady(function(){

function drawTable(  ){
    Ext.define('serverStruct', {
        extend: 'Ext.data.Model',
        fields: [
            {name: 'id', type:'string'},
            {name: 'tag', type: 'string'},
            {name: 'name', type: 'string'},
            {name: 'node_info', type: 'string'},
            {name: 'desc', type: 'string'},
            {name: 'status', type: 'string'},
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
	    autoLoad : false,
		model: 'serverStruct',
		proxy: {
			type: 'ajax',
			url: current_page,
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
		page.set( store.currentPage );
		startDrawTable();
	});	
	

    function startDrawTable(){
        Ext.create('Ext.grid.Panel', {
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
                {text: '编号', width:100,dataIndex:'id'},
                {text: '标签', width:80, dataIndex:'tag'},
                {text: '名称', width:130, dataIndex:'name'},
                {text: '节点',width:150,  dataIndex:'node_info'},
                {text: '描述',width:150,  dataIndex:'desc'},
                {text: '状态',width:150,  dataIndex:'status'},
                {text: '创建时间',width:150,dataIndex:'create_time'},
                {
                    xtype:'actioncolumn',
                    width:55,
                    align: 'center',
                    text:'添加节点',
                    items: [{
                        icon: js_source_path+'/source/js/ExtJS/shared/icons/fam/add.gif',  // Use a URL in the icon config
                        tooltip: 'Edit',
                        handler: function(grid, rowIndex, colIndex) {
                            var record = store.getAt(rowIndex);
                            var id = record.get('id');            
                            openWindow({
                                title:'详细信息',
                                width:'515',
                                height:'200',
                                className:'test',
                                src:js_url_path+'/index.php?r=/approve/default/addnode/id/'+id
                            });
                        }
                    }]
                },
                {
                    xtype:'actioncolumn',
                    width:40,
                    text:'删除',
                    align: 'center',
                    items: [{
                        icon: js_source_path+'/source/js/ExtJS/shared/icons/fam/delete.gif',
                        tooltip: 'Delete',
                        handler: function(grid, rowIndex, colIndex) {
                            ajaxCallBack.alert({
    			                params : {
                                    id : store.getAt(rowIndex).get('id')
                                },
                                url : js_url_path+'/index.php?r=/approve/default/deleteflow/'
                            });
                        }
                    }]
                }
            ],
            width: 'auto',
            renderTo: Ext.get('list')
        });
    }

}

drawTable();

myMask.hide();
});
</script>
