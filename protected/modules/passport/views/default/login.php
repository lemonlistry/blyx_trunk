<?php
    $this->pageTitle=Yii::app()->name . ' - Login';
?>

<div class="form">

    <?php $form = $this->beginWidget('ActiveForm', array('id' => 'login_form')); ?>

    <div class="row">
        <label>username:</label>
        <input type="text" name="user[username]" id="username" />
    </div>

    <div class="row">
        <label>password:</label>
        <input type="text" name="user[password]" id="password" />
    </div>

    <div class="row buttons">
        <input type="submit" name="submit" id="submit" value="submit" />
    </div>
    
    <?php $this->endWidget(); ?>
    
</div>
