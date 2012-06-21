<?php 
    Yii::app()->clientScript->registerCoreScript('jquery.ui');
    Yii::app()->clientScript->registerCoreScript('platform');;
    $form = $this->beginWidget('ActiveForm', array('id' => 'gift_form'));
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
        <?php echo $form->labelEx($model, 'role_id'); ?>
        <div class="item">
            <div class="main">
                <?php echo $form->textField($model, 'role_id'); ?>
            </div>
        </div>
        <?php echo $form->error($model, 'role_id'); ?>
    </div>
</div>

<div class="clearfix">
    <div class="cell">
        <?php echo $form->labelEx($model, 'name'); ?>
        <div class="item">
            <div class="main">
                <?php echo $form->textField($model, 'name'); ?>
            </div>
        </div>
        <?php echo $form->error($model, 'name'); ?>
    </div>
</div>

<div class="clearfix">
    <div class="cell">
        <?php echo $form->labelEx($model, 'item_id'); ?>
        <div class="item">
            <div class="main">
                <?php echo $form->textField($model, 'item_id'); ?>
            </div>
        </div>
        <?php echo $form->error($model, 'item_id'); ?>
    </div>
</div>

<div class="clearfix">
    <div class="cell">
        <?php echo $form->labelEx($model, 'num'); ?>
        <div class="item">
            <div class="main">
                <?php echo $form->textField($model, 'num'); ?>
            </div>
        </div>
        <?php echo $form->error($model, 'num'); ?>
    </div>
</div>

<div class="clearfix">
    <div class="cell">
        <?php echo $form->labelEx($model, 'time'); ?>
        <div class="item">
            <div class="main">
                <?php echo $form->textField($model, 'time'); ?>
            </div>
        </div>
        <?php echo $form->error($model, 'time'); ?>
    </div>
</div>

<div class="actions">
    <button type="submit" id="save" name="save">提交</button>
</div>

<?php $this->endWidget(); ?>
