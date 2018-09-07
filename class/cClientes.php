<?php
include_once( "config.php" );
include_once( $DIST.$LIB."/SQL.php" );
include_once( $DIST.$CLASS."/cBasica.php" );
interface ClienteSQL {
	public function GrabarAlta();
}
class cClientes extends cBasica {
	public $cod = "";
	public $raz = "";
	public $dom = "";
	public $loc = "";
	public $cpo = "";
	public $tel = "";
	public $gan = 0.0;
	public $zona="";
	public $grupo ="";
	
	public $db;
	
	public $DetalleError;
	
	public function __set($name, $value){
	}

	public function Clear(){
		return true;
	}
	public function EsValido(){
		return true;
	
	}
	
	public function GrabarAlta(){
		if( ! $this->EsValido() ){
			return false;
		}
		
		$this->cod = PadN( $this->cod , 3 );
		$query = "call SP_ClientesAlta( ";
		$query .= "'$this->cod',";
		$query .= "'$this->raz',";
		$query .= "'$this->dom',";
		$query .= "'$this->tel',";
		$query .= "'$this->loc',";
		$query .= "'$this->cpo',";
		$query .= " $this->gan  ,"; 
		$query .= "'$this->zona' ,"; 
		$query .= "'$this->grupo' );"; 
		
		return ejecutar_query( $query );		

	}

	
	public function GrabarModi(){
		if( ! $this->EsValido() ){
			return false;
		}
		
		$this->cod = PadN( $this->cod , 3 );
	
		$txt = "call SP_ClientesModi( ";
		$txt .= "'$this->cod',";
		$txt .= "'$this->raz',";
		$txt .= "'$this->dom',";
		$txt .= "'$this->tel',";
		$txt .= "'$this->loc',";
		$txt .= "'$this->cpo',";
		$txt .= " $this->gan ,"; 
		$txt .= "'$this->zona' ,"; 
		$txt .= "'$this->grupo' );"; 
		return ejecutar_query( $txt );
	
	}
	
		
	public function Leer( ){
		$q = "call SP_ClientesLeer( '$this->cod' ); ";
		$arr = ejecutar_query( $q );		
		$obj = $arr[0];
		$this->raz = $obj['razcli'];
		$this->dom = $obj['domcli'];
		$this->loc = $obj['loccli'];
		$this->cpo = $obj['cpocli'];
		$this->tel = $obj['telcli'];
		$this->gan = $obj['gancli'];
		$this->zona = $obj['zona'];
		$this->grupo = $obj['grucli'];
		
		return true;
	
	}


}

?>