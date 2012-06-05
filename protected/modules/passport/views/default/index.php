<?php
$this->breadcrumbs=array(
	$this->module->id,
);
$host = Yii::app()->request->hostInfo;
?>
<h1><?php echo $this->uniqueId . '/' . $this->action->id; ?></h1>

<p>
This is the view content for action "<?php echo $this->action->id; ?>".
The action belongs to the controller "<?php echo get_class($this); ?>" in the "<?php echo $this->module->id; ?>" module.
</p>
<p>
You may customize this page by editing <tt><?php echo __FILE__; ?></tt>
</p>
<p>
GM 禁止玩家登录
request url : <?php echo $host; ?>/interact/default/forbidlogin?seconds=1111&role_id=999
</p>
<p>
GM 禁止玩家聊天
request url : <?php echo $host; ?>/interact/default/forbidchat?seconds=1111&role_id=999
</p>
<p>
GM 允许玩家登录
request url : <?php echo $host; ?>/interact/default/permitlogin?role_id=999
</p>
<p>
GM 允许玩家聊天
request url : <?php echo $host; ?>/interact/default/permitchat?role_id=999
</p>
<p>
GM 发送奖励给玩家
request url : <?php echo $host; ?>/interact/default/sendaward?award_name=xxx&time=111&item_id=222&num=11&role_id=999
</p>
<p>
请求关闭服务器
request url : <?php echo $host; ?>/interact/default/closeserver
</p>
