window.config = {
    '$page' : 30
}

Ext.require([
     'Ext.window.MessageBox',
     'Ext.tip.*'
]);



//message.js start

Ext.example = function(){
    var msgCt;

    function createBox(t, s){
       return '<div class="msg"><h3>' + t + '</h3><p>' + s + '</p></div>';
    }
    return {
        msg : function(title, format){
            if(!msgCt){
                msgCt = Ext.DomHelper.insertFirst(document.body, {id:'msg-div'}, true);
            }
            var s = Ext.String.format.apply(String, Array.prototype.slice.call(arguments, 1));
            var m = Ext.DomHelper.append(msgCt, createBox(title, s), true);
            m.hide();
            m.slideIn('t').ghost("t", { delay: 1600, remove: true});
        },

        init : function(){
        }
    };
}();
Ext.example.shortBogusMarkup = '<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Sed metus nibh, '+
    'sodales a, porta at, vulputate eget, dui. Pellentesque ut nisl. Maecenas tortor turpis, interdum non, sodales '+
    'non, iaculis ac, lacus. Vestibulum auctor, tortor quis iaculis malesuada, libero lectus bibendum purus, sit amet '+
    'tincidunt quam turpis vel lacus. In pellentesque nisl non sem. Suspendisse nunc sem, pretium eget, cursus a, fringilla.</p>';

Ext.example.bogusMarkup = '<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Sed metus nibh, sodales a, '+
    'porta at, vulputate eget, dui. Pellentesque ut nisl. Maecenas tortor turpis, interdum non, sodales non, iaculis ac, '+
    'lacus. Vestibulum auctor, tortor quis iaculis malesuada, libero lectus bibendum purus, sit amet tincidunt quam turpis '+
    'vel lacus. In pellentesque nisl non sem. Suspendisse nunc sem, pretium eget, cursus a, fringilla vel, urna.<br/><br/>'+
    'Aliquam commodo ullamcorper erat. Nullam vel justo in neque porttitor laoreet. Aenean lacus dui, consequat eu, adipiscing '+
    'eget, nonummy non, nisi. Morbi nunc est, dignissim non, ornare sed, luctus eu, massa. Vivamus eget quam. Vivamus tincidunt '+
    'diam nec urna. Curabitur velit. Lorem ipsum dolor sit amet.</p>';

function showResultText(btn, text){
    Ext.example.msg('操作提示', '您点击了 {0} 按钮  ,{1}.', btn, text);
};

//message.js end

//Ext.Cookies start
var Cookies = {};
Cookies.set = function( c_name, value, exdays ){
	var exdate = new Date();
	exdate.setDate( exdate.getDate() + exdays );
	var c_value=escape(value) + ( ( exdays == null ) ? "" : "; expires=" + exdate.toUTCString() );
	document.cookie = c_name + "=" + c_value;
}
Cookies.get = function(name){
	var arr = document.cookie.match( new RegExp("(^| )" + name + "=([^;]*)(;|$)") );
	if(arr != null) return unescape( arr[2] ); return null;
};
Cookies.clear = function(name) {
	var exp = new Date();
	exp.setTime( exp.getTime() - 1 );
	var cval=Cookies.get(name);
	if( cval != null ) document.cookie = name + "=" + cval + ";expires=" + exp.toGMTString();
};
Cookies.getCookieVal = function(offset){
   var endstr = document.cookie.indexOf(";", offset);
   if(endstr == -1){
       endstr = document.cookie.length;
   }
   return unescape(document.cookie.substring(offset, endstr));
};
Ext.Cookies = Cookies;
//Ext.Cookies end


/*
 * class为js-dialog-link的元素添加事件：
 * 打开iframe弹层
 */
Ext.onReady(function(){



    /*
     * 类名为js-dialog-link的a标签，添加鼠标点击事件，打开弹层
     */
    window.initLink = function(){
        Ext.select('.js-dialog-link').on('click',function(e,t){
            if( !!this.dataset ){
                var src= t.href,
                data = this.dataset,
                w = data.width || 800,
                h = data.height || 500,
                title = t.innerHTML || data.title || '';
            }else{
                var src= t.href,
                w = this.getAttribute('data-width'),
                h = this.getAttribute('data-height'),
                title = t.innerHTML || this.getAttribute('data-title') || '';
            }
            openWindow({
                title: title,
                width: w,
                height: h,
                className: 'testIframe',
                src:src
            });
            e.stopEvent();
        });
    }
    window.initLink();



});



