<?php 
    Yii::app()->clientScript->registerScriptfile('/source/js/jquery.min.js');
    Yii::app()->clientScript->registerScriptfile('/source/js/zDialog.js');
    $form = $this->beginWidget('ActiveForm', array('id' => 'role_form'));
?>

<div class="clearfix">
    <div class="cell">
        <label>请选择角色类型:</label>
        <div class="item">
            <div class="main">
                <?php echo $form->dropDownList($model, 'group_id', $group_list); ?>
            </div>
        </div>
    </div>
</div>

<div class="clearfix">
    <div class="cell">
        <label>请输入角色名称:</label>
        <div class="item">
            <div class="main">
                <?php echo $form->textField($model, 'name'); ?>
            </div>
        </div>
    </div>
</div>

<div class="clearfix">
    <div class="cell">
        <label>请输入角色描述:</label>
        <div class="item">
            <div class="main">
                <?php echo $form->textField($model, 'desc'); ?>
            </div>
        </div>
    </div>
</div>

<input type="hidden" id="role_id" name="Role[id]" value="<?php echo $model->isNewRecord ? 0 : $model->id; ?>" />

<div class="actions">
    <button type="button" id="save_role" name="save_role">提交</button>
</div>

<?php $this->endWidget(); ?>

<script>
jQuery(function($) {
    $("#save_role").bind('click', function(){
        $("#save_role").prop('disabled',true);
        $.ajax({
            type: "POST",
            dataType: 'JSON',
            url: $('#role_form').action,
            data : $('#role_form').serialize(),
            success: function(json){
                Dialog.alert(json.msg);
                $("#save_role").prop('disabled',false);
                parent.location.href = parent.location.href;
            },
            error: function(xhr, status, err) {
                Dialog.alert('请求的地址错误。');
            }
        });
    });
});
</script>