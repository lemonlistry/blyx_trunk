<?php
class UserController extends Controller
{
    /**
     * 角色信息查询
    */
    public function actionIndex()
    {
        set_time_limit(300);
        $list = array();
        Yii::import('passport.models.Server');
        $servers = Server::model()->findAll();
        $filename = date('YmdHis'). '.xls';
        header("Content-type:application/vnd.ms-excel;charset:utf-8;");
        header('Content-Disposition:filename='.$filename);
        header("Pragma: no-cache");
        header("Expires: 0");
        header("Cache-control:must-revalidate,post-check=0,pre-check=0"); // 解决IE不能下载问题。
        $thead = "服务器\t角色ID\t帐号名\t角色名 \t角色等级\t称号\t帮派\t\n";
        echo(iconv("UTF-8","GBK//IGNORE",$thead));
        if(count($servers)){
            foreach ($servers as $server) {
                $model = new UserRoleAR();
                $model->setDbConnection($server->id);
                $cotent = $model->findAll('role_name' != '');
                foreach ($cotent as $k => $v){
                    $att = Util::getSplit($v['attributes']);
                    if (isset($att['431008'])){
                        $list['title'] = Util::translation('title', array(), 'id', $att['431008'], 'titleName');   //称号
                    }else{
                        $list['title'] = '';
                    }
                    $faction = RoleFactionAR::model()->find('role_id = :role_id',array(':role_id' => $v['role_id']));
                    if (strpos($faction['attributes'],',')){
                          $faction = Util::getSplit( $faction['attributes']) ;
                          $factionName = FactionAR::model()->find('faction_id = :faction_id',array(':faction_id' => $faction['431009']));
                          $list['faction'] = $factionName['faction_name'];
                     }else{
                         $list['faction'] = '';
                     }
                     echo iconv("UTF-8","GBK//IGNORE", $server['sname'] . "\t");
                     echo $v['role_id'] . "\t";
                     echo iconv("UTF-8","GBK//IGNORE", $v['user_account'] . "\t");
                     echo iconv("UTF-8","GBK//IGNORE", $v['role_name'] . "\t");
                     echo intval($v['role_level']) . "\t";
                     echo iconv("UTF-8","GBK//IGNORE",  $list['title'] . "\t");
                     echo iconv("UTF-8","GBK//IGNORE", $list['faction'] . "\t\n");
                 }
            }
        }
    }

}