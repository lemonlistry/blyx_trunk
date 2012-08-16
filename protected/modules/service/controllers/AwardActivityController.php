<?php
class AwardActivityController extends Controller
{
    public function actionActivities()
    {
        $this->render('list', array('select' => Util::getRealServerSelect(false)));
    }

    public function actionGetActivityByServerId()
    {
        $serverId = $this->getParam("server_id");
        $model = new AwardActivity();
        $activities = $model->findAllByAttributes(array('serverId' => $serverId));
        if (count($activities) == 0)
        {
            $this->addDefaultActivities($serverId);
            $activities = $model->findAllByAttributes(array('serverId' => $serverId));
        }
        echo json_encode(array("count" => count($activities), "activities" => $activities));
    }

    public function actionUpdateActivity()
    {
        $serverId = $this->getParam('server_id');
        $activityId = $this->getParam('activity_id');
        $startTime = strtotime($this->getParam('startTime'));
        $endTime = strtotime($this->getParam('endTime'));
        $duration = intval($this->getParam('duration'));
        $isHot = intval($this->getParam('isHot'));
        $isEnable = intval($this->getParam('isEnable'));
        $model = AwardActivity::model()->findbyAttributes(array(
            'serverId' => $serverId,
            'activityId' => $activityId
        ));
        $model->duration = $duration;
        $model->startTime = $startTime;
        $model->endTime = $endTime;
        $model->isHot = $isHot;
        $model->isEnable = $isEnable;
        $this->doUpdateActivity($model);
    }

    public function actionStopActivity()
    {
        $serverId = $this->getParam('server_id');
        $activityId = $this->getParam('activity_id');
        $model = AwardActivity::model()->findbyAttributes(array(
            'serverId' => $serverId,
            'activityId' => $activityId
        ));
        $model->endTime = time();
        $this->doUpdateActivity($model);
    }

    protected function doUpdateActivity($model)
    {
        if ($model->validate())
        {
            $result = Service::sendAwardActivity(
                        $model->serverId,
                        $model->activityId,
                        $model->startTime,
                        $model->endTime,
                        $model->duration,
                        $model->isEnable,
                        $model->isHot
                    );
            if($result['success'] == 1){
                $model->save();
                Util::log("update award activity success!", "service", __FILE__, __LINE__);
                echo json_encode(array("ret" => 0));
            }else{
                echo json_encode(array("ret" => -1));
            }
        }
        else
        {
            echo json_encode(array("ret" => -1));
        }
    }

    protected function addDefaultActivities($server_id)
    {
        $idToNames = array (479251 => '充值有礼', 479252 => '全服冲级赛', 479253 => '随从大比拼', 479254 => '武林争霸赛', 479255 => 'vip等级活动');
        foreach ($idToNames as $activityId => $activityName)
        {
            $model = new AwardActivity();
            $model->id = $this->getAutoIncrementKey('bl_award_activity');
            $model->serverId = $server_id;
            $model->startTime = time();
            $model->endTime = time();
            $model->isEnable = 0;
            $model->isHot = 0;
            $model->duration = 0;
            $model->name = $activityName;
            $model->activityId = $activityId;
            if ($model->validate()) {
                $model->save();
            }
            else
            {
                //log to file
            }
        }
    }
}
