<?php
/*
 * General system parameters
 */

$config = Config::singleton();

$config->set('rootPath', '/BasicMVC/');
$config->set('controllersFolder', 'controllers/');
$config->set('modelsFolder', 'models/');
$config->set('viewsFolder', 'views/');

$config->set('dbhost', 'localhost');
$config->set('dbname', '');
$config->set('dbuser', '');
$config->set('dbpass', '');

$config->set('timezone', 'America/Santiago');
$config->set('debug', true);
$config->set('token', '3756a4505914c97f76b8557a688466a4');
?>