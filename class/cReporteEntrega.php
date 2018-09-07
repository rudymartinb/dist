<?php
include_once ("config.php");
include_once( $DIST.$CLASS."/cBasica.php" );
include_once( $DIST.$LIB."/SQL.php" );
include_once( $DIST.$LIB."/fechas.php" );
include_once( $DIST.$LIB."/TiposDatos.php" );

class cReporteEntrega extends cBasica  {
	public $TestMode = false;
	public $db;
	public $idx;
	
	public $fecha;
	public $pro;
	public $Observaciones = "";
	// public $prefijo ;
	
	
	public $DetalleError;
	public $rec = []; // Reporte Entrega Cliente
	
	
	public function Valido(){
		if( $this->db === null ){
			return false;
		}
		if( ! ValidarFecha( $this->fecha  ) ){
			return false;
		}		
		if( count( $this->rec ) == 0 ){
			return false;
		}
		return true;
	}
	
	public function ClearAll(){
		$this->idx = null;
		$this->fecha = "";
		$this->pro = "";
		$this->Observaciones = "";
		$this->DetalleError = "";
		$this->rec = [];
		
	}
	public function Agregar( $cli, $cantcc, $cantsc ){
		for( $i = 0; $i < count( $this->rec ); $i++ ){
			if( $this->rec[ $i ][0] == $cli ){
				$this->rec[ $i ] = [ $cli, $cantcc, $cantsc ];
				return true;
			}
		}
		/* cliente debe existir
		** validamos ahora o luego cuando grabamos?
		*/
		$this->rec[] = [ $cli, $cantcc, $cantsc ];
		return true;
	}
	public function GrabarAlta(){
		if( ! SQL_EsValido( $this->db ) ){
			$this->DetalleError = "db no asignada";
			return false;
		}
		$db = $this->db;
		if( ! $this->TestMode ) {
			$q = "start transaction;";
			try {
				$res = $db->query( $q );
			} catch ( Exception $e ) {
				$this->DetalleError  = $e->getMessage() ;
				return false;
			}
			if( $res === FALSE ) {
				$this->DetalleError  = "Error: ". $db->error ;
				return false;
			}

		}
		
		$q = "call sp_ReporteEntregaAlta( ";
		$q .= "'".Fecha2SQL( $this->fecha )."' ,";
		$q .= "'".$this->pro ."' ,";
		$q .= "'".$this->Observaciones ."' );";
		try {
			$res = $db->query( $q );
		} catch ( Exception $e ) {
			$this->DetalleError = $e->getMessage() ;
			return false;
		}
		if( $res === FALSE ) {
			$this->DetalleError = "Error: ". $db->error ;
			return false;
		}
		
		/* SP devuelve el idx en un select
		*/
		$idx = 0;
		if( $db->more_results() ) {
			if( $obj = $res->fetch_object() ){
				$idx = $obj->idx ;
			}
			while ( $db->more_results() ){
				$db->next_result();
			}
		} else {
			$this->DetalleError = "Sin IDX" ;
			return false;
		}
		
		if( $idx == 0 ){
			$this->DetalleError = "IDX en cero" ;
			return false;
		}
		$this->idx = $idx;
		
		for( $i = 0; $i < count( $this->rec ) ; $i++ ){
			$q = "call sp_ReporteEntregaClienteAlta( ";
			$q .= "".$idx." ,";
			$q .= "'".$this->rec[$i][0] ."' ,";
			$q .= " ".$this->rec[$i][1] ." ,";
			$q .= " ".$this->rec[$i][2] ." );";
			try {
				$res = $db->query( $q );
			} catch ( Exception $e ) {
				$this->DetalleError = $e->getMessage() ;
				return false;
			}
			if( $res === FALSE ) {
				$this->DetalleError = "Error: ". $db->error ;
				return false;
			}
		}
		
		
		if( ! $this->TestMode ) {
			$q = "commit;";
			try {
				$res = $db->query( $q );
			} catch ( Exception $e ) {
				$this->DetalleError = $e->getMessage() ;
				return false;
			}
			if( $res === FALSE ) {
				$this->DetalleError  = "Error: ". $db->error ;
				return false;
			}
		}
		return true;
	}
	
}

?>
