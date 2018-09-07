<?php

include_once( "config.php" );
include_once( $DIST.$CLASS."/cBasica.php" );
include_once( $DIST.$LIB."/SQL.php" );
include_once( $DIST.$LIB."/PadN.php" );
class cNroDoc extends cBasica{
	public $db ;
	public $prefijo ;
	public $despre ;
	public $DetalleError = "";
	
	function Leer(){
		$q = "call sp_nrodoc1_leer( '".$this->prefijo."' )";
		$res = $this->db->query( $q );
		$control = false;
		if( $res ){		
			if( $obj = $res->fetch_assoc() ){
				$control = true;
				$this->prefijo = $obj['prefijo'];
				$this->despre = $obj['despre'];
			} else {
				$this->DetalleError = "falla al leer?: ".$q;
			}
			while ( $this->db->more_results() ){
				$this->db->next_result();
			}
			$res->close();
		} else {
			$this->DetalleError = $this->db->error;
		}
		return $control;
	}
	function GrabarAlta(){
		$q = "call sp_nrodoc1_agregar( '".$this->prefijo."','".$this->despre."' )";
		$res = $this->db->query( $q );
		$control = false;
		if( $res ){		
			$control = true;
		} else {
			$this->DetalleError = $this->db->error;
		}
		return $control;
	}
	function UpdateNro( $nro, $codtd ){
		$q = "call sp_nrodoc2_actualizar( '".$this->prefijo."', '".$codtd."', ".$nro." );";
		$res = $this->db->query( $q );
		$control = false;
		if( $res ){
			$control = true;
		} else {
			$this->DetalleError = $this->db->error ." ".$q;
		}
		return $control;

	}
	function LeerNros(){
		$q = "call sp_nrodoc2_leer( '".$this->prefijo."' )";
		$res = $this->db->query( $q );
		$arr = [];
		if( $res ){		
			while( $obj = $res->fetch_assoc() ){
				$control = true;
				$arr[] = $obj;
			} 
			while ( $this->db->more_results() ){
				$this->db->next_result();
			}
			$res->close();
		} else {
			$this->DetalleError = $this->db->error;
		}
		return $arr;
	}
}
?>