<?php
/**
 * User controller
 * @author Hernan Thiers 
 */
class UsersController extends ControllerBase
{
    /*
     * login action 
     */
    public function logIn()
    {
            //Parametros login form
            isset($_POST['txtusername'],$_POST['txtpassword'],$usuario1,$datos,$priv);
            $username = $_POST['txtusername'];
            $password = md5($_POST['txtpassword']);

            //Incluye el modelo que corresponde
            require_once 'models/UsersModel.php';

            //Creamos una instancia de nuestro "modelo"
            $account = new UsersModel();

            //Le pedimos al modelo que busque la cuenta de usuario (nombre de usuario y contraseña)
            $result = $account->getUserAccount($username, $password);
            $values = $result->fetch(PDO::FETCH_ASSOC);

            //Segun resultado iniciamos sesion (ir a sistema) o lanzamos error (volver a home)
            if(isset($values['ID']) == true && $values['ID'] > 0)
            {
                //Set timezone
                date_default_timezone_set($this->timezone);

                //Start session
                $session = FR_Session::singleton();
                $session->id = $values['ID'];
                $session->usuario = $values['USUARIO'];
                $session->datos = $values['NOMBRE']." ".$values['APELLIDOP'];
                $session->privilegio = $values['PRIVILEGIO'];

                header("Location: ".$this->root."?controller=users&action=userProfile");
            }
            else
                header("Location: ".$this->root."?controller=index&action=indexErrorLogin");
    }

    /*
     * logout action
     */
    public function logOut()
    {
        //Finish session
        $session = FR_Session::singleton();
        $session->destroy();

        header("Location: ".$this->root);		
    }

    /**
     * show user profile
     * @param int $error_flag 
     */
    public function userProfile($error_flag = 0)
    {
        $session = FR_Session::singleton();

        $session_id = $session->id;
        $session_user = $session->usuario;

        require_once 'models/UsersModel.php';
        $account = new UsersModel();

        $data['user_data'] = $account->getUserInfo($session_id, $session_user);

        //Titulo pagina
        $data['titulo'] = "MI PERFIL";

        //Controller
        $data['controller'] = "users";
        //Action edit
        $data['action'] = "userProfileEditForm";

        //Posible error
        $data['error_flag'] = $this->errorMessage->getError($error_flag);

        //Finalmente presentamos nuestra plantilla
        $this->view->show("user_profile.php", $data);
    }

    /*
     * show user profile edition form
     */
    public function userProfileEditForm()
    {
        if($_POST)
        {
            $data['id_user'] = $_POST['id_user'];
            $data['nick_user'] = $_POST['nick_user'];
            $data['name_user'] = $_POST['name_user'];
            $data['apellidop_user'] = $_POST['apellidop_user'];
            $data['apellidom_user'] = $_POST['apellidom_user'];

            //Finalmente presentamos nuestra plantilla
            $data['titulo'] = "mi perfil > EDICION";

            //time value for submit control
            $data['orig_timestamp'] = microtime(true); //debug
            $session->orig_timestamp = $data['orig_timestamp'];

            //Controller
            $data['controller'] = "users";
            //Action edit
            $data['action'] = "userProfileEdit";
            //Action back
            $data['action_b'] = "userProfile";

            $this->view->show("user_profile_edit.php", $data);
        }
        else
            $this->userProfile();
    }

    /*
     * user profile edition action
     */
    public function userProfileEdit()
    {
        if($_POST['form_timestamp'] != $session->orig_timestamp)
        {
            //Avoid resubmit
            $session->orig_timestamp = $_POST['form_timestamp'];

            $id_user = $this->utils->cleanQuery($_POST['id_user']);
            $nick_user = $this->utils->cleanQuery($_POST['nick_user']);
            $name_user = $this->utils->cleanQuery($_POST['name_user']);
            $apellidop_user = $this->utils->cleanQuery($_POST['apellidop_user']);
            $apellidom_user = $this->utils->cleanQuery($_POST['apellidom_user']);

            //Incluye el modelo que corresponde
            require_once 'models/UsersModel.php';

            //Creamos una instancia de nuestro "modelo"
            $model = new UsersModel();

            //Le pedimos al modelo todos los items
            $result = $model->editUserInfo($id_user, $nick_user, $name_user, $apellidop_user, $apellidom_user);

            if($result->rowCount() > 0)
            {
                    $this->userProfile(1);
            }
            else
            {
                    $this->userProfile(2);
            }
        }
        else
        {
                $this->userProfile(2);
        }
    }

