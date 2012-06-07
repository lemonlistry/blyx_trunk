<div id="page_body">
<div id="page_title">
    <?php
        require dirname(__FILE__) . '/_menu.php';
    ?>
</div>

<div class="main-box">
    <div class="main-body">
        <aside class="span5">
            <?php
                $this->widget('zii.widgets.CMenu', array('items' => $menu, 'activeCssClass' => 'selected',
                    'htmlOptions' => array('class' => 'left-menu',)));
            ?>
        </aside>
        <div class="main-container prepend5">
            <div class="main-content">

                <?php 
                    $form = $this->beginWidget('ActiveForm', array('id' => 'userlook', 'method' => 'get', 'action' => '/realtime/default'));
                ?>
                <center>
                    <div class="clearfix">
                            <label>服务器ID:</label>
                            <input type="text" id="server_id" name="server_id" value="<?php echo $server_id;?>" />
                            &nbsp;&nbsp;&nbsp;
                            <label>角色名:</label>
                            <input type="text" id="role_name" name="role_name" value="<?php echo $role_name;?>" />
                            
                            <input type="submit" value='查询' />
                    </div>
                </center>
                
                <br/>                      
                      
                <?php $this->endWidget(); ?>
                
              <table>
              <thead>
                 <tr>
                     <th class="span1">帐号名</th>
                     <th class="span1">角色名</th>
                     <th class="span1">角色ID</th>
                 </tr>
              </thead>
              <tbody>
                            <?php 
                               if (count($list)) {
                                    foreach ($list as $k => $v) {
                            ?>
                                        <tr>
                                            <td><?php echo $v['user_account']; ?></td>
                                            <td><?php echo $v['role_name']; ?></td>
                                            <td><?php echo $v['role_id']; ?></td>
                                        </tr>
                            <?php 
                                    } 
                               }else { 
                            ?>
                                    <tr>
                                        <td colspan="6">暂无数据!</td>
                                    </tr>
                            <?php 
                                } 
                            ?>
              </tbody>
            </table>
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
