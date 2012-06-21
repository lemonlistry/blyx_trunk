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
       <td>时间</td>
       <td><?php echo $model->time; ?></td>
    </tr>
    <tr> 
       <td>角色ID</td>
       <td><?php echo $model->role_id; ?></td>
    </tr>
    <tr>
       <td>状态</td>
       <td><?php echo $model->getStatus($model->status); ?></td>
    </tr>
    <tr>
       <td>礼包名称</td>
       <td><?php echo $model->name; ?></td>
    </tr>
    <tr>
       <td>物品ID</td>
       <td><?php echo  $model->item_id; ?></td>
    </tr>
    <tr>
       <td>数量</td>
       <td><?php echo  $model->num; ?></td>
    </tr>
    <tr>
       <td>创建时间</td>
       <td><?php echo  date('Y-m-d H:i:s', $model->create_time); ?></td>
    </tr>
 </table>

