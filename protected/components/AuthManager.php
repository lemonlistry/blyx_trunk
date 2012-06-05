<?php
/**
 * 权限验证类
 * @author shadow
 *
 */
class AuthManager { 
    
    /**
     * 验证权限
     * @param int $resource_id
     * @param int $channel_id
     * @param int $uid
     * @param string $op
     * @return boolean
     */
    public static function checkAuth($uid, $resource_id, $op, $channel_id = 0)
    {
        
        $model = Prime::model()->findByAttributes(array('uid' => $uid, 'resource_id' => $resource_id, 'channel_id' => $channel_id));
        return isset($model->prime) ? $model->prime : false;
    }
    
    /**
     * 添加权限
     * @param int $resource_id
     * @param int $channel_id
     * @param int $role_id
     * @param string $op
     * @return boolean
     */
    public static function addAuth($resource_id, $op, $role_id, $channel_id = 0)
    {
    
    }
    
    /**
     * 删除权限
     * @param int $resource_id
     * @param int $channel_id
     * @param int $role_id
     * @param string $op
     * @return boolean
     */
    public static function delAuth($resource_id, $op, $role_id, $channel_id = 0)
    {
    
    }
    
    /**
     * 获取用户权限
     * @param int $channel_id
     * @param int $uid
     * @return array
     */
    public static function getAuth($uid, $channel_id = 0)
    {
    
    }
    
    
    /**
     * 验证频道是否存在
     * @param int $channel_id
     * @return boolean
     */
    public static function checkChannel($channel_id)
    {
        $model = Channel::model()->findByAttributes(array('id' => $channel_id));
        return isset($model->id) ? true : false;
    }
    
    /**
     * 频道添加
     * @param string $name
     * @param string $desc
     * @return boolean
     */
    public static function addChannel($name, $desc)
    {
    
    }
    
   /**
     * 删除频道 
     * @param int $channel_id
     * @return boolean
     */
    public static function delChannel($channel_id)
    {
    
    }
    
    /**
     * 获取用户权限
     * @param int $channel_id
     * @param int $uid
     * @return array
     */
    public static function getChannel($channel_id = 'all')
    {
    
    }
    
    /**
     * 检查资源是否存在
     * @param int $resource_id
     * @return boolean
     */
    public static function checkResource($resource_id)
    {
        
    }
    
    
    /**
     * 资源添加
     * @param string $name
     * @param string $desc
     * @return boolean
     */
    public static function addResource($name, $desc)
    {
    
    }
    
    /**
     * 删除资源
     * @param int $channel_id
     * @return boolean
     */
    public static function delResource($resource_id)
    {
    
    }
    
    /**
     * 获取资源
     * @param int $resource_id
     * @return array
     */
    public static function getResource($resource_id = 'all')
    {
    
    }
    
    /**
     * 检查角色是否存在
     * @param int $role_id
     * @return boolean
     */
    public static function checkRole($role_id)
    {
        
    }
    
    
    /**
     * 角色添加
     * @param string $name
     * @param string $desc
     * @return boolean
     */
    public static function addRole($name, $desc)
    {
    
    }
    
    /**
     * 删除角色
     * @param int $role_id
     * @return boolean
     */
    public static function delRole($role_id)
    {
    
    }
    
    /**
     * 获取角色
     * @param int $role_id
     * @return array
     */
    public static function getRole($role_id = 'all')
    {
    
    }
    
    /**
     * 获取角色ID 根据用户ID
     * @param int $user_id
     * @return int
     */
    public static function getRoleId($user_id)
    {
    
    }
} 