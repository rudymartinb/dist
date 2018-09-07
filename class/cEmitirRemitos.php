<?php
/* esta clase es un elemento 
** que forma parte de cReporteProduccion
*/

include_once( "config.php" );
include_once( $DIST.$CLASS."/cBasica.php" );
include_once( $DIST.$LIB."/SQL.php" );
include_once( $DIST.$LIB."/fechas.php" );

class cEmitirRemitos extends cBasica  {
	public $db;
	public $DetalleError = "";
	public $fecha;
	public function ObtenerListaRemitos(){
		if( !SQL_EsValido( $this->db ) ){
			$this->DetalleError = "mal db";
			return null;
		}
		if( !ValidarFecha( $this->fecha ) ){
			$this->DetalleError = "mal fecha";
			return null;
		}
		$fecha = fecha2SQL( $this->fecha );
		
		$lista = [];
		$q = "call sp_remitos_leer( '".$fecha."' )";
		$res = $this->db->query( $q );
		if( ! $res ){
			$this->DetalleError = "falla query ".$this->db->error." (".$q.")";
			return false;
		}
		while( $row = $res->fetch_assoc() ){
			$lista[] = $row;
		}
		while( $this->db->more_results() ){
			$this->db->next_result();
		}		
		$res->close();
		return $lista;

		

	}
}


?>	
