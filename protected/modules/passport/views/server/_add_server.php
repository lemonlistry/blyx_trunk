<?php 
    Yii::app()->clientScript->registerCoreScript('jquery.ui');
    Yii::app()->clientScript->registerCoreScript('platform');;
    $form = $this->beginWidget('ActiveForm', array('id' => 'server_form'));
?>
 
<div class="clearfix">
    <div class="cell">
		<?php echo $form->labelEx($model, 'gname'); ?>
        <div class="item">
            <div class="main">
                <?php echo $form->textField($model, 'gname'); ?>
            </div>
        </div>
        <?php echo $form->error($model, 'gname'); ?>
    </div>
</div>

<div class="clearfix">
    <div class="cell">
        <?php echo $form->labelEx($model, 'sname'); ?>
        <div class="item">
            <div class="main">
                <?php echo $form->textField($model, 'sname'); ?>
            </div>
        </div>
        <?php echo $form->error($model, 'sname'); ?>
    </div>
</div>

<div class="clearfix">
    <div class="cell">
        <?php echo $form->labelEx($model, 'create_time'); ?>
        <div class="item">
            <div class="main">
                <?php echo Html5::timeField('Server[create_time]',$model->create_time, array('id' => 'Server_create_time')); ?>
            </div>
        </div>
        <?php echo $form->error($model, 'create_time'); ?>
    </div>
</div>

<div class="clearfix">
    <div class="cell">
        <?php echo $form->labelEx($model, 'status'); ?>
        <div class="item">
            <div class="main">
                <?php echo $form->textField($model, 'status'); ?>
            </div>
        </div>
        <?php echo $form->error($model, 'status'); ?>
    </div>
</div>

<div class="clearfix">
    <div class="cell">
        <?php echo $form->labelEx($model, 'recommend'); ?>
        <div class="item">
            <div class="main">
                <?php echo $form->textField($model, 'recommend'); ?>
            </div>
        </div>
        <?php echo $form->error($model, 'recommend'); ?>
    </div>
</div>

<div class="clearfix">
    <div class="cell">
        <?php echo $form->labelEx($model, 'type'); ?>
        <div class="item">
            <div class="main">
                <?php echo $form->textField($model, 'type'); ?>
            </div>
        </div>
        <?php echo $form->error($model, 'type'); ?>
    </div>
</div>

<div class="clearfix">
    <div class="cell">
        <?php echo $form->labelEx($model, 'db_ip'); ?>
        <div class="item">
            <div class="main">
                <?php echo $form->textField($model, 'db_ip'); ?>
            </div>
        </div>
        <?php echo $form->error($model, 'db_ip'); ?>
    </div>
</div>

<div class="clearfix">
    <div class="cell">
        <?php echo $form->labelEx($model, 'db_port'); ?>
        <div class="item">
            <div class="main">
                <?php echo $form->textField($model, 'db_port'); ?>
            </div>
        </div>
        <?php echo $form->error($model, 'db_port'); ?>
    </div>
</div>

<div class="clearfix">
    <div class="cell">
        <?php echo $form->labelEx($model, 'db_name'); ?>
        <div class="item">
            <div class="main">
                <?php echo $form->textField($model, 'db_name'); ?>
            </div>
        </div>
        <?php echo $form->error($model, 'db_name'); ?>
    </div>
</div>

<div class="clearfix">
    <div class="cell">
        <?php echo $form->labelEx($model, 'db_user'); ?>
        <div class="item">
            <div class="main">
                <?php echo $form->textField($model, 'db_user'); ?>
            </div>
        </div>
        <?php echo $form->error($model, 'db_user'); ?>
    </div>
</div>

<div class="clearfix">
    <div class="cell">
        <?php echo $form->labelEx($model, 'db_passwd'); ?>
        <div class="item">
            <div class="main">
                <?php echo $form->textField($model, 'db_passwd'); ?>
            </div>
        </div>
        <?php echo $form->error($model, 'db_passwd'); ?>
    </div>
</div>

<div class="clearfix">
    <div class="cell">
        <?php echo $form->labelEx($model, 'script'); ?>
        <div class="item">
            <div class="main">
                <?php echo $form->textField($model, 'script'); ?>
            </div>
        </div>
        <?php echo $form->error($model, 'script'); ?>
    </div>
</div>
     
<div class="clearfix">
    <div class="cell">
        <?php echo $form->labelEx($model, 'web_ip'); ?>
        <div class="item">
            <div class="main">
                <?php echo $form->textField($model, 'web_ip'); ?>
            </div>
        </div>
        <?php echo $form->error($model, 'web_ip'); ?>
    </div>
</div>

<div class="clearfix">
    <div class="cell">
        <?php echo $form->labelEx($model, 'web_socket_port'); ?>
        <div class="item">
            <div class="main">
                <?php echo $form->textField($model, 'web_socket_port'); ?>
            </div>
        </div>
        <?php echo $form->error($model, 'web_socket_port'); ?>
    </div>
</div>

<input type="hidden" id="server_id" name="Server[id]" value="<?php echo $model->isNewRecord ? 0 : $model->id; ?>" />

<div class="actions">
    <input type="submit" value="提交" />
</div>

<?php $this->endWidget(); ?>