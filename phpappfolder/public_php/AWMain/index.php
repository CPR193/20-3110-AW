<?php
/**
 * Index of the application that redirects to the bootstrap
 *
 * @package AWMain
 */

ini_set('xdebug.trace_output_name', 'AWMain_xdebug_output');
ini_set('display_errors', 'on');
ini_set('html_errors', 'On');
ini_set('xdebug.trace_format', 1);

if (function_exists(xdebug_start_trace())) {
    xdebug_start_trace();
}

include_once 'AWMain/bootstrap.php';

if (function_exists(xdebug_stop_trace())) {
    xdebug_stop_trace();
}