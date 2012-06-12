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
                    $form = $this->beginWidget('ActiveForm', array('id' => 'online_notice'));
                ?>
                
                <div class="clearfix">
                    <div class="cell">
                        <label>请选择服务器:</label>
                        <div class="item">
                            <div class="main">
                                <?php 
                                    echo Html5::dropDownList('server_id', '', $select, array('class'=>'span3'));
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="clearfix">
                    <div class="cell">
                        <label>请输入间隔时间:</label>
                        <div class="item">
                            <div class="main">
                                <input type="text" id="interval_time" name="interval_time" value="3" />
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="clearfix">
                    <div class="cell">
                        <label>请输入播放次数:</label>
                        <div class="item">
                            <div class="main">
                                <input type="text" id="playtimes" name="playtimes" value="1" />
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="clearfix">
                    <div class="cell">
                        <label>请输入播放内容:</label>
                        <div class="item">
                            <div class="main">
                                <input type="text" id="notice_content" name="notice_content" value="test" />
                            </div>
                        </div>
                    </div>
                </div>
                 
                <div class="actions">
                    <button type="button" id="save" name="save">提交</button>
                </div>
                
                <?php $this->endWidget(); ?>

            </div>
        </div>
    </div>
</div>
</div>

<script>
    jQuery(function($) {
        $("#save").click(function(){
            if(!$("#server_id").val()){
                Dialog.alert('请选择服务器');
                return false;
            }
            $("#save").prop('disabled',true);
            $.ajax({
                type: "POST",
                dataType: 'JSON',
                url: this.action,
                data : $('#online_notice').serialize(),
                success: function(json){
                    Dialog.alert(json.msg);
                    $("#save").prop('disabled',false);
                },
                error: function(xhr, status, err) {
                    Dialog.alert('请求的地址错误。');
                }
            });
        });
    });
</script>
