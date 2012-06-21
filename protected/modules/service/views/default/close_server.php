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
                    $form = $this->beginWidget('ActiveForm', array('id' => 'close_server'));
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
                        <label>请输入验证码:</label>
                        <div class="item" style="margin-top: -15px;">
                            <div class="main">
                                <?php 
                                    echo Html5::textField('code', '', array('style' => 'float:left; margin-top:15px; '));  $this->widget('CCaptcha'); 
                                ?>
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
            if(!$("#code").val()){
                Dialog.alert('请输入验证码');
                return false;
            }
            $("#save").prop('disabled',true);
            $.ajax({
                type: "POST",
                dataType: 'JSON',
                url: this.action,
                data : $('#close_server').serialize(),
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
