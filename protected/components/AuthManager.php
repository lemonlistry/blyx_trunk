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
     * @return boolean
     */
    public static function checkAuth($resource_id, $channel_id, $uid)
    {

    }
    
    /**
     * 设置权限
     * @param int $resource_id
     * @param int $channel_id
     * @param int $uid
     * @param boolean $prime 增加(TRUE)/删除(FALSE)权限
     * @return boolean
     */
    public static function setAuth($resource_id, $channel_id, $uid, $prime = true)
    {
    
    }
    
    /**
     * 获取用户权限
     * @param int $channel_id
     * @param int $uid
     * @return array
     */
    public static function getAuth($uid, $channel_id)
    {
    
    }
    
    /**
     * 获取所有用户权限
     * @return array
     */
    public static function getAllAuth()
    {
    
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
     * 资源添加
     * @param string $name
     * @param string $desc
     * @return boolean
     */
    public static function addResource($name, $desc)
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
     * 删除资源
     * @param int $channel_id
     * @return boolean
     */
    public static function delResource($resource_id)
    {
    
    }    
} 