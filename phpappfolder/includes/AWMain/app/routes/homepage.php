<?php
/**
 * Home page of the application
 */

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->get('/', function(Request $request, Response $response) {
    $html_output = $this->view->render($response,
    'homepageform.html.twig',
    [
        'css_path' => CSS_PATH,
        'landing_page' => LANDING_PAGE,
        'method' => 'get',
        'action' => 'index.php',
        'page_title' => APP_NAME,
        'page_heading_1' => 'Hello yes, this is 20-3110-AW.',
        'page_text' => 'Hello world or something, IDK I\'m not a computer. Please give us extension!'
    ]);

    return $html_output;
})->setName('homepage');