<?php
    Yii::app()->clientScript->registerCoreScript('jquery.ui');
    Yii::app()->clientScript->registerCoreScript('platform');;
    $form = $this->beginWidget('ActiveForm', array('id' => 'node_form'));
?>

<div class="clearfix">
    <div class="cell">
        <?php echo $form->labelEx($model, 'flow_id'); ?>
        <div class="item">
            <div class="main">
                <?php echo $form->dropDownList($model, 'flow_id', $flow_list, array('class' => 'medium')); ?>
            </div>
        </div>
    </div>
</div>

<div class="clearfix">
    <div class="cell">
        <?php echo $form->labelEx($model, 'name'); ?>
        <div class="item">
            <div class="main">
                <?php echo $form->textField($model, 'name'); ?>
            </div>
            <?php echo $form->error($model, 'name'); ?>
        </div>
    </div>
</div>

<div class="clearfix">
    <div class="cell">
        <?php echo $form->labelEx($model, 'user_id'); ?>
        <div class="item">
            <div class="main">
                <?php echo $form->dropDownList($model, 'user_id', $user_list, array('class' => 'medium')); ?>
            </div>
        </div>
    </div>
</div>


<input type="hidden" id="node_id" name="Node[id]" value="<?php echo $model->isNewRecord ? 0 : $model->id; ?>" />

<div class="actions">
    <button type="submit">提交</button>
</div>

<?php $this->endWidget(); ?>
