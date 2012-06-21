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
                <div class="main-content">
                    <div class="grid-view">
                        <table>
                            <thead>
                                <tr>
                                    <th class="span6">流程</th>
                                    <th class="span6">发布人</th>
                                    <th class="span4">状态</th>
                                    <th class="span6">当前流转</th>
                                    <th class="span6">创建时间</th>
                                    <th class="span8">操作</th>
                                </tr>
                            </thead>
                            <tbody id="tbody">
                                <?php
                                    if (count($list)) {
                                ?>
                                    <?php
                                        foreach ($list as $k => $v) {
                                            $flow = Flow::model()->findByAttributes(array('id' => $v->flow_id));
                                    ?>
                                        <tr>
                                            <td><?php echo $flow->name; ?></td>
                                            <td><?php echo Account::user('id', $v->user_id, 'username'); ?></td>
                                            <td><?php echo $model->getStatus($v->status); ?></td>
                                            <td>
                                                <?php 
                                                    $current_node =  WorkFlow::getCurrentNode($v->flow_id, $v->id);
                                                    echo ($v->status == 0 && !empty($current_node)) ? Account::user('id', $current_node->user_id, 'username') : ''; 
                                                ?>
                                            </td>
                                            <td><?php echo date('Y-m-d H:i:s', $v->create_time); ?></td>
                                            <td>
                                                <?php 
                                                    if($v->status == 0 && WorkFlow::verifyAuth($v->flow_id, $v->id)){
                                                        echo Html5::link('审批', array('/approve/default/approve', 'task_id' => $v->id, 'flow_id' => $v->flow_id, 
                                                                 'node_id' => $current_node->id), array('class' => 'js-dialog-link')) . '&nbsp;&nbsp;';
                                                    }
                                                    echo Html5::link('详细信息', array('/approve/default/relateinfo', 'relate_id' => $v->relate_id, 
                                                                 'flow_id' => $v->flow_id), array('class' => 'js-dialog-link')) . '&nbsp;&nbsp;';
                                                    echo Html5::link('审批记录', array('/approve/default/approverecord', 'task_id' => $v->id), array('class' => 'js-dialog-link')) . ' ';
                                                ?>
                                            </td>
                                        </tr>
                                    <?php
                                        }
                                    ?>
                                    <tr>
                                        <td colspan="6"> <div class="pager"><?php $this->widget('CLinkPager', array('pages' => $pages));?> </div></td>
                                    </tr>
                                <?php
                                    } else {
                                ?>
                                    <tr>
                                        <td  colspan="6">暂无事务!</td>
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
