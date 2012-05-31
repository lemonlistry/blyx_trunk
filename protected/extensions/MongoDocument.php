<?php
/**
 * MongoDB.php
 * @author shadow
 * @since v1.0
 */

abstract class MongoDocument extends EMongoDocument
{

    public static $db_instance = array(); 
    
    public $db = 'mongodb';
    
    /**
     * get mongodb component
     * @return string
     */
    public function getDbComponent(){
        return $this->db;
    }
    
    /**
     * Get EMongoDB component instance
     * By default it is mongodb application component
     * @return EMongoDB
     * @since v1.0
     */
    public function getMongoDBComponent()
    {
        $db = $this->getDbComponent();
        if(isset(self::$db_instance[$db]) && self::$db_instance[$db] instanceof EMongoDB){
            return self::$db_instance[$db];
        }else{
            self::$db_instance[$db] = Yii::app()->$db;
        }

        if(self::$db_instance[$db] instanceof EMongoDB){
            return self::$db_instance[$db];
        }else{
            throw new CDbException(Yii::t('yii','EMongoDB requires a "db" CDbConnection application component.'));
        }
    }
    
    /**
     * Set Mongodb connection
     * @param string $db
     * @return CDbConnection the database connection used by EMongoDB.
     */
    public function setMongoDBConnection($db){
        $this->db = $db;
        $conn = $this->getMongoDBComponent()->getConnection();
        return self::$db_instance[$this->db]->setConnection($conn);
    }

}
