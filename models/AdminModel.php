<?php
/**
 * Administration model class
 * (admin backend example)
 * 
 * @author Hernan Thiers 
 */
class AdminModel extends ModelBase
{
    /*******************************************************************************
    * ADMINISTRATION MODULE MODEL
    *******************************************************************************/

    /**
        * Get all log events
        * @return PDO
        */
    public function getAllEvents()
    {
        $consulta = $this->db->prepare("
                SELECT 
                    USUARIO
                    , FECHA
                    , MODIFICACION
                    , IP_CLIENTE
                    , HOST_NAME
                    , MODULO
                FROM t_seguimiento ORDER BY FECHA DESC
        ");

        $consulta->execute();

        return $consulta;
    }

    /**
        * Get number of all log events
        * @return PDO 
        */
    public function getEventsTotalNumber()
    {
        $consulta = $this->db->prepare("
                SELECT
                    COUNT(ID)
                FROM t_seguimiento
        ");

        $consulta->execute();

        return $consulta;
    }

    /**
        * Add new log event
        * @param string $usuario
        * @param string $modificacion
        * @param string $modulo
        * @return int 
        */
    public function addNewEvent($usuario, $modificacion, $modulo)
    {
        $fecha = date('Y-m-d H:i:s');
        $ip_cliente = $_SERVER["REMOTE_ADDR"];
        $log_sql = str_replace("'"," ",$modificacion);
        $host_name = gethostbyaddr($_SERVER['REMOTE_ADDR']);

        try
        {
            $consulta = $this->db->prepare("
                    INSERT INTO t_seguimiento 
                            (USUARIO
                            , FECHA
                            , MODIFICACION
                            , IP_CLIENTE
                            , HOST_NAME
                            , MODULO) 
                    VALUES 
                            ('$usuario'
                            ,'$fecha'
                            ,'$log_sql'
                            ,'$ip_cliente'
                            ,'$host_name'
                            ,'$modulo')
                    ");

            $consulta->execute();
        }
        catch(PDOException $e)
        {
                return 0;
        }

        return $consulta;
    }

    /**
        * Get PDO object from custom sql query
        * NOTA: Esta función impide tener un control de la consulta sql (depende desde donde se llame).
        * @param string $sql
        * @return PDO 
        */
    public function goCustomQuery($sql)
    {
        $consulta = $this->db->prepare($sql);

        $consulta->execute();

        return $consulta;
    }

    /**
        * Get database table name linked to this model
        * NOTA: Solo por lógica modelo = tabla
        * @return string 
        */
    public function getTableName()
    {
        $tableName = "t_seguimiento";

        return $tableName;
    }

    /**
        * Get database table column names
        * NOTA: Solo por lógica modelo = tabla
        * @return array
        */
    public function getTableColumnNames()
    {
        $columns = array('USUARIO'
            , 'FECHA'
            , 'MODIFICACION'
            , 'IP_CLIENTE'
            , 'HOST_NAME'
            , 'MODULO'
        );

        return $columns;
    }
}