<div id="page_body">
    <div id="page_title">
        <?php
        $this->widget('zii.widgets.CBreadcrumbs', array('links' => array(
                '事务审批',
                $title,
                )));
        ?>
    </div>

    <div class="main-box">
        <div class="main-body">
            <div class="main-container">
                <header>
                    <div class="right">
                        <?php echo Html5::link('添加流程', array('/approve/default/addflow'), array('class' => 'js-dialog-link')); ?>
                    </div>
                </header>
                <div class="main-content">
                    <div class="grid-view">
                        <table class="normal">
                            <thead>
                                <tr>
                                    <th class="span2">编号</th>
                                    <th class="span2">标签</th>
                                    <th class="span3">名称</th>
                                    <th>节点</th>
                                    <th>描述</th>
                                    <th class="span2">状态</th>
                                    <th class="span4">创建时间</th>
                                    <th class="span4">操作</th>
                                </tr>
                            </thead>
                            <tbody>
                        <?php
                            if (count($list)) {
                        ?>
                                
                                <?php foreach ($list as $k => $v): ?>
                                    <tr>
                                        <td><?php echo $k + 1; ?></td>
                                        <td><?php echo $v['tag']; ?></td>
                                        <td><?php echo $v['name']; ?></td>
                                        <td><?php echo WorkFlow::getNodeInfo($v->id); ?></td>
                                        <td><?php echo $v['desc']; ?></td>
                                        <td><?php echo $model->getStatus($v['status']); ?></td>
                                        <td><?php echo date('Y-m-d H:i:s', $v['create_time']); ?></td>
                                        <td>
                                            <?php
                                            echo Html5::link('添加节点', array('/approve/default/addnode', 'id' => $v['id']), array('class' => 'js-dialog-link')) . ' ' .
                                            Html5::link('删除', array('/approve/default/deleteflow', 'id' => $v['id']), array(
                                                'class' => 'js-confirm-link', 'data-title' => "您确定要删除当前流程吗？"));
                                            ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                                <tr>
                                    <td colspan="6"> <div class="pager"><?php $this->widget('CLinkPager', array('pages' => $pages));?> </div></td>
                                </tr>
                        <?php
                            }else {
                        ?>
                                <tr>
                                    <td  colspan="6">暂无流程!</td>
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