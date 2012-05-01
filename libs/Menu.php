<?php
/**
 * System Menu 
 */
class Menu 
{
	function __construct() 
	{
	}
	
	public function loadMenu($privi,$nav,$root)
	{
            if($privi=='9')
            {
                if($nav == 'MSIE 6.0')
                {
                        #Create MSIE6 list menu
                        echo '<ul id="navmenu-h">';
                        $this->menuUser();
                        echo '</ul>'; 
                }
                else
                {
                        #Create standar list menu
                        echo '<ul id="menu">';
                        $this->menuUser();
                        echo '</ul>'; 
                }
            }
            else if($privi=="8")
            {
            }
            else if($privi=="7")
            {
            }
            else if($privi=="6")
            {
            }
            else if($privi=="5")
            {
            }
            else if($privi=="4")
            {
            }
            else if($privi=="3")
            {
            }
            else if($privi=="2")
            {
            }
            else if($privi=='1')
            {	
                if($nav == 'MSIE 6.0')
                {
                        echo '<ul id="navmenu-h">';
                        $this->menuAdmin();
                        echo '</ul>'; 
                }
                else
                {
                        echo '<ul id="menu">';
                        $this->menuAdmin();
                        echo '</ul>'; 
                }	
            }
	}

	function menuUser()
	{
            $this->mimenuuser();
	}
		
	function menuAdmin()
	{
            $this->mimenu();
            $this->otros();
	}
	
	function otros()
	{
            echo '<li><a href="#">Otros</a>';
            echo '<ul>';
            echo '<li><a href="#">Sub Otros</a>';
                echo '<ul>';
                echo '<li><a href="#">SubSub Otros</a></li>';
                echo '</ul>';
            echo '</li>';
            echo '</ul>';
            echo '</li>';
	}
	
	
	function mimenu()
	{ 	
            echo '<li><a href="#">Menu</a>';
            echo '<ul>';
                $this->administracion();
                echo '<li><a href="'.$root.'?controller=users&amp;action=userProfile">Mi Perfill</a></li>';
            echo '</ul>';
            echo '</li>';
	}
	
	function mimenuuser()
	{ 	
            echo '<li><a href="#">Menu</a>';
            echo '<ul>';
                echo '<li><a href="'.$root.'?controller=users&amp;action=userProfile">Mi Perfil</a></li>';
            echo '</ul>';
            echo '</li>';
	}
}
?>