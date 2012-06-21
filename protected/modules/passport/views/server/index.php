<div id="page_body">
<div id="page_title">
    <?php
        require dirname(__FILE__) . '/_menu.php';
    ?>
</div>

<div class="main-box">
    <div class="main-body">
        
        <div class="main-container">
            <header>
                <div class="right">
                    <?php echo Html5::link('添加服务器', array('/passport/server/addServer'), array('class' => 'js-dialog-link')); ?>
                </div>
            </header>
            <div class="main-content">
                <div class="grid-view">
                    <table>
                        <thead>
                            <tr>
                                <th class="span2">游戏名</th>
                                <th class="span2">服务器名字</th>
                                <th class="span3">开服时间</th>
                                <th class="span2">服务器状态</th>
                                <th class="span2">是否推荐</th>
                                <th class="span2">服务器类型</th>
                                <th class="span2">数据库IP</th>
                                <th class="span2">数据库端口</th>
                                <th class="span2">数据库名字</th>
                                <th class="span2">账号</th>
                                <th class="span2">密码</th>
                                <th class="span3">web服务器IP</th>
                                <th class="span2">socket端口</th>
                                <th class="span2">操作</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                if (count($list)) {
                                    foreach ($list as $k => $v) {
                                       
                            ?>
                                        <tr> 
                                            <td><?php echo $v->gname; ?></td>
                                            <td><?php echo $v->sname; ?></td>
                                            <td><?php echo $v->create_time; ?></td>
                                            <td><?php echo $model->getServerStatus($v->status); ?></td>
                                            <td><?php echo $model->getServerRecommend($v->recommend); ?></td>
                                            <td><?php echo $model->getServerType($v->type); ?></td>
                                            <td><?php echo $v->db_ip; ?></td>
                                            <td><?php echo $v->db_port; ?></td>
                                            <td><?php echo $v->db_name; ?></td>
                                            <td><?php echo $v->db_user; ?></td>
                                            <td><?php echo $v->db_passwd; ?></td>
                                            <td><?php echo $v->web_ip; ?></td>
                                            <td><?php echo $v->web_socket_port; ?></td>
                                            <td>
                                                    <?php
                                                    echo Html5::link('编辑', array('/passport/server/updateserver', 'id' => $v->id), array('class' => 'js-dialog-link', 'data-width' => 600, 'data-height' => 600)) . ' ' .
                                                    Html5::link('删除', array('/passport/server/deleteserver', 'id' => $v->id), array('class' => 'js-confirm-link', 'data-title' => "您确定要删除当前服务器吗？"));
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
