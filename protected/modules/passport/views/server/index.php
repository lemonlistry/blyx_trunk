<?php echo Html5::link('添加服务器', array('/passport/server/addServer'), array(
    'class' => 'js-dialog-link js-link-btn',
    'data-height' => '490',
    'data-width' => '550'
)); ?>
<div id="server_list"></div>
<script type="text/javascript">

Ext.Loader.setConfig({enabled: true});
Ext.Loader.setPath('Ext.ux', js_source_path+'/source/js/ExtJS/ux/');
Ext.require([
    'Ext.ux.PreviewPlugin'
]);


Ext.onReady(function(){
    drawTable();
function drawTable( ){

    Ext.getDom('server_list').innerHTML = '';
    Ext.define('serverStruct', {
        extend: 'Ext.data.Model',
        fields: [
            {name: 'server_id', type:'string'},
            {name: 'gname', type:'string'},
            {name: 'sname', type: 'string'},
            {name: 'create_time', type: 'string'},
            {
                name: 'status',
                type: 'string',
                convert : function(value,record){
                    return ['异常','正常'][ parseInt(value,10) ];
                }
            },
            {
                name: 'recommend',
                type: 'string',
                convert : function(value,record){
                    return ['测试服','正式服'][ parseInt(value,10) ];
                }
            },
            {
                name: 'type',
                type: 'string',
                convert : function(value,record){
                    return ['日志服','逻辑服','网关服','游戏库'][ parseInt(value,10) ];
                }
            },
            {name: 'db_ip', type: 'string'},
            {name: 'db_port', type: 'string'},
            {name: 'db_name', type: 'string'},
            {name: 'db_user', type: 'string'},
            {name: 'db_passwd', type: 'string'},
            {name: 'web_ip', type: 'string'},
            {name: 'web_socket_port', type: 'string'},
            {name: 'gateway_socket_port', type: 'string'},
            {name: 'gateway_ip', type: 'string'}
        ]
    });

	var currentPage = page.get() || 1;
	//解决翻页按钮状态错误bug,c_page = parseInt( c_page );
	currentPage = parseInt( currentPage,10 );
	var startpage = (currentPage-1) * window.config.$page;
    var store = Ext.create('Ext.data.Store', {
        model: 'serverStruct',
        autoLoad:true,
        proxy: {
            type: 'ajax',
            url: js_url_path+'/index.php?r=/passport/server/serverlist',
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

    Ext.create('Ext.grid.Panel', {
        store: store,
        viewConfig  : {
			enableTextSelection:true
        },
        columns: [
            {text: '游戏名', width:100,dataIndex:'gname'},
            {text: '服务器ID', width:60,dataIndex:'server_id'},
            {text: '服务器名字', width:80, dataIndex:'sname'},
            {text: '开服时间', width:105, dataIndex:'create_time'},
            {text: '服务器状态',width:70,  dataIndex:'status'},
            {text: '服务器标记', width:70, dataIndex:'recommend'},
            {text: '服务器类型',width:70,  dataIndex:'type'},
            {text: '数据库IP', width:90, dataIndex:'db_ip'},
            {text: '数据库端口', width:60, dataIndex:'db_port'},
            {text: '数据库名', width:60, dataIndex:'db_name'},
            {text: '账号', width:60, dataIndex:'db_user'},
            {text: '密码', width:70, dataIndex:'db_passwd'},
            {text: 'web服务器IP', width:90, dataIndex:'web_ip'},
            {text: 'web服务器端口', width:70, dataIndex:'web_socket_port'},
            {text: '网关服务器IP', width:90, dataIndex:'gateway_ip'},
            {text: '网关服务器端口', width:70, dataIndex:'gateway_socket_port'},
            {
                xtype:'actioncolumn',
                width:35,
                text:'编辑',
                align: 'center',
                items: [{
                    icon: js_source_path+'/source/js/ExtJS/shared/icons/fam/cog_edit.png',
                    tooltip: 'Edit',
                    handler: function(grid, rowIndex, colIndex) {
                        var record = store.getAt(rowIndex);
                        var id = record.get('id');
                        openWindow({
                            title:'编辑服务器信息',
                            width:'550',
                            height:'600',
                            className:'test',
                            src: js_url_path + '/index.php?r=/passport/server/updateserver/id/'+id
                        });
                    }
                }]
            },
            /*{
                xtype:'actioncolumn',
                width:35,
                text:'删除',
                items: [{
                    icon: js_source_path+'/source/js/ExtJS/shared/icons/fam/delete.gif',
                    tooltip: 'Delete',
                    handler: function(grid, rowIndex, colIndex) {
                        Ext.MessageBox.confirm("确认操作","您确定要删除这条记录吗？",function(e){
                            var record = store.getAt(rowIndex);
                            var _id = record.get('id');
                            if(e=='yes'){
                                myMask.show();
                                Ext.Ajax.request({
                                    url: js_url_path+'/index.php?r=/passport/server/deleteserver/',
                                    method:'POST',
                                    params: {
                                        id:_id
                                    },
                                    success: function(response){
                                        var json = Ext.JSON.decode(response.responseText);
                                        myMask.hide();
                                        Ext.MessageBox.alert("操作提示",
                                                json.text,
                                            function(){
                                                window.location.reload();
                                            }
                                        );
                                    }
                                });
                            }else{
                                showResultText(e,'删除操作取消');
                            }
                        });
                    }
                }]
            },*/
            {
                xtype:'actioncolumn',
                width:35,
                text:'关闭',
                align: 'center',
                items: [{
                    icon: js_source_path+'/source/js/ExtJS/shared/icons/fam/folder_wrench.png',
                    tooltip: 'Edit',
                    handler: function(grid, rowIndex, colIndex) {
                        var record = store.getAt(rowIndex);
                        var id = record.get('id');
                        openWindow({
                            title:'关闭服务器',
                            width:'550',
                            height:'200',
                            className:'test',
                            src: js_url_path + '/index.php?r=/service/default/closeserver/id/'+id
                        });
                    }
                }]
            }
        ],
        width: 'auto',
        height:'auto',
        bbar: Ext.create('Ext.PagingToolbar', {
            store: store,
            displayInfo: true,
            displayMsg: '第{0}-{1}条(共{2}条)',
            emptyMsg: "<b style='color:red;'>查询结果为空</b>"
        }),
        loadMask: true,
        renderTo: Ext.get('server_list')
    });
}



myMask.hide();
});
</script>
