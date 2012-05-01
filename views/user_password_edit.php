<?php
require('templates/header.tpl.php'); #session & header

#session
if($session->id != null):

#privs
if($session->privilegio == 1 or $session->privilegio == 9):
?>

<!-- AGREGAR JS & CSS AQUI -->
<style type="text/css" title="currentStyle">
	@import "views/css/datatable.css";
</style>

</head>
<body id="dt_example">

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
            print_r($titulo); print('<br />');print_r($controller); print('<br />');
            print_r($action); print('<br />');print_r($action_b); print('<br />');
            print(htmlspecialchars($error_flag, ENT_QUOTES)); print('<br />');
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
        <form method="post" action="<?php echo $rootPath.'?controller='.$controller.'&amp;action='.$action.'';?>">
        <table id="normaltable" class="texto">
            <thead>
                <tr class="headers">
                    <th colspan="2">CAMBIO CONTRASEÑA: <?php echo $nick_user;?></th>
                </tr>
            </thead>
            <tbody>
            <tr>
                <td>CONTRASEÑA ACTUAL</td>
                <td><input type="password" name="password_actual" /></td>
            </tr>
            <tr>
                <td>NUEVA CONTRASEÑA</td>
                <td><input type="password" name="password_nuevo_a" /></td>
            <tr>
                <td>REPETIR NUEVA CONTRASEÑA</td>
                <td><input type="password" name="password_nuevo_b" /></td>
            </tr>
            <tr>
                <td>
                    <input name="id_user" type="hidden" value="<?php echo $id_user;?>" />
                    <input name='nick_user' type='hidden' value="<?php echo $nick_user;?>" />
                    <input name="form_timestamp" type="hidden" value="<?php echo microtime(true); ?>" />

                    <input class="input" type="reset" value="CANCELAR" onclick="window.location = '<?php echo $rootPath.'?controller='.$controller.'&amp;action='.$action_b.'';?>'"  value="CANCELAR" />
                </td>
                <td>
                    <input class="input" type="submit" value="GUARDAR" />
                </td>
            </tr>
            </tbody>
        </table>
        </form>

        <div class="spacer"></div>

    </div>
    </div>
    <!-- END CENTRAL -->

<?php
endif; #privs
endif; #session
require('templates/footer.tpl.php');
?>