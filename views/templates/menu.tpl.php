<?php
$url = (!empty($_SERVER['HTTPS'])) ? "https://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'] : "http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
?>

<div id="cabecera" align="left">
  <br />
  <img alt="logo" src="views/img/logo.png" width="237" height="67" align="left" />
  <img alt="mundolg" src="views/img/logo-mundolg.gif" width="225" height="60" />
</div>

<div class="fin" id="banner">
  Bienvenido <?php echo "<a href='".$rootPath."?controller=users&amp;action=userProfile'>".$session->usuario."</a>"; ?>
   | (<a href="<?php echo $rootPath.'?controller=users&amp;action=logout';?>" style="color:#FFFFFF">SALIR</a>)
</div>

<div id="menu_div" class="menu">
<?php
#echo "<!-- navegador:".$navegador."-->\n";
include 'libs/Menu.php';
$menu = new Menu();
$menu->loadMenu($session->privilegio,$navegador,$rootPath); 
?>
</div>