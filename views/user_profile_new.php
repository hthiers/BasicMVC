<?php
require('templates/header.tpl.php'); #session & header

#session
if($session->id != null):

#privs
if($session->privilegio == 1 or $session->privilegio == 9):
?>

<!-- AGREGAR JS & CSS AQUI -->
<script language="javascript">
$(document).ready(function(){
        $("#moduleForm").validate();
});
</script>

</head>
<body>

<?php
require('templates/menu.tpl.php'); #banner & menu
?>
	<!-- CENTRAL -->
	<div id="central">
        <div id="contenido">

            <!-- DEBUG -->
            <?php 
            if($debugMode)
            {
                print('<div id="debugbox">');
                print_r($titulo);
                print("<br />");
                print_r($new_code);print("<br />");
                print_r($controller);print("<br />");print_r($action);print("<br />");
                print_r($action_b);print("<br />");
                print('</div>');
            }
            ?>
            <!-- END DEBUG -->

            <p class="titulos-form"><?php echo $titulo; ?></p>

            <?php 
            if (isset($error_flag))
                if(strlen($error_flag) > 0)
                    echo $error_flag;
            ?>
            
            <form id="moduleForm" name="form1" method="post"  action="<?php echo $rootPath.'?controller='.$controller.'&amp;action='.$action.'';?>">
              <table width="457" height="118" border="0" align="center" class="texto">
                <tr>
                  <td width="56">Nombre</td>
                  <td width="3">:</td>
                  <td width="380"><input class="required" minlength="3" name="name_user" type="text" id="txtcodigo" size="40" /></td>
                </tr>
                <tr>
                  <td>Apellido Paterno</td>
                  <td>:</td>
                  <td><input class="required" minlength="3" name="apellidop_user" type="text" id="txtnombre" size="40" /></td>
                </tr>
                <tr>
                  <td>Apellido Materno</td>
                  <td>:</td>
                  <td><input class="required" minlength="3" name="apellidom_user" type="text" id="txtnombre" size="40" /></td>
                </tr>
                <tr>
                  <td>Nombre de Usuario</td>
                  <td>:</td>
                  <td><input class="required" minlength="3" name="nick_user" type="text" id="txtnombre" size="40" /></td>
                </tr>
                <tr>
                  <td>Contraseña</td>
                  <td>:</td>
                  <td><input class="required" minlength="4" name="password_a" type="password" id="txtnombre" size="40" /></td>
                </tr>
                <tr>
                  <td>Repetir Contraseña</td>
                  <td>:</td>
                  <td><input class="required" minlength="4" name="password_b" type="password" id="txtnombre" size="40" /></td>
                </tr>
                <tr>
                  <td>Privilegio</td>
                  <td>:</td>
                  <td>
                        <?php
                        echo "<select class='required' name='privi_user'>\n";
                        echo "<option value='' selected='selected'>SELECCIONAR</option>\n";
                        for($i=1; $i<10; $i++)
                            echo "<option value='$i'>$i</option>\n";
                        echo "</select>\n";
                        ?>
                  </td>
                </tr>
                <tr>
                  <td colspan="3">
                      <br />
                      <input name="form_timestamp" type="hidden" value="<?php echo microtime(true); ?>" />
                  </td>
                </tr>
                <tr>
                    <td colspan="3" class="submit">
                        <input name="Atras" type="reset" class="input" id="Atras"  onclick="window.location = '<?php echo $rootPath.'?controller='.$controller.'&amp;action='.$action_b.'';?>'"  value="Cancelar" />
                        &nbsp;&nbsp;
                        <input name="button" type="submit" class="input" id="button" value="Guardar" />
                    </td>
                </tr>
              </table>
            </form>
        
    </div>
    </div>
    <!-- END CENTRAL -->

<?php
endif; #privs
endif; #session
require('templates/footer.tpl.php');
?>