<div id="search-player"></div>
<div id="loglist"></div>


<script type="text/javascript">
<?php
    echo 'var server_obj='.json_encode($select).';';
?>
var server_arr    = build.array( server_obj );

Ext.Loader.setConfig({enabled: true});
Ext.Loader.setPath('Ext.ux', js_source_path+'/source/js/ExtJS/ux/');
Ext.require([
    'Ext.ux.PreviewPlugin',
]);
Ext.onReady(function(){


var logForm = Ext.widget({
    xtype: 'form',
    id: 'simpleForm',
    frame: true,
    title: '',
    width: 'auto',
    height:35,
    fieldDefaults: {
        labelAlign: 'left',
        msgTarget: 'side',
        width : 200,
        style : 'margin-left:15px;'
    },
    layout : 'column',
    items:[
		{
			xtype : 'datefield',
		    fieldLabel: '结束时间',
		    labelWidth: 55,
            width: 160,
		    name: 'endtime',
		    format: 'Y-m-d',
            editable:false,
            allowBlank : false,
            blankText:'此项不能为空',
            listeners: {
	            specialkey: {
	                fn: function(field,e) {
                        if(e.getKey() == Ext.EventObject.ENTER){
                            //submit();
                        }
	                }
	            }
	        },
            value : date.format(new Date(),'ISO8601Short' )
		},
		/*{
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
        },*/
		{
			xtype : 'button',
            style:'margin-left:20px;',
            text:'查询',
            handler : function(){
                submit();
        	}
		}
    ],
    renderTo : Ext.get('search-player')
});



submit();

function submit(){
    //if (!logForm.getForm().isValid()) return;
    var args = logForm.getForm().getValues();
    myMask.show();
    Ext.Ajax.request({
        url: js_url_path + '/index.php?r=/core/default/index',
        method: 'POST',
        params: args,
        success: function(response){
            myMask.hide();
            var json = Ext.JSON.decode(response.responseText);
            //console.log( json );
            drawTable( json );
        },
        error: function(){
            myMask.hide();
        }
    });
}




function drawTable( dataFromServer ){
	Ext.getDom('loglist').innerHTML = '';

	Ext.define('LogDataStruct', {
		extend: 'Ext.data.Model',
		fields: [
            {name: 'server_id', type:'string'},
            {name: 'name', type: 'string'},
            {name: 'create_time', type: 'string'},
            {name: 'online', type: 'string'},
            {name: 'current_installation', type: 'string'},
            {name: 'total_installation', type: 'string'},
            {name: 'current_role', type: 'string'},
            {name: 'total_role', type: 'string'},
            {name: 'current_cost', type: 'string'},
            {name: 'month_cost', type: 'string'},
            {name: 'total_cost', type: 'string'},
            {name: 'total_balance', type: 'string'},
            {name: 'current_num_of_pay', type: 'string'},
            {name: 'num_of_pay', type: 'string'},
		]
	});

    var store = Ext.create('Ext.data.JsonStore', {
        model: LogDataStruct,
        data: dataFromServer
    });


	initLogList();

	function initLogList(){
		Ext.create('Ext.grid.Panel', {
			store: store,
			viewConfig  : {
				enableTextSelection:true
        	},
			tbar: [{
				text: '导出数据',
				handler: function(){
                    var url = js_url_path+'/index.php?r=core/default/export';
                    /*var begintime = logForm.getForm().findField('begintime').getValue();
                    if( !begintime ){
                        Ext.MessageBox.alert('提示','请先选择开始时间!');
                        return ;
                    }
                    begintime = date.format(begintime,'ISO8601Short')
                    url += '&begintime='+begintime;*/
                    window.open( url );
                }
			}],
			loadMask: true,
			columns: [
                /*{text: '服务器名称', width:'auto',dataIndex:'sname'},
                {text: '开服时间', width:120, dataIndex:'create_time'},
                {text: '实时在线人数', width:90, dataIndex:''},
                {text: '今日登录数(DAU)',width:110,  dataIndex:'login_num'},
                {text: '累计注册账号数',width:110,  dataIndex:'register_num'},
                {text: '累计创建角色数',width:110,  dataIndex:''},
                {text: '累计消费人数',width:90,  dataIndex:''},
                {text: '今日注册账号数',width:110,  dataIndex:''},
                {text: '今日创建角色数',width:110,  dataIndex:'register_day_num'},
                {text: '今日消费人数',width:90,  dataIndex:''},
                {text: '今日消费金额',width:90,  dataIndex:''},
                {text: '累计消费金额',width:90,  dataIndex:''},
                {text: '累计金额',width:70,  dataIndex:''},
                {text: '开服天数', width:70, dataIndex:'open_days'}*/

                /*{text: '今日充值人数',width:70,  dataIndex:''},
                {text: '今日充值累计',width:70,  dataIndex:''},
                {text: '本月充值累计',width:70,  dataIndex:''},
                {text: '截止累计充值',width:70,  dataIndex:''},
                {text: '本次刷新时间',width:70,  dataIndex:''}*/

                {text: '服务器名称', width: 120, dataIndex: 'name'},
                {text: '开服时间', width: 140, dataIndex: 'create_time'},
                {text: '在线', width: 60,  dataIndex: 'online'},
                {text: '日安装', width: 70, dataIndex: 'current_installation'},
                {text: '总安装', width: 70, dataIndex: 'total_installation'},
                {text: '日创建角色', width: 80, dataIndex: 'current_role'},
                {text: '总创建角色', width: 80, dataIndex: 'total_role'},
                {text: '日消费', width: 70, dataIndex: 'current_cost'},
                {text: '月消费', width: 70, dataIndex: 'month_cost'},
                {text: '总消费', width: 70, dataIndex: 'total_cost'},
                {text: '余额', width: 70, dataIndex: 'total_balance'},
                {text: '日消费人数', width: 90, dataIndex: 'current_num_of_pay'},
                {text: '总消费人数', width: 70, dataIndex: 'num_of_pay'}

			],
			width: 'auto',
			renderTo: Ext.get('loglist')
		});
	}



}




myMask.hide();

});
</script>
