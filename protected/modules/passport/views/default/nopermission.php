<style type="text/css">
body{

}
#wrap{
    width:800px;
    margin:0 auto;
    margin-top:200px;
}
h4{
    color:#383838;
    text-shadow:0 1px rgba(255, 255, 255, 0.5);
    font:38px ProximaNovaSoft,sans-serif;
}
p{
    font:18px ProximaNovaSoft,sans-serif;
    color:#999;
}
</style>
<div id="wrap">
    <h4>No Permission!</h4>
    <p>You do not have permission to access this page</p>
</div>
<script type="text/javascript">
Ext.onReady(function(){
	myMask.hide();
    if(window.parent !== window ){
        if( window.parent.location.href.indexOf('passport/default/main') != -1 ){
            return ;
        }
        Ext.get('wrap').dom.style.cssText = 'width:auto;margin:0;';
    }
});
</script>
