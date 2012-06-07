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
                    <a data-url="<?php echo $this->createUrl('/passport/role/addrole'); ?>" data-title="添加角色" href="javascript:void(0);">添加角色</a>
                </div>
            </header>
            <div class="main-content">
                <div class="grid-view">
                    <table>
                        <thead>
                            <tr>
                                <th class="span3">序号</th>
                                <th class="span5">名称</th>
                                <th class="span4">类型</th>
                                <th class="span10">描述</th>
                                <th class="span5">创建时间</th>
                                <th class="span4">操作</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                if (count($list)) {
                                    foreach ($list as $k => $v) {
                                        $group = RoleGroup::model()->findByAttributes(array('id' => floatval($v->group_id)));
                            ?>
                                        <tr>
                                            <td><?php echo $v->id; ?></td>
                                            <td><?php echo $v->name; ?></td>
                                            <td><?php echo $group->name; ?></td>
                                            <td><?php echo $v->desc; ?></td>
                                            <td><?php echo date("Y-m-d H:i:s", $v->create_time); ?></td>
                                            <td>
                                                <a href="javascript:void(0);" class="op" data-act="delete" data-id="<?php echo $v->id; ?>">删除</a>
                                                <a href="javascript:void(0);" class="op" data-act="update" data-id="<?php echo $v->id; ?>">编辑</a>
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

<script>
    jQuery(function($) {
        $(".op").click(function(){
            var id = $(this).data('id');
            var act = $(this).data('act');
            if('delete' == act){
                $.ajax({
                    type: "POST",
                    dataType: 'JSON',
                    url: '/passport/role/deleterole?id=' + id,
                    success: function(json){
                        Dialog.alert(json.msg);
                        location.href = location.href;
                    },
                    error: function(xhr, status, err) {
                        Dialog.alert('请求的地址错误。');
                    }
                });
            }else{
                var url = '/passport/role/updaterole?id=' + id;
                $.urlDialog(url, '编辑角色');
            }
        });
        $(".right a").click(function(){
            var url = $(this).data('url');
            var title = $(this).data('title');
            $.urlDialog(url, title);
        });
    });
</script>
