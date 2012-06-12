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
                    $form = $this->beginWidget('ActiveForm', array('id' => 'send_award'));
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
                        <label>请输入角色ID:</label>
                        <div class="item">
                            <div class="main">
                                <input type="text" id="role_id" name="role_id" value="33044" />
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="clearfix">
                    <div class="cell">
                        <label>请输入礼包名称:</label>
                        <div class="item">
                            <div class="main">
                                <input type="text" id="award_name" name="award_name" value="" />
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="clearfix">
                    <div class="cell">
                        <label>请输入时间:</label>
                        <div class="item">
                            <div class="main">
                                <input type="text" id="time" name="time" value="<?php echo date('Y-m-d H:i:s'); ?>" />
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="clearfix">
                    <div class="cell">
                        <label>请输入物品ID:</label>
                        <div class="item">
                            <div class="main">
                                <input type="text" id="item_id" name="item_id" value="" />
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="clearfix">
                    <div class="cell">
                        <label>请输入数量:</label>
                        <div class="item">
                            <div class="main">
                                <input type="text" id="num" name="num" value="1" />
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
                data : $('#send_award').serialize(),
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
