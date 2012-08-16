<?php
    echo Html5::link('添加资源', array('/passport/resource/addresource'), array(
        'class' => 'js-dialog-link js-link-btn',
        'data-height'=>'190',
        'data-width'=>'515'
    ));
?>
<div id="resourcelist"></div>
<script type="text/javascript">
Ext.Loader.setConfig({enabled: true});
Ext.Loader.setPath('Ext.ux', js_source_path + '/source/js/ExtJS/ux/');
Ext.require([
    'Ext.ux.PreviewPlugin'
]);

Ext.onReady(function(){

drawTable();
    
function drawTable( start, end, operator ) {
	start = start || '';
	end = end || '';
	operator = operator || '';
	currentPage = currentPage || 1;
	Ext.getDom('resourcelist').innerHTML = '';

	Ext.define('LogDataStruct', {
		extend: 'Ext.data.Model',
		fields: [
			{name: 'id', type:'string'},
			{name: 'name', type: 'string'},
			{name: 'tag', type: 'string'},
			{name: 'desc', type: 'string'},
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
			url: js_url_path + '/index.php?r=/passport/resource/resourcelist',
			extraParams: {
				begintime : start,
				endtime : end,
				operator : operator
			},
			reader: {
				root: 'dataList',
				totalProperty: 'dataCount'
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
		page.set( store.currentPage );
		initLogList();
	});	

	function initLogList(){
		Ext.get('resourcelist').update('');
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
				{text: '编号',  width:40,dataIndex:'id'},
				{text: '资源名称',  width:180,dataIndex:'name'},
				{text: '标签',  width:150,dataIndex:'tag'},
				{text: '资源描述', width:180, dataIndex:'desc'},
				{text: '创建时间',width:'150px',  dataIndex:'create_time'},
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
								title:'编辑资源信息',
								width:'515',
								height:'190',
								className:'test',
								src:js_url_path+'/index.php?r=/passport/resource/updateresource/id/'+id
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
	                            url : js_url_path+'/index.php?r=/passport/resource/deleteresource/'
	                        });
						}
					}]
				}
			],
			width: 900,
			renderTo: Ext.get('resourcelist')
		});
	}



}



myMask.hide();

});
</script>
