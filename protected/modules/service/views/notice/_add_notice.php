<?php 
    Yii::app()->clientScript->registerCoreScript('jquery.ui');
    Yii::app()->clientScript->registerCoreScript('platform');;
    $form = $this->beginWidget('ActiveForm', array('id' => 'notice_form'));
?>

<div class="clearfix">
    <div class="cell">
        <?php echo $form->labelEx($model, 'server_id'); ?>
        <div class="item">
            <div class="main">
                <?php echo $form->dropDownList($model, 'server_id', $select, array('class'=>'medium')); ?>
            </div>
        </div>
        <?php echo $form->error($model, 'server_id'); ?>
    </div>
</div>

<div class="clearfix">
    <div class="cell">
        <?php echo $form->labelEx($model, 'interval_time'); ?>
        <div class="item">
            <div class="main">
                <?php echo $form->textField($model, 'interval_time'); ?>
            </div>
        </div>
        <?php echo $form->error($model, 'interval_time'); ?>
    </div>
</div>

<div class="clearfix">
    <div class="cell">
        <?php echo $form->labelEx($model, 'play_times'); ?>
        <div class="item">
            <div class="main">
                <?php echo $form->textField($model, 'play_times'); ?>
            </div>
        </div>
        <?php echo $form->error($model, 'play_times'); ?>
    </div>
</div>

<div class="clearfix">
    <div class="cell">
        <?php echo $form->labelEx($model, 'content'); ?>
        <div class="item">
            <div class="main">
                <?php echo $form->textField($model, 'content'); ?>
            </div>
        </div>
        <?php echo $form->error($model, 'content'); ?>
    </div>
</div>

<div class="clearfix">
    <div class="cell">
        <?php echo $form->labelEx($model, 'send_time'); ?>
        <div class="item">
            <div class="main">
                <?php echo Html5::timeField('Notice[send_time]', $model->send_time); ?>
            </div>
        </div>
        <?php echo $form->error($model, 'send_time'); ?>
    </div>
</div>

<input type="hidden" id="notice_id" name="Notice[id]" value="<?php echo $model->isNewRecord ? 0 : $model->id; ?>" />
 
<div class="actions">
    <button type="submit" id="save" name="save">提交</button>
</div>

<?php $this->endWidget(); ?>