/*
 * Ext.window控件打开iframe弹层
 */
function openWindow( opt ){
    opt.width = parseInt(opt.width,10);
    opt.height = parseInt(opt.height,10)
    var body_w = document.body.clientWidth ,
        body_h = document.body.scrollHeight,
        x = (body_w -opt.width)/2,
        y = (body_h -opt.height)/2,
        y = y > 0 ? y > 50 ? 25 : y : 0;
    window.iframeWindow = Ext.create('Ext.Window', {
        title: opt.title,
        width: opt.width,
        height: opt.height,
        x: x,
        y: y,
        plain: true,
        modal:true,
        headerPosition: 'top',
        layout: 'fit',
        closable:true,
        plain: true,
        html:'<iframe class="'+opt.className+'" scrolling="auto" frameborder="0" width="100%" height="100%" src="'+opt.src+'"></iframe>'
    }).show();
}
/*
 * 显示tips
 */
function showResult(btn){
    Ext.example.msg('Button Click', 'You clicked the {0} button', btn);
};

/*
 * 时间格式化
 */
var date = {
    patterns : {
        ISO8601Long:"Y-m-d H:i:s",
        ISO8601Short:"Y-m-d",
        ShortDate: "n/j/Y",
        LongDate: "l, F d, Y",
        FullDateTime: "l, F d, Y g:i:s A",
        MonthDay: "F d",
        ShortTime: "g:i A",
        LongTime: "g:i:s A",
        SortableDateTime: "Y-m-d\\TH:i:s",
        UniversalSortableDateTime: "Y-m-d H:i:sO",
        YearMonth: "F, Y"
    },
    UnixTimestamp : function( t ){
        t = t || (new Date());
        return t.valueOf();
    },
    unixtimeToDate:function( unixtime ){
        var newDate = new Date();
        unixtime += '';
        if(unixtime.length<13){
            unixtime = parseInt(unixtime);
            unixtime *= 1000;
        }else{
            unixtime = parseInt(unixtime);
        }
        newDate.setTime( unixtime );
        return new Date( newDate.toUTCString() );
    },
    format : function( opt,format ){
		if( typeof opt == 'string' || typeof opt == 'number' ){
			if(!/\d{10,13}/g.test(opt)){
				return '';
			}
		}
        
        if( typeof opt == 'undefined' ) return '';
        var dt;
        if( /^\d+$/g.test( opt )){
            dt = this.unixtimeToDate( opt );
        }else if( opt.constructor === Date ){
            dt = opt;
        }else if( typeof opt=== 'string' ){
            try{
                dt = new Date(opt);
            }catch(e){
                return 'date string is not correct';
            }
        }
        if( typeof dt === 'undefined'){
            return '参数错误';
        }
        return Ext.Date.format(dt,this.patterns[format] );
    },
    getPreviouslyTime : function() {
        var now = new Date(),
            today = this.format(now,'ISO8601Short'),
            nowMiliSeconds = this.UnixTimestamp( now ),
            yesterdaySeconds = nowMiliSeconds - 24*60*60*1000,
            yesterday = this.format(yesterdaySeconds, 'ISO8601Short'),
            lastMonthSeconds = nowMiliSeconds - 30*24*60*60*1000,
            lastMonth = this.format(lastMonthSeconds,'ISO8601Short');
        return {
            yesterday : yesterday,
            lastMonth : lastMonth,
            today     : today
        };
    }
}
/*
 * 构建二维数组
 * 统一整形参数
 */
var build ={
    array : function( s ){
        var obj,re=[];
        obj = typeof s === 'string' ? Ext.JSON.decode(s)
                : typeof s === 'object' ? s :[];
        if( obj.constructor === Array ){
            for( var i =0;i<obj.length;i++){
                re.push( [obj[i],i] );
            }
        }else if( obj.constructor === Object ){
            for (var i in obj ){
                re.push( [obj[i],parseInt(i,10)] );
            }
            var isChrome = /chrome/.test(navigator.userAgent.toLowerCase());
            if( isChrome ){
                re = re.reverse();
            }
        }
        return re;
    },
    value : function(v){
        return v === null ? ''
                :  typeof v === 'string' ? parseInt( v ) : v;
    },
    convert2Int : function( arr ,obj ){
       for(var i =0; i< arr.length;i++ ){
           if( obj[arr[i]] == null ){

           }else{
               obj[arr[i]] = parseInt( obj[arr[i]],10 );
           }
       }
    }
};

