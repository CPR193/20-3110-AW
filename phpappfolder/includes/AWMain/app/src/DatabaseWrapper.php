<?php


namespace AWMain;

use PDO;
use PDOException;

class DatabaseWrapper

{
    public function __construct(){}
    public function __destruct(){}

    private function createAWMainVar($AWMain_key, $AWMain_value)
{
    $query_string = $this->sql_queries->createAWMainVar();

    $query_parameters = [
        ':local_AWMain_id' => AWMain_id(),
        ':AWMain_var_name' => $AWMain_key,
        ':AWMain_var_value' => $AWMain_value
    ];

    $this->safeQuery($query_string, $query_parameters);
}

    private function storeAWMainVar($AWMain_key, $AWMain_value)
{
    $query_string = $this->sql_queries->setAWMainVar();

    $query_parameters = [
        ':local_AWMain_id' => AWMain_id(),
        ':AWMain_var_name' => $AWMain_key,
        ':AWMain_var_value' => $AWMain_value
    ];

    $this->safeQuery($query_string, $query_parameters);
}

    private function safeQuery($query_string, $params = null)
{
    $this->errors['db_error'] = false;
    $query_parameters = $params;

    try {
        $this->prepared_statement = $this->db_handle->prepare($query_string);
        $execute_result = $this->prepared_statement->execute($query_parameters);
        $this->errors['execute-OK'] = $execute_result;
        $this->AWMain_logger->notice('Successfully connected to database');
    } catch (PDOException $exception_object) {
        $error_message = 'PDO Exception caught. ';
        $error_message .= 'Error with the database access.' . "\n";
        $error_message .= 'SQL query: ' . $query_string . "\n";
        $error_message .= 'Error: ' . var_dump($this->prepared_statement->errorInfo(), true) . "\n";
        $this->errors['db_error'] = true;
        $this->errors['sql_error'] = $error_message;
        $this->AWMain_logger->warning('Error connecting to database');
    }
    return $this->errors['db_error'];
}
}

