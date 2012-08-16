<div id="NewForm"></div>
<script type="text/javascript">

Ext.onReady(function(){


var columns = [
    {
        fieldLabel: '筋骨属性点',
        value:"<?php echo isset($attributes[23])?$attributes[23]:''?>"
    },
    {
        fieldLabel: '心法属性点',
        value:"<?php echo isset($attributes[25])?$attributes[25]:''?>"
    },
    {
        fieldLabel: '悟性属性点',
        value:"<?php echo isset($attributes[27])?$attributes[27]:''?>"
    },
    {
        fieldLabel: '战斗力',
        value:"<?php echo isset($attributes[29])?$attributes[29]:''?>"
    },
    {
        fieldLabel: '培养筋骨属性点',
        value:"<?php echo isset($attributes[31])?$attributes[31]:''?>"
    },
    {
        fieldLabel: '培养心法属性点',
        value:"<?php echo isset($attributes[33])?$attributes[33]:''?>"
    },
    {
        fieldLabel: '培养悟性属性点',
        value:"<?php echo isset($attributes[35])?$attributes[35]:''?>"
    },
    {
        fieldLabel: '攻击属性',
        value:"<?php echo isset($attributes[37])?$attributes[37]:''?>"
    },
    {
        fieldLabel: '等级',
        value:"<?php echo isset($attributes[39])?$attributes[39]:''?>"
    },
    {
        fieldLabel: '当前生命',
        value:"<?php echo isset($attributes[41])?$attributes[41]:''?>"
    },
    {
        fieldLabel: '生命上限',
        value:"<?php echo isset($attributes[43])?$attributes[43]:''?>"
    },
    {
        fieldLabel: '品质',
        value:"<?php echo isset($attributes[45])?($attributes[45] == 471301 ? '白' : 
                ($attributes[45] == 471302 ? '蓝' : 
                ($attributes[45] == 471303 ? '紫' : 
                ($attributes[45] == 471304 ? '橙' : 
                ($attributes[45] == 471305 ? '红' : 
                ($attributes[45] == 471306 ? '绿' : '无记载')))))):''?>"
    },
    {
        fieldLabel: '出战',
        value:"<?php echo isset($attributes[1]) ? ($attributes[1] == 1 ? '闲置' : ($attributes[1] == 2 ? '出战' : ($attributes[1] == 2 ? '修炼' : '客栈'))) :''?>"
    },
    {
        fieldLabel: '伙伴',
        value:"<?php echo isset($attributes[5]) ? $attributes[5]:''?>"
            },
            {
                fieldLabel: '职业类型',
//              value:"<?php echo isset($attributes[7])?$attributes[7]:''?>"
    },
    {
        fieldLabel: '门派',
        value:"<?php echo isset($attributes[9])?$attributes[9]:''?>"
    },
    {
        fieldLabel: '人物类型',
        value:"<?php echo isset($attributes[11])?$attributes[11]:''?>"
    },
    {
        fieldLabel: '性别',
        value:"<?php echo isset($attributes[13])?($attributes[13] == 0 ? '女' : '男'):''?>"
    },
    {
        fieldLabel: '美术资源',
        value:"<?php echo isset($attributes[15])?$attributes[15]:''?>"
    },
    {
        fieldLabel: '当前经验值',
        value:"<?php echo isset($attributes[17])?$attributes[17]:''?>"
    },
    {
        fieldLabel: '普通技能',
        value:"<?php echo isset($attributes[19])?$attributes[19]:''?>"
    },
    {
        fieldLabel: '绝技技能',
        value:"<?php echo isset($attributes[21])?$attributes[21]:''?>"
    },
    {
        fieldLabel: '装备1',
        labelWidth: 55,
        value:"<?php echo isset($list[0][19])?$list[0][19]:'';echo isset($list[0][17])?'等级：'.$list[0][17]:'';echo isset($list[0][25])?'品质：'.$list[0][25]:''?>"
    },
    {
        fieldLabel: '装备2',
        labelWidth: 55,
        value:"<?php echo isset($list[1][19])?$list[1][19]:'';echo isset($list[1][17])?'等级：'.$list[1][17]:'';echo isset($list[1][25])?'品质：'.$list[1][25]:''?>"
    },
    {
        fieldLabel: '装备3',
        labelWidth: 55,
        value:"<?php echo isset($list[2][19])?$list[2][19]:'';echo isset($list[2][17])?'等级：'.$list[2][17]:'';echo isset($list[2][25])?'品质：'.$list[2][25]:''?>"
    },
    {
        fieldLabel: '装备4',
        labelWidth: 55,
        value:"<?php echo isset($list[3][19])?$list[3][19]:'';echo isset($list[3][17])?'等级：'.$list[3][17]:'';echo isset($list[3][25])?'品质：'.$list[3][25]:''?>"
    },
    {
        fieldLabel: '装备5',
        labelWidth: 55,
        value:"<?php echo isset($list[4][19])?$list[4][19]:'';echo isset($list[4][17])?'等级：'.$list[4][17]:'';echo isset($list[4][25])?'品质：'.$list[4][25]:''?>"
    },
    {
        fieldLabel: '装备6',
        labelWidth: 55,
        value:"<?php echo isset($list[5][19])?$list[5][19]:'';echo isset($list[5][17])?'等级：'.$list[5][17]:'';echo isset($list[5][25])?'品质：'.$list[5][25]:''?>"
    },
    {
        fieldLabel: '秘籍1',
        labelWidth: 55,
        value:"<?php echo isset($parter_booklist[1])?$parter_booklist[1]:'';echo isset($parter_booklist[2])?'等级:'.$parter_booklist[2]:''?>"
    },
    {
        fieldLabel: '秘籍2',
        labelWidth: 55,
        value:"<?php echo isset($parter_booklist[5])?$parter_booklist[5]:'';echo isset($parter_booklist[6])?'等级:'.$parter_booklist[6]:''?>"
    },
    {
        fieldLabel: '秘籍3',
        labelWidth: 55,
        value:"<?php echo isset($parter_booklist[9])?$parter_booklist[9]:'';echo isset($parter_booklist[10])?'等级:'.$parter_booklist[10]:''?>"
    },
    {
        fieldLabel: '秘籍4',
        labelWidth: 55,
        value:"<?php echo isset($parter_booklist[13])?$parter_booklist[13]:'';echo isset($parter_booklist[14])?'等级:'.$parter_booklist[14]:''?>"
    },
    {
        fieldLabel: '秘籍5',
        labelWidth: 55,
        value:"<?php echo isset($parter_booklist[17])?$parter_booklist[17]:'';echo isset($parter_booklist[18])?'等级:'.$parter_booklist[18]:''?>"
    },
    {
        fieldLabel: '秘籍6',
        labelWidth: 55,
        value:"<?php echo isset($parter_booklist[21])?$parter_booklist[21]:'';echo isset($parter_booklist[22])?'等级:'.$parter_booklist[22]:''?>"
    },
    {
        fieldLabel: '秘籍7',
        value:"<?php echo isset($parter_booklist[25])?$parter_booklist[25]:'';echo isset($parter_booklist[26])?'等级:'.$parter_booklist[26]:''?>"
    },
    {
        fieldLabel: '秘籍8',
        value:"<?php echo isset($parter_booklist[29])?$parter_booklist[29]:'';echo isset($parter_booklist[30])?'等级:'.$parter_booklist[30]:''?>"
    }
];

var listOrder = [
    '等级',             '筋骨属性点',        '装备1',
    '当前生命',         '心法属性点',        '装备2',
    '生命上限',         '悟性属性点',        '装备3',
    '品质',             '战斗力',            '装备4',
    '出战',             '培养筋骨属性点',    '装备5',
    '伙伴',             '培养心法属性点',    '装备6',
    '职业类型',         '培养悟性属性点',    '秘籍1',
    '门派',             '攻击属性',          '秘籍2',
    '人物类型',         '普通技能',          '秘籍3',
    '性别',             '绝技技能',          '秘籍4',
    '当前经验值',        '美术资源',          '秘籍5',
    '秘籍7',             '秘籍8',            '秘籍6'
];

var listOrdered = [];
for( var i = 0; i < listOrder.length; i++ ){
    for( var j = 0; j < columns.length; j++ ){
        if( listOrder[i] == columns[j]['fieldLabel'] ){
            listOrdered.push( columns[j] );
            break;
        }
    }
}

var NewForm = Ext.widget({
	xtype: 'form',
	frame: true,
	width: 780,
	height:330,
	items: [{
		xtype: 'fieldset',
		title: '伙伴状态信息',
		layout : "column",
		defaults: {
			anchor: '100%',
			labelWidth: 95,
			columnWidth : .333,
		},
		defaultType: 'textfield',
		items: listOrdered
	}],
});
NewForm.render('NewForm');


myMask.hide();
});
</script>