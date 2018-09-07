<?php
require( "config.php" );
require_once( $DIST.$CLASS."/cBasica.php" );
class cFakeResult extends cBasica {
	public $prox_recordset;

	public function fetch_array(){
		reset( $this->prox_recordset );
		$first_key = key( $this->prox_recordset );
		$arr = $this->prox_recordset[ $first_key ];
		unset( $this->prox_recordset[ $first_key ] );
		reset( $this->prox_recordset );
		return $arr;
	}

	public function fetch_all(){
		return $this->prox_recordset;
	}

	public function free(){
		return ;
	}
		
	public function fetch_object(){
		$arr = new stdClass();
		
		$esto = $this->prox_recordset[0];
		foreach( $esto as $key => $value ){
			$arr->$key = $value;
		}
		unset( $this->prox_recordset[0] );
		return $arr;
	}	
	
}
class cFakeDB extends cBasica {
	private $devolver = [];
	
	private $prox_recordset; // lista de items a devolver
	private $more = false;
	private $ultimoquery = "";
	
	public $errno = 0;
	public $error = "";
	
	public function EsperarQuery( $q, $devolver ){
		$this->devolver[] = [ $q, $devolver ];
		return true;
	}

	public function query( $q ){
		foreach( $this->devolver as $key => $value ){
			if( $value[0] == $q ){
				$res = new cFakeResult();
				$res->prox_recordset = $value[1];
				unset( $this->devolver[ $key ] );
				$this->more = false;
				$this->ultimoquery = $q;
				return $res;
			}
		}
		$this->prox_recordset = null;
		return false;
	}
	
	/* 
	esto esta mal
	deberia remover el primer index 
	en la lista de resultados a devolver 
	para el comando actual.
	*/
	public function next_result(){
		$this->more = false;
	}
	public function more_results(){
		return $this->more;
		// $cant = count( $this->prox_recordset );
		// return $cant > 0 ;
	}
	
}
?>
