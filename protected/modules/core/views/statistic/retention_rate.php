<div id="search"></div>
<div id="dataTable"></div>


<script type="text/javascript">
<?php
    echo 'var server_obj='.json_encode($select).';';
?>
var server_arr    = build.array( server_obj );
Ext.onReady(function(){

//查询表单
var required = '<span style="color:red;font-weight:bold" data-qtip="Required">*</span>';
var SearchForm = Ext.widget({
	xtype: 'form',
	frame: true,
	width: 'auto',
	height:35,
    layout : 'column',
    fieldDefaults: {
        labelAlign: 'left',
        msgTarget: 'side',
        width : 200,
        style : 'margin-left:15px;',
        allowBlank : false,
		blankText:'此项不能为空',
		editable: false
    },
	items:[
		{
            fieldLabel: '选择服务器',
            afterLabelTextTpl: required,
            xtype : 'combo',
			valueField:'value',
			displayField:'name',
            width:300,
            labelWidth: 80,
			store:new Ext.data.SimpleStore({
				fields:['name','value'],
				data : server_arr
			}),
			name:'server_id',
			listeners: {
	            specialkey: {
	                fn: function(field,e) {
                        if(e.getKey() == Ext.EventObject.ENTER){
                            submit();
                        }
	                }
	            }
	        },
            value : server_arr[0][1]
        },
		{
			xtype : 'datefield',
			width:300,
			labelWidth: 60,
			fieldLabel: '开始时间',
			format: 'Y-m-d',
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
		},
		{
			xtype : 'datefield',
			width:300,
			labelWidth: 60,
			fieldLabel: '结束时间',
			format: 'Y-m-d',
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
		},
		{
			xtype : 'button',
            style:'margin-left:20px;',
            text:'查询',
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
		 url: js_url_path+'/index.php?r=/core/statistic/retentionrate ',
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
    var dataStruct1=[];
    for( var i = 0; i<=32;i++){
        if( i == 0 ){
            dataStruct1.push({
                text:'统计日期',
            	width: 80,
            	dataIndex:'date'
            });
        }else if( i == 1 ){
            dataStruct1.push({
                text:'服务器',
            	width: 80,
            	dataIndex:'server_id'
            });
        }else if( i == 2 ){
            dataStruct1.push({
                text:'创建角色数',
            	width: 60,
            	dataIndex:'register'
            });
        }else{
            dataStruct1.push({
                text:i-2,
            	width: 50,
            	dataIndex:(i-3)+''
            });
        }
    }
    var model = [];
    for(i in dataStruct1){
        var d=dataStruct1[i];
        if(/^\d+$/g.test( d.dataIndex )){
            model.push({
                name : d.dataIndex,
                type : 'string',
                convert : function( v,r ){
                    if( v == '0' || v == 0 ){
                        return v;
                    }else{
                        return v + '%';
                    }
                }
            });
        }else{
            if('server_id' == d.dataIndex){
                 model.push({
                    name : d.dataIndex,
                    type : 'string',
                    convert:function(v){
                        return server_obj[v];
                    }
                });
            }else{
                model.push({
                    name : d.dataIndex,
                    type : 'string'
                });
            }
        }
    }
    Ext.define('staticStruct', {
		extend: 'Ext.data.Model',
		fields: model
	});

    var store = Ext.create('Ext.data.Store', {
        model : 'staticStruct',
    	data:data
    });
    Ext.create('Ext.grid.Panel', {
    	title: '',
    	store: store,
    	viewConfig  : {
			enableTextSelection:true
        },
    	frame: true,
    	tbar: [{
			text: '导出数据',
			handler: function(){
                var url = js_url_path+'/index.php?r=core/statistic/retentionrateexport';
                var begintime = SearchForm.getForm().findField('begintime').getValue();
                var endtime = SearchForm.getForm().findField('endtime').getValue();
                var server_id = SearchForm.getForm().findField('server_id').getValue();
                if( !begintime || !endtime || !server_id ){
                    Ext.MessageBox.alert('提示','请先选择要导出的参数！(时间、服务器)');
                    return ;
                }
                begintime = date.format(begintime,'ISO8601Short');
                endtime = date.format(endtime,'ISO8601Short')
                url += '&begintime='+begintime+'&endtime='+endtime+'&server_id='+server_id;
                window.open( url );
            }
		}],
    	columns : dataStruct1,
    	width: 'auto',
    	renderTo: Ext.get('dataTable')
    });
}











myMask.hide();
});
</script>
