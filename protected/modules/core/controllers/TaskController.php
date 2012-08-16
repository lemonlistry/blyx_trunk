<?php
class TaskController extends Controller
{

    /**
     * 任务分析
     */
    public function actionTaskAnalysis()
    {
        if(Yii::app()->request->isAjaxRequest){
            $serverId = $this->getParam("serverId");
            $cache_data = Yii::app()->cache->get('CACHE_TASK_ANALYSIS_' . $serverId);
            if($cache_data){
                echo json_encode($cache_data);
            }else{
                $acceptTask = Yii::app()->db->createCommand()->select("role_id, max(task) as task_id")->from("accept_task")
                                    ->where("server_id=:server_id and task >= 451000 and task <= 451999", array(":server_id" => $serverId))
                                    ->group("role_id")->queryAll();
                $submitTask = Yii::app()->db->createCommand()->select("role_id, max(task_id) as task_id")->from("submit_task")
                                    ->where("server_id=:server_id and task_id >= 451000 and task_id <= 451999", array(":server_id" => $serverId))
                                    ->group('role_id')->queryAll();
                $roleIdToAcceptedTaskIds = array();
                foreach ($acceptTask as $row){
                    $roleId = $row['role_id'];
                    $taskId = $row['task_id'];
                    $roleIdToAcceptedTaskIds[$roleId] = $taskId;
                    if ($taskId == 451002)
                    {
                        $taskId = 451003;
                    }
                }
                $roleIdToSubmittedTaskIds = array();
                foreach ($submitTask as $row){
                    $roleId = $row['role_id'];
                    $taskId = $row['task_id'];
                    $roleIdToSubmittedTaskIds[$roleId] = $taskId;
                }
                $roleIdToTaskId = array();
                foreach (array_keys($roleIdToAcceptedTaskIds) as $roleId){
                    $taskId = 0;
                    $acceptedTaskId = $roleIdToAcceptedTaskIds[$roleId];
                    if (!isset($roleIdToSubmittedTaskIds[$roleId])){
                        $submittedTaskId = 0;
                    }else{
                        $submittedTaskId = $roleIdToSubmittedTaskIds[$roleId];
                    }
                    if ($acceptedTaskId > $submittedTaskId){
                        $taskId = $acceptedTaskId;
                    }else if ($acceptedTaskId == $submittedTaskId){
                        if ($acceptedTaskId <= 451020){
                            $taskId = $acceptedTaskId + 1;
                        }else{
                            $taskId = $acceptedTaskId;
                        }
                    }else{
                        $taskId = $submittedTaskId;
                    }
                    $roleIdToTaskId[$roleId] = $taskId;
                }
                $histogram = array();
                foreach ($roleIdToTaskId as $key => $value){
                    if (!array_key_exists($value, $histogram)){
                        $histogram[$value] = 1;
                    }else{
                        $histogram[$value] += 1;
                    }
                }
                ksort($histogram);
                $result = array();
                foreach ($histogram as $k => $v) {
                    $index = Util::translationChildLabel('tasks', array(), 'id', $k, 'name');
                    $map_level = isset(AppConst::$task_map_level[$k]) ? AppConst::$task_map_level[$k] : '未知等级';
                    $index = $index . '(' . $map_level . ')';
                    $result[$index] = $v;
                }
                Yii::app()->cache->set('CACHE_TASK_ANALYSIS_' . $serverId, $result, 1800);
                echo json_encode($result);
            }
            Yii::app()->end();
        }else{
            $select = Util::getRealServerSelect(false);
            $this->render('task_analysis',array('select' => $select));
        }
    }

}
?>
