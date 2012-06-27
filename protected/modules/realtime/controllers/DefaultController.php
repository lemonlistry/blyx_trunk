<?php

class DefaultController extends Controller
{
    public $server_id;
    
    public function beforeAction($action){
       parent::beforeAction($action);
       $this->server_id = $this->getParam('server_id');
       if (!empty($this->server_id)){
           $this->setDbConnection($this->server_id);
       }
       return true;
    }
    
    /**
     * 角色信息查询
    */
    public function actionIndex()
    {     
        $title = '角色信息查询';
        $list = array();
        $list['parter'] = array();
        $role_name = $this->getParam('role_name');
        $select = Util::getServerSelect();
        if(!empty($role_name)){
            $model = new UserRoleAR();
            $cotent = $model->find('role_name = BINARY :role_name',array(':role_name' => $role_name));
            if ($cotent){
                $attribute = Util::getSplit($cotent['attributes']);  
                $list['role_id']  =  $cotent['role_id'];//角色ID
                $list['user_account']  =  $cotent['user_account'];//帐号名
                $list['qq'] = $attribute['479101'].'级';//黄钻
                $list['role_name']  =  $cotent['role_name'];//角色名 
                $list['role_level']  =  intval($cotent['role_level']);//角色等级              
                $list['role_reputation']  = intval($cotent['role_reputation']);//角色声望     
                $list['clan'] = Util::translation('roleAttributes', array('clanType'), 'clanId', $attribute['431103'], 'clanName');  //门派
                $list['skill']= Util::translation('effectAttribute', array('skillList'), 'skillId', $attribute['431115'], 'skillName'); 
                $list['career'] = Util::translation('roleAttributes', array('careerType'), 'careerTypeId', $attribute['431101'], 'careerTypeName'); ;  //职业
                $list['attack'] = Util::translation('roleAttributes', array('attackNature'), 'attackNatureId', $attribute['431130'], 'attackNatureName'); //属性
                $list['title'] = Util::translation('title', array(), 'id', $attribute['431008'], 'titleName');   //称号
                $faction = RoleFactionAR::model()->find('role_id = :role_id',array(':role_id' => $list['role_id']));
                if (strpos($faction['attributes'],',')){
                    $faction = Util::getSplit( $faction['attributes']) ;
                    $factionName = FactionAR::model()->find('faction_id = :faction_id',array(':faction_id' => $faction['431009']));
                    $list['faction'] = $factionName['faction_name'];
                }
                $list['hp'] = $attribute['431409'];  //生命
                $list['muscle'] = $attribute['431119'];  //筋骨  
                $list['spirit'] = $attribute['431120'];  //心法  
                $list['aptitude'] = $attribute['431121'];  //悟性  
                $list['gold'] = $attribute['431013'];  //黄金  
                $list['silver'] = $attribute['431015'];  //银两          
                $list['gift'] = $attribute['431014'];  //礼金  
                $list['vitality'] = $attribute['431010'];  //精气
                $list['energy'] = $attribute['431016'];   //修为
                $scene_info = Util::getSplit($cotent['scene_info']); //场景 
                if (isset($scene_info['431003'])){
                    $list['map'] = Util::translation('world', array('maps'), 'id', $scene_info['431003'], 'name');   //地图
                    $list['where'] = 'x:'.$scene_info['431004'].' y:'.$scene_info['431005'];
                }
                $list['role_fightpower']  =  intval($cotent['role_fightpower']);//战斗力 
                //装备
                $equipment = RoleEquipmentAR::model()->find('role_id = :role_id',array(':role_id' => $list['role_id']));
                if ($equipment['equipment_info']){
                    $equipment = Util::getOneSplit($equipment['equipment_info']);
                    foreach ($equipment as $k => $value) {
                        $equipment = EquipmentAR::model()->find('equip_id = :equip_id',array(':equip_id' => $value));
                        $equiattr = Util::getSplit($equipment['attributes']);
                        $ename = Util::translation('itemInformation', array('items'), 'itemId',$equiattr['471401'], 'itemName');  //装备名称
                        $equlity = Util::translation('itemInformation', array('quality'), 'qualityId',$equiattr['471407'], 'qualityName');  //装备品质
                        $list['equip'.$k] = $ename.' '.$equlity.' '.$equiattr['471206']; //装备
                    }
                }
                //秘籍
                $book = RoleBookinfoAR::model()->find('role_id = :role_id',array(':role_id' => $list['role_id']));
                if ($book['equipedbooks']){
                    $book = Util::getOneSplit($book['equipedbooks']);
                    foreach ($book as $k => $v){
                        $bookinfo[$k]=explode(',', $v);
                    }
                    foreach ($bookinfo as $k => $v){
                        if(!empty($v[1])){
                            $bookName  = Util::translation('books', array(), 'bookId', $v[1], 'bookName'); 
                            $list['book'.$k] = $bookName.' 等级:'.$bookinfo[$k][2];
                         }
                    }
                }
                $list['know'] = $attribute['431019']; //学识
                //伙伴信息
                $parter = RoleParterAR::model()->find('role_id = :role_id',array(':role_id' => $list['role_id']));
                if ($parter['role_parterlist']){
                    $parter = Util::getOneSplit($parter['role_parterlist']);
                    $pa  =  explode(',', $parter[0]); 
                    foreach ($pa as $k => $v){
                        $out = ParterAR::model()->find('parter_id = :parter_id',array(':parter_id' => $v));
                        if ($out['attributes'] != null){
                            $out = Util::getSplit($out['attributes']);
                            if ($out['100019'] != 4){
                                $parterName  = Util::translation('roleAttributes', array('roleType'), 'roleTypeId', $out['431105'], 'roleTypeName'); 
                                $list['parter'][$v] = $parterName;
                            }
                        }    
                    } 
                }
            } 
        }
        $this->render('userinfo',array('title' => $title,'list' => $list,'server_id' => $this->server_id, 
                                               'role_name' => $role_name, 'select' =>$select));
    }
    
