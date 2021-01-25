<?php


namespace AWMain;


class M2MDatabaseModel
{

    public function __construct(){}
    public function __destruct(){}
}

CREATE DATABASE IF NOT EXISTS sms_db

CREATE TABLE sms_msg_table (
    source_sim int,
    email_address varchar(255),
    name varchar (255),
    message_content varchar(80),
);

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

    public function getStorageResult()
{
    return $this->storage_result;
}

$query = $db->get('messages');
if($query->row_count() > 0) {
    $messages = $query->results();
    foreach($messages as $message) {
        echo $message->message_content;
    }
}

$query = $db->get('sims');
if($query->row_count() > 0) {
    $sims = $query->results();
    foreach($sims as $sim) {
        echo $sim->source_sim;
    }
}

$query = $db->get('emails');
if($query->row_count() > 0) {
    $emails = $query->results();
    foreach($emails as $email) {
        echo $email->email_address;
    }
}

$query = $db->get('handles');
if($query->row_count() > 0) {
    $handles = $query->results();
    foreach ($handles as $handle) {
        echo $handle->name;
    }
}

 public function storeDataInSessionDatabase()
{
    $store_result = false;

    $this->session_wrapper_database->setSqlQueries($this->sql_queries);
    $this->session_wrapper_database->setDatabaseConnectionSettings($this->database_connection_settings);
    $this->session_wrapper_database->SetLogger($this->session_logger);
    $this->session_wrapper_database->makeDatabaseConnection();

    $store_result_username = $this->session_wrapper_database->setSessionVar('user_name', $this->username);
    $store_result_password = $this->session_wrapper_database->setSessionVar('user_password', $this->password);

    if ($store_result_username !== false && $store_result_password !== false) {
        $store_result = true;
    }
    return $store_result;
}

