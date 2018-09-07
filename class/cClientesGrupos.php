<?php
include_once( "config.php" );
include_once( $DIST.$LIB."/SQL.php" );

class cClientesGrupos {
	public $cod = "";
	public $des = "";
	public $abr = "";
	
	public $db;
	public $DetalleError;
	
	public function __set($name, $value){
	}

	public function Clear(){
		$this->cod = "";
		$this->des = "";
		$this->abr = "";
		return true;
	}
	public function EsValido(){
		if( $this->cod == "" ){
			return false;
		}
		if( $this->des == "" ){
			return false;
		}
		if( $this->abr == "" ){
			return false;
		}
		return true;
	
	}
	
	public function GrabarAlta(){
		if( ! $this->EsValido() ){
			return false;
		}
		
		$this->cod = PadN( $this->cod , 3 );
		$txt = "call SP_ClientesGruposAlta( ";
		$txt .= "'$this->cod',";
		$txt .= "'$this->des',";
		$txt .= "'$this->abr' );"; 
		
		try {
			$res = $this->db->query( $txt );
		} catch(Exception $e) {
			$this->DetalleError = $e->getMessage();
			return false;
		}
		if( $this->db->errno <> 0 ){
			$this->DetalleError = "Error " . $this->db->error ;
			return false;
		}
		$this->DetalleError = $txt;
		return true;
	}

	
	public function GrabarModi(){
		if( ! $this->EsValido() ){
			return false;
		}
		
		$this->cod = PadN( $this->cod , 3 );
	
		$txt = "call SP_ClientesGruposModi( ";
		$txt .= "'$this->cod',";
		$txt .= "'$this->des',";
		$txt .= "'$this->abr' );"; 
		
		try {
			$res = $this->db->query( $txt );
		} catch(Exception $e) {
			$this->DetalleError = $e->getMessage();
			return false;
		}
		if( $this->db->errno <> 0 ){
			$this->DetalleError = "Error " . $this->db->error ;
			return false;
		}
		return true;
	}

	public function Result( ){
		$q = "call dev_last_result(); ";
		$db = $this->db;
		$result = false;
		try {
			$res = $db->query( $q );
		} catch ( Exception $e ) {
			$this->DetalleError = $e->getMessage();
			return false;
		}
		if( $res === FALSE ) {
			$this->DetalleError = $db->error ;
			return false;
		}
		if( $obj = $res->fetch_object() ){
			$result = $obj->result ;
			$res->close();
		} else {
			return false;
		}
		while( $db->more_results() ){
			$db->next_result();
		}
		return $result;
	}	
		
	public function Leer( ){
		$q = "call SP_ClientesGruposLeer( '$this->cod' ); ";
		$db = $this->db;
		try {
			$res = $db->query( $q );
		} catch ( Exception $e ) {
			$this->DetalleError = $e->getMessage();
			return false;
		}
		if( $res === FALSE ) {
			$this->DetalleError = $db->error ;
			return false;
		}
		if( $db->more_results() ){
			if( $obj = $res->fetch_object() ){
				$this->des = $obj->desgru ;
				$this->abr = $obj->abrgru ;
				$res->close();
			} 
		} else {
			return false;
		}
		while( $db->more_results() ){
			$db->next_result();
		}
		return true;
	}


}

?>