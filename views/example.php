<?php
require('templates/header.tpl.php'); #session & header

#session
if($session->id != null):

#privs
if($session->privilegio == 1 or $session->privilegio == 9):
?>

<!-- JS & CSS -->
<!-- END JS & CSS -->

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
                print_r($titulo); print('<br />'); print_r($controller); print('<br />');
                print_r($action); print('<br />'); print_r($action_b); print('<br />');
                print('</div>');
        }
        ?>
        <!-- END DEBUG -->

        <p class="titulos-form"><?php echo $titulo; ?></p>

        <!-- ERROR MESSAGE -->
        <?php 
        if (isset($error_flag))
                if(strlen($error_flag) > 0)
                        echo $error_flag;
        ?>
        <!-- ERROR MESSAGE -->

        <p>This is a simple page example!</p>

    </div>
    </div>
    <!-- END CENTRAL -->

<?php
endif; #privs
endif; #session
require('templates/footer.tpl.php');
?>