/*
 * 处理表单提交回馈处理
 */
var formCallback = {
    alert : function( d ){
        if( typeof d == 'string') d = Ext.JSON.decode(d);
        if( typeof d.text == 'undefined'){
            Ext.Msg.alert('提示','未知错误，服务器没有返回错误码');
            return ;
        }
        if( !d.success ){
            var errors = [];
            if( d.text.constructor === Object){
                for( var i in d.text ){
                    errors.push( unescape(d.text[i]) );
                }
                errors = errors.join('<br>');
            }else{
                errors = d.text;
            }
            Ext.Msg.alert('错误提示',errors);
        }else{
            Ext.Msg.alert('提示', d.text ,function(){
                if( d.reload ){
                    !!window.parent && window.parent.location.reload();
                }
            });
        }
    }
}
/*
 * Ajax请求回馈处理
 */
var ajaxCallBack = {
    alert : function( options ){
        var params = options.params,
            url = options.url,
            method = options.method || "POST",
            conformTitle = options.conformTitle||"确认操作",
            conformContent = options.conformContent||"您确定要删除这条记录吗？",
            cancleText = options.cancelText || "删除操作取消",
            callback = options.callbak;
        Ext.MessageBox.confirm(conformTitle,conformContent,function(e){
            if(e=='yes'){
                myMask.show();
                Ext.Ajax.request({
                    url : url,
                    method : method,
                    params : params,
                    success : function(response){
                        if( typeof callback != 'undefined' ){
                            callback.call(window,response);
                            return ;
                        }
                        myMask.hide();
                        var data = Ext.JSON.decode(response.responseText);
                        Ext.MessageBox.alert("操作提示",
                            data.text,
                            function(){
                                if(data.reload){
                                    window.location.reload();
                                }
                            }
                        );
                    },
                    failure: function(resp,opts) {
                        myMask.hide();
                        var respText = resp.responseText;
                        try{
                            respText = Ext.JSON.decode(respText);
                        }catch(e){
                            console.log(e);
                        }
                        Ext.Msg.alert('错误', respText.error || respText );
                    }
                });
            }else{
                myMask.hide();
                showResultText(e,cancleText);
            }
        });
    }
};
/*
 * 将url的参数以json格式返回
 */
var url = {
	parseQueryString : function ( url ) {
		var reg = /\w+=[^&]+/g;
		var obj = {};
		if( !reg.test(url) ) return '';
		var arr = url.match(reg);
		for (var i = 0; i < arr.length; i++) {
			var str = arr[i];
			var subArr = str.split('=');
			obj[subArr[0]]=subArr[1];
		};
		return obj;
	}
};

var page = {
	getCookieName: function( url2 ){
		var _url = url2 || window.location.href;
		var sitePath = url.parseQueryString( _url );
		if( !sitePath.r ){
			return '';
		}
		sitePath = sitePath.r;
		sitePath = sitePath.split('/').join('');
		return sitePath;
	},
	set: function( v ) {
		var cookieName = this.getCookieName();
		if( cookieName == '' ) return ;
		Ext.Cookies.set( cookieName, v );
	},
	get: function(){
		 var cookieName = this.getCookieName();
		 return Ext.Cookies.get(cookieName);
	}
};

/*
 * 表单验证
 */
Ext.apply(Ext.form.field.VTypes, {

    IPAddress:  function(v) {
        //return true;
        return /^\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}$/.test(v);
    },
    IPAddressText: 'IP地址格式不对，格式为:127.0.0.1',
    IPAddressMask: /[\d\.]/i,

    Integer : function(v){
        return /^\d+$/.test(v);
    },
    IntegerText : '必须是整数',
    IntegerMask: /[\d]/i,

    Password : function(val, field) {
        console.log(field.initialPassField);
        if (field.initialPassField) {
            var pwd = Ext.getCmp(field.initialPassField);
            return (val == pwd.getValue());
        }
        return true;
    },
    PasswordText : '两次输入的密码不一致!'
});

/*
 * javascript原型拓展
 */
Array.prototype.contain = function( v ){
    for( var i = 0, length = this.length; i < length; i++ ) {
        if ( this[ i ] === v ) {
            return true;
        }
    }
    return false;
}
