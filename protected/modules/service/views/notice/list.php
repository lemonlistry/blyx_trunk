<div id="search"></div>
<div id="costCount"></div>


<script type="text/javascript">
<?php
    echo "var servers=".json_encode($servers).";";
?>

servers = build.array( servers );

Ext.onReady(function(){


//查询表单
var SearchForm = Ext.widget({
    xtype: 'form',
    frame: true,
    width: 'auto',
    bodyPadding: '0 0 0 5',
    height: 35,
    fieldDefaults: {
        msgTarget: 'side',
        labelWidth: 52
    },
    defaultType: 'textfield',
    layout : "column",
    items:[
        {
            xtype : 'textfield',
            labelWidth: 140,
            width : 450 ,
            fieldLabel: '请输入公告内容包含文字',
            name:'content',
            listeners: {
                specialkey: {
                    fn: function(field,e) {
                        if(e.getKey() == Ext.EventObject.ENTER){
                            submit();
                        }
                    }
                }
            },
        },
        {
            xtype : 'combo',
            fieldLabel: '',
            labelWidth: 115,
            width : 150 ,
            valueField:'value',
            displayField:'name',
            style : 'margin-left:15px;',
            emptyText : '请选择服务器',
            store:new Ext.data.SimpleStore({
                fields:['name','value'],
                data:servers
            }),
            value: servers[0][1],
            name:'server_id',
            triggerAction : 'all',
            editable: false,
            listeners: {
                specialkey: {
                    fn: function(field,e) {
                        if(e.getKey() == Ext.EventObject.ENTER){
                            submit();
                        }
                    }
                }
            },
        },
        {
            xtype : 'button',
            text : '查询',
            style : 'margin-left:15px;',
            width : 60,
            handler : function(){
                submit();
            }
        },
        {
            xtype : 'button',
            text : '新建公告',
            style : 'margin-left:15px;',
            width : 60,
            handler : function(){
                openWindow({
                    width:515,
                    height:290,
                    title:'',
                    src:js_url_path + '/index.php?r=service/notice/addnotice'
                });
            }
        }
    ],
    renderTo : Ext.get('search')
});

function submit(){
    var content = SearchForm.getForm().findField('content').getValue();
    var server = SearchForm.getForm().findField('server_id').getValue();
    if( !content && !server ){
        Ext.Msg.alert('提示','请输入搜索条件再试');
        return ;
    }
    drawTable(content,server);
}





function drawTable( content,server ){
    content = content || '';
    server = server || '';
    Ext.getDom('costCount').innerHTML = '';

    Ext.define('NoticeDataStruct', {
        extend: 'Ext.data.Model',
        fields: [
            {name: 'id', type:'string'},
            {name: 'sname', type: 'string'},
            {name: 'interval_time', type: 'string'},
            {name: 'content', type: 'string'},
            {
                name: 'begin_time',
                type: 'string',
                convert: function (value, record) {
                    if(null == value){
                        return '';
                    }
                    return date.format(value,'ISO8601Long');
                }
            },
            {
                name: 'end_time',
                type: 'string',
                convert: function (value, record) {
                    if(null == value){
                        return '';
                    }
                    return date.format(value,'ISO8601Long');
                }
            },
            {
                name: 'send_time',
                type: 'string',
                convert: function (value, record) {
                    if(0 == value){
                        return '';
                    }
                    return date.format(value,'ISO8601Long');
                }
            },
            {
                name: 'create_time',
                type: 'string',
                convert: function (value, record) {
                    return date.format(value,'ISO8601Long');
                }
            },
            {name: 'status', type: 'string'},
            {name: 'tran_status', type: 'string'}
        ]
    });


    var currentPage = page.get() || 1;
    //解决翻页按钮状态错误bug,c_page = parseInt( c_page );
    currentPage = parseInt( currentPage,10 );
    var startpage = (currentPage-1) * window.config.$page;
    var store = Ext.create('Ext.data.Store', {
        model: 'NoticeDataStruct',
        proxy: {
            type: 'ajax',
            url: js_url_path+'/index.php?r=/service/notice/list',
            extraParams: {
                content : content,
                server_id : server,
            },
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
        bbar: Ext.create('Ext.PagingToolbar', {
            store: store,
            displayInfo: true,
            displayMsg: '第{0}-{1}条(共{2}条)',
            emptyMsg: "<b style='color:red;'>查询结果为空</b>",
        }),
        columns: [
            {text: '编号', width:40,dataIndex:'id'},
            {text: '服务器', width:120, dataIndex:'sname'},
            {text: '时间间隔', width:80, dataIndex:'interval_time'},
            {text: '内容', width:190, dataIndex:'content'},
            {text: '开始时间',width:140,  dataIndex:'begin_time'},
            {text: '结束时间',width:140,  dataIndex:'end_time'},
            {text: '发送时间',width:140,  dataIndex:'send_time'},
            {text: '创建时间', width:140, dataIndex:'create_time'},
            {text: '状态', width:60, dataIndex:'tran_status'},
            {
                xtype:'actioncolumn',
                width:35,
                text:'删除',
                items: [{
                    icon: js_source_path + '/source/js/ExtJS/shared/icons/fam/delete.gif',
                    tooltip: 'Delete',
                    handler: function(grid, rowIndex, colIndex) {
                        var _id = store.getAt(rowIndex).get('id');
                        var url = js_url_path+'/index.php?r=/service/notice/deletenotice';
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
        renderTo: Ext.get('costCount')
    });
}


drawTable();
myMask.hide();


});
</script>