    /**
     * 背包秘籍信息查询
    */
    public function actionBag(){
        $title = "背包秘籍" ; 
        $list = array();
        $role_id = $this->getParam('role_id');
        if (!empty($role_id)){
            $model = new RolePackageAR();
            $bag = $model->find('role_id = :role_id',array(':role_id' => $role_id));
            $bag = Util::getOneSplit($bag['packageinfo']); 
            foreach ($bag as $k => $v){
                if (!empty($v)){
                    $item = explode(',', $v);
                    $name = Util::translation('itemInformation', array('items'), 'itemId',$item[2], 'itemName');  //物品名称
                    $list['bag'.$k] = $name.'  数量:'.$item[3];
                }
            }
            $book = RoleBookinfoAR::model()->find('role_id = :role_id',array(':role_id' =>  $role_id));
            $book = Util::getOneSplit($book['packagebooks']); 
            foreach ($book as $k => $v){
                if (!empty($v)){
                    $book = explode(',', $v);
                    $bookName  = Util::translation('books', array(), 'bookId', $book[1], 'bookName'); 
                    $list['book'.$k] = $bookName.'  等级:'.$book[2];
                }
            }
        }
        $this->renderPartial('bag',array('title' => $title,'list' => $list),false,true);
    }
    
    /**
     * 伙伴信息查询
    */
    public function actionParter(){
        
        $title = '伙伴信息';
        $list = array();
        $parter_id = $this->getParam('parter_id');
        Yii::import('passport.models.Server');
        $model = new ParterAR;
        $bag = $model -> find('parter_id = :parter_id',array(':parter_id' => $parter_id));
        //装备
        $parter_equipmentlist = str_replace(array(' ', 'equipmentlist={', '}'), array('', '', ''), $bag['parter_equipmentlist']);
        $parter_equipmentlist = substr($parter_equipmentlist, 0, strlen($parter_equipmentlist)-1);
        $parter_equipmentlist = explode(',',$parter_equipmentlist);
        $criteria = new CDbCriteria();
        $criteria->addInCondition('equip_id', $parter_equipmentlist);
        $equipmentlist = EquipmentAR::model()->findAll($criteria);
        $list = array();
        foreach ($equipmentlist as $key => $value) {
            $list[$key] = str_replace(array(' ','{','}','attribute='),array('','','',''),$value->attributes);
            $list[$key] = explode(',',$list[$key]);
        }
        
        foreach ($list as $k => $v) {
            if(!empty($v[19])){
                $list[$k][19] = Util::translation('itemInformation', array('items'),'itemId',$v[19],'itemName');
            }
            if(!empty($v[25])){
                $list[$k][25] = Util::translation('itemInformation', array('quality'),'qualityId',$v[25],'qualityName');
            }
        }
        //书籍
        $parter_booklist = str_replace(array(' ','{','}'),array('','',''),$bag['parter_booklist']);
        $parter_booklist = substr($parter_booklist, 0, strlen($parter_booklist)-1);
        $parter_booklist = explode(',',$parter_booklist);
        foreach ($parter_booklist as $key => $book){
            if($key % 2 == 1 && !empty($book)){
                $parter_booklist[$key] = Util::translation('books', array(), 'bookId', $book, 'bookName');
            }
        }
        //状态
        $attributes = str_replace(array(' ','{','}','attribute='),array('','','',''),$bag['attributes']);
        $attributes = substr($attributes, 0, strlen($attributes)-1);
        $attributes = explode(',',$attributes);
        if(!empty($attributes[43])){
            $attributes[43] = Util::translation('itemInformation', array('quality'),'qualityId',$attributes[43],'qualityName');
        }
        if(!empty($attributes[9])){
            $attributes[9] = Util::translation('roleAttributes', array('roleType'),'roleTypeId',$attributes[9],'roleTypeName');
        }
        if(!empty($attributes[5])){
            $attributes[5] = Util::translation('roleAttributes', array('careerType'),'careerTypeId',$attributes[5],'careerTypeName');
        }
        if(!empty($attributes[7])){
            $attributes[7] = Util::translation('roleAttributes', array('clanType'),'clanId',$attributes[7],'clanName');
        }
        if(!empty($attributes[17])){
            $attributes[17] = Util::translation('effectAttribute', array('skillList'),'skillId',$attributes[17],'skillName');
        }
        if(!empty($attributes[19])){
            $attributes[19] = Util::translation('effectAttribute', array('skillList'),'skillId',$attributes[19],'skillName');
        }
        $this -> renderPartial('parter',array('tital' => $title,'parter_equipmentlist' => $parter_equipmentlist,
        'parter_booklist' => $parter_booklist,'list' => $list,'attributes' => $attributes),false,true);
        
    }
    /**
     * 经脉阵法查询
    */
    public function actionOther(){
        $title = "经脉阵法" ; 
        $list = array();
        $role_id = $this->getParam('role_id');
        if (!empty($role_id)){
            $model = new RoleFormationAR();
            //阵法
            $formation = $model->find('role_id = :role_id',array(':role_id' => $role_id));
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
                $list[$li[$k]['422207']] = ' 等级'.$li[$k]['431401'];
            }
            //经脉
            $energy = RoleEnergyAR::model()->find('role_id = :role_id',array(':role_id' => $role_id));
            $energy = Util::getOneSplit($energy['energy_info']);
            foreach ($energy as  $k => $v){
                $li = explode(',', $v);    
                $list[$li[0]] = '等级:'.$li[1].' 转生:'.$li[2];
            }

         }
         $this->renderPartial('other',array('title' => $title,'list' => $list),false,true);
    }
    
}