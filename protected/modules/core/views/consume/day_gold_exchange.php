<div id="search"></div>
<div id="dataTable"></div>


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
    height:35,
    layout: 'column',
    items:[
        /*{
            xtype : 'checkbox',
            labelWidth: 85,
            width: 110,
            fieldLabel: '排除测试账号',
            name:''
        },*/
        {
            xtype : 'datefield',
            labelWidth: 55,
            width: 160,
            fieldLabel: '结束日期',
            format: 'Y-m-d',
            name:'endtime',
            style: 'margin-left:15px;',
            editable: false,
            value: date.getPreviouslyTime().yesterday
        },
        /*{
            xtype : 'combo',
            fieldLabel: '',
            labelWidth: 115,
            width: 150,
            emptyText: '请选择要查询的内容...',
            valueField:'value',
            displayField:'name',
            value:'0',
            store:new Ext.data.SimpleStore({
                fields:['name','value'],
                data:[
                    ['全部来源','0'],
                    ['合作代理1','1'],
                    ['合作代理2','2'],
                ]
            }),
            name:'',
            style: 'margin-left:15px;',
            editable: false
        },*/
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
            width: 80,
            style: 'margin-left:15px;',
            handler : function(){
                submit();
            }
        },
    ],
    renderTo: Ext.get('search')
});

function submit(){
    if (!SearchForm.getForm().isValid()) {
        Ext.Msg.alert('提示', '请正确地填写必要数据');
        return ;
    }
    SearchForm.getForm().submit({
      waitMsg: '正在提交数据',
      waitTitle: '提示',
      url: js_url_path+'/index.php?r=/core/consume/daygoldexchange ',
      method: 'POST',
      success: function(form, action) {
          drawTable(action.result.data);
      },
      failure: function(form, action) {
          formCallback.alert( action.result );
      }
    });
}




function drawTable(data){
    Ext.get('dataTable').update('');

    for(var m = 0; m < data.length; m++ ){
        var n1=0,n2=0,d=data[m];
        for( n in d ){
            if( n == 'date' || n == 'server_id' ) continue;
            n1++;
            if( d[n] == '0' || d[n] == '' || d[n] == null ) n2++;
        }
        if( n1 == n2 ){
            for( n in d ){
                if( n == 'date' || n == 'server_id' ) continue;
                data[m][n] = ' ';
            }
        }
    }

    Ext.define('goldModel',{
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
           {
               name: 'cost_day',
               type:'string',
               convert: function( v, r ){
                    if( v == ' ' ) return '';
                    return (-1 * parseInt(v, 10)) || 0;
               }
           },
           {
               name: 'cost_total',
               type:'string',
               convert: function( v, r ){
                   if( v == ' ' ) return '';
                   return (-1 * parseInt(v, 10)) || 0;
               }
           },
           {
               name: 'give_gold',
               type:'string',
               convert: function( v, r ){
                   //屏蔽数据显示
                   //if( v == ' ' ) return '';
                   //return (-1 * parseInt(v, 10)) || 0;
                   return '';
               }
           },
           {
               name: 'total_give_gold',
               type:'string',
               convert: function( v, r ){
                   //屏蔽数据显示
                   //if( v == ' ' ) return '';
                   //return (-1 * parseInt(v, 10)) || 0;
                   return '';
               }
           },
           {
               name: 'total_balance',
               type:'string',
               convert: function( v, r ){
                   return v || 0;
               }
           },
           {
               name: 'balance',
               type:'string',
               convert: function( v, r ){
                   return v || 0;
               }
           }
        ]
    });
    var totalCountStruct = [
    {
        text:'服务器',
        width: 110,
        dataIndex:'server_id'
    },
    {
        text:'兑换金额',
        width: 90,
        dataIndex:'a1'
    },
    {
        text:'赠送金额',
        width: 90,
        dataIndex:'total_give_gold'
    },
    {
        text:'消费金额',
        width: 90,
        dataIndex:'cost_total'
    },
    {
        text:'余额',
        width: 90,
        dataIndex:'total_balance'
    }];

    var dayCountStruct = [
    {
        text:'兑换金额',
        width: 90,
        dataIndex:'a1'
    },
    {
        text:'赠送金额',
        width: 90,
        dataIndex:'give_gold'
    },
    {
        text:'消费金额',
        width: 90,
        dataIndex:'cost_day'
    },
    {
        text:'余额',
        width: 90,
        dataIndex:'balance'
    }];
    var store = Ext.create('Ext.data.Store', {
        model: goldModel,
        data:data
    });
    Ext.create('Ext.grid.Panel', {
        title: '',
        store: store,
        viewConfig  : {
            enableTextSelection:true
        },
        tbar: [{
                    text: '导出数据',
                    handler: function(){
                        var url = js_url_path + '/index.php?r=core/consume/daygoldexchangeexport';
                        var endtime = SearchForm.getForm().findField('endtime').getValue();
                        var server_id = SearchForm.getForm().findField('server_id').getValue();
                        if(!endtime){
                            Ext.MessageBox.alert('提示','请先选择要导出的参数！(时间、服务器)');
                            return ;
						}
                        endtime = date.format(endtime,'ISO8601Short')
                        url += '&endtime='+endtime+'&server_id='+server_id;
                        window.open( url );
                    }
		}],
        frame: true,
        columns: [
            {
                text:'范围',
                columns:[
                    {
                        text:'日期',
                        dataIndex:'date',
                        width: 80
                    }
                ],
            },
            {
                text: '截止到当前日期(总兑换消费金额)',
                columns: totalCountStruct,
            },
            {
                text:'今日新增(今日兑换消费金额)',
                columns: dayCountStruct
            }
        ],
        renderTo: Ext.get('dataTable')
    });
}






myMask.hide();
});
</script>
