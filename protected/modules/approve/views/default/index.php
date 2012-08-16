<script type="text/javascript">
<?php
    echo "var show_approve = ". (!isset($show_approve) ? 1 : 0) .";";
    echo "var current_page = '". $current_page ."';";
?>
    
Ext.onReady(function(){

function drawTable(  ){
    Ext.define('serverStruct', {
        extend: 'Ext.data.Model',
        fields: [
            {
                name: 'flow_name', 
                type:'string'
            },
            {name: 'username', type: 'string'},
            {name: 'status', type: 'string'},
            {name: 'current_user', type: 'string'},
            {name: 'flow_id', type: 'string'},
            {name: 'relate_id', type: 'string'},
            {name: 'prime', type: 'string'},
            {name: 'current_node_id', type: 'string'},
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
	});	

    var my_grid = Ext.create('Ext.grid.Panel', {
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
            {text: '流程', width:100,dataIndex:'flow_name'},
            {text: '发布人', width:80, dataIndex:'username'},
            {text: '状态', width:130, dataIndex:'status'},
            {text: '当前流转',width:80,  dataIndex:'current_user'},
            {text: '创建时间',width:150,  dataIndex:'create_time'},
            {
                xtype:'actioncolumn',
                width:40,
                text:'审批',
                align: 'center',
                hidden : !show_approve,
                items: [{
                    icon: js_source_path+'/source/js/ExtJS/shared/icons/fam/folder_go.gif',  // Use a URL in the icon config
                    tooltip: 'Edit',
                    handler: function(grid, rowIndex, colIndex) {
                        var record = store.getAt(rowIndex);
                        var id = record.get('id');
                        var flow_id = record.get('flow_id');
                        var relate_id = record.get('relate_id');
                        var current_node_id = record.get('current_node_id');
                        openWindow({
                            title:'审批',
                            width:'515',
                            height:'190',
                            className:'test',
                            src:js_url_path+'/index.php?r=/approve/default/approve/task_id/' + id + '/flow_id/' + flow_id + '/node_id/' + current_node_id
                        });
                    },
                    getClass:function(v,m,r,rIndex,cIndex,store){  
                        if( r.data.prime == 'false'){
                            return 'x-hidden';
                        }
                    }
                }]
            },
            {
                xtype:'actioncolumn',
                width:40,
                text:'详情',
                align: 'center',
                items: [
                {
                    icon: js_source_path+'/source/js/ExtJS/shared/icons/fam/book.png',
                    tooltip: 'Edit',
                    handler: function(grid, rowIndex, colIndex) {
                        var record = store.getAt(rowIndex);
                        var flow_id = record.get('flow_id');
                        var relate_id = record.get('relate_id');
                        openWindow({
                            title:'详细信息',
                            width:'550',
                            height:'280',
                            className:'test',
                            src:js_url_path+'/index.php?r=/approve/default/relateinfo/relate_id/' + relate_id + '/flow_id/'+flow_id
                        });
                    }
                }]
            },
            {
                xtype:'actioncolumn',
                width:40,
                text:'记录',
                align: 'center',
                items: [
                {
                    icon: js_source_path+'/source/js/ExtJS/shared/icons/fam/grid.png',  // Use a URL in the icon config
                    tooltip: 'Edit',
                    handler: function(grid, rowIndex, colIndex) {
                        var record = store.getAt(rowIndex);
                        var id = record.get('id');            
                        openWindow({
                            title:'审批记录',
                            width:'550',
                            height:'200',
                            className:'test',
                            src:js_url_path+'/index.php?r=/approve/default/approverecord/task_id/'+id
                        });
                    }
                }]
            }
        ],
        width: 'auto',
        renderTo: Ext.getBody()
    });
    
}

drawTable();
myMask.hide();
});
</script>
