<?php 
    Yii::app()->clientScript->registerCoreScript('jquery.ui');
    Yii::app()->clientScript->registerCoreScript('platform');
?>
<style type="text/css"> 
     table{font-size:2px;}
</style>
<table border=1>
    <tr> 
       <td>服务器</td>
       <td><?php echo Util::getServerName($model->server_id); ?></td>
    </tr>
    <tr> 
       <td>间隔时间</td>
       <td><?php echo $model->interval_time; ?></td>
    </tr>
    <tr> 
       <td>播放次数</td>
       <td><?php echo $model->play_times; ?></td>
    </tr>
    <tr>
       <td>状态</td>
       <td><?php echo $model->getStatus($model->status); ?></td>
    </tr>
    <tr>
       <td>公告内容</td>
       <td><?php echo $model->content; ?></td>
    </tr>
    <tr>
       <td>发送时间</td>
       <td><?php echo  date('Y-m-d H:i:s', $model->send_time); ?></td>
    </tr>
    <tr>
       <td>创建时间</td>
       <td><?php echo  date('Y-m-d H:i:s', $model->create_time); ?></td>
    </tr>
 </table>

