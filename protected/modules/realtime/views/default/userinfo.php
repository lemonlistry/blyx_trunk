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
            <header>
                <div class="right">
                    <?php 
                        $form = $this->beginWidget('ActiveForm', array('id' => 'userlook', 'method' => 'get', 'action' => '/realtime/default'));
                    ?>
                            <?php 
                                echo Html5::dropDownList('server_group_id', $server_group_id, $select, array('class'=>'span3'));
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
                            <tr>
                                <th class="span7">帐号名</th>
                                <th class="span10">角色名</th>
                                <th class="span13">角色ID</th>
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
</div>
<script>
jQuery(function($) {
    $("#userlook").submit(function(){
        if($.trim($("#server_group_id").val()) == '' ||  $.trim($("#role_name").val()) == ''){
            Dialog.alert('请输入参数');
            return false;
        }
    });
});
</script>
