<?php

class DefaultController extends Controller
{
    
    public function actionIndex()
    {     
        $title = '角色信息查询';
        $list = array();
        $param = $this->getParam(array('server_id', 'role_name'));
        $server_id = $param['server_id'];
        $role_name = $param['role_name'];
        Yii::import('passport.models.Server');
        $servers = Server::model()->findAll();
        $select = array();
        if(count($servers)){
            foreach ($servers as $k => $v) {
                $select[$v->id] = $v->sname;
            }
        }
        if(!empty($param['role_name'])){
            $model = new UserRoleAR();
            $model->setDbConnection($server_id);
            $cotent = $model->find('role_name = :role_name',array(':role_name' => $param['role_name']));
            $attribute = Util::getSplit($cotent['attributes']);  
            $list['role_id']  =  $cotent['role_id'];//角色ID
            $list['user_account']  =  $cotent['user_account'];//帐号名
                               
            $list['role_name']  =  $cotent['role_name'];//角色名 
            $list['role_level']  =  intval($cotent['role_level']);//角色等级              
            $list['role_reputation']  = intval($cotent['role_reputation']);//角色声望     
            $list['clan'] = $attribute['431103'];  //门派
            $list['skill'] = $attribute['431115'];  //绝技
            $list['career'] = $attribute['431101'];  //职业
            $list['title'] = $attribute['431008'];  //称号
            $list['faction'] = $attribute['431009'];  //帮派
            $list['hp'] = $attribute['431409'];  //生命
            $list['muscle'] = $attribute['431119'];  //筋骨  
            $list['spirit'] = $attribute['431120'];  //心法  
            $list['aptitude'] = $attribute['431121'];  //悟性  
            $list['gold'] = $attribute['431013'];  //黄金  
            $list['silver'] = $attribute['431015'];  //银两          
            $list['gift'] = $attribute['431014'];  //礼金  
            $list['vitality'] = $attribute['431010'];  //精气
            
            $scene_info = Util::getSplit($cotent['scene_info']); //场景 
            $list['map'] = $scene_info['431003'];
            $list['where'] = 'x:'.$scene_info['431004'].' y:'.$scene_info['431005'];
            $list['role_fightpower']  =  intval($cotent['role_fightpower']);//战斗力 
            
            //装备
            $equipment = RoleEquipmentAR::model()->find('role_id = :role_id',array(':role_id' => $list['role_id']));
            $equipment = Util::getOneSplit($equipment['equipment_info']);
            foreach ($equipment as $k => $value) {
                $equipment = EquipmentAR::model()->find('equip_id = :equip_id',array(':equip_id' => $value));
                $equiattr = Util::getSplit($equipment['attributes']);
                $list['equip'.$k] = $equiattr['471401'].' '.$equiattr['471407'].' '.$equiattr['471206']; //装备
            }
            //秘籍
             $book = RoleBookinfoAR::model()->find('role_id = :role_id',array(':role_id' => $list['role_id']));
             $book = Util::getOneSplit($book['equipedbooks']);
             foreach ($book as $k => $v){
               $bookinfo[$k]=explode(',', $v);
             }
             foreach ($bookinfo as $k => $v){
               $list['book'.$k] = $bookinfo[$k][1].' 等级:'.$bookinfo[$k][2];
             }
             $list['know'] = $attribute['431019']; //学识
            //阵法
             $formation = RoleFormationAR::model()->find('role_id = :role_id',array(':role_id' => $list['role_id']));
             $str = str_replace(array(' ', '{{{'), array('','{{'), $formation['role_formationlist']);
             preg_match_all('/\{\{(.*?)\}\,\}/', $str, $matches);
             foreach ($matches[1] as $k => $v){
                 $arr[$k] = explode('},{', $v);
             }
             foreach ($arr as $k => $v){
                  foreach ($v as $key => $value){
                      $meal = explode(',', $value);
                      $li[$k][$meal[0]]   =  $meal[1] ;
                  }
                  $list['formation'.$k] = $li[$k]['422207'].' 等级'.$li[$k]['431401'];
             }
             //经脉
             $energy = RoleEnergyAR::model()->find('role_id = :role_id',array(':role_id' => $list['role_id']));
             $energy = Util::getOneSplit($energy['energy_info']);
             foreach ($energy as  $k => $v){
                  $li = explode(',', $v);    
                  $list[$li[0]] = '等级:'.$li[1].' 转生:'.$li[2];
             }
             $list['energy'] = $attribute['431016'];
             //伙伴信息
             $parter = RoleParterAR::model()->find('role_id = :role_id',array(':role_id' => $list['role_id']));
             $parter = Util::getOneSplit($parter['role_parterlist']);
             $pa  =  explode(',', $parter[0]); 
             $list['parter'] = array();
             foreach ($pa as $k => $v){
                 $out = ParterAR::model()->find('parter_id = :parter_id',array(':parter_id' => $v));
                 if ($out['attributes'] != null){
                    $out = Util::getSplit($out['attributes']);
                     if ($out['100019'] != 4){
                       $list['parter'][$k] = $v ;
                     }
                 }    
              }      
        }
        $this->render('userinfo',array('title' => $title,'list' => $list,'server_id' => $server_id, 
                                               'role_name' => $role_name, 'select' =>$select));
    }
    
    public function actionBag(){
      $title = "背包秘籍" ; 
      $list = array();
      $param = $this->getParam(array('server_id','role_id'));
      $role_id = $param['role_id'];
      $server_id = $param['server_id'];
      Yii::import('passport.models.Server');
      if (!empty($role_id)){
         $model = new RolePackageAR();
         $model->setDbConnection($server_id);
         $bag = $model->find('role_id = :role_id',array(':role_id' => $param['role_id']));
         $bag = Util::getOneSplit($bag['packageinfo']); 
         foreach ($bag as $k => $v){
             $item = explode(',', $v);
             $list['bag'.$k] = $item[2].'  数量:'.$item[3];
         }
         
         $book = RoleBookinfoAR::model()->find('role_id = :role_id',array(':role_id' =>  $param['role_id']));
         $book = Util::getOneSplit($book['packagebooks']); 
         foreach ($book as $k => $v){
             $book = explode(',', $v);
             $list['book'.$k] = $book[1].'  等级:'.$book[2];
         }
      }
      $this->renderPartial('attribute',array('title' => $title,'list' => $list),FALSE,TRUE);
    }
    
}