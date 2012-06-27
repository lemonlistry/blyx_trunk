<div id="page_body">
<div id="page_title">
    <?php
        require dirname(__FILE__) . '/../default/_menu.php';
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
                    <?php echo Html5::link('添加礼包', array('/service/gift/addgift'), array('class' => 'js-dialog-link', 'data-height' => 400, 'data-width' => 550)); ?>
                </div>
            </header>
            <div class="main-content">
                <div class="grid-view">
                    <table>
                        <thead>
                            <tr>
                                <th class="span2">编号</th>
                                <th class="span4">服务器</th>
                                <th class="span2">时间</th>
                                <th class="span4">角色ID</th>
                                <th class="span4">礼包名称</th>
                                <th class="span4">物品ID</th>
                                <th class="span2">数量</th>
                                <th class="span2">状态</th>
                                <th class="span4">创建时间</th>
                                <th class="span2">操作</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                if (count($list)) {
                                    foreach ($list as $k => $v) {
                                       $server = Server::model()->findByAttributes(array('id' => $v->server_id));
                            ?>
                                        <tr> 
                                            <td><?php echo $k + 1; ?></td>
                                            <td><?php echo $server->sname; ?></td>
                                            <td><?php echo $v->time; ?></td>
                                            <td><?php echo $v->role_id; ?></td>
                                            <td><?php echo $v->name; ?></td>
                                            <td><?php echo $v->item_id; ?></td>
                                            <td><?php echo $v->num; ?></td>
                                            <td><?php echo $model->getStatus($v->status); ?></td>
                                            <td><?php echo date("Y-m-d H:i:s",$v->create_time); ?></td>
                                            <td>
                                                <?php
                                                    if($v->status == 0){
                                                        echo Html5::link('删除', array('/service/gift/deletegift', 'id' => $v->id), array('class' => 'js-confirm-link', 'data-title' => "您确定要删除当前礼包吗？"));
                                                    }
                                                ?>
                                            </td>
                                        </tr>
                                <?php 
                                    } 
                                ?>
                                    <tr>
                                        <td colspan="6"> <div class="pager"><?php $this->widget('CLinkPager', array('pages'=>$pages));?> </div></td>
                                    </tr>
                            <?php 
                                } else { 
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
