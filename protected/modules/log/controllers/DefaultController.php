<?php

class DefaultController extends Controller
{
    public $defaultAction ='logList';

    /**
     * 查看日志列表
     */
    public function actionLogList()
    {
        $title = '日志管理';
        $param = $this->getParam(array('begintime', 'endtime', 'operator', 'page', 'moudel'));
        $criteria = new EMongoCriteria();
        $offset = empty($param['page']) ? 0 : ($param['page'] - 1) * Pages::LIMIT;
        $criteria->offset($offset)->limit(Pages::LIMIT);
        $list = Log::model()->bySearch($param)->findAll($criteria);
        $count = Log::model()->bySearch($param)->count();
        if(Yii::app()->request->isAjaxRequest){
            echo json_encode(array(
                "dataCount" => $count, 
                "dataList" => $list
            ));
        }else{
            $this->render('index', array('title' => $title, 
                'list' => $list, 
                'begintime' => $param['begintime'], 
                'endtime' =>  $param['endtime'], 
                'operator' =>  $param['operator'])
            );    
        }
        
    }
    
    /**
     * 查看详细日志
     * @param int $role_id
     */
    public function actionLook(){
        $id = $this->getParam('id');
        $model = $this->loadModel($id , 'Log');
        $this->renderPartial('loginfo', array('model' => $model,), false, true);
    }
}

?>