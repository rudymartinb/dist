<?php
// require_once( "config.php" );
// require_once( $DIST.$LIB."/SQL.php" );
/*
 * problema: extraer dependiencia al $db 
 */
class cProducto {
    protected $cod = "";
    protected $des = "";
    protected $abr = "";
    protected $controlpapelusado = "";
    protected $db;
    
	private $DetalleError;
	
	public function getDes()  {
	    return $this->des;
	}
	
	protected function __construct( ) {
	    // $this->db = $db;
	 
	}
	
	public static function Builder(){
	    return new class extends cProducto {
	        public function setDB( $db ){
	           $this->db = $db;
	           return $this;
	        }
	        
	        public function setCod( string $valor ){
	            $this->cod = $valor;
	            return $this;
	        }
	        
	        public function setDes( string $des ){
	           $this->des = $des;
	           return $this;
	        }
	        public function setAbr( string $valor) {
	            $this->abr = $valor;
	            return $this;
	        }
	        public function setCtrl( bool $valor ){
	            $this->controlpapelusado = $valor;
	            return $this;
	        }
	        public function setDemo(){
	            $this->cod = "998" ;
	            $this->des = "DIARIO LUNES";
	            $this->abr = "E.LUNES";
	            $this->controlpapelusado = false;
	            return $this;
	        }
	        
	        public function build(){
	            $prod = new cProducto( null );
	            // var_dump( $this );
	            $prod->cod = $this->cod;
	            $prod->des = $this->des;
	            $prod->abr = $this->abr;
	            $prod->controlpapelusado = $this->controlpapelusado;
	            $prod->db = $this->db;
	            return $prod;
	        }
	    };
	}
	

	
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

		$this->cod = PadN( $this->cod , 3 );

		if( $this->controlpapelusado ){ 
			$ctrl = "true"; 
		} else { 
			$ctrl = "false"; 
		}
		
		$txt = "call SP_ProductoAlta( '$this->cod', '$this->des', '$this->abr', $ctrl  )";
		
		$res = $this->db->ejecutar( $txt );
		
		// return false;
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