    /*
     * show user password edition form
     */
    public function userPasswordEditForm()
    {
        if(isset($_GET['id']) == true && isset($_GET['usuario']) == true)
        {
            //Finalmente presentamos nuestra plantilla
            $data['titulo'] = "mi perfil > cambio contraseña";

            $data['id_user'] = $_GET['id'];
            $data['nick_user'] = $_GET['usuario'];

            //time value for submit control
            $data['orig_timestamp'] = microtime(true); //debug
            $session->orig_timestamp = $data['orig_timestamp'];

            //Controller
            $data['controller'] = "users";
            //Action edit
            $data['action'] = "userPasswordEdit";
            //Action back
            $data['action_b'] = "userProfile";

            $this->view->show("user_password_edit.php", $data);
        }
        else
            $this->userProfile(2);
    }

    /*
     * user password edition action
     */
    public function userPasswordEdit()
    {
        if($_POST['form_timestamp'] != $session->orig_timestamp)
        {
            //Avoid resubmit
            $session->orig_timestamp = $_POST['form_timestamp'];

            $id_user = $this->utils->cleanQuery($_POST['id_user']);
            $nick_user = $this->utils->cleanQuery($_POST['nick_user']);
            $password_actual = $this->utils->cleanQuery($_POST['password_actual']);
            $password_nuevo_a = $this->utils->cleanQuery($_POST['password_nuevo_a']);
            $password_nuevo_b = $this->utils->cleanQuery($_POST['password_nuevo_b']);

            //Incluye el modelo que corresponde
            require_once 'models/UsersModel.php';

            //Creamos una instancia de nuestro "modelo"
            $model = new UsersModel();

            //VALIDATION CASES
            $password_real = $model->getUserInfoPassword($id_user, $nick_user);
            $values = $password_real->fetch(PDO::FETCH_ASSOC);                    

            if(md5($password_actual) == $values['CLAVE'])
            {
                if($password_nuevo_a == $password_nuevo_b)
                {
                    //Le pedimos al modelo todos los items
                    $result = $model->editUserPassword($id_user, $nick_user, $password_nuevo_b);

                    if($result->rowCount() > 0)
                    {
                            //Destroy POST
                            unset($_POST);

                            $this->userProfile(1);
                    }
                    else
                    {
                            //Destroy POST
                            unset($_POST);

                            //error general
                            $this->userProfile(2);
                    }
                }
                else
                {
                        //Destroy POST
                        unset($_POST);

                        //error password no coinciden
                        $this->userProfile(5);
                }
            }
            else
            {
                    //Destroy POST
                    unset($_POST);

                    //error password invalido
                    $this->userProfile(4);
            }
        }
        else
        {
            //access error
            $this->userProfile(2);
        }
    }

    /**
     * show new user form
     * @param int $error_flag 
     */
    public function userProfileAddForm($error_flag = 0)
    {
        //Finalmente presentamos nuestra plantilla
        $data['titulo'] = "Administración > nuevo usuario";

        //time value for submit control
        $data['orig_timestamp'] = microtime(true); //debug
        $session->orig_timestamp = $data['orig_timestamp'];

        //Controller
        $data['controller'] = "users";
        //Action edit
        $data['action'] = "userProfileAdd";
        //Action back
        $data['action_b'] = "userProfile";

        //Posible error
        $data['error_flag'] = $this->errorMessage->getError($error_flag);

        $this->view->show("user_profile_new.php", $data);
    }

    /*
     * new user action
     */
    public function userProfileAdd()
    {
        if($_POST['form_timestamp'] != $session->orig_timestamp)
        {
            //Avoid resubmit
            $session->orig_timestamp = $_POST['form_timestamp'];

            $name_user = $_POST['name_user'];
            $apellidop_user = $_POST['apellidop_user'];
            $apellidom_user = $_POST['apellidom_user'];
            $nick_user = $_POST['nick_user'];
            $password_a = $_POST['password_a'];
            $password_b = $_POST['password_b'];
            $privi_user = $_POST['privi_user'];

            if($password_a == $password_b)
            {
                //Incluye el modelo que corresponde
                require_once 'models/UsersModel.php';

                //Creamos una instancia de nuestro "modelo"
                $model = new UsersModel();

                $result = $model->addNewUser($name_user, $apellidop_user, $apellidom_user, $nick_user, $password_b, $privi_user);

                if($result->rowCount() > 0)
                {
                        $this->userProfile(1);
                }
                else
                {
                        //error general
                        $this->userProfileAddForm(2);
                }
            }
            else
            {
                //error password no coinciden
                $this->userProfileAddForm(5);
            }
        }
        else
        {
            //access error
            $this->userProfileAddForm(5);
        }
    }
}
?>