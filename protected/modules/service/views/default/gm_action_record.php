<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/source/js/ExtJS/ux/css/CheckHeader.css" />
<div id="forbidForm"></div>
<div id="forbidlist"></div>



<script type="text/javascript">
<?php
    echo "var servers=".json_encode($select).";";
?>

//servers = build.array( servers );

Ext.Loader.setConfig({enabled: true});
Ext.Loader.setPath('Ext.ux', js_source_path+'/source/js/ExtJS/ux/');
Ext.require([
    'Ext.ux.PreviewPlugin',
    'Ext.ux.CheckColumn'
]);



Ext.onReady(function(){


var MyForbidForm = Ext.widget({
    xtype: 'form',
    frame: true,
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
            fieldLabel: '开始时间',
            labelWidth: 56,
            width :  200,
            name: 'begin_time',
            format: 'Y-m-d',
            editable:false,
            blankText:'此项不能为空',
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
            fieldLabel: '结束时间',
            labelWidth: 56,
            width :  200,
            name: 'end_time',
            format: 'Y-m-d',
            editable:false,
            blankText:'此项不能为空',
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
            xtype : 'combo',
            width : 80,
            editable: false,
            displayField:'name',
            valueField:'value',
            value:'2',
            store:new Ext.data.SimpleStore({
                fields:['name','value'],
                data:[['账号名','1'],['角色名','2']]
            }),
            name:'search_type'
        },
        {
            xtype: 'textfield',
            labelWidth: 44,
            width :  200,
            name: 'search_name',
            listeners: {
                specialkey: {
                    fn: function(field,e) {
                        if(e.getKey() == Ext.EventObject.ENTER){
                            submit();
                        }
                    }
                }
            }
        },
        {
            xtype: 'combo',
            name: 'type',
            value: 0 ,
            width :  120,
            editable: false,
            valueField:'value',
            displayField:'name',
            store:new Ext.data.SimpleStore({
                fields:['name','value'],
                data:[
						['全部',0],
						['封号','3,4'],
						['禁言','1,2']
					]
            }),
            listeners: {
                specialkey: {
                    fn: function(field,e) {
                        if(e.getKey() == Ext.EventObject.ENTER){
                            submit();
                        }
                    }
                }
            }
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
    renderTo : Ext.get('forbidForm')
});

function submit(){
    if (!MyForbidForm.getForm().isValid()) return;
    var begin_time = MyForbidForm.getForm().findField('begin_time').getValue();
    var end_time = MyForbidForm.getForm().findField('end_time').getValue();
    var search_name = MyForbidForm.getForm().findField('search_name').getValue();
    var type = MyForbidForm.getForm().findField('type').getValue();
    var search_type = MyForbidForm.getForm().findField('search_type').getValue();
    begin_time = date.format(begin_time,'ISO8601Short');
    end_time = date.format(end_time,'ISO8601Short')
    drawTable( {
        begin_time: begin_time,
        end_time: end_time,
        search_name: search_name,
        type: type,
        search_type: search_type
    });
}

function drawTable( options ) {

    Ext.define('forbidModel', {
        extend: 'Ext.data.Model',
        fields: [
            {name: 'comment', type:'string'},
            {name: 'id', type:'string'},
            {name: 'operator', type:'string'},
            {name: 'role_id', type:'string'},
            {name: 'role_name', type:'string'},
            {name: 'seconds', type:'int'},
            {
                name: 'server_id',
                type:'string',
                convert: function( v, r ){
                    return servers[v];
                }
            },
            {name: 'type', type:'int'},//允许聊天 1 禁止聊天 2  允许登陆 3 禁止登陆4
            {
                name: 'begin_time',
                type:'string',
                convert: function( v, r ){
					return v;
                    //return date.format(v,'ISO8601Long');
                }
            },
            {
                name: 'endtime',
                type:'string',
                convert: function( v, r ){
                    var begin = new Date( r.data.begin_time ).valueOf();
                    var remain = r.data.seconds;
                    var end = begin + remain*1000;
                    return date.format( end,'ISO8601Long');
                }
            },
            {
                name: 'status',
                type:'string',
                convert: function( v, r ){
                    if( r.data.seconds == 0 ){
                        return '正常' +　'(' + (r.data.type == 3 ? '解封号' : '解禁言') + ')';
                    }else{
                        var endtime = new Date( r.data.endtime ).valueOf();;
                        var now = new Date().valueOf();
                        if( endtime > now ){
                            if( r.data.type == 4 ) return '封号中';
                            else if( r.data.type == 2 ) return '禁言中';
                        }else{
                            if( r.data.type == 4 ) return '已封号';
                            else if( r.data.type == 2 ) return '已禁言';
                        }
                    }
                }
            },
            {
                name: 'handler',
                type:'string',
                convert: function( v, r ){
                    var endtime = new Date( r.data.endtime ).valueOf();;
                    var now = new Date().valueOf();
                    if( r.data.seconds != '0' && endtime > now ){
                        if( r.data.type == 4 ){
                            return '解封号';
                        }else if(r.data.type == 2 ){
                            return '解禁言';
                        }
                    }
                    return '';
                }
            },
            {name: 'user_account', type:'string'}
        ]
    });


	var currentPage = page.get() || 1;
	//解决翻页按钮状态错误bug,c_page = parseInt( c_page );
	currentPage = parseInt( currentPage,10 );
	var startpage = (currentPage-1) * window.config.$page;
    var store = Ext.create('Ext.data.Store', {
        model: 'forbidModel',
        proxy: {
            type: 'ajax',
            url: js_url_path + '/index.php?r=/service/default/showgmactionrecord',
            extraParams: options,
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
        Ext.getDom('forbidlist').innerHTML = '';
        var cellEditing = Ext.create('Ext.grid.plugin.CellEditing', {
            clicksToEdit: 2
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
            plugins: [cellEditing],
            columns: [
      			{text: '账号名', width:250, dataIndex:'user_account'},
      			{text: '服务器', width:120, dataIndex:'server_id'},
      			{text: '角色名', width:80, dataIndex:'role_name'},
                        {text: '角色ID',  width:60,dataIndex:'role_id'},
      			{
      				text: '开始时间',
      				width:150,
      				dataIndex:'begin_time'
      			},
      			{
      				text: '结束时间',
      				width:150,
      				dataIndex:'endtime'
      			},
      			{
      				text: '禁封时间(秒)',
      				width:100,
      				dataIndex:'seconds'
      			},
      			{
      				text: '禁封状态',
      				width:100,
      				dataIndex:'status'
      			},
      			{
      				text: '操作人',
      				width:60,
      				dataIndex:'operator'
      			},
      			{
      				text: 'GM备注',
      				width:130,
      				dataIndex:'comment',
      				editor: {
    	                allowBlank: true
    	            }
      			},
      			{
      				text: '操作',
      				width:80,
      				dataIndex:'handler',
      				listeners: {
	                   click: {
          	               fn: function(a,b,rowIndex, colIndex) {
            	               var record = store.getAt(rowIndex);
                               var server_id,server_name = record.get('server_id');
                               for( i in servers ){
                                    if( servers[i] === server_name ){
                                        server_id = i;
                                        break;
                                    }
                               }
                               var options = {
    	                           type: record.get('type'),
    	                           args: {
    	                               server_id: server_id,
        	                           role_name: record.get('role_name'),
        	                           role_id: record.get('role_id'),
        	                           user_account: record.get('user_account'),
        	                           comment: record.get('comment')
                                   }
    	                       };
                               excuteRelieve( options );
          	               }
      	               }
      	            }
      			}
            ],
            width: 'auto',
            renderTo: Ext.get('forbidlist')
        });
    }
}
////允许聊天 1 禁止聊天 2  允许登陆 3 禁止登陆4
function excuteRelieve( options ){
    if( options.type == 1 || options.type == 3 ) return ;
    var request_url, handler;
    if( options.type == 2 ){
        handler = '解禁言';
        request_url = js_url_path + '/index.php?r=/service/default/permitchat';
    }else if( options.type == 4 ){
        handler = '解封号';
        request_url = js_url_path + '/index.php?r=/service/default/permitlogin';
	}else{
        return ;
    }
    Ext.MessageBox.confirm("确认操作","你确定要对 <strong style='color:red;'>" + options.args.role_name + "</strong> 进行<strong style='color:red;'>" + handler + "</strong>操作吗？",function(e){
        if(e=='yes'){
            myMask.show();
            Ext.Ajax.timeout = 5000;
            Ext.Ajax.request({
                url: request_url,
                method:'POST',
                params: options.args,
                success: function(response){
                    myMask.hide();
                    var json = Ext.JSON.decode(response.responseText);
                    Ext.MessageBox.alert("操作提示", json.text);
                }
            });
        }else{
            showResultText(e,handler + ' 操作取消');
        }
    });
}



myMask.hide();

});
</script>
