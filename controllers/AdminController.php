<?php
/**
 * Administration controller
 * @author Hernan Thiers 
 */
class AdminController extends ControllerBase
{
	/*******************************************************************************
	* ADMINISTRATION MODULE CONTROLLER
	*******************************************************************************/
	
	/**
         * Show log historial datatable
         * @param int $error_flag
         * @param string $message 
         */
	public function eventsDt($error_flag = 0, $message = "")
	{
		//Titulo pagina
		$data['titulo'] = "ADMINISTRACION - HISTORIAL DE EVENTOS";

		//Posible error
		$data['error_flag'] = $this->errorMessage->getError($error_flag, $message);
		
		//Finalmente presentamos nuestra plantilla
		$this->view->show("admin_events_dt.php", $data);
	}
        
        /**
         * Ajax response for historial datatable interactions
         * @return json
         */
        public function ajaxEventsDt()
        {
            //Incluye el modelo que corresponde
            require_once 'models/AdminModel.php';

            //Creamos una instancia de nuestro "modelo"
            $model = new AdminModel();


            /*
            * Build up dynamic query
            */
            
            $sTable = $model->getTableName();
            $aColumns = $model->getTableColumnNames();
            $sIndexColumn = "ID";

            /******************** Paging */
            if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' )
                $sLimit = "LIMIT ".mysql_real_escape_string( $_GET['iDisplayStart'] ).", ".mysql_real_escape_string( $_GET['iDisplayLength'] );

            /******************** Ordering */
            $sOrder = "";
            if ( isset( $_GET['iSortCol_0'] ) )
            {
                    $sOrder = "ORDER BY  ";
                    for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ )
                    {
                            if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" )
                            {
                                    $sOrder .= "".$aColumns[ intval( $_GET['iSortCol_'.$i] ) ]." ".
                                            mysql_real_escape_string( $_GET['sSortDir_'.$i] ) .", ";
                            }
                    }

                    $sOrder = substr_replace( $sOrder, "", -2 );
                    if ( $sOrder == "ORDER BY" )
                    {
                            $sOrder = "";
                    }
            }

            /******************** Filtering */
            $sWhere = "";

            if ( isset($_GET['sSearch']) && $_GET['sSearch'] != "" )
            {
                $sWhere = "WHERE (";
                for ( $i=0 ; $i<count($aColumns) ; $i++ )
                {
                    $sWhere .= "".$aColumns[$i]." LIKE '%".mysql_real_escape_string( $_GET['sSearch'] )."%' OR ";
                }

                $sWhere = substr_replace( $sWhere, "", -3 );
                $sWhere .= ')';
            }

            /********************* Individual column filtering */
            for ( $i=0 ; $i<count($aColumns) ; $i++ )
            {
                if ( isset($_GET['bSearchable_'.$i]) && $_GET['bSearchable_'.$i] == "true" && $_GET['sSearch_'.$i] != '' )
                {
                    if ( $sWhere == "" )
                    {
                        $sWhere = "WHERE ";
                    }
                    else
                    {
                        $sWhere .= " AND ";
                    }

                    $sWhere .= "".$aColumns[$i]." LIKE '%".mysql_real_escape_string($_GET['sSearch_'.$i])."%' ";
                }
            }

            /********************** Create Query */
            $sql = "
                SELECT SQL_CALC_FOUND_ROWS ".str_replace(" , ", " ", implode(", ", $aColumns))."
                FROM $sTable
                $sWhere
                $sOrder
                $sLimit
                ";

            $result_data = $model->goCustomQuery($sql);

            $found_rows = $model->goCustomQuery("SELECT FOUND_ROWS()");

            $total_rows = $model->goCustomQuery("SELECT COUNT(`".$sIndexColumn."`) FROM $sTable");

            /*
            * Output
            */
            $iTotal = $total_rows->fetch(PDO::FETCH_NUM);
            $iTotal = $iTotal[0];

            $iFilteredTotal = $found_rows->fetch(PDO::FETCH_NUM);
            $iFilteredTotal = $iFilteredTotal[0];

            $output = array(
                    "sEcho" => intval($_GET['sEcho']),
                    "iTotalRecords" => $iTotal,
                    "iTotalDisplayRecords" => $iFilteredTotal,
                    "aaData" => array()
            );

            $k = 1;
            while($aRow = $result_data->fetch(PDO::FETCH_NUM))
            {
                    $row = array();

                    for ( $i=0 ; $i<count($aColumns) ; $i++ )
                    {
                        $row[] = $aRow[ $i ];
                    }

                    $output['aaData'][] = $row;

                    $k++;
            }

            // Print (return) json string
            echo json_encode( $output );
        }

}
?>