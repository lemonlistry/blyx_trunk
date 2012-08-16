<style type="text/css">
body{
	font-family:helvetica,tahoma,verdana,sans-serif；
}
.fontTips a{
    color:green;
    font-weight:bold;
    text-decoration:none;
}
.fontTips a:hover{
    text-decoration:underline;
}

</style>
<div style="margin-left:100px;">
<h2>Welcome!</h2>
<div>本系统对Chrome浏览器支持最好, <span id='tips' style='font-weight:bold;'></span></div>
<p class="fontTips">系统字体模糊看不清?下载 <a href="http://www.microsoft.com/typography/ClearTypePowerToy.mspx" target="_blank;">微软字体清晰补丁</a> 试试吧..</p>
<div id="broswer"></div>
</div>

<script type='text/javascript'>
function uagent(){
	return uagent.prototype.init();
}
uagent.prototype = {
	init : function(){
		this.ua=window.navigator.userAgent.toLowerCase();
		var ua = this.ua;
		this.no = {
			ie : !/msie/.test( ua ),
			chrome : !/chrome/.test( ua ),
			opera : !/opera/.test( ua ),
			firefox : !/firefox/.test( ua ),
			safari : !/safari/.test( ua )
		};
		this.ie			 = !this.no.ie && this.no.opera && this.no.firefox && this.no.safari;
		this.safari		 = !this.no.safari && this.no.ie && this.no.firefox && this.no.chrome;
		this.chrome		 = !this.no.chrome && this.no.ie && this.no.firefox && this.no.opera;
		this.opera		 = !this.no.opera && this.no.chrome && this.no.safari;
		this.firefox	 = !this.no.firefox && this.no.chrome 
							&& this.no.safari && this.no.ie&&this.no.opera;
		this.broswer={name:'',version:''};
		return this;
	},
	getBroswer:function(){
		if( this.ie ) return "ie";
		else if( this.chrome ) return "chrome";
		else if( this.firefox ) return "firefox";
		else if( this.opera ) return "opera";
		else if( this.safari ) return "safari";
		else return 'unknow';
	},
	getVersion : function(){
		var bro = this.getBroswer(),s;
		switch (bro) {
			case 'safari' :
				if ( /version/.test(this.ua) ) {
					(s = this.ua.match(/version\/([\d.]+).*safari/)) ? 
						this.broswer.version=s[1] : 0;
				}else if( /applewebKit/.test(this.ua) ){
					(s = this.ua.match(/applewebKit\/([\d.]+).*/)) ? 
						this.broswer.version=s[1] : 0;
				}else{
					(s = this.ua.match(/safari\/([\d.]+).*/)) ? 
						this.broswer.version=s[1] : 0;
				}
				this.broswer.name='safari';
				break;
			case 'opera' :
				if ( /version/.test(this.ua) ) {
					(s = this.ua.match(/version\/([\d.]+).*/)) ? 
						this.broswer.version=s[1] : 0;
				}else{
					(s = this.ua.match(/opera[\/\s]([\d.]+).*/)) ? 
						this.broswer.version=s[1] : 0;
				}
				this.broswer.name='opera';
				break;
			case 'chrome' :
				(s = this.ua.match(/chrome\/([\d.]+).*/)) ? 
						this.broswer.version=s[1] : 0;
				this.broswer.name='chrome';
				break;
			case 'firefox' :
				(s = this.ua.match(/firefox\/([\d.]+).*/)) ? 
						this.broswer.version=s[1] : 0;
				this.broswer.name='firefox';
				break;
			case 'ie' :
				(s = this.ua.match(/msie\s([\d.]+).*/)) ? 
						this.broswer.version=s[1] : 0;
				this.broswer.name='ie';
				break;
			default :
				break;
		}
		return this.broswer.version;
	},
	getShell : function(){
		if(this.ie){
			this.shell=(this.ua.indexOf('360ee')>-1)?'360极速':
			(this.ua.indexOf('360se')>-1)?'360':
			(this.ua.indexOf('se')>-1)?'搜狗':
			(this.ua.indexOf('aoyou')>-1)?'遨游':
			(this.ua.indexOf('theworld')>-1)?'世界之窗':
			(this.ua.indexOf('worldchrome')>-1)?'世界之窗':
			(this.ua.indexOf('greenbrowser')>-1)?'绿色':
			(this.ua.indexOf('qqbrowser')>-1)?'QQ':
			(this.ua.indexOf('tencenttraveler')>-1)?'腾讯TT':
			(this.ua.indexOf('baidu')>-1)?'百度':
			'no';
			return this.shell;
		}else{
			return '';
		}
	},
	getSystem : function(){
		if(/win98|windows 98/.test(this.ua)){
			return "windows 98";
		}else if(/windows nt 5.0|windows 2000/.test(this.ua)){
			return "windows 2000";
		}else if(/windows nt 5.1|windows xp/.test(this.ua)){
			return "windows xp";
		}else if(/windows nt 6.1|windows 7/.test(this.ua)){
			return "windows 7";
		}else if(/windows nt 7.1|windows 8/.test(this.ua)){
			return "windows 8";
		}else if(/windows phone/.test(this.ua)){
			return "windows phone";
		}else if(/linux/.test(this.ua)){
			return "linux";
		}else if(/iphone|ipad|ipod/.test(this.ua)){
			return "ios";
		}else if(/mac/.test(this.ua)){
			return "mac";
		}
	}
	
};


(function(){
	var data=[],
		ua = uagent(),
		b = ua.getBroswer(),
		v = ua.getVersion(),
		s = ua.getSystem(),
		sh = ua.getShell(),
		ua = ua.ua;
	var title = "<h4>您的浏览器信息如下：</h4>",html=[];
	html.push(title);
	html.push("<p>您正在使用的浏览器是："+b+"("+v+")</p>");
	html.push("<p>您正在使用的操作系统是："+s+"</p>");
	html.push("<p>User Agent："+ua+"</p>");
	html = html.join('');
	var broswer = document.getElementById('broswer');
	var tip_obj = document.getElementById('tips');
	if(b!='chrome'){
		var tips = '您现在使用的不是chrome，';
		tips += "如遇到界面或者交互等问题，试试<a href='http://www.google.cn/chrome/intl/zh-CN/landing_chrome.html' target='_blank;'>Chrome浏览器</a>吧！";
		tip_obj.style.color='red';
	}else{
		var tips = "恭喜您，您现在用的是就是Chrome";
		tip_obj.style.color='green';
	}
	tip_obj.innerHTML = tips;
    broswer.innerHTML = html;
	
})();
</script>