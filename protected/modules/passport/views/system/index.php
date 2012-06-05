<div id="page_body">
<div id="page_title">
    <?php
        require dirname(__FILE__) . '../_menu.php';
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
                <div class="grid-view">
                    <table>
                        <thead>
                            <tr>
                                <th class="span3">序号</th>
                                <th class="span5">名称</th>
                                <th class="span18">描述</th>
                                <th class="span5">创建时间</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                if (count($list)) {
                                    foreach ($list as $k => $v) {
                            ?>
                                        <tr>
                                            <td class="td-left">
                                            </td>
                                            <td></td>
                                            <td>
                                            </td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                <?php 
                                    } 
                                ?>
                                    <tr>
                                        <td colspan="6"> <div class="pager"> </div></td>
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
        $("#save").click(function(){
            $("#save").prop('disabled',true);
            $.ajax({
                type: "POST",
                dataType: 'JSON',
                url: this.action,
                data : $('#addrole').serialize(),
                success: function(json){
                    alert(json.msg);
                    $("#save").prop('disabled',false);
                },
                error: function(xhr, status, err) {
                    alert('请求的地址错误。');
                }
            });
        });
    });
</script>
