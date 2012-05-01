<?php
#session
if($session->id != null):
#if(isset($_SESSION['usuario'])):

#privs
if($session->privilegio == 1 or $session->privilegio == 9):
?>
<div id="info">
  <p class="Estilo1"> MY SITE POWERED BY EASYMVC</p>
</div>

</body>
</html>
<?php
else:
	echo '<script language="JavaScript">alert("Usted No Posee Privilegios Suficientes "); document.location = "/som_v21/"</script>';
endif; #privileges
else:
	session_destroy();
	echo '<script language="JavaScript">alert("Debe Identificarse"); document.location = "/som_v21/"</script>';
endif; #session
?>