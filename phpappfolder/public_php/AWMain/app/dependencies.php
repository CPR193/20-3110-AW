<?php

/**
 * Declaring dependencies and registering components of containers
 *
 * @package AWMain
 */

$container['view'] = function ($container) {
    $view = new \Slim\Views\Twig(
        $container['settings']['view']['template_path'], $container['settings']['view']['twig'],
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

$container['mainModel'] = function($container) {
    $model = new \AWMain\MainModel();

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
