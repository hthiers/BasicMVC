<?php
/**
 * Main index controller for login actions
 * @author Hernan Thiers 
 */
class IndexController extends ControllerBase
{
    //Go to index
    public function index()
    {	
        $this->view->show("home.php", $vars);
    }
	
    //Go to error index
    public function indexErrorLogin()
    {
	$vars['error'] = 1;
		
        $this->view->show("home.php", $vars);
    }
    
    /**
     * Si ambas acciones llevan a un mismo destino 
     * puede dejarse una sola funcion.
     */
}
?>