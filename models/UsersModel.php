<?php
/**
 * Users model class
 * (system users example) 
 * 
 * @author Hernan Thiers
 */
class UsersModel extends ModelBase
{
    /**
     * Get user account
     * @param string $username
     * @param string $password
     * @return PDO 
     */
    public function getUserAccount($username, $password)
    {
            //realizamos la consulta de todos los segmentos
            $consulta = $this->db->prepare("SELECT ID,USUARIO,NOMBRE,APELLIDOP,PRIVILEGIO 
                        FROM t_usuario 
                        WHERE USUARIO='$username' 
                            AND CLAVE='$password'");
            $consulta->execute();

            //devolvemos la coleccion para que la vista la presente.
            return $consulta;
    }

    /**
     * Get user general information
     * @param int $id
     * @param string $username
     * @return PDO 
     */
    public function getUserInfo($id, $username)
    {
        try
        {
            //realizamos la consulta de todos los segmentos
            $consulta = $this->db->prepare("SELECT ID,USUARIO,NOMBRE,APELLIDOP, APELLIDOM,PRIVILEGIO
                        FROM t_usuario 
                        WHERE ID = '$id'
                            AND USUARIO='$username'");

            $consulta->execute();
        }
        catch(PDOException $e)
        {
            return $e->getMessage();
        }

        return $consulta;
    }

    /**
     * Get user password
     * @param int $id
     * @param string $username
     * @return PDO
     */
    public function getUserInfoPassword($id, $username)
    {
        try
        {
            //realizamos la consulta de todos los segmentos
            $consulta = $this->db->prepare("SELECT ID, USUARIO, CLAVE
                        FROM t_usuario
                        WHERE ID = '$id'
                            AND USUARIO = '$username'");

            $consulta->execute();
        }
        catch(PDOException $e)
        {
            #return $e->getMessage();
            return 0;
        }

        return $consulta;
    }

    /**
     * Edit user information
     * @param int $id
     * @param string $username
     * @param string $name
     * @param string $apellidop
     * @param string $apellidom
     * @return PDO
     */
    public function editUserInfo($id, $username, $name, $apellidop, $apellidom)
    {
        require_once 'AdminModel.php';
        $logModel = new AdminModel();
        $sql = "UPDATE t_usuario WHERE '$username'";

        $session = FR_Session::singleton();

        try
        {
            //realizamos la consulta de todos los segmentos
            $consulta = $this->db->prepare("UPDATE t_usuario
                        SET NOMBRE = '$name'
                            , APELLIDOP = '$apellidop'
                            , APELLIDOM = '$apellidom'
                        WHERE ID = '$id'
                            AND USUARIO = '$username'");

            $consulta->execute();

            //Save log event - NOTE THAT IS ACTION IS NOT DEBUGGABLE
            $logModel->addNewEvent($session->usuario, $sql, 'USERS');
        }
        catch(PDOException $e)
        {
            #return $e->getMessage();
            return 0;
        }

        return $consulta;
    }

    /**
     * Edit user password
     * @param int $id
     * @param string $username
     * @param string $password
     * @return PDO
     */
    public function editUserPassword($id, $username, $password)
    {
        require_once 'AdminModel.php';
        $logModel = new AdminModel();
        $sql = "UPDATE t_usuario PASSW WHERE '$username'";

        $session = FR_Session::singleton();

        try
        {
            $new_password = md5($password);

            //realizamos la consulta de todos los segmentos
            $consulta = $this->db->prepare("UPDATE t_usuario
                        SET CLAVE = '$new_password'
                        WHERE ID = '$id'
                            AND USUARIO = '$username'");

            $consulta->execute();

            //Save log event - NOTE THAT IS ACTION IS NOT DEBUGGABLE
            $logModel->addNewEvent($session->usuario, $sql, 'USERS');
        }
        catch(PDOException $e)
        {
            #return $e->getMessage();
            return 0;
        }

        return $consulta;
    }

    /**
     * Add new user
     * @param string $nombre
     * @param string $apellidop
     * @param string $apellidom
     * @param string $username
     * @param string $password
     * @param int $privilegio
     * @return PDO 
     */
    public function addNewUser($nombre, $apellidop, $apellidom, $username, $password, $privilegio)
    {
        require_once 'AdminModel.php';
        $logModel = new AdminModel();
        $sql = "INSERT INTO t_usuario VALUES '$username'";

        $session = FR_Session::singleton();

        try
        {
            $new_password = md5($password);

            //realizamos la consulta de todos los segmentos
            $consulta = $this->db->prepare("INSERT INTO t_usuario
                            (NOMBRE, APELLIDOP, APELLIDOM, USUARIO, CLAVE, PRIVILEGIO)
                            VALUES
                            ('$nombre', '$apellidop', '$apellidom', '$username', '$new_password', $privilegio)");

            $consulta->execute();

            //Save log event - NOTE THAT IS ACTION IS NOT DEBUGGABLE
            $logModel->addNewEvent($session->usuario, $sql, 'USERS');
        }
        catch(PDOException $e)
        {
            #return $e->getMessage();
            return 0;
        }

        return $consulta;
    }
}
?>