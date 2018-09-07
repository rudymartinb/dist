<?php
include_once( "config.php" );
include_once( $DIST.$LIB."/SQL.php" );
include_once( $DIST.$LIB."/fechas.php" );
include_once( $DIST.$CLASS."/cBasica.php" );
/*
 * solo 1 metodo?
*/
class cReporteDevolucion extends cBasica {
	public $fecha;
	public $cli;
	public $prod; 
	public $cant;

	public $db; 
	public $DetalleError = "";
	
	public function Registrar(){
		$fec = $this->fecha;
		$cli = $this->cli;
		$prod = $this->prod;
		$cant = $this->cant;
		
		$q = "call sp_RegistrarDevolucion( ";
		$q .= "'". fecha2SQL( $fec )."', ";
		$q .= "'".$cli."', ";
		$q .= "'".$prod."', ";
		$q .= " ".$cant." ); ";
		$db = $this->db;
		
		// usar la funcion !!!
		// esto parece estar mal 
		$res = $db->query( $q );
		if( ! $res ) {
			$this->DetalleError = "Registrar: ".$db->error; // ." ".$q
			return false;
		}
		
		return true;
		
	}

}
?>