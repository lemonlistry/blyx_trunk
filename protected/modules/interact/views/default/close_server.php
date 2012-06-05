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

                <?php 
                    $form = $this->beginWidget('ActiveForm', array('id' => 'close_server'));
                ?>
                
                <div class="clearfix">
                    <div class="cell">
                        <label>请输入服务器IP:</label>
                        <div class="item">
                            <div class="main">
                                <input type="text" id="ip" name="ip" value="<?php echo Yii::app()->params['socket_ip']; ?>" />
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="clearfix">
                    <div class="cell">
                        <label>请输入服务器端口:</label>
                        <div class="item">
                            <div class="main">
                                <input type="text" id="port" name="port" value="<?php echo Yii::app()->params['socket_port']; ?>" />
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
            $("#save").prop('disabled',true);
            $.ajax({
                type: "POST",
                dataType: 'JSON',
                url: this.action,
                data : $('#close_server').serialize(),
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
