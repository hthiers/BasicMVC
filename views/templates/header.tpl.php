<?php
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past

#session vars
$session = FR_Session::singleton();

#system vars for view level
$config = Config::singleton();
$rootPath = $config->get('rootPath');
$debugMode = $config->get('debug');

#session vars
if($session->id != null):

$navegador = $_SERVER['HTTP_USER_AGENT'];
$navegador = substr($navegador,25,8);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>LG Electronics Chile</title>
<link rel="shortcut icon" type="image/x-icon" href="/som/img/LG.ico" />
<style type="text/css">
	@import "views/css/estilo.css";
	@import "views/css/reset-min.css";
	@import "views/css/formularios.css";
	@import "views/css/texto.css";
	<?php 
	if($navegador == 'MSIE 6.0')  
		echo '@import "views/css/menuie6.css";';
	else
		echo '@import "views/css/menu2.css";';
	?>
</style>
<script type="text/javascript" language="javascript" src="views/lib/jquery.js"></script>
<script type="text/javascript" language="javascript" src="views/lib/jquery.validate.min.js"></script>
<?php
	if($navegador == 'MSIE 6.0')
		echo '<script type="text/javascript" language="javascript" src="views/lib/menuie6.js"></script>';
	
endif; #session
?>