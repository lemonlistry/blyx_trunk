<?php

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
         * @return boolean
         */
        public static function setAuth($resource_id, $channel_id, $uid)
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
         * 频道设置
         * @param string $name
         * @param string $desc
         * @return boolean
         */
        public static function setChannel($name, $desc)
        {
        
        }
        
        /**
         * 资源设置
         * @param string $name
         * @param string $desc
         * @return boolean
         */
        public static function setResource($name, $desc)
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