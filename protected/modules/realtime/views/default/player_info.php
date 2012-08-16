<style type='text/css'>
.result_list_1{
    height:270px;
    width:240px;
    float:left;
}
.result_list_1 h5{
    float:left;
    width:30px;
    padding:10px;
    height:270px;
    background:#ABABAB;
}
.result_list_1 h5 p{
    margin-top:60px;
}
.result_list_1 ul{
    float:left;
    width:200px;
    height:100%;
}
.result_list_1 ul li{
    line-height:30px;
    width:200px;
    float:left;
    background:#DFDFDF;
}
.result_list_1 ul li:nth-child(even){
    background:#DFDFDF;
}
.result_list_1 ul li:nth-child(odd){
    background:#CDCDCD;
}
.result_list_1 ul li span:nth-child(1){
    width:80px;
    float:left;
    margin-right:10px;
    text-align:right;
}
#friends-info ul li{
    float:left;
    padding:5px;
}
</style>

<div id="search-player"></div>
<div id="playerlist"></div>
<div id="playerinfos"></div>
<div id="tabs1">
    <div id="status-info" class="x-hide-display">
        <div class="result_list_1">
            <h5><p>角色信息栏</p></h5>
            <ul>
                <li><span>角色名:</span><span id="role_name"></span></li>
                <li><span>等级:</span><span id="role_level"></span></li>
                <li><span>当前经验:</span><span id="experience"></span></li>
                <li><span>声望:</span><span id="role_reputation"></span></li>
                <li><span>称号:</span><span id="chenghao"></span></li>
                <li><span>职业:</span><span id="zhiye"></span></li>
                <li><span>门派:</span><span id="menpai"></span></li>
                <!-- <li><span>属性:</span><span id="shuxing"></span></li> -->
                <li><span>武学:</span><span id="wuxue"></span></li>
                <li><span>帮派:</span><span id="bangpai"></span></li>
            </ul>
        </div>
        <div class="result_list_1">
            <h5><p>角色状态栏</p></h5>
            <ul>
                <li><span>生命:</span><span id="hp"></span></li>
                <li><span>筋骨:</span><span id="muscle"></span></li>
                <li><span>心法:</span><span id="spirit"></span></li>
                <li><span>悟性:</span><span id="aptitude"></span></li>
                <li><span>精力:</span><span id="vitality"></span></li>
                <li><span>礼金:</span><span id="gift"></span></li>
                <li><span>银两:</span><span id="silver"></span></li>
                <li><span>黄金:</span><span id="gold"></span></li>
                <li><span>修为:</span><span id="energy"></span></li>
            </ul>
        </div>
        <div class="result_list_1">
            <h5><p>角色装备栏</p></h5>
            <ul>
                <li><span>武器:</span><span id="equip0"></span></li>
                <li><span>披风:</span><span id="equip4"></span></li>
                <li><span>项链:</span><span id="equip5"></span></li>
                <li><span>头盔:</span><span id="equip1"></span></li>
                <li><span>衣服:</span><span id="equip2"></span></li>
                <li><span>靴子:</span><span id="equip3"></span></li>
                <li><span>所在地图:</span><span id="map"></span></li>
                <li><span>地图坐标:</span><span id="where"></span></li>
                <li><span>战斗值:</span><span id="role_fightpower"></span></li>
            </ul>
        </div>
        <div class="result_list_1">
            <h5><p>角色特殊栏</p></h5>
            <ul>
                <li><span>秘籍1:</span><span id="book0"></span></li>
                <li><span>秘籍2:</span><span id="book1"></span></li>
                <li><span>秘籍3:</span><span id="book2"></span></li>
                <li><span>秘籍4:</span><span id="book3"></span></li>
                <li><span>秘籍5:</span><span id="book4"></span></li>
                <li><span>秘籍6:</span><span id="book5"></span></li>
                <li><span>秘籍7:</span><span id="book6"></span></li>
                <li><span>秘籍8:</span><span id="book7"></span></li>
                <li><span>学识:</span><span id="know"></span></li>
            </ul>
        </div>
    </div>
    <div id="bags-info" class="x-hide-display">稍后就来...</div>
    <div id="tasks-info" class="x-hide-display">稍后就来...</div>
    <div id="miji-info" class="x-hide-display">稍后就来...</div>
    <div id="friends-info" class="x-hide-display">
    </div>
    <div id="jinmai-info" class="x-hide-display">稍后就来...</div>
    <div id="zhuanbei-info" class="x-hide-display">稍后就来...</div>
    <div id="xiaofei-info" class="x-hide-display">稍后就来...</div>
    <div id="gifts-info" class="x-hide-display">稍后就来...</div>
    <div id="duofu-info">
        <div id="duofu_form"></div>
        <div id="duofu_info"></div>
    </div>
