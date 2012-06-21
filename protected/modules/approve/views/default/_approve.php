<?php
    Yii::app()->clientScript->registerCoreScript('jquery.ui');
    Yii::app()->clientScript->registerCoreScript('platform');;
    $form = $this->beginWidget('ActiveForm', array('id' => 'approve_form'));
?>

<div class="clearfix">
    <div class="cell">
        <?php echo $form->labelEx($model, 'status'); ?>
        <div class="item">
            <div class="main">
                <?php echo $form->dropDownList($model, 'status', $model->getStatus(), array('class' => 'medium')); ?>
            </div>
        </div>
    </div>
</div>

<div class="clearfix">
    <div class="cell">
        <?php echo $form->labelEx($model, 'comment'); ?>
        <div class="item">
            <div class="main">
                <?php echo $form->textField($model, 'comment', array('class' => 'large')); ?>
            </div>
            <?php echo $form->error($model, 'comment'); ?>
        </div>
    </div>
</div>

<div class="actions">
    <button type="submit">提交</button>
</div>

<?php $this->endWidget(); ?>
