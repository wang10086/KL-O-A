<?php
ini_set('date.timezone','Asia/Shanghai');
if(version_compare(PHP_VERSION,'5.4.0','<'))  die('require PHP > 5.4.0 !');
define('APP_DEBUG',true);
define('APP_PATH','./api/');
define('RUNTIME_PATH','./temp/api/' );
//define('BIND_MODULE','Auth');
//define('BIND_CONTROLLER', 'Index');

require './lib/core.php';

?>
