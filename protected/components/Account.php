<?php

/**
 * 账户接口类
 */
class Account {

    /**
     * 是否管理员
     * @param int $user_id
     * @return boolean
     */
    public static function isAdmin($user_id) {
        Yii::import('passport.models.User');
        $user = User::model()->findByAttributes(array('id' => $user_id));
        if ($user->role_id === 1) {
            return true;
        } else {
            return false;
        }
    }

}
