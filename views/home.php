<?php
require('templates/header_index.tpl.php');
?>

<!-- AGREGAR JS & CSS AQUI -->
</head>

<body>

    <noscript>
    <div>
        <h4>¡Espera un momento!</h4>
        <p>La página que estás viendo requiere JavaScript.
        Si lo has deshabilitado intencionalmente, por favor vuelve a activarlo o comunicate con soporte.</p>
    </div>
    </noscript>

    <!-- CABECERA -->
    <div id="cabecera" align="left">
        <br />
        <a href="<?php echo $rootPath;?>"><img src="views/img/logo.png" width="237" height="67" border="0" align="left" /></a>
        <img src="views/img/logo-mundolg.gif" width="225" height="60" />
    </div>
    
	<div class="Estilo2" id="banner"></div>
    <!-- END CABECERA -->

    <!-- CENTRAL -->
	<div id="central">
		<div id="contenido">
			<form id="form1" name="form1" method="post" action="<?php echo $rootPath.'?controller=users&action=logIn';?>">
            <?php if(isset($error) && $error == 1) echo "<div id='errorbox_failure'>Usuario o contraseña inválido!</div>"; ?>
 			<h2 class="menuinicio">Inicio de sesión</h2>
			<p class="submenu">Especifique su nombre de usuario y contraseña.</p>
            <p class="submenu">
            	Nombre de Usuario
            	<br />
       	        <label>
       	            <input name="txtusername" type="text" class="bien" id="txtuser" size="50" />
            	</label>
            	<br />
            	<br />
    	    	Contraseña
                <br />
          	    <label>
            		<input name="txtpassword" type="password" class="bien" id="txtpass" size="50" />
              	</label>
      		</p>
            <label>
                <input name="button" type="submit" class="boton" id="button" value="Acceder" />
            </label>
        	</form>
		</div>
	</div>
    <!-- END CENTRAL -->

</div>
<!-- END CABECERA -->

<!-- FOOTER -->
<?php require('templates/footer_index.tpl.php'); ?>
<!-- END FOOTER -->