</div>
<div id="handle-bottom3"></div>


<script type="text/javascript">
<?php
    echo 'var server_obj='.json_encode($select).';';
?>
var server_arr=  build.array(server_obj);



window.TAB = document.getElementById('tabs1').innerHTML;
Ext.require('Ext.tab.*');
Ext.onReady(function(){

/*
//多服查询表单
function initDuoFu(){
    var duofu_form = Ext.widget({
        xtype: 'form',
        frame: true,
        width: 'auto',
        height:35,
        fieldDefaults: {
            labelWidth: 70,
        },
        layout : "column",
        items:[
            {
                xtype : 'datefield',
                columnWidth : .3,
                fieldLabel: '开始时间',
                emptyText: '开始时间...',
                format: 'Y-m-d',
                name:''
            },
            {
                xtype : 'datefield',
                columnWidth : .3,
                fieldLabel: '截止时间',
                emptyText: '截止时间...',
                format: 'Y-m-d',
                name:''
            },
            {
                xtype : 'combo',
                fieldLabel: '',
                columnWidth : .2,
                emptyText: '',
                valueField:'value',
                displayField:'name',
                store:new Ext.data.SimpleStore({
                    fields:['name','value'],
                    data:server_arr
                }),
                name:'',
            },
        ],
        buttons: [{
            text: '查询'
        },{
            text: '导出Excel'
        }]
    });
    duofu_form.render('duofu_form');
    //多服信息列表
    (function(){
        function drawTable( data ){
            var store = Ext.create('Ext.data.Store', {
                fields:['a1', 'a2','a3','a4','a5','a6'],
                data:data
            });

            Ext.create('Ext.grid.Panel', {
                title: '',
                store: store,
                columns: [
                    {text: '日期', width:120, dataIndex:'a2'},
                    {text: '服务器', width:120, dataIndex:'a2'},
                    {text: '角色ID', width:130, dataIndex:'a2'},
                    {text: '角色名', width:130, dataIndex:'a2'},
                    {text: '等级', width:100, dataIndex:'a2'},
                    {text: '充值时间', width:120, dataIndex:'a2'},
                    {text: '黄金', width:120, dataIndex:'a2'},
                    {text: '订单号', width:120, dataIndex:'a2'},
                ],
                width: 980,
                renderTo: Ext.get('duofu_info')
            });
        }
        var dataCount = [
                     {
                         'a1':'',
                         'a2':'',
                         'a3':'',
                         'a6':'',
                     }
        ];
        for(var j=1;j<=11;j++){
            var a=(function( a,b ){
                return {
                    'a1':'','a2':'','a3':'',
                    'a6':'',
                };
            })(dataCount[0],j);
            dataCount.push(a);
        }
        drawTable(dataCount);
    })();
}*/


var simple_info = Ext.widget({
    xtype: 'form',
    id: 'simpleForm',
    frame: true,
    width: 'auto',
    height:35,
    fieldDefaults: {
        msgTarget: 'side',
        labelWidth: 52,
        style : 'margin-left:15px;',
        allowBlank:false,
        blankText:'选项不能为空',
    },
    defaultType: 'textfield',
    layout : "column",
    items:[
        {
            xtype : 'combo',
            fieldLabel: '选择服务器',
            labelWidth: 65,
            editable: false,
            width : 230,
            valueField:'value',
            displayField:'name',
            store:new Ext.data.SimpleStore({
                fields:['name','value'],
                data:server_arr
            }),
            value: server_arr[0][1],
            name:'server_id'
        },
        {
            xtype : 'combo',
            width : 120,
            editable: false,
            displayField:'name',
            valueField:'value',
            value:2,
            store:new Ext.data.SimpleStore({
                fields:['name','value'],
                data:[['账号名',1],['角色名',2]],
            }),
            name:'search_type'
        },
        {
            xtype: 'textfield',
            value : '',
            labelWidth: 115,
            allowBlank : false,
            blankText:'账号名/角色名不能为空',
            width : 260,
            name: 'search_name',
        },
        {
            xtype : 'button',
            text : '提交',
            style : 'margin-left:15px;',
            handler : function(){
                if( !simple_info.getForm().isValid()){
                    Ext.Msg.alert('提示', '请根据提示，填写完整数据表单');
                    return ;
                }
                fuzzySearch();
            }
        }
    ],
    renderTo : Ext.get('search-player')
});

function fuzzySearch(){
	var args = simple_info.getForm().getValues();
	myMask.show();
	Ext.Ajax.timeout = 5000;
    Ext.Ajax.request({
        url: js_url_path+'/index.php?r=/realtime/default/playerinfo',
        method:'POST',
        params: args,
        success: function(response){
            myMask.hide();
            var json = Ext.JSON.decode(response.responseText);
            listPlayer( json );
        }
    });
}

function listPlayer( data ){
	var targetDiv = Ext.get('playerlist');
	targetDiv.update('');
	Ext.select('#tabs1').update('');
	Ext.select('#playerinfos').update('');
	Ext.select('#handle-bottom3').hide();
	Ext.define('playerListStruct', {
        extend: 'Ext.data.Model',
        fields: [
            {name: 'index', type:'string'},
            {name: 'user_account', type: 'string'},
            {name: 'role_id', type: 'string'},
            {name: 'role_name', type: 'string'},
            {
                name: 'server_id',
                type: 'string',
                convert: function(v){
					return server_obj[v];
                }
             }
        ]
    });

	var store = Ext.create('Ext.data.Store', {
        model: 'playerListStruct',
        data:data
    });

	var playlsitTable = Ext.create('Ext.grid.Panel', {
        store: store,
        columns: [
            {text: '序号', width:70, dataIndex:'index'},
            {text: '角色名', width:130, dataIndex:'role_name'},
            {text: '角色id', width:100, dataIndex:'role_id'},
            {text: '账号名', width:250, dataIndex:'user_account'},
            {text: '服务器', width:200, dataIndex:'server_id'}
        ],
        width: 'auto',
        renderTo: targetDiv
    });
	playlsitTable.on('cellclick',function(a,b,c,d,e,f,g,h,i){
		if( typeof window.config == 'undefined'){
			window.config = {};
		}
		if( window.config.ajaxIsLoading ){
			return;
		}
		var args = store.data.items[f].data,serverID;
		for( i in server_obj ){
			if( server_obj[i] === args.server_id ){
				serverID = i;
				break;
			}
		}
		var options = {
			server_id: serverID,
			search_name: args.role_name
		};
		getPlayerInformation( options );
	});
}

function getPlayerInformation( options ){
	window.config.ajaxIsLoading = true;
	myMask.show();
	Ext.Ajax.timeout = 5000;
    Ext.Ajax.request({
        url: js_url_path+'/index.php?r=/realtime/default',
        method:'POST',
        params: options,
		success: function(response){
			window.config.ajaxIsLoading = false;
            myMask.hide();
            var data = Ext.JSON.decode(response.responseText);
            updateList( data.data );
        }
    });
}



function updateList( data ){
        if(typeof data.user_account=='undefined' || data.user_account==''){
            Ext.Msg.alert('提示', '查询结果为空');
            return ;
        }
        Ext.select('#handle-bottom3').show();
        Ext.select('#playerinfos').update('');
        initResultForm();
        window.roleId = data.role_id;
        window.serverId = simple_info.getForm().findField('server_id').getValue();
        window.playerinfos_form.getForm().findField('role_id').setValue(data.role_id);
        window.playerinfos_form.getForm().findField('qq').setValue(data.qq + '、' + data.vip_level + '、' + (data.yellow_year_vip == 1 ? '是' :'否'));
        window.playerinfos_form.getForm().findField('user_account').setValue(data.user_account);
        window.playerinfos_form.getForm().findField('create_time').setValue(data.create_time == '' ? '' : date.format(data.create_time,'ISO8601Long'));
        window.playerinfos_form.getForm().findField('last_login_time').setValue(data.last_login_time == '' ? '' : date.format(data.last_login_time,'ISO8601Long'));
        window.playerinfos_form.getForm().findField('first_pay_time').setValue(data.first_pay_time == '' ? '' : data.first_pay_time);
        window.playerinfos_form.getForm().findField('first_pay_balance').setValue(data.first_pay_balance);
        Ext.select('#tabs1').update(window.TAB);
        initTab();
        Ext.get('role_name').update( securityValue(data.role_name) );
        Ext.get('role_level').update( securityValue(data.role_level) ) ;
        Ext.get('experience').update( securityValue(data.experience) );
        Ext.get('role_reputation').update( securityValue(data.role_reputation) );
        Ext.get('energy').update( securityValue(data.energy) );
        Ext.get('menpai').update( securityValue(data.clan) );
        //Ext.get('shuxing').update( securityValue(data.attack,'0') );
        Ext.get('wuxue').update( securityValue(data.skill) );
        Ext.get('zhiye').update( securityValue(data.career) );
        Ext.get('chenghao').update( securityValue(data.title) );
        Ext.get('bangpai').update( securityValue(data.faction) );
        Ext.get('hp').update( securityValue(data.hp) );
        Ext.get('muscle').update( securityValue(data.muscle) );
        Ext.get('spirit').update( securityValue(data.spirit) );
        Ext.get('aptitude').update( securityValue(data.aptitude) );
        Ext.get('gift').update( securityValue(data.gift) );
        Ext.get('silver').update( securityValue(data.silver) );
        Ext.get('gold').update( securityValue(data.gold) );
        Ext.get('vitality').update( securityValue(data.vitality) );
        Ext.get('map').update( securityValue(data.map) );
        Ext.get('where').update( securityValue(data.where) );
        Ext.get('role_fightpower').update( securityValue(data.role_fightpower) );
        for(var i=0;i<=5;i++){
            var name = 'equip'+i;
            if(typeof data[name] != 'undefined') Ext.get(name).update(data[name]);
        }
        for(var j=0;j<=7;j++){
            var name = 'book'+j;
            if( typeof data[name] != 'undefined') Ext.get(name).update(data[name]);
        }

        Ext.get('know').update(data.know);

        if(typeof data.parter != 'undefined'){
            var html = ['<ul>'];
            var p =data.parter;
            if( !(p.constructor === Array && p.length == 0) ){
                for(var i in p){
                    html.push('<li><a href="'+js_url_path+'/index.php?r=/realtime/default/parter/parter_id/'+i+'/server_id/'+window.serverId+'" class="js-dialog-link"  data-height="370" data-width="795">'+p[i]+'</a></li>');
                }
                html.push('</ul>');
                html = html.join('');
                Ext.select('#friends-info').update(html);
                window.initLink();
            }
        }
        //默认隐藏多服查询的表单
        Ext.get('duofu-info').addCls('x-hide-display');
        bottom_form.show();
}

function securityValue( obj, name ){
    var o,n;
    if( typeof name == 'undefined' ){
        try{
            o = obj;
        }catch(e){}
        return typeof o == 'undefined' ? '' : o;
    }else{
        try{
            n = obj[name];
        }catch(e){}
        return typeof n == 'undefined' ? '' : n;
    }
}

function initResultForm(){
    Ext.get('playerinfos').dom.innerHTML = '';
    window.playerinfos_form = Ext.widget({
        xtype: 'form',
        frame: true,
        bodyPadding: '5 5 0',
        width: 1000,
        height:150,
        fieldDefaults: {
            msgTarget: 'side',
            labelWidth: 52
        },
        defaultType: 'textfield',
        items: [{
            xtype: 'fieldset',
            title: '玩家基本信息',
            defaultType: 'textfield',
            layout: 'anchor',
            defaults: {
                anchor: '100%',
                labelWidth: 180
            },
            width: '100%',
            layout : "column",
            items:[
                //第一列
                {
                    xtype : 'textfield',
                    fieldLabel: '角色ID',
                    name:'role_id',
                    columnWidth : .3
                },{
                    xtype : 'textfield',
                    fieldLabel: '创建时间',
                    name:'create_time',
                    columnWidth : .34
                },{
                    xtype : 'textfield',
                    fieldLabel: '黄钻信息（等级、VIP、年费）',
                    name:'qq',
                    columnWidth : .3
                },
                //第二列
                {
                    xtype : 'textfield',
                    fieldLabel: '账号',
                    name:'user_account',
                    columnWidth : .3
                },{
                    xtype : 'textfield',
                    fieldLabel: '最后登录时间',
                    name:'last_login_time',
                    columnWidth : .34
                },{
                    xtype : 'textfield',
                    fieldLabel: '首次充值时间',
                    name:'first_pay_time',
                    columnWidth : .34
                },
                //第三列
                {
                    xtype : 'textfield',
                    fieldLabel: '首次充值金额',
                    name:'first_pay_balance',
                    columnWidth : .3
                }
            ]//选择并输入用户查询信息 items end
        }],
        buttons: [],
        renderTo : Ext.get('playerinfos')
    });
}


//玩家角色账号列表
/*
(function(){
    function drawTable( data ){
        var store = Ext.create('Ext.data.Store', {
            fields:['a1', 'a2','a3','a4','a5','a6'],
            data:data
        });

        Ext.create('Ext.grid.Panel', {
            title: '玩家角色账号列表',
            store: store,
            columns: [
                {text: '序号', width:240, dataIndex:'a2'},
                {text: '账号ID', width:250, dataIndex:'a2'},
                {text: '账号名', width:250, dataIndex:'a2'},
                {text: '角色名', width:250, dataIndex:'a2'},
            ],
            width: 1000,
            renderTo: Ext.get('playerlist')
        });
    }
    var dataCount = [
                 {
                     'a1':'',
                     'a2':'',
                     'a3':'',
                     'a6':'',
                 }
    ];
    for(var j=1;j<=2;j++){
        var a=(function( a,b ){
            return {
                'a1':'','a2':'','a3':'',
                'a6':'',
            };
        })(dataCount[0],j);
        dataCount.push(a);
    }
    //drawTable(dataCount);
})();*/


function initTab(){
    var tabs = Ext.createWidget('tabpanel', {
        renderTo: 'tabs1',
        width: 1000,
        id : 'inforTabs',
        activeTab: 0,
        defaults :{
            bodyPadding: 10
        },
        items: [{
            contentEl:'status-info',
            title: '状态信息'
        },{
            contentEl:'bags-info',
            title: '背包信息',
            loader: {
                url: js_url_path+'/index.php?r=/realtime/default/bag/role_id/'+window.roleId+'/server_id/'+window.serverId,
                contentType: 'html',
                autoLoad: false,
                loadMask: true
            },
            listeners: {
                activate: function(tab) {
                        tab.loader.load();
                }
            }
        },{
            contentEl:'tasks-info',
            title: '任务信息'
        },{
            contentEl:'miji-info',
            title: '秘籍信息'
        },{
            contentEl:'friends-info',
            title: '伙伴信息'
        },{
            contentEl:'jinmai-info',
            title: '筋脉阵法信息',
            loader: {
                url: js_url_path+'/index.php?r=/realtime/default/other/role_id/'+window.roleId+'/server_id/'+window.serverId,
                contentType: 'html',
                autoLoad: false,
                loadMask: true
            },
            listeners: {
                activate: function(tab) {
                        tab.loader.load();
                }
            }
        },{
            contentEl:'zhuanbei-info',
            title: '装备强化'
        },{
            contentEl:'xiaofei-info',
            title: '消费信息'
        },{
            contentEl:'gifts-info',
            title: '礼包信息'
        },{
            contentEl:'duofu-info',
            title: '多服信息',
            listeners: {
                activate: function(tab){
                    //Ext.select('#duofu_info,#duofu_form').update('');
                    //initDuoFu();
                }
            },
        }]
    });
}

var bottom_form = Ext.widget({
    xtype: 'form',
    frame: true,
    bodyPadding: '5 5 0',
    width: 1000,
    height:250,
    fieldDefaults: {
        msgTarget: 'side',
        labelWidth: 52
    },
    defaultType: 'textfield',
    items: [{
        xtype: 'fieldset',
        title: '禁言封号设置选项',
        defaultType: 'textfield',
        layout: 'anchor',
        defaults: {
            anchor: '100%',
            labelWidth: 60,
        },
        width: '100%',
        layout : "column",
        items:[
            {
                xtype : 'textfield',
                fieldLabel: '封号时间(秒)',
                name:'FengHao',
				width : 250,
				labelWidth: 90,
                vtype:'Integer'
            },
            {
                xtype : 'button',
                text : '封号',
                width : 80,
                style : 'margin-left:10px;',
                handler : function(){
                    executeForbidLogin();
                }
            },
            {
                xtype : 'button',
                text : '解封号',
				width : 80,
                style : 'margin-left:10px;',
                handler : function(){
                    executePermitLogin();
                }
            },
            {
                xtype : 'textfield',
				fieldLabel: '禁言时间(秒)',
				labelWidth: 90,
                style : 'margin-left:75px;',
                name:'JinYan',
                width : 250,
                vtype:'Integer'
            },
            {
                xtype : 'button',
                text : '禁言',
                width : 80,
                style : 'margin-left:10px;',
                handler : function(){
                    executeForbidSpeaking();
                }
            },
            {
                xtype : 'button',
                text : '解禁言',
                width : 80,
                style : 'margin-left:10px;',
                handler : function(){
                    exectutePermitSpeaking();
                }
            },
        ]
    },{
        xtype: 'fieldset',
        title: 'GM备注记录列表',
        defaultType: 'textfield',
        layout: 'anchor',
        defaults: {
            anchor: '100%',
            labelWidth: 150,
        },
        width: '100%',
        layout : "column",
        items:[
            {
                xtype: 'textarea',
                name: 'comment',
            }
        ]
    }],
    buttons: [{
        text: '查看充值记录'
    },{
        text: '刷新'
	}],
	renderTo : Ext.get('handle-bottom3')
});
bottom_form.hide();

function executeForbidSpeaking() {
    var jinyan = bottom_form.getForm().findField('JinYan').getValue() || 999999999;
    var server = simple_info.getForm().findField('server_id').getValue();
    var comment = bottom_form.getForm().findField('comment').getValue();
    var role_name = Ext.get('role_name').dom.innerHTML;
    var role_id = window.playerinfos_form.getForm().findField('role_id').getValue();
    var user_account = window.playerinfos_form.getForm().findField('user_account').getValue();
    if( typeof window.playerinfos_form != 'undefined' && window.playerinfos_form){
        var role_id = window.playerinfos_form.getForm().findField('role_id').getValue();
    }else{
        Ext.Msg.alert('提示', '先查询用户再进行禁言操作');
        return;
    }
    var username = Ext.get('role_name');
    if( username == null ){
        return;
    }
    username = username.dom.innerHTML;
    if(!username){
       Ext.Msg.alert('提示','用户不存在');
	}
	if( !/^\d+$/g.test( jinyan ) && jinyan != '' ){
		Ext.Msg.alert('提示','时间必须是正整数');
		return;
	}
	var jinYanTime = jinyan == 999999999 ? '永久' : jinyan+'秒';
    Ext.MessageBox.confirm("确认操作","你确定要对 <strong style='color:red;'>"+username+"</strong> 进行<strong style='color:red;'>("+jinYanTime+")禁言</strong>操作吗？",function(e){
        if(e=='yes'){
            myMask.show();
            Ext.Ajax.timeout = 5000;
            Ext.Ajax.request({
                url: js_url_path+'/index.php?r=/service/default/forbidchat',
                method:'POST',
                params: {
                    server_id : server,
                    seconds : jinyan,
                    role_id : role_id,
                    role_name : role_name,
                    comment : comment,
                    user_account : user_account,
                },
                success: function(response){
                    myMask.hide();
                    var json = Ext.JSON.decode(response.responseText);
                    Ext.MessageBox.alert("操作提示", json.text);
                }
            });
        }else{
            showResultText(e,'操作取消');
        }
    });
    setTimeout(function(){
        myMask.hide();
    },5000);
}
function exectutePermitSpeaking(){
    var server = simple_info.getForm().findField('server_id').getValue();
    var comment = bottom_form.getForm().findField('comment').getValue();
    var role_name = Ext.get('role_name').dom.innerHTML;
    var role_id = window.playerinfos_form.getForm().findField('role_id').getValue();
    var user_account = window.playerinfos_form.getForm().findField('user_account').getValue();
    if( typeof window.playerinfos_form != 'undefined' && window.playerinfos_form){
        var role_id = window.playerinfos_form.getForm().findField('role_id').getValue();
    }else{
        Ext.Msg.alert('提示', '先查询用户再进行解禁言操作');
        return;
    }
    var username = Ext.get('role_name');
    if( username == null ){
        return;
    }
    username = username.dom.innerHTML;
    if(!username){
       Ext.Msg.alert('提示','用户不存在');
    }
    Ext.MessageBox.confirm("确认操作","你确定要对 <strong style='color:red;'>"+username+"</strong> 进行<strong style='color:red;'>解禁言</strong>操作吗？",function(e){
        if(e=='yes'){
            myMask.show();
            Ext.Ajax.timeout = 5000;
            Ext.Ajax.request({
                url: js_url_path+'/index.php?r=/service/default/permitchat',
                method:'POST',
                params: {
                    server_id : server,
                    role_id : role_id,
                    role_name : role_name,
                    comment : comment,
                    user_account : user_account,
                },
                success: function(response){
                    myMask.hide();
                    var json = Ext.JSON.decode(response.responseText);
                    Ext.MessageBox.alert("操作提示", json.text);
                }
            });
        }else{
            showResultText(e,'操作取消');
        }
    });
    setTimeout(function(){
        myMask.hide();
    },5000);
}
function executeForbidLogin (){
    var jinyan = bottom_form.getForm().findField('FengHao').getValue() || 999999999;
    var server = simple_info.getForm().findField('server_id').getValue();
    var comment = bottom_form.getForm().findField('comment').getValue();
    var role_name = Ext.get('role_name').dom.innerHTML;
    var role_id = window.playerinfos_form.getForm().findField('role_id').getValue();
    var user_account = window.playerinfos_form.getForm().findField('user_account').getValue();
    if( typeof window.playerinfos_form != 'undefined' && window.playerinfos_form){
        var role_id = window.playerinfos_form.getForm().findField('role_id').getValue();
    }else{
        Ext.Msg.alert('提示', '先查询用户再进行封号操作');
        return;
    }
    var username = Ext.get('role_name');
    if( username == null ){
        return;
    }
    username = username.dom.innerHTML;
    if(!username){
       Ext.Msg.alert('提示','用户不存在');
	}
	if( !/^\d+$/g.test( jinyan ) && jinyan != '' ){
		Ext.Msg.alert('提示','时间必须是正整数');
		return;
	}
	var jinYanTime = jinyan == 999999999 ? '永久' : jinyan+'秒';
    Ext.MessageBox.confirm("确认操作","你确定要对 <strong style='color:red;'>"+username+"</strong> 进行<strong style='color:red;'>("+jinYanTime+")封号</strong>操作吗？",function(e){
        if(e=='yes'){
            myMask.show();
            Ext.Ajax.timeout = 5000;
            Ext.Ajax.request({
                url: js_url_path+'/index.php?r=/service/default/forbidlogin',
                method:'POST',
                params: {
                    server_id : server,
                    seconds : jinyan,
                    role_id : role_id,
                    role_name : role_name,
                    comment : comment,
                    user_account : user_account,
                },
                success: function(response){
                    myMask.hide();
                    var json = Ext.JSON.decode(response.responseText);
                    Ext.MessageBox.alert("操作提示", json.text);
                }
            });
        }else{
            showResultText(e,'操作取消');
        }
    });
    setTimeout(function(){
        myMask.hide();
    },5000);
}
function executePermitLogin() {
    var server = simple_info.getForm().findField('server_id').getValue();
    var username = Ext.get('role_name');
    var comment = bottom_form.getForm().findField('comment').getValue();
    var role_name = Ext.get('role_name').dom.innerHTML;
    var role_id = window.playerinfos_form.getForm().findField('role_id').getValue();
    var user_account = window.playerinfos_form.getForm().findField('user_account').getValue();
    if( username == null ){
        return;
    }
    username = username.dom.innerHTML;
    if(!username){
       Ext.Msg.alert('提示','用户不存在');
    }
    if( typeof window.playerinfos_form != 'undefined' && window.playerinfos_form){
        var role_id = window.playerinfos_form.getForm().findField('role_id').getValue();
    }else{
        Ext.Msg.alert('提示', '先查询用户再进行解封号操作');
        return;
    }
    Ext.MessageBox.confirm("确认操作","你确定要对 <strong style='color:red;'>"+username+"</strong> 进行<strong style='color:red;'>解封号</strong>操作吗？",function(e){
        if(e=='yes'){
            myMask.show();
            Ext.Ajax.timeout = 5000;
            Ext.Ajax.request({
                url: js_url_path+'/index.php?r=/service/default/permitlogin',
                method:'POST',
                params: {
                    server_id : server,
                    role_id : role_id,
                    role_name : role_name,
                    comment : comment,
                    user_account : user_account,
                },
                success: function(response){
                    myMask.hide();
                    var json = Ext.JSON.decode(response.responseText);
                    Ext.MessageBox.alert("操作提示", json.text);
                }
            });
        }else{
            showResultText(e,'操作取消');
        }
    });
    setTimeout(function(){
        myMask.hide();
    },5000);
}

//检测url的参数，含有用户账号，server_id，自动加载用户信息
(function(){
	if( typeof url.parseQueryString( location.search).server_id != 'undefined'){
		var args = url.parseQueryString( location.search);
		var server_id = parseInt( args.server_id );
		simple_info.getForm().findField('server_id').setValue( server_id );

		simple_info.getForm().findField('server_id').select( server_id );
		typeof args.search_type != 'undefined' && simple_info.getForm().findField('search_type').select( parseInt(args.search_type) );
		if( typeof args.user_account != 'undefined' ){
			args.search_name = args.user_account;
			simple_info.getForm().findField('search_name').setValue( args.user_account );
		}else{
			args.role_name = decodeURIComponent(args.role_name);
			args.search_name = args.role_name;
			simple_info.getForm().findField('search_name').setValue( args.role_name );
		}
		getPlayerInformation( args );
		window.aa=simple_info;
	}else{
		myMask.hide();
	}
})();






Ext.get('duofu-info').addCls('x-hide-display');

});
</script>
