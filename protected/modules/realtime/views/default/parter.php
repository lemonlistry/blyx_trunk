<div id="page_body">
<style type="text/css">
.tableborder{border:0px; border-collapse:collapse;} 
.tableborder td{border-top:1px #666 solid;border-right:1px #666 solid;} 
.tableborder{border-bottom:1px #666 solid;border-left:1px #666 solid;}
</style>
<div class="main-box">
    <div class="main-body">
        <div class="main-container prepend5">
            <div class="main-content">
                <div class="grid-view">
                    <table>
                        <thead>
                                <th align = "left"><font size="5" face ="隶书">伙伴状态信息</font></th>
                        </thead>
                    </table>
                    <table class='tableborder'> 
                         <tr>
                            <td>筋骨属性点&nbsp;:<input type="text" size="7"  value =<?php echo isset($attributes[21])?$attributes[21]:''?> ></td>
                            <td>心法属性点&nbsp;:<input type="text" size="7"  value =<?php echo isset($attributes[23])?$attributes[23]:''?> ></td>
                            <td>悟性属性点&nbsp;:<input type="text" size="7"  value =<?php echo isset($attributes[25])?$attributes[25]:''?> ></td>
                            <td>战斗力&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:<input type="text" size="7"   value =<?php echo isset($attributes[27])?$attributes[27]:''?> ></td>
                        </tr>
                         <tr>
                            <td>培养筋骨属性点:<input type="text" size="7"   value =<?php echo isset($attributes[29])?$attributes[29]:''?> ></td>
                            <td>培养心法属性点:<input type="text" size="7"   value =<?php echo isset($attributes[31])?$attributes[31]:''?> ></td>
                            <td>培养悟性属性点:<input type="text" size="7"   value =<?php echo isset($attributes[33])?$attributes[33]:''?> ></td>
                            <td>攻击属性&nbsp;&nbsp;:<input type="text" size="7"   value =<?php echo isset($attributes[35])?$attributes[35]:''?> ></td>
                         </tr>
                         <tr>
                            <td>等级&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:<input type="text" size="7"   value =<?php echo isset($attributes[37])?$attributes[37]:''?> ></td>
                            <td>当前生命&nbsp;&nbsp;:<input type="text" size="7"   value =<?php echo isset($attributes[39])?$attributes[39]:''?> ></td>
                            <td>生命上限&nbsp;&nbsp;:<input type="text" size="7"   value =<?php echo isset($attributes[41])?$attributes[41]:''?> ></td>
                            <td>品质&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:<input type="text" size="7"   value =<?php echo isset($attributes[43])?$attributes[43]:''?> ></td>
                         </tr>
                         <tr>
                             <td>出战&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:<input type="text" size="7"   value =<?php echo isset($attributes[1]) ? ($attributes[1] == 2 ? '出战' : '闲置') :''?> ></td>
                             <td>伙伴&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:<input type="text" size="7"   value =<?php echo isset($attributes[3]) ? $attributes[3]:''?> ></td>
                             <td>职业类型&nbsp;&nbsp;:<input type="text" size="7"   value =<?php echo isset($attributes[5])?$attributes[5]:''?> ></td>
                             <td>门派&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:<input type="text" size="7"   value =<?php echo isset($attributes[7])?$attributes[7]:''?> ></td>
                          </tr>
                          <tr>
                             <td>人物类型&nbsp;&nbsp;:<input type="text" size="7"   value =<?php echo isset($attributes[9])?$attributes[9]:''?> ></td>
                             <td>性别&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:<input type="text" size="7"  value =<?php echo isset($attributes[11])?($attributes[11] == 0 ? '女' : '男'):''?> ></td>
                             <td>美术资源&nbsp;&nbsp;:<input type="text" size="7"   value =<?php echo isset($attributes[13])?$attributes[13]:''?> ></td>
                             <td>当前经验值&nbsp;:<input type="text" size="7"   value =<?php echo isset($attributes[15])?$attributes[15]:''?> ></td>
                          </tr>
                          <tr>
                             <td>普通技能&nbsp;&nbsp;:<input type="text" size="7"   value =<?php echo isset($attributes[17])?$attributes[17]:''?> ></td>
                             <td>绝技技能&nbsp;&nbsp;:<input type="text" size="7"   value =<?php echo isset($attributes[19])?$attributes[19]:''?> ></td>
                             <td>武器&nbsp;:<input type="text" size="20"  value =<?php echo isset($list[0][19])?$list[0][19]:'';echo isset($list[0][17])?'等级：'.$list[0][17]:'';echo isset($list[0][25])?'品质：'.$list[0][25]:''?>></td>
                             <td>头盔&nbsp;:<input type="text" size="20"  value =<?php echo isset($list[1][19])?$list[1][19]:'';echo isset($list[1][17])?'等级：'.$list[1][17]:'';echo isset($list[1][25])?'品质：'.$list[1][25]:''?>></td>
                          </tr>
                          <tr>
                              <td>衣服&nbsp;:<input type="text" size="20"  value =<?php echo isset($list[2][19])?$list[2][19]:'';echo isset($list[2][17])?'等级：'.$list[2][17]:'';echo isset($list[2][25])?'品质：'.$list[2][25]:''?>></td>
                              <td>靴子&nbsp;:<input type="text" size="20"  value =<?php echo isset($list[3][19])?$list[3][19]:'';echo isset($list[3][17])?'等级：'.$list[3][17]:'';echo isset($list[3][25])?'品质：'.$list[3][25]:''?>></td>
                              <td>披风&nbsp;:<input type="text" size="20"  value =<?php echo isset($list[4][19])?$list[4][19]:'';echo isset($list[4][17])?'等级：'.$list[4][17]:'';echo isset($list[4][25])?'品质：'.$list[4][25]:''?>></td>
                              <td>项链&nbsp;:<input type="text" size="20"  value =<?php echo isset($list[5][19])?$list[5][19]:'';echo isset($list[5][17])?'等级：'.$list[5][17]:'';echo isset($list[5][25])?'品质：'.$list[5][25]:''?>></td>
                          </tr>
                          <tr>
                             <td>秘籍1:&nbsp;:<input type="text" size="10"   value =<?php echo isset($parter_booklist[1])?$parter_booklist[1]:'';echo isset($parter_booklist[2])?'等级:'.$parter_booklist[2]:''?>></td>
                             <td>秘籍2:&nbsp;:<input type="text" size="10"   value =<?php echo isset($parter_booklist[5])?$parter_booklist[5]:'';echo isset($parter_booklist[6])?'等级:'.$parter_booklist[6]:''?>></td>
                             <td>秘籍3:&nbsp;:<input type="text" size="10"   value =<?php echo isset($parter_booklist[9])?$parter_booklist[9]:'';echo isset($parter_booklist[10])?'等级:'.$parter_booklist[10]:''?>></td>
                             <td>秘籍4:&nbsp;:<input type="text" size="10"   value =<?php echo isset($parter_booklist[13])?$parter_booklist[13]:'';echo isset($parter_booklist[14])?'等级:'.$parter_booklist[14]:''?>></td>
                          </tr>
                          <tr>
                             <td>秘籍5:&nbsp;:<input type="text" size="10"   value =<?php echo isset($parter_booklist[17])?$parter_booklist[17]:'';echo isset($parter_booklist[18])?'等级:'.$parter_booklist[18]:''?>></td>
                             <td>秘籍6:&nbsp;:<input type="text" size="10"   value =<?php echo isset($parter_booklist[21])?$parter_booklist[21]:'';echo isset($parter_booklist[22])?'等级:'.$parter_booklist[22]:''?>></td>
                             <td>秘籍7:&nbsp;:<input type="text" size="10"   value =<?php echo isset($parter_booklist[25])?$parter_booklist[25]:'';echo isset($parter_booklist[26])?'等级:'.$parter_booklist[26]:''?>></td>
                             <td>秘籍8:&nbsp;:<input type="text" size="10"   value =<?php echo isset($parter_booklist[29])?$parter_booklist[29]:'';echo isset($parter_booklist[30])?'等级:'.$parter_booklist[30]:''?>></td>
                          </tr>
                        </table>
                </div>
            </div>
        </div>
    </div>
</div>
