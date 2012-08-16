<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
<title>服务器监控</title>
<style type="text/css">
#search_form{
	font-family:Menlo,Consolas,"Courier New",Courier,monospace;
	border:dashed 1px #DFDFDF;
	padding:0 10px;
}
#search_form a{
	font-family:'幼圆';
	text-decoration:none;
	font-weight:bold;
}
#search_form a:hover{
	text-decoration:underline;
	color:red;
}
#search_form a.disabled {
	color:#DFDFDF;
}
#search_form a.disabled:hover {
	color:#DFDFDF;
	text-decoration:none;
}
#search_form input{
	height:14px;
	padding:6px 2px;
	width:200px;
	border:solid 1px black;
	outline:none;
}
#search_form input:focus{
	border:solid 1px green;
}
#tips{
	color:green;
}
</style>
</head>
<body>

<div id="search_form">
	<p>
		<label> open_id:</label><input type="text" id="open_id" name="open_id" />
		<label>open_key:</label><input type="text" id="open_key" name="open_key" />
		<label>参数:</label><input type="text" id="config" name="config" />
		<a href="javascript:void(0)" id="search">提交</a>
		<span id="tips"></span>
	</p>
</div>
<div id="server_list"></div>
<script type="text/javascript">


$('search').onclick=function(){
	var args = {},
	list = $('search_form').getElementsByTagName('input');

	if( !validate() ){
		alert('open_id 和 open_key都由0-9ABCDEF组成的32位的字符串,且参数不能为空');
		return ;
	}

	if( isDisabled() ){
		return ;
	}else{
		disableButton( true );
	}

	for( var i = 0,len = list.length; i< len; i++ ){
		args[ list[i].name ] = encodeURIComponent( list[i].value );
	}
	window.config={
		args: args
	};

	getServerStatus();
	tips('(Loading...)');
}

function disableButton( bool ){
	var btn = $('search');
	if( bool ){
		btn.className = 'disabled';
	}else{
		btn.className = '';
	}
}

function isDisabled(){
	var btn = $('search');
	if( btn.className == 'disabled' ){
		return true;
	}else{
		return false;
	}
}

function tips( txt,fn ){
	var span = $('tips');
	span.innerHTML = txt;
	if( typeof window.timer != 'undefined'){
		clearTimeout(window.timer);
	}
	if( $('countDown') != null ){
		count();
	}
	function count(){
		var obj = $('countDown'),
		remain = parseInt(obj.innerHTML,10);
		if( remain > 0 ){
			--remain;
			obj.innerHTML = remain;
			window.timer = setTimeout(function(){
				count();
			},1000);
		}else{
			fn.call( this );
		}
	}
}

function validate(){
	var open_id = $('open_id').value,
		open_key = $('open_key').value,
		config = $('config').value,
		reg_id = /^[0-9ABCDEF]{32}$/g,
		reg_key = /^[0-9ABCDEF]{32}$/g;
	if(reg_id.test(open_id) && reg_key.test(open_key) && config != '' ){
		return true;
	}
	return false;
}

function $(id){
	return document.getElementById(id);
}


function getServerStatus(){
	var fn = arguments.callee,
	server_status_box = $('server_list');
	ajax({
		method:'post',
		data: window.config.args,
		url:window.location.href,
		timeout:40000,
		onSuccess:function( xhr ){
			var status = xhr.responseText;
			server_status_box.innerHTML = status;
			tips('(<i id="countDown">60</i>\'s后重新加载)',function(){
				fn.call( this );
			});
			disableButton( false );
		},
		onError: function(){
			server_status_box.innerHTML = '<p style="color:red;">获取服务器信息失败!</p>';
			tips('(<i id="countDown">10</i>\'s后重新加载)',function(){
				fn.call( this );
			});
		}
	});

}





function ajax( options ){
	var requestDone,errorText
	xhr = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject("Microsoft.XMLHTTP"),
	options = {
		method : options.method ? options.method.toUpperCase() : "POST",
		url : options.url || "",
		timeout : options.timeout || 5000,
		onComplete : options.onComplete || function(){},
		onError : options.onError || function(){},
		onSuccess : options.onSuccess || function(){},
		data : serilize( options.data ) || "",
		dataType : options.dataType || "HTML",
		async : null == options.async ? true : Boolean(options.async),
		username : options.username || "",
		password : options.password || "",
		cache : options.cache || true
	};

	setTimeout( function() {
		requestDone = true;
	}, options.timeout );
	xhr.onreadystatechange = function(){
		if( xhr.readyState == 4 && !requestDone ){
			if (httpSuccess( xhr )){
				options.onSuccess.call(this,xhr);
			}else {
				errorText = xhr.status == "404" ? "Not Found" : "Unknown Error";
				options.onError.call( window,errorText);
			}
			options.onComplete(window,xhr);
			xhr = null;
		}else if ( requestDone == true && xhr.readyState==3 ){
			errorText = "请求超时";
			options.onError.call( window, errorText );
		}
	}
	function httpSuccess(r) {
		try {
			return !r.status && location.protocol == "file:" ||
			( r.status >= 200 && r.status < 300 ) ||
			r.status == 304 ||
			navigator.userAgent.indexOf("Safari") >= 0
				&& typeof r.status == "undefined";
		}catch (e){}
		return false;
	}
	function serilize( data ){
		if( typeof data == 'string' ){
			return data;
		}else if( data.constructor === Array ){
			return data.join('&');
		}else if( data.constructor === Object ){
			var tmp = [];
			for( var i in data ){
				tmp.push( i + "=" + data[i] );
			}
			return serilize(tmp);
		}
	}
	xhr.open( options.method, options.url, options.async ,options.username, options.password );
	xhr.setRequestHeader("X-Requested-With","XMLHttpRequest");
	xhr.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	xhr.send(options.data);
}
</script>

</body>
</html>
