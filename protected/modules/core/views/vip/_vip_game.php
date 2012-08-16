<div id="list" style="width:500px; margin:0 auto;margin-top:5px;"></div>
<script type="text/javascript">
<?php
echo 'var vip_info_list = '.json_encode($list).';';
echo 'var vip_children_type = '.json_encode($children_type).';';
?>
Ext.onReady(function(){
var inputs = [];
for( i in vip_children_type ){
	var lable = vip_children_type[i];
	var value = vip_info_list[i];
	inputs.push({
        xtype : 'textfield',
        width: 230,
        labelWidth: 100,
        fieldLabel: lable,
        value:value,
    });
}
Ext.widget({
	xtype: 'form',
	frame: true,
	width: 500,
	layout : "column",
	items:inputs,
	renderTo: Ext.get('list')
});

myMask.hide();
});
</script>