<?php
/**
 * Index of the application that redirects to the bootstrap
 *
 * @package AWMain;
 * @author 20-3110-AW - Cosmin
 */


ini_set('xdebug.trace_output_name', 'AWMain.%t');
ini_set('display_errors', 'on');
ini_set('html_errors', 'On');
ini_set('xdebug.trace_format', 1);

$make_trace = false;

if ($make_trace == true && function_exists(xdebug_start_trace())) {
    xdebug_start_trace();
}


include 'AWMain/bootstrap.php';

if ($make_trace == true && function_exists(xdebug_stop_trace())) {
    xdebug_stop_trace();
}
