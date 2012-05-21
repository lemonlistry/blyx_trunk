<?php

/**
 * 账户接口类
 */
class Account {

    /**
     * 取得用户信息
     * @param int $id 当$in为false时，表示用户编号；当$in为true时，表示IN号
     * @param boolean $in 是否根据IN号来获取用户信息
     * @param mixed $active 0,离职 1,在职 null,所有
     * @return StdClass 用户存在则返回用户的数据对象，否则抛出一个异常
     * @exception CException 执行失败抛出CException
     */
    public static function user($id, $in = false, $active = 1) {
        $users = Account::users($active);
        if ($in) {
            foreach ($users as $user) {
                if ($user->in == $id) {
                    return $user;
                }
            }
        } else {
            return $users[$id];
        }
        return false;
    }

    /**
     * 用户列表
     * @param $actived 默认为1:在职人员, null:为含离职的用户
     * @return array
     */
    public static function users($actived = 1) {
        return AccountService::users($actived);
    }

    /**
     * 指定部门
     * @param int $department_id 部门编号
     * @return stdClass
     */
    public static function department($department_id) {
        $depts = AccountService::departments(null);
        return $depts[$department_id];
    }

    /**
     * 所有部门
     * @param $actived 1,有效 0，删除 null，所有。默认为1
     * @return array
     */
    public static function departments($actived = 1) {
        return AccountService::departments($actived = 1);
    }

    /**
     * 指定部门下的所有用户
     * @param int $department_id 部门编号
     * @param $actived 0，离职; 1,在职; null，所有。默认1在职
     * @return array
     */
    public static function departmentUsers($department_id, $actived = 1) {
        $all = Account::users($actived);
        $users = array();
        foreach ($all as $user) {
            if ($user->department_id == $department_id) {
                $users[$user->id] = $user;
            }
        }
        return $users;
    }

    /**
     * 取得系统所有角色
     * @return array
     */
    public static function roles() {
        $db = Yii::app()->db;
        $roleList = $db->createCommand()->from('core_role')->queryAll();
        $roles = array();
        foreach ($roleList as $k => $v) {
            $roles[$v['id']] = (object) $v;
        }
        return $roles;
    }

    /**
     * 取得系统角色
     * @return array
     */
    public static function role($role_id) {
        $db = Yii::app()->db;
        $roles = $db->createCommand()->from('core_role')->where('`id`=:role_id', array(':role_id' => $role_id))->queryRow();
        return (object) $roles;
    }

    /**
     * 取得用户角色
     * @param int $user_id
     * @return array
     */
    public static function userRoles($user_id) {
        $db = Yii::app()->db;
        $roles = $db->createCommand()->select('role_id')->from('core_role_assign')->where('`user_id`=:user_id', array(':user_id' => $user_id))->queryColumn();
        // 默认加上2员工的角色
        $roles[] = '2';
        // 如果时部门经理，在加上4部门经理的角色
        if ($user_id == Account::department(Account::user($user_id)->department_id)->user_id) {
            $roles[] = '4';
        }
        return (array) $roles;
    }

    /**
     * 取得角色所有用户
     * @param int $role_id 角色id
     * @param $actived 默认为1:在职人员, null:为含离职的用户
     * @return array 用户编号数组，如果没有用户返回空数组
     */
    public static function roleUsers($role_id, $actived = 1) {
        $actived_users = Account::users();
        $role_users = Yii::app()->db->createCommand()->select('user_id')->from('core_role_assign')
                ->where('`role_id`=:role_id', array(':role_id' => $role_id))
                ->queryColumn();
        $users = array();
        foreach ($role_users as $k => $v) {
            if ($actived) {
                if (isset($actived_users[$v])) {
                    $users[$v] = $v;
                }
            } else {
                $users[$v] = $v;
            }
        }
        return $users;
    }

    /**
     * 取得用户编号
     * @return StdClass
     */
    public static function corp() {
        return AccountService::corp();
    }

    /**
     * 部门选择下拉菜单
     * @param int|array 需要忽略的部门编号(编辑部门时选择上级部门需要隐藏自己)
     * @return array
     */
    public static function departmentDropdown($skip_id = null) {
        $dept_list = array();
        $depts = self::departments();
        foreach ($depts as $dept) {
            $dept_list[] = array(
                'name' => $dept->name,
                'id' => $dept->id,
                'parent_id' => $dept->parent_id,
            );
        }
        return Tree::DropdownList($dept_list, $skip_id);
    }

    /**
     * 是否管理员
     * @param int $user_id
     * @return boolean
     */
    public static function isAdmin($user_id) {
        $db = Yii::app()->db;
        $role = $db->createCommand()->from('core_role_assign')->where('`user_id`=:user_id and `role_id`=1', array(':user_id' => $user_id))->queryRow();
        if ($role) {
            return true;
        } else {
            return false;
        }
    }

}
