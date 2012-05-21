<?php

/**
 * 重写YII CActiveRecord  直接多DB 连接
 * @author shadow
 */
class ActiveRecord extends CActiveRecord 
{
    public static $database = array(); 
    
    public $dbname = 'db';
    
    /**
     * Returns the database connection used by active record.
     * By default, the "db" application component is used as the database connection.
     * You may override this method if you want to use a different database connection.
     * @return CDbConnection the database connection used by active record.
     */
    public function getDbConnection()
    {
        $dbname = $this->dbname;
        if(isset(self::$database[$dbname]) && self::$database[$dbname] instanceof CDbConnection){
            return self::$database[$dbname];
        }else{
            self::$database[$dbname] = Yii::app()->$dbname;
        }

        if(self::$database[$dbname] instanceof CDbConnection){
            self::$database[$dbname]->setActive(true); 
            return self::$database[$dbname];
        }else{
            throw new CDbException(Yii::t('yii','Active Record requires a "db" CDbConnection application component.'));
        }
    }
    
    /**
     * 设置DB连接
     * @param string $dbname
     * @return CDbConnection the database connection used by active record.
     */
    public function setDbConnection($dbname){
        $this->dbname = $dbname;
        return $this->getDbConnection();
    }
}
