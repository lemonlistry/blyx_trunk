<?php 
    Yii::app()->clientScript->registerCoreScript('jquery.ui');
    Yii::app()->clientScript->registerCoreScript('platform');
?>
<style type="text/css"> 
     table{font-size:2px;}
</style>
<table border=1>
    <thead>
        <tr>
            <th>编号</th>
            <th>审批者</th>
            <th>状态</th>
            <th>备注</th>
            <th>审批时间</th>
        </tr>
    </thead>
    <tbody>
        <?php 
            if (count($list)) {
                foreach ($list as $k => $v) {
                   
        ?>
                    <tr> 
                        <td><?php echo $k + 1; ?></td>
                        <td><?php echo Account::user('id', $v->user_id, 'username'); ?></td>
                        <td><?php echo $model->getStatus($v->status); ?></td>
                        <td><?php echo $v->comment; ?></td>
                        <td><?php echo date("Y-m-d H:i:s",$v->create_time); ?></td>
                    </tr>
        <?php 
                } 
            } else { 
        ?>
                <tr>
                    <td colspan="5" style="padding-left:250px;">暂无数据!</td>
                </tr>
        <?php 
            } 
        ?>
    </tbody>
 </table>

