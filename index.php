<?php

date_default_timezone_set('America/Sao_Paulo');

// Define path to application directory
define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/app'));

require './library/Guga1.0/Guga.php';
$guga = new Guga();
