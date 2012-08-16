<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/source/js/ExtJS/ux/css/CheckHeader.css" />
<div class="list_left" style="float:left;width:350px;">
    <div id="search"></div>
    <div id="daoju_list"></div>
</div>

<div class="list_right" style="float:left;width:600px;">
    <div id="chaxun"></div>
    <div id="libao_list"></div>
</div>

<script type="text/javascript">
<?php
    echo 'var servers ='.json_encode($select).';';
?>

var server_name_id_pairs=  build.array(servers);
Ext.Loader.setConfig({
    enabled: true
});
Ext.Loader.setPath('Ext.ux', js_source_path+'/source/js/ExtJS/ux');
Ext.require([
     'Ext.ux.CheckColumn'
]);
Ext.onReady(function(){
//查询表单
var SearchForm = Ext.widget({
    xtype: 'form',
    frame: true,
    width: 900,
    height:33,
    defaults: {
        anchor: '100%',
        labelWidth: 180
    },
    layout : "column",
    items:[
    {
        xtype: 'combo', //combo
        fieldLabel: '选择服务器',
        allowBlank :false,
        blankText :'服务器选项不能为空',
        labelWidth : 65,
        forceSelection : true,
        editable: false,
        width:300,
        emptyText: '选择服务器...',
        valueField: 'serverId',
        displayField: 'serverName',
        store: new Ext.data.SimpleStore({
            fields: ['serverName','serverId'],
            data: server_name_id_pairs
        }),
        name: 'server',
        value: server_name_id_pairs[0][1],
        listeners: {
			change: function(){
				Ext.get('daoju_list').update('')
			}
        }
    },
    {
        xtype: 'button',
        text: '查询',
        width: 90,
        style: 'margin-left:20px;',
        handler: function() {
            var serverId = SearchForm.getForm().findField('server').getValue();
            if( !serverId ){
                Ext.Msg.alert('提示','请先选择服务器再提交查询请求!');
                return ;
            }
            fetchActivitiesByServerId(serverId);
        }
    }],
});
SearchForm.render('search');

function fetchActivitiesByServerId(serverId, callback) {
    Ext.Ajax.request({
        method: "GET",
        url: js_url_path + '/index.php?r=/service/awardActivity/getActivityByServerId',
        params: {server_id: serverId},
        success: function(options, success, response) {
            drawTable(Ext.JSON.decode(options.responseText).activities);
            if (typeof callback != 'undefined') {
                callback(options.status);
            }
        }
    });
}

function drawTable(data) {
    Ext.get('daoju_list').update('')
    Ext.define('giftModle', {
        extend: 'Ext.data.Model',
        fields: [
            {
                name: 'name',
                type:'string'
            },
            {
                name: 'serverId',
                type: 'string'
            },
            {
                name: 'activityId',
                type: 'string'
            },
            {
                name: 'startTime',
                type: 'string',
                convert : function (value, record) {
                    if (/:/.test(value)) {
                        return value;
                    }
                    return date.format(value,'ISO8601Long');
                }
            },
            {
                name: 'endTime',
                type: 'string',
                convert : function (value, record) {
                    if (/:/.test(value)) {
                        return value;
                    }
                    return date.format(value,'ISO8601Long');
                }
            },
            {
                name: 'isEnable',
                type: 'string',
                convert:function(value,record){
                    return ['关闭','开启'][parseInt(value,10)];
                }
            },
            {
                name: 'duration',
                type: 'string',
                convert: function(v,r){
					if(r.data.isEnable==='关闭'){
						return 259200;//3天
					}else{
						return v;
					}
                }
            },
            {
                name: 'isHot',
                type: 'string',
                convert:function(value,record){
                    return ['否','是'][parseInt(value,10)];
                }
            }
        ]
    });
    var store = Ext.create('Ext.data.Store', {
        model: 'giftModle',
        data:data
    });

    var cellEditing = Ext.create('Ext.grid.plugin.CellEditing', {
        clicksToEdit: 2
    });

    Ext.create('Ext.grid.Panel', {
        store: store,
        plugins: [cellEditing],
        viewConfig  : {
			enableTextSelection:true
        },
        columns: [
            {text: '活动名称', width:85, dataIndex:'name'},
            {text: '活动ID', width:55, dataIndex:'activityId'},
            {text: '服务器', width:105, dataIndex:'serverId'},
            {
                text: '开始日期',
                width:145,
                dataIndex:'startTime',
                editor: {
                    allowBlank: false,
                }
            },
            {
                text: '结束日期',
                width:145,
                dataIndex:'endTime',
                editor: {
                    allowBlank: false,
                }
            },
            {
                text: '领奖期限(单位秒)',
                width:100,
                dataIndex:'duration',
                editor: {
                    allowBlank: false
                }
            },
            {
                text: '状态',
                width:70,
                dataIndex:'isEnable',
                editor: new Ext.form.field.ComboBox({
                    typeAhead: true,
                    triggerAction: 'all',
                    selectOnTab: true,
                    store: [
                        ['1','开启'],
                        ['0','关闭']
                    ]
                })
            },
            {
                header: 'HOT',
                width: 40,
                dataIndex: 'isHot',
                editor: new Ext.form.field.ComboBox({
                    typeAhead: true,
                    triggerAction: 'all',
                    selectOnTab: true,
                    store: [
                        ['0','否'],
                        ['1','是']
                    ]
                })
            },
            {
                xtype: 'actioncolumn',
                width: 40,
                header: '提交',
                items: [{
                    icon: js_source_path + '/source/js/ExtJS/shared/icons/fam/accept.gif',
                    tooltip: 'Delete',
                    handler: function(grid, rowIndex, colIndex) {
                        var _record = store.getAt(rowIndex).data;
                        var server_id = _record.serverId;
                        var serverName = servers[server_id];
                        var handler = _record.isEnable;
                        var activity = _record.name;
                        var startTime = _record.startTime;
                        var endTime = _record.endTime;
                        var conformTips = '您确认要对服务器 <span style="color:red;">' + serverName;
                        conformTips += ' </span>上的活动 <span style="color:red;">'+ activity +' </span>';
                        conformTips += '进行 <span style="color:red;">'+handler+' </span>';
                        conformTips += '操作吗(开始时间:<span style="color:red;">'+startTime+'</span>,结束时间:<span style="color:red;">'+endTime+'</span>)?';
                        Ext.MessageBox.confirm("确认操作", conformTips , function(e){
                            var record = store.getAt(rowIndex);
                            if(e=='yes') {
                                myMask.show();
                                Ext.Ajax.request({
                                    method: 'GET',
                                    url: js_url_path + '/index.php?r=/service/awardActivity/updateActivity',
                                    params: {
                                        activity_id: record.get('activityId'),
                                        server_id: record.get('serverId'),
                                        startTime: record.get('startTime'),
                                        endTime: record.get('endTime'),
                                        duration: record.get('duration'),
                                        isHot: record.get('isHot') == '是' ? 1 : 0,
                                        isEnable: record.get('isEnable') == '开启' ? 1 : 0,
                                    },
                                    success: function (response) {
                                        fetchActivitiesByServerId(record.get('serverId'), function (code) {
                                            myMask.hide();
                                            if (Ext.JSON.decode(response.responseText).ret == 0) {
                                                Ext.Msg.alert('提示', '更新活动成功');
                                            }else{
                                                Ext.Msg.alert('提示', '更新活动失败');
                                            }
                                        });
                                    }
                                }
                                );
                            } else {
                                showResultText(e,'修改操作取消');
                            }
                        });
                    }
                }]
            },
            {
                xtype:'actioncolumn',
                width:60,
                header: '结束活动',
                items: [{
                    icon: js_source_path+'/source/js/ExtJS/shared/icons/fam/application_go.png',
                    tooltip: 'Delete',
                    handler: function(grid, rowIndex, colIndex) {
                        var _record = store.getAt(rowIndex).data;
                        var server_id = _record.serverId;
                        var serverName = servers[server_id];
                        var activity = _record.name;
                        var startTime = _record.startTime;
                        var conformTips = '您确认要对服务器 <span style="color:red;">' + serverName;
                        conformTips += ' </span>上的活动 <span style="color:red;">'+ activity +' </span>';
                        conformTips += '进行 <span style="color:red;">关闭</span>';
                        conformTips += '操作吗(开始时间:<span style="color:red;">'+startTime+'</span>)?';
                        Ext.MessageBox.confirm("确认操作", conformTips , function(e){
                            if(e=='yes') {
                                myMask.show();
                                var record = store.getAt(rowIndex);
                                Ext.Ajax.request({
                                    method: 'GET',
                                    url: js_url_path + '/index.php?r=/service/awardActivity/stopActivity',
                                    params: {
                                        activity_id: record.get('activityId'),
                                        server_id: record.get('serverId')
                                    },
                                    success: function (response) {
                                        fetchActivitiesByServerId(record.get('serverId'), function() {
                                            myMask.hide();
                                            if (Ext.JSON.decode(response.responseText).ret == 0) {
                                                Ext.Msg.alert('提示', '结束活动成功');
                                            }
                                        });
                                    }
                                });
                            } else {
                                showResultText(e,'修改操作取消');
                            }
                        });
                    }
                }]
            }
        ],
        width: 900,
        renderTo: Ext.get('daoju_list')
    });
}
//drawTable(dataCount);
myMask.hide();
});
</script>
