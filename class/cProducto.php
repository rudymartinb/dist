<?php
include_once( "config.php" );
include_once( $DIST.$LIB."/SQL.php" );

class cProducto {
	public $cod = "";
	public $des = "";
	public $abr = "";
	public $controlpapelusado = "";
	
	public $db;
	public $DetalleError;
	
	public function __set($name, $value){
	}

	public function Clear(){
		$this->cod = "";
		$this->des = "";
		$this->abr = "";
		$this->controlpapelusado = "";
		return true;
	}
	
	/* sin uso ?
	*/
	public function EsValido(){
		return true;
	
	}
	
	public function GrabarAlta(){
		if( ! $this->EsValido() ){
			return false;
		}
		
		$this->cod = PadN( $this->cod , 3 );

		if( $this->controlpapelusado ){ 
			$ctrl = "true"; 
		} else { 
			$ctrl = "false"; 
		}
		
		$txt = "call SP_ProductoAlta( '$this->cod', '$this->des', '$this->abr', $ctrl  )";
		
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
		if( $res ) {
			if( $obj = $res->fetch_object() ){
				$quepaso = $obj->resultado;
				while ( $this->db->more_results() ){
					$this->db->next_result();
				}
				$this->DetalleError = $this->db->error; 
				if( $quepaso ) {
					return true;
				}
			}
		}
		return false;
	}

	
	public function GrabarModi(){
		if( ! $this->EsValido() ){
			return false;
		}
		
		$this->cod = PadN( $this->cod , 3 );

		if( $this->controlpapelusado ){ $ctrl = "true"; } else { $ctrl = "false"; }
		
		$txt = "call SP_ProductoModi( ";
		$txt .= "'$this->cod',";
		$txt .= "'$this->des',";
		$txt .= "'$this->abr',";
		$txt .= " $ctrl  )";
		
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
		if( $res ) {
			if( $obj = $res->fetch_object() ){
				$quepaso = $obj->resultado;
				while ( $this->db->more_results() ){
					$this->db->next_result();
				}
				$this->DetalleError = $this->db->error; 
				if( $quepaso ) {
					return true;
				}
			}
		}
		return false;
	}
	
		
	public function Leer( ){
		$q = "call SP_ProductosLeer( '$this->cod' ); ";
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
		if( $obj = $res->fetch_object() ){
			$this->des = $obj->despro ;
			$this->abr = $obj->abrpro ;
			$this->controlpapelusado = $obj->ctlpro;
			$res->close();
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