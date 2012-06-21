<?php
    Yii::app()->clientScript->registerCoreScript('jquery.ui');
    Yii::app()->clientScript->registerCoreScript('platform');;
    $form = $this->beginWidget('ActiveForm', array('id' => 'flow_form'));
?>

<div class="clearfix">
    <div class="cell">
        <?php echo $form->labelEx($model, 'tag'); ?>
        <div class="item">
            <div class="main">
                <?php echo $form->textField($model, 'tag', array('minlength' => 2, 'maxlength' => 10)); ?>
            </div>
            <?php echo $form->error($model, 'tag'); ?>
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
        <?php echo $form->labelEx($model, 'desc'); ?>
        <div class="item">
            <div class="main">
                <?php echo $form->textarea($model, 'desc'); ?>
            </div>
            <?php echo $form->error($model, 'desc'); ?>
        </div>
    </div>
</div>

<input type="hidden" id="flow_id" name="Flow[id]" value="<?php echo $model->isNewRecord ? 0 : $model->id; ?>" />

<div class="actions">
    <button type="submit">提交</button>
</div>

<?php $this->endWidget(); ?>
