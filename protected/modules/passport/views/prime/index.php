<div id="tabs">
	<div id="primelist" class="x-hide-display"></div>
</div>


<script type="text/javascript">
<?php
	echo 'var role_menu='.json_encode($role_menu).';';
?>
var items = [];
for(var i=0;i<role_menu.length;i++){
	var col = role_menu[i];
	items.push({
		contentEl:'primelist',
		title: col.label,
		autoHeight:true,
        autoScroll:true,
        autoWidth:true,
        frame:true,
        html:'<iframe id="HelloIframe" src="'+js_url_path+'/index.php?r='+col.url['0']+'/iframe/1/role_id/'+col.url['role_id']+'" width="100%" height="650" frameborder="0" scrolling="auto"></iframe>'
	});

}

Ext.require('Ext.tab.*');
Ext.onReady(function(){

function initTab(){
    var tabs = Ext.createWidget('tabpanel', {
        renderTo: 'tabs',
        width: 955,
        activeTab: 0,
        defaults :{
            bodyPadding: 10
        },
        items: items
    });
}

initTab();
myMask.hide();
});

</script>