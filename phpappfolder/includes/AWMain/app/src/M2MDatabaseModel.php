<?php
/**
 * Database class that calls on the soap wrapper to process data
 * 
 * @package AWMain
 * @author 20-3110-AW - Edward
 */

namespace AWMain;


class M2MDatabaseModel {
    
    private $username;
    private $password;
    private $email;
    private $arr_storage_result;
    private $database_wrapper;
    private $database_connection_settings;
    private $db_handle;
    private $sql_queries;
    private $DatabaseWrapper;
    private $server_type;
    private $storage_result;

    public function __construct(){
        $this->username = null;
        $this->password = null;
        $this->email = null;
        $this->arr_storage_result = null;
        $this->database_wrapper = null;
        $this->database_connection_settings = null;
        $this->db_handle = null;
        $this->sql_queries = null;
    }
    public function __destruct(){}

    /** 
    * Stores Data within the Database
    */ 
    public function storeData()
    {
        switch ($this->server_type)
        {
            case 'database':
                $storage_result = $this->storeDataInSessionDatabase();
                break;
            case 'file':
            default:
                $storage_result = $this->storeDataInSessionFile();
        }
        $this->storage_result = $storage_result;
    }

    public function getStorageResult() {
        return $this->storage_result;
    }




    public function storeDataInSessionDatabase()
    {
        $store_result = false;

        $this->DatabaseWrapper->setSqlQueries($this->sql_queries);
        $this->DatabaseWrapper->setDatabaseConnectionSettings($this->database_connection_settings);
        $this->DatabaseWrapper->SetLogger($this->session_logger);
        $this->DatabaseWrapper->makeDatabaseConnection();

        $store_result_username = $this->DatabaseWrapper->setSessionVar('user_name', $this->username);
        $store_result_password = $this->DatabaseWrapper->setSessionVar('user_password', $this->password);

        if ($store_result_username !== false && $store_result_password !== false) {
            $store_result = true;
        }
        return $store_result;
    }

}

