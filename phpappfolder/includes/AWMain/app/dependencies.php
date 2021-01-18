<?php

/**
 * Declaring dependencies and registering components of containers
 *
 * @package AWMain
 */

$container['view'] = function ($container) {
    $view = new \Slim\Views\Twig(
        $container['settings']['view']['template_path'],
        $container['settings']['view']['twig'],
        ['debug' => true]
    );

    $basePath = rtrim(str_ireplace('index.php','', $container['request']-> getUri()->getBasePath()), '/');
    $view -> addExtension(new Slim\Views\TwigExtension($container['router'], $basePath));

    return $view;
};

$container['validator'] = function ($container) {
    $validator = new \AWMain\Validator();

    return $validator;
};

$container['m2mDatabaseModel'] = function($container) {
    $model = new \AWMain\M2MDatabaseModel();

    return $model;
};

$container['databaseWrapper'] = function ($container) {
    $database_wrapper = new \AWMain\DatabaseWrapper();

    return $database_wrapper;
};

$container['sqlQueries'] = function ($container) {
    $sql_queries = new \AWMain\SQLQueries();

    return $sql_queries;
};

$container['m2mSoapModel'] = function ($container) {
    $model = new \AWMain\M2MSoapModel();

    return $model;
};

$container['soapWrapper'] = function($container){
    $soap_wrapper = new \AWMain\SoapWrapper();

    return $soap_wrapper;
};

$container['xmlParser'] = function ($container) {
    $xml_parser = new \AWMain\XmlParser();

    return $xml_parser;
};

$container['processOutput'] = function ($container) {
    $process_output = new \AWMain\ProcessOutput();

    return $process_output;
};

