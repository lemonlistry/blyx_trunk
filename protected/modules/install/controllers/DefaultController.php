<?php

class DefaultController extends Controller
{
    public $defaultAction = 'install';
    
    /**
     * 数据结构安装
     */
    public function actionInstall() 
    {
        Yii::import('passport.models.*');
        Yii::import('log.models.*');
        $this->uninstall();
        $this->initRoleGroup();
        $this->initRole();
        $this->initResource();
        $this->initUser();
    }
    
    /**
     * 数据卸载
     */
    protected function uninstall(){
        User::model()->deleteAll();
        Role::model()->deleteAll();
        RoleGroup::model()->deleteAll();
        Resource::model()->deleteAll();
        Log::model()->deleteAll();
        Prime::model()->deleteAll();
        Server::model()->deleteAll();
        AutoIncrement::model()->deleteAll();
    }
    
    /**
     * 初始化用户数据
     */
    protected function initUser()
    {
        $model = new User();
        $model->username = 'admin';
        $model->password = md5('20120606');
        $model->role_id = 1;
        $model->id = $this->getAutoIncrementKey('bl_user');
        $model->create_time = time();
        if($model->validate()){
            $model->save();
        }else{
            throw new CException('model attribute validate error');
        }
    }
    
    /**
     * 初始化角色数据
     */
    protected function initRole()
    {
        $data = array(
             '超级管理员' => 1,
             '系统管理员' => 2,
             '游戏管理员' => 2,
             '客服管理员' => 3,
             '客服' => 3,
             '运营管理员' => 4,
             '运营' => 4,
             '运维管理员' => 5,
             '运维' => 5,
             '资源审核' => 6,
        );
        foreach ($data as $k => $v) {
            $model = new Role();
            $model->name = $k;
            $model->desc = $k;
            $model->group_id = $v;
            $model->id = $this->getAutoIncrementKey('bl_role');
            $model->create_time = time();
            if($model->validate()){
                $model->save();
            }else{
                throw new CException('model attribute validate error');
            }
        }
    }
    
    /**
     * 初始化资源数据
     */
    protected function initResource()
    {
        $data = array(
            'wjxxgl' => '玩家信息管理',
            'ftjjgl' => '封停禁言管理',
            'gmczgl' => 'GM操作审核',
            'rdwt' => '热点问题',
            'wjjjgl' => '玩家交互管理',
            'yslwjfk' => '已受理玩家反馈',
            'lsjlcx' => '历史记录查询',
            'jssjrz' => '角色升级日志',
            'jsdlrz' => '角色登录日志',
            'wjczrz' => '玩家充值日志',
            'yxbdhrz' => '游戏币兑换日志',
            'yxbxfrz' => '游戏币消费日志',
            'yxbdhxflsz' => '游戏币兑换、消费流水账',
            'ylcsxhrz' => '银两产生、消耗日志',
            'jycsxhrz' => '经验产生、消耗日志',
            'wpcsxwbgrz' => '物品产生、消亡、变更日志',
            'wpcwubcrz' => '物品、宠物补偿日志',
            'wjhdrz' => '玩家活动日志',
            'wjphb' => '玩家排行榜',
            'rzczhxjdljss' => '日注册帐号、新建、登录角色数',
            'jszydjfx' => '角色职业、等级分析',
            'jszyfb' => '角色职业分布',
            'rjsdjfb' => '日角色等级分布',
            'zxrsscfx' => '在线人数、时长分析',
            'mxszx' => '每小时在线',
            'mrzx' => '每日在线',
            'rzxscfb' => '日在线时长分布',
            'hyl' => '活跃率',
            'hyyhs' => '活跃用户数',
            'lcl' => '留存率',
            'yhrlcfb' => '用户日留存分布',
            'lsl' => '流失率',
            'zcwjzlsl' => '注册玩家周流失率',
            'duxf' => '兑换、消费',
            'yxbdhxfrb' => '游戏币兑换、消费日报',
            'xflxfb' => '消费类型分布',
            'arpuz' => 'ARPU值',
            'kflwjfftj' => '跨服老玩家付费统计',
            'gjsjzl' => '关键数据总览',
            'ptwjzphb' => '平台玩家总排行榜',
            'ggfb' => '公告发布',
            'lbgl' => '礼包管理',
            'lbff' => '礼包发放',
            'hdgl' => '活动管理',
            'wpcwbc' => '物品、宠物补偿',
            'cszhgl' => '测试账号管理',
            'qxgl' => '权限管理',
            'yhgl' => '用户管理',
            'czrz' => '操作日志',
            'fwqjk' => '服务器监控',
            'yxgl' => '游戏管理',
        );
        foreach ($data as $k => $v) {
            $model = new Resource();
            $model->name = $v;
            $model->desc = $v;
            $model->id = $this->getAutoIncrementKey('bl_resource');
            $model->tag = $k;
            $model->create_time = time();
            if($model->validate()){
                $model->save();
            }else{
                throw new CException('model attribute validate error');
            }
        }
    
    }
    
    /**
     * 初始化角色类型数据
     */
    protected function initRoleGroup()
    {
        $data = array(
             '超级管理员组',
             '管理员组',
             '客服组',
             '运营组',
             '运维组',
             '审核组',
        );
        foreach ($data as $v) {
            $model = new RoleGroup();
            $model->name = $v;
            $model->desc = $v;
            $model->id = $this->getAutoIncrementKey('bl_role_group');
            $model->create_time = time();
            if($model->validate()){
                $model->save();
            }else{
                throw new CException('model attribute validate error');
            }
        }
    }
    
}