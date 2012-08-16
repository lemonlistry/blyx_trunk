<script type="text/javascript">
<?php
    echo "var roles = '".json_encode($roles) . "';";
    echo "var data = ".json_encode($list).";"
?>
role_arr = Ext.JSON.decode(roles);
Ext.onReady(function(){

function drawTable( data ){
	Ext.define('serverStruct', {
		extend: 'Ext.data.Model',
		fields: [
			{name: 'id', type:'string'},
			{name: 'username', type: 'string'},
			{
                name: 'role_id',
                type: 'string',
                convert: function (value, record) {
                    return role_arr[value];
                }
            },
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
			url: js_url_path+'/index.php?r=/passport/user/userlist',
			reader: {
				root: 'dataList',
				totalProperty: 'dataCount'
			},
		},
		pageSize : window.config.$page,
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
		bbar: Ext.create('Ext.PagingToolbar', {
			store: store,
			displayInfo: true,
			displayMsg: '第{0}-{1}条(共{2}条)',
			emptyMsg: "<b style='color:red;'>查询结果为空</b>"
		}),
		loadMask: true,
		columns: [
			{text: '序号', width:100,dataIndex:'id'},
			{text: '名称', width:150, dataIndex:'username'},
			{text: '角色', width:150, dataIndex:'role_id'},
			{text: '创建时间', width:150, dataIndex:'create_time'},
			{
				xtype:'actioncolumn',
				width:70,
				text:'修改|删除',
				align: 'center',
				items: [{
					icon: js_source_path+'/source/js/ExtJS/shared/icons/fam/cog_edit.png',  // Use a URL in the icon config
					tooltip: 'Edit',
					handler: function(grid, rowIndex, colIndex) {
						var record = store.getAt(rowIndex);
                        var id = record.get('id');
						openWindow({
							title:'编辑用户信息',
							width:'515',
							height:'190',
							className:'test',
							src:js_url_path+'/index.php?r=/passport/user/updateuser/id/'+id
						});
					}
				},{
					icon: js_source_path+'/source/js/ExtJS/shared/icons/fam/delete.gif',
					tooltip: 'Delete',
					handler: function(grid, rowIndex, colIndex) {
					    ajaxCallBack.alert({
			                params : {
                                id : store.getAt(rowIndex).get('id')
                            },
                            url : js_url_path+'/index.php?r=/passport/user/deleteuser'
                        });
					}
				}]
			}
		],
		width: 'auto',
		renderTo: Ext.getBody()
	});
}
drawTable(data);
myMask.hide();
});
</script>
<?php
    echo Html5::link('添加用户', array('/passport/user/adduser'), array(
	'class' => 'js-dialog-link js-link-btn',
        'data-height'=>'190',
        'data-width'=>'515'
    ));
?>
