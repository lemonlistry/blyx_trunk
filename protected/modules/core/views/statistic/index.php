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
            <?php 
                $form = $this->beginWidget('ActiveForm', array('id' => 'statistic_user_form', 'method' => 'get', 'action' => $this->createUrl('/core/statistic')));
            ?>
            <header>
                <div class="right">
                    <?php 
                        echo Html5::dropDownList('server_id', $param['server_id'], $select, array('class'=>'span3'));
                    ?>
                    <label>开始时间:</label>
                    <?php 
                        echo Html5::timeField('begintime', $param['begintime']);
                    ?>
                    <label>结束时间:</label>
                    <?php 
                        echo Html5::timeField('endtime', $param['endtime']);
                    ?>
                    <input type="submit" value='查询' />
                    <input type="button" value='数据导出' id="data_export" name="data_export"/>
                </div>
            </header>
            <?php $this->endWidget(); ?>
            <div class="main-content">
                <div class="grid-view">
                    <table>
                        <thead>
                            <tr>
                                <th class="span1">范围</th>
                                <th class="span5" colspan="11">截止到当前日期(总账号角色数)</th>
                                <th class="span5" colspan="10">当天新增(新账号角色数)</th>
                            </tr>
                            <tr>
                                <th>日期</th>
                                <th>注册用户数</th>
                                <th>创建角色数</th>
                                <th>开通率</th>
                                <th>今日登录数</th>
                                <th>登录IP数</th>
                                <th>登录角色数</th>
                                <th>登录率</th>
                                <th>≥10级角色数</th>
                                <th>百分比</th>
                                <th>≥30级角色数</th>
                                <th>百分比</th>
                                <th>注册用户数</th>
                                <th>创建角色数</th>
                                <th>今日登录数</th>
                                <th>登录IP数</th>
                                <th>登录角色数</th>
                                <th>登录率</th>
                                <th>≥10级角色数</th>
                                <th>百分比</th>
                                <th>≥30级角色数</th>
                                <th>百分比</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                if (count($list)) {
                                    foreach ($list as $k => $v) {
                            ?>
                                        <tr>
                                            <td><?php echo $v->id; ?></td>
                                            <td><?php echo $v->name; ?></td>
                                            <td><?php echo '' ; ?></td>
                                            <td><?php echo $v->desc; ?></td>
                                            <td><?php echo date("Y-m-d H:i:s", $v->create_time); ?></td>
                                            <td></td>
                                        </tr>
                                <?php 
                                    } 
                                ?>
                                    <tr>
                                        <td colspan="22"> <div class="pager"><?php $this->widget('CLinkPager', array('pages'=>$pages));?> </div></td>
                                    </tr>
                            <?php 
                                } else { 
                            ?>
                                    <tr>
                                        <td colspan="22">暂无数据!</td>
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