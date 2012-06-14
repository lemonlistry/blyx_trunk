<div id="page_body">
<div id="page_title">
    <?php
        require dirname(__FILE__) . '/_menu.php';
    ?>
</div>
<style type="text/css">
.tableborder{border:0px; border-collapse:collapse;} 
.tableborder td{border-top:1px #666 solid;border-right:1px #666 solid;} 
.tableborder{border-bottom:1px #666 solid;border-left:1px #666 solid;}
</style>
<div class="main-box">
    <div class="main-body">
        <aside class="span5">
            <?php
                $this->widget('zii.widgets.CMenu', array('items' => $menu, 'activeCssClass' => 'selected',
                    'htmlOptions' => array('class' => 'left-menu',)));
            ?>
        </aside>
        <div class="main-container prepend5">
            <header>
                <div class="right">
                    <?php 
                        $form = $this->beginWidget('ActiveForm', array('id' => 'userlook', 'method' => 'get', 'action' => $this->createUrl('/realtime/default')));
                    ?>
                            <?php 
                                echo Html5::dropDownList('server_id', $server_id, $select, array('class'=>'span3'));
                            ?>
                            <label>角色名:</label>
                             <?php 
                                 echo Html5::textField('role_name', $role_name, array('size'=>10));
                             ?>
                             <input type="submit" value="查询" />
                 
                     <?php $this->endWidget(); ?>
                </div>
            </header>
            <div class="main-content">
                <div class="grid-view">
                    <table>
                        <thead>
                                <th align = "left"><font size="5" face ="隶书">角色基本信息</font></th>
                        </thead>
                    </table>
                    <table class='tableborder'>
                         <tr>
                             <td>角色ID&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:
                                  <input type="text" size = 20  id=""  value = <?php echo isset($list['role_id'])?$list['role_id']:''?> >
                             </td>
                             <td>创建IP&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:
                                 <input type="text" size = 20  id=""  value ="" />
                             </td>
                             <td>黄钻信息&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:<input type="text" size = 20  id=""  value =""></td>
                         </tr>
                          <tr>
                             <td>账号名&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:
                                 <input type="text" size = 20  id=""  value =<?php echo isset($list['user_account'])?$list['user_account']:''?>>
                             </td>
                             <td>最后登录时间&nbsp;:<input type="text" size = 20  id=""  value =""></td>
                             <td>首次充值时间&nbsp;:<input type="text" size = 20  id=""  value =""></td>
                         </tr>
                          <tr>
                             <td>账号创建时间&nbsp;:<input type="text" size = 20  id=""  value =""></td>
                             <td>最后登录IP&nbsp;&nbsp;&nbsp;&nbsp;:<input type="text" size = 20  id=""  value =""></td>
                             <td>首次充值金额&nbsp;:<input type="text" size = 20  id=""  value =""></td>
                         </tr>
<!--                          <tr>-->
<!--                             <td>账号创建城市&nbsp;	:<input type="text" size = 20  id=""  value =""></td>-->
<!--                             <td>最后登录城市&nbsp;:<input type="text" size = 20  id=""  value =""></td>-->
<!--                             <td>在线状态&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:-->
<!--                                <input type="text" size = 20  id=""  value =''?>-->
<!--                             </td>-->
<!--                         </tr>-->
                    </table>
                    <br>
                    <table>
                        <thead>
                                <th align = "left"><font size="5" face ="隶书">状态信息</font></th>
                        </thead>
                    </table>
                    <br>
                    <table>
                       <tr>
                        <td>
                        <table class='tableborder'>
                                 <tr><td>角色名&nbsp;:<input type="text" size = 10  id=""  value =<?php echo isset($list['role_name'])?$list['role_name']:''?> ></td></tr>
                                 <tr><td>等级&nbsp;&nbsp;&nbsp;:<input type="text" size = 10  id=""  value =<?php echo isset($list['role_level'])?$list['role_level']:''?> ></td></tr>
                                 <tr><td>声望&nbsp;&nbsp;&nbsp;:<input type="text" size = 10  id=""  value =<?php echo isset($list['role_reputation'])?$list['role_reputation']:''?> ></td></tr>
                                 <tr><td>门派&nbsp;&nbsp;&nbsp;:<input type="text" size = 10  id=""  value =<?php echo isset($list['clan'])?$list['clan']:''?> ></td></tr>
                                 <tr><td>属性&nbsp;&nbsp;&nbsp;:<input type="text" size = 10  id=""  value =<?php echo isset($list['clan'])?$list['clan']:''?> ></td></tr>
                                 <tr><td>武学&nbsp;&nbsp;&nbsp;:<input type="text" size = 10  id=""  value =<?php echo isset($list['skill'])?$list['skill']:''?> ></td></tr>
                                 <tr><td>职业&nbsp;&nbsp;&nbsp;:<input type="text" size = 10  id=""  value =<?php echo isset($list['career'])?$list['career']:''?> ></td></tr>
                                 <tr><td>称号&nbsp;&nbsp;&nbsp;:<input type="text" size = 10  id=""  value =<?php echo isset($list['title'])?$list['title']:''?> ></td></tr>
                                 <tr><td>帮派&nbsp;&nbsp;&nbsp;:<input type="text" size = 10  id=""  value =<?php echo isset($list['faction'])?$list['faction']:''?>  ></td></tr>
                        </table> 
                        </td>
                        <td>
                        <table class='tableborder'> 
                             <tr><td>生命&nbsp;:<input type="text" size = 7  id=""  value =<?php echo isset($list['hp'])?$list['hp']:''?> ></td></tr>
                             <tr><td>筋骨&nbsp;:<input type="text" size = 7  id=""  value =<?php echo isset($list['muscle'])?$list['muscle']:''?> ></td></tr>
                             <tr><td>心法&nbsp;:<input type="text" size = 7  id=""  value =<?php echo isset($list['spirit'])?$list['spirit']:''?> ></td></tr>
                             <tr><td>悟性&nbsp;:<input type="text" size = 7  id=""  value =<?php echo isset($list['aptitude'])?$list['aptitude']:''?> ></td></tr>
                             <tr><td>礼金&nbsp;:<input type="text" size = 7  id=""  value =<?php echo isset($list['gift'])?$list['gift']:''?> ></td></tr>
                             <tr><td>银两&nbsp;:<input type="text" size = 7 id=""  value =<?php echo isset($list['silver'])?$list['silver']:''?> ></td></tr>
                             <tr><td>黄金&nbsp;:<input type="text" size = 7  id=""  value =<?php echo isset($list['gold'])?$list['gold']:''?> ></td></tr>
                             <tr><td>精气&nbsp;:<input type="text" size = 7  id=""  value =<?php echo isset($list['vitality'])?$list['vitality']:''?> ></td></tr>
                             <tr><td>H P&nbsp;:<input type="text" size = 7  id=""  value =<?php echo isset($list['hp'])?$list['hp']:''?> ></td></tr>
                        </table>
                        </td>
                        <td>
                        <table class='tableborder'> 
                             <tr><td>武器&nbsp;:<input type="text" size = 20  id=""  value =<?php echo isset($list['equip0'])?$list['equip0']:''?>></td></tr>
                             <tr><td>头盔&nbsp;:<input type="text" size = 20  id=""  value =<?php echo isset($list['equip1'])?$list['equip1']:''?>></td></tr>
                             <tr><td>衣服&nbsp;:<input type="text" size = 20  id=""  value =<?php echo isset($list['equip2'])?$list['equip2']:''?>></td></tr>
                             <tr><td>靴子&nbsp;:<input type="text" size = 20  id=""  value =<?php echo isset($list['equip3'])?$list['equip3']:''?>></td></tr>
                             <tr><td>披风&nbsp;:<input type="text" size = 20  id=""  value =<?php echo isset($list['equip4'])?$list['equip4']:''?>></td></tr>
                             <tr><td>项链&nbsp;:<input type="text" size = 20  id=""  value =<?php echo isset($list['equip5'])?$list['equip5']:''?>></td></tr>
                             <tr><td>地图&nbsp;:<input type="text" size = 20  id=""  value =<?php echo isset($list['map'])?$list['map']:''?> ></td></tr>
                             <tr><td>坐标&nbsp;:<input type="text" size = 20  id=""  value =<?php echo isset($list['where'])?$list['where']:''?> ></td></tr>
                             <tr><td>战斗力:<input type="text" size = 20  id=""  value =<?php echo isset($list['role_fightpower'])?$list['role_fightpower']:''?> ></td></tr>
                             
                        </table>    
                        </td>
                        <td>
                        <table class='tableborder'> 
                             <tr><td>秘籍1:&nbsp;<input type="text" size = 10  id=""  value =<?php echo isset($list['book0'])?$list['book0']:''?>></td></tr>
                             <tr><td>秘籍2:&nbsp;:<input type="text" size = 10  id=""  value =<?php echo isset($list['book1'])?$list['book1']:''?>></td></tr>
                             <tr><td>秘籍3:&nbsp;:<input type="text" size = 10  id=""  value =<?php echo isset($list['book2'])?$list['book2']:''?>></td></tr>
                             <tr><td>秘籍4:&nbsp;:<input type="text" size = 10  id=""  value =<?php echo isset($list['book3'])?$list['book3']:''?>></td></tr>
                             <tr><td>秘籍5:&nbsp;:<input type="text" size = 10  id=""  value =<?php echo isset($list['book4'])?$list['book4']:''?>></td></tr>
                             <tr><td>秘籍6:&nbsp;:<input type="text" size = 10  id=""  value =<?php echo isset($list['book5'])?$list['book5']:''?>></td></tr>
                             <tr><td>秘籍7:&nbsp;:<input type="text" size = 10  id=""  value =<?php echo isset($list['book6'])?$list['book6']:''?>></td></tr>
                             <tr><td>秘籍8:&nbsp;:<input type="text" size = 10  id=""  value =<?php echo isset($list['book7'])?$list['book7']:''?>></td></tr>
                             <tr><td>学识&nbsp;:&nbsp;:<input type="text" size = 10  id=""  value =<?php echo isset($list['know'])?$list['know']:''?>></td></tr>
                        </table>
                        </td>
                        <td>
                        <table class='tableborder'> 
                             <tr><td>阳维脉:&nbsp;<input type="text" size = 10  id=""  value =<?php echo isset($list['473011'])?$list['473011']:''?>></td></tr>
                             <tr><td>阴维脉:&nbsp;:<input type="text" size = 10  id=""  value =<?php echo isset($list['473012'])?$list['473012']:''?>></td></tr>
                             <tr><td>阳跷脉:&nbsp;:<input type="text" size = 10  id=""  value =<?php echo isset($list['473013'])?$list['473013']:''?>></td></tr>
                             <tr><td>阴跷脉:&nbsp;:<input type="text" size = 10  id=""  value =<?php echo isset($list['473014'])?$list['473014']:''?>></td></tr>
                             <tr><td>带脉:&nbsp;:<input type="text" size = 10  id=""  value =<?php echo isset($list['473015'])?$list['473015']:''?>></td></tr>
                             <tr><td>冲脉:&nbsp;:<input type="text" size = 10  id=""  value =<?php echo isset($list['473016'])?$list['473016']:''?>></td></tr>
                             <tr><td>督脉:&nbsp;:<input type="text" size = 10  id=""  value =<?php echo isset($list['473017'])?$list['473017']:''?>></td></tr>
                             <tr><td>任脉:&nbsp;:<input type="text" size = 10  id=""  value =<?php echo isset($list['473018'])?$list['473018']:''?>></td></tr>
                             <tr><td>修为:&nbsp;:<input type="text" size = 10  id=""  value =<?php echo isset($list['know'])?$list['know']:''?>></td></tr>
                        </table>
                        </td>
                        <td> 
                        <table class='tableborder'> 
                             <tr><td>阵法1:&nbsp;<input type="text" size = 10  id=""  value =""></td></tr>
                             <tr><td>阵法2:&nbsp;:<input type="text" size = 10  id=""  value =""></td></tr>
                             <tr><td>阵法3:&nbsp;:<input type="text" size = 10  id=""  value =""></td></tr>
                             <tr><td>阵法4:&nbsp;:<input type="text" size = 10  id=""  value =""></td></tr>
                             <tr><td>阵法5:&nbsp;:<input type="text" size = 10  id=""  value =""></td></tr>
                             <tr><td>阵法6:&nbsp;:<input type="text" size = 10  id=""  value =""></td></tr>
                             <tr><td>阵法7:&nbsp;:<input type="text" size = 10  id=""  value =""></td></tr>
                             <tr><td>阵法8:&nbsp;:<input type="text" size = 10  id=""  value =""></td></tr>
                             <tr><td>待定:&nbsp;:<input type="text" size = 10  id=""  value =""></td></tr>
                        </table>       
                        </td>
                       </tr>
                     </table>
                     <br>
                     <table>
                        <thead>
                                <th align = "left"><font size="5" face ="隶书">伙伴信息</font></th>
                        </thead>
                     </table>
                     <div align="center">
                         <font size="4" face ="隶书">
                                <?php 
                                  if(count($list)){
                                     foreach ($list['parter'] as $k => $v){
                                     echo Html5::link($v, array('/realtime/default/attribute','parter_id' => isset($v)?$v:'','server_id' => isset($server_id)?$server_id:''), array('class' => 'js-dialog-link'));
                                     echo "&nbsp;&nbsp;&nbsp;";
                                     }
                                  }
                                ?>
                          </font>
                      </div>
                      <br>
                      <div align="center">
                          <font size="5" face ="隶书">
                                <?php echo Html5::link('角色特殊信息', array('/realtime/default/attribute','role_id' => isset($list["role_id"])?$list["role_id"]:'','server_id' => isset($server_id)?$server_id:''), array('class' => 'js-dialog-link')); ?>
                                <?php echo Html5::link('背包秘籍', array('/realtime/default/bag','role_id' => isset($list["role_id"])?$list["role_id"]:'','server_id' => isset($server_id)?$server_id:''), array('class' => 'js-dialog-link')); ?>
                          </font>
                      </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div> 
<script>
jQuery(function($) {
    $("#userlook").submit(function(){
        if($.trim($("#server_id").val()) == '' ||  $.trim($("#role_name").val()) == ''){
            Dialog.alert('请输入参数');
            return false;
        }
    });
});
</script>
