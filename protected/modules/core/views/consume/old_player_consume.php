<div id="search"></div>
<div id="dataTable1" style="float:left;width:730px;"></div>
<div id="dataTable2" style="float:left;width:400px;"></div>
<div id="chartPie"></div>

<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/source/js/ExtJS/Multi-column-Legend.js"></script>
<script type="text/javascript">
<?php
    echo 'var server_obj='.json_encode($select).';';
?>
var server_arr    = build.array( server_obj );
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
    height:33,
    defaults: {
        anchor: '100%',
        labelWidth: 180
    },
    layout : "column",
    items:[
        {
            xtype : 'datefield',
            labelWidth: 55,
            columnWidth : .2,
            fieldLabel: '开始日期',
            emptyText: '开始日期...',
            format: 'Y-m-d',
            name:'begintime',
            editable: false,
            value: date.getPreviouslyTime().lastMonth
        },
        {
            xtype : 'datefield',
            labelWidth: 55,
            columnWidth : .2,
            fieldLabel: '截止日期',
            emptyText: '查询截止日期...',
            format: 'Y-m-d',
            name:'endtime',
            editable: false,
            style: 'margin-left:15px;',
            value: date.getPreviouslyTime().yesterday
        },
        {
            xtype : 'combo',
            fieldLabel: '',
            labelWidth: 115,
            columnWidth : .2,
            emptyText: '查询服务器...',
            valueField:'value',
            displayField:'name',
            value : server_arr[0][1],
            store : new Ext.data.SimpleStore({
                fields : ['name','value'],
                data : server_arr
            }),
            name:'server_id',
            forceSelection: true,
            triggerAction : 'all',
            allowBlank : false,
            blankText:'此项不能为空',
            editable: false,
            style: 'margin-left:15px;'
        },
        {
            xtype: 'button',
            text: '查询',
            width: 70,
            style: 'margin-left:15px;',
            handler : function(){
                submit();
            }
        }
    ],
    renderTo : Ext.get('search')
});



function submit(){
	var args = SearchForm.getForm().getValues();
	window.config.server_id = args.server_id;
	Ext.Ajax.request({
		url: js_url_path + '/index.php?r=/core/consume/oldplayerconsume',
		method: 'POST',
		params: args,
		success: function( r ){
			var d = Ext.JSON.decode(r.responseText);
			drawTableList(d);
		},
		error: function(){}
	});
}

function drawTableList( data ){
	var targetDiv = Ext.get('dataTable1');
	targetDiv.update('');

	Ext.define('forbidModel', {
        extend: 'Ext.data.Model',
        fields: [
			{ name: 'date', type:'string' },
			{ 
				name: 'server_id', 
				type:'string',
				convert: function(v){
					return server_obj[v];
				}
			},
			{ name: 'login_day', type:'string' },
			{ name: 'old_player_login', type:'string' },
			{ name: 'pay_role', type:'string' },
			{ name: 'pay_num', type:'string' },
			{ name: 'old_player_pay', type:'string' },
			{ name: 'old_player_num', type:'string' }
		]
    });

	var store = Ext.create('Ext.data.Store', {
		model: forbidModel,
		data:data
	});
	var tableHeaderColumn = [
		{text: '日期', width: 80, dataIndex: 'date'},
		{text: '服务器', width: 120, dataIndex: 'server_id'},
		{text: '今日登陆数', width: 75, dataIndex: 'login_day'},
		{text: '老玩家登录数', width: 90, dataIndex: 'old_player_login'},
		{text: '付费总人数', width: 75, dataIndex: 'pay_role'},
		{text: '付费总金额', width: 75, dataIndex: 'pay_num'},
		{text: '老玩家付费人数', width: 100, dataIndex: 'old_player_pay'},
		{text: '老玩家付费金额', width: 100, dataIndex: 'old_player_num'},
	];
	var grid = Ext.create('Ext.grid.Panel', {
		store: store,
		frame: true,
		columns: tableHeaderColumn,
		width: 'auto',
		tbar: [{
			text: '导出数据',
			handler: function(){
				return;
                var url = js_url_path+'/index.php?r=core/player/dayonlineexport';
                var args = SearchForm.getForm().getValues();
                var tmp = [];
                for(var i in args ){
					tmp.push( i+'='+args[i]);
	            }
                url += '&' + tmp.join('&');
                window.open( url );
            }
		}],
		renderTo: targetDiv
	});

	grid.addListener('cellclick', cellclick);
	function cellclick(grid, rowIndex, columnIndex, e) {
		if( window.config.ajaxIsLoading ){
			return ;
		}
		var date = e.data.date,
			server_id = window.config.server_id;
			window.config.date = date;
		drawTablePlayer(date);		
    }
}


function drawTablePlayer( date ){
	var targetDiv = Ext.get('dataTable2');
	
	window.config.ajaxIsLoading = true;
	Ext.define('forbidModel', {
        extend: 'Ext.data.Model',
        fields: [
		{ 
			name: 'role_name', 
			type:'string',
			convert: function(v){
				var server_id = window.config.server_id,
					role_name = v,
					url = js_url_path+'/index.php?r=/realtime/default/playerinfo';
					url += '&server_id='+server_id;
					url += '&search_type=2&role_name='+role_name;
				return '<a href="'+url+'" target="_blank;">'+role_name+'</a>'
			}
		}
		]
	});

	myMask.show();
	var currentPage = page.get() || 1;
	currentPage = parseInt( currentPage,10 );
	var startpage = (currentPage-1) * window.config.$page;
	var store = Ext.create('Ext.data.Store', {
		model: 'forbidModel',
		proxy: {
			type: 'ajax',
			url: js_url_path+'/index.php?r=/core/consume/oldplayerlist',
			extraParams: {
				begintime : date,
				server_id: window.config.server_id
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
		window.config.ajaxIsLoading = false;
		myMask.hide();
		startDraw();
	});
	

	function startDraw(){
		targetDiv.update('');
		var tableHeaderColumn = [
			{text: '角色名', width: 100, dataIndex: 'role_name'},
		];
		var grid = Ext.create('Ext.grid.Panel', {
			store: store,
			title: '老玩家详细角色列表['+window.config.date+']',
			frame: true,
			columns: tableHeaderColumn,
			width: 'auto',
			bbar: Ext.create('Ext.PagingToolbar', {
				store: store,
				displayInfo: true,
				displayMsg: '第{0}-{1}条(共{2}条)',
				emptyMsg: "<b style='color:red;'>查询结果为空</b>"
			}),
			renderTo: targetDiv
		});
	}
	


}

myMask.hide();
});
</script>
