<?php
/**
 * MongoDB.php
 * @author shadow
 * @since v1.0
 */

abstract class MongoDocument extends EMongoDocument
{

    public static $db_instance = array(); 
    
    private $db_component = 'mongodb';
    
    private $new = false;
    
    /**
     * get mongodb component
     * @return string
     */
    public function getDbComponent(){
        return $this->db_component;
    }
    
    /**
     * Get EMongoDB component instance
     * By default it is mongodb application component
     * @return EMongoDB
     * @since v1.0
     */
    public function getMongoDBComponent()
    {
        $db_component = $this->getDbComponent();
        if(isset(self::$db_instance[$db_component]) && self::$db_instance[$db_component] instanceof EMongoDB){
            return self::$db_instance[$db_component];
        }else{
            self::$db_instance[$db_component] = Yii::app()->$db_component;
        }

        if(self::$db_instance[$db_component] instanceof EMongoDB){
            return self::$db_instance[$db_component];
        }else{
            throw new CDbException(Yii::t('yii','EMongoDB requires a "db" CDbConnection application component.'));
        }
    }
    
    /**
     * Set Mongodb connection
     * @param string $db
     * @return CDbConnection the database connection used by EMongoDB.
     */
    public function setMongoDBConnection($db_component){
        $this->db_component = $db_component;
        $conn = $this->getMongoDBComponent()->getConnection();
        return self::$db_instance[$this->db]->setConnection($conn);
    }
    
    
    /**
     * 维护自增表
     * @see EMongoDocument::afterSave()
     */
    public function afterSave(){
        if($this->new){
            $table = $this->getCollectionName();
            if($table == 'bl_auto_increment'){
                return true;
            }else{
                $model = AutoIncrement::model()->findByAttributes(array('table' => $table));
                if(empty($model)){
                    $model = new AutoIncrement(); 
                    $model->table = $table;
                    $model->index = 1;
                    $model->save(true, array('table', 'index'));
                }else{
                    ++$model->index;
                    $model->save(true, array('table', 'index'));
                }
            }
        }
        return parent::afterSave();
    }
    
    /**
     * 获取自增Key
     */
    public function getAutoIncrementKey(){
        $table = $this->getCollectionName();
        $model = AutoIncrement::model()->findByAttributes(array('table' => $table));
        return empty($model) ? 1 : ++$model->index;
    }
    
    /**
     * 新增记录标识处理
     * @see EMongoDocument::beforeSave()
     */
    public function beforeSave(){
        $this->new = $this->getIsNewRecord() ? true : false;
        return parent::beforeSave();
    }
}
