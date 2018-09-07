<?php
include_once( "config.php" );

class cAgendaListaDoble{
	public $db;
	public $DetalleError = "";
	
	public $periodo = ""; 
	public $lista = [];
	
	public function ArmarLista() {
		/*
		*/
		if( $this->db == null ){
			$this->DetalleError = "No se definio DB";
			return false;
		}
		$this->lista = [  ];
		
		
		$q = "call sp_AgendaEntregaLeerResumen( '".$this->periodo."' );";
		$db = $this->db;
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
		if( $res ) {
			while( $obj = $res->fetch_object() ){
				$cli = $obj->codcli;
				$raz = $obj->razcli;
				$pro = $obj->codpro;
				$des = $obj->despro;
				$abr = $obj->abrpro;
				$cant1 = $obj->cant1;
				$cant2 = $obj->cant2;
				$cant3 = $obj->cant3;
				$this->lista[] = [ $cli, $raz, $pro, $abr, $cant1, $cant2, $cant3 ];
			}
			while ( $this->db->more_results() ){
				$this->db->next_result();
			}
		}

		
		return true;

	}
	public function ArmarCabecera(){
		$esperado = "<hr>";
		$esperado .= "<div class='renglonagenda'>";
		$esperado .= "<div class='cabeceracol col0'>Cod.";
		$esperado .= "</div>";
		$esperado .= "<div class='cabeceracol col1'>Cliente.";
		$esperado .= "</div>";
		$esperado .= "<div class='cabeceracol col2'>Producto";
		$esperado .= "</div>";
		$esperado .= "<div class='cabeceracol col3'>&nbsp;";
		$esperado .= "</div>";
		$esperado .= "<div class='cabeceracol col4'>CCC";
		$esperado .= "</div>";
		$esperado .= "<div class='cabeceracol col5'>CSC";
		$esperado .= "</div>";
		$esperado .= "<div class='cabeceracol col6'>DEV";
		$esperado .= "</div>";
		$esperado .= "</div>";
		$esperado .= "<div class=''>&nbsp;";
		$esperado .= "</div>";
		$esperado .= "<hr>";
		
		return $esperado;
	}
	public function ArmarRenglon( $i ){
		$arr = $this->lista[ $i ];
		$codcli =  $arr[0];
		$razcli =  $arr[1];
		$codpro =  $arr[2];
		$abrpro =  $arr[3];
		$cant1  =  $arr[4];
		$cant2  =  $arr[5];
		$cant3  =  $arr[6];
		
		$esperado = "<div class='renglonagenda'>";
		$esperado .= "<div class='cabeceracol col0'>";
		$esperado .= $codcli;
		$esperado .= "</div>";
		$esperado .= "<div class='cabeceracol col1'>";
		$esperado .= $razcli;
		$esperado .= "</div>";
		$esperado .= "<div class='cabeceracol col2'>";
		$esperado .= $codpro;
		$esperado .= "</div>";
		$esperado .= "<div class='cabeceracol col3'>";
		$esperado .= $abrpro;
		$esperado .= "</div>";
		$esperado .= "<div class='cabeceracol col4'>";
		$esperado .= $cant1;
		$esperado .= "</div>";
		$esperado .= "<div class='cabeceracol col5'>";
		$esperado .= $cant2;
		$esperado .= "</div>";
		$esperado .= "<div class='cabeceracol col6'>";
		$esperado .= $cant3;
		$esperado .= "</div>";
		$esperado .= "</div>";
		return $esperado;
	}
	function RenderHTML( $periodo ){
		$res = $this->ArmarCabecera();
		$ultimo = "";
		for( $i = 0; $i < count( $this->lista ); $i ++ ){
			$arr = $this->lista[ $i ];
			$esperado = "<div class='renglonagenda'>";
			$codcli =  $arr[0];
			$razcli =  $arr[1];
			$codpro =  $arr[2];
			$abrpro =  $arr[3];
			$cant1  =  $arr[4];
			$cant2  =  $arr[5];
			$cant3  =  $arr[6];
			if( $ultimo <> $arr[0] ){
			// $esperado .= "<hr>";
				$esperado .= "<div class='cabeceracol col0' style='font-weight:bold;'>";
			$esperado .= "<a href='AgendaProduccion3.php?ref=$periodo$codcli$codpro'>";
				$esperado .= $codcli;
			$esperado .= "</a>";
				$esperado .= "</div>";
				$esperado .= "<div class='cabeceracol col1' style='font-weight:bold;'>";
				$esperado .= $razcli;
				$esperado .= "</div>";
				// $esperado .= "<hr>";
				$ultimo = $arr[0];
			} else {
				$esperado .= "<div class='cabeceracol col0'>";
				$esperado .= "&nbsp;";
				$esperado .= "</div>";
				$esperado .= "<div class='cabeceracol col1'>";
				$esperado .= "&nbsp;";
				$esperado .= "</div>";
				
			}
			$esperado .= "<div class='cabeceracol col2'>";
			$esperado .= "<a href='AgendaProduccion3.php?ref=$periodo$codcli$codpro'>";
			$esperado .= $codpro;
			$esperado .= "</a>";
			$esperado .= "</div>";
			$esperado .= "<div class='cabeceracol col3'>";
			$esperado .= "<a href='AgendaProduccion3.php?ref=$periodo$codcli$codpro'>";
			$esperado .= $abrpro;
			$esperado .= "</a>";
			$esperado .= "</div>";
			$esperado .= "<div class='cabeceracol col4'>";
			$esperado .= $cant1;
			$esperado .= "</div>";
			$esperado .= "<div class='cabeceracol col5'>";
			$esperado .= $cant2;
			$esperado .= "</div>";
			$esperado .= "<div class='cabeceracol col6'>";
			$esperado .= $cant3;
			$esperado .= "</div>";
			$esperado .= "</div>";

			$res .= $esperado;
		}
		return $res;
	}
}

?>	
