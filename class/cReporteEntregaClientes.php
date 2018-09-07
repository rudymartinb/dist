<?php
include_once( "config.php" );
include_once( $DIST.$CLASS."/cBasica.php" );
include_once( $DIST.$LIB."/SQL.php" );
include_once( $DIST.$LIB."/PadN.php" );
include_once( $DIST.$LIB."/fechas.php" );
include_once( $DIST.$LIB."/TiposDatos.php" );

class cReporteEntregaClientes extends cBasica {
	public $db; // mysqli
	public $fecha;
	public $prod; // cod prod
	public $DetalleError;
	public $prefijo;
	
	private $lista = [] ;
	private $obs = "";
	
	
	public $idx = 0;
	public $TestMode = false;
	// public $listaclientes;
	
	public function ObtenerListaClientes(){
		$db = $this->db;
		$q = "call SP_ClientesLeerLC();";
		$res = $this->db->query( $q );
		if( ! $res ){
			$this->DetalleError = "no se pudo obtener la lista de clientes";
			return false;
		}
		$lista = [];
		if( $db->more_results() ) {
			while( $obj = $res->fetch_assoc() ){
				$lista[] = $obj ;
			}
			while ( $db->more_results() ){
				$db->next_result();
			}
		}
		return $lista;
			
	}
	public function GenerarHidden( $valor, $id ){
		return '<input type=hidden value="'.$valor.'" id="'.$id.'" name="'.$id.'" >';
	}
	public function GenerarTitulo( $tit ){
		$txt = "";
		$txt .= '<div class="tituloInput floatLeft size400">'.$tit.':</div>' ;
		return $txt;
	}
	public function GenerarInput( $tit, $id, $idclass, $len, $value, $mensa ){
		$name = $idclass;
		$txt = "";
		// $txt .= '<div class="admitem">'.$tit.':</div>' ;
		$txt .= '<input class="adminput1 floatLeft '.$idclass.'" type=text value="'.$value.'" id="'.$id.'" name="'.$id.'" maxlength="'.$len.'" style="width:50px;">' ;
		// $txt .= '<input class="adminput1 '.$idclass.'" type=text value="'.$value.'" id="'.$id.'" name="'.$name.'" maxlength="'.$len.'">' ;
		// $txt .= '<div class="admmensa">'.$mensa.'</div>' ;
		return $txt;
	}
	
	public function DesglosarForm( $form ){
		$this->DetalleError = "";
		if( count( $form ) == 0 ) {
			$this->DetalleError = "Sin datos";
			return false;
		}
		if( ! isset( $form['fecha'] )  ) {
			$this->DetalleError = "Falta definir fecha reporte";
			return false;
		}
		$this->fecha = $form['fecha'];
		if( ! isset( $form['codprod'] )  ) {
			$this->DetalleError = "Falta definir producto";
			return false;
		}
		
		$this->prod = $form['codprod'];
		if( ! isset( $form['cantidad'] )  ) {
			$this->DetalleError = "Falta lista de clientes";
			return false;
		}
		$cant = $form['cantidad'];
		/* y ahora como hago para saber cuantos registros vienen?
		*/

		for( $i = 1; $i <= $cant ; $i ++ ){
			$nro = PadN( $i, 3 );
			$cli = "CLI".$nro;
			$ccc = "CCC".$nro;
			$csc = "CSC".$nro;
			if( !isset( $form[ $cli ] ) ){
				$this->DetalleError = "falta definir cliente ".$i;
				return false;
			}
			if( !isset( $form[ $ccc ] ) ){
				$this->DetalleError = "falta definir ccc ".$i;
				return false;
			}
			if( !isset( $form[ $csc ] ) ){
				$this->DetalleError = "falta definir csc ".$i;
				return false;
			}
			
			$codcli = $form[ $cli ] ;
			$cantcc = $form[ $ccc ] ;
			$cantsc = $form[ $csc ] ;
			// echo $codcli. " ".$cantcc." ".$cantsc ;
			if( ! $this->Agregar( $cantcc, $codcli, $cantsc ) ){
				return false;
			}
		
		}
		return true;
		
	}
	
	public function CantItems(){
		return count( $this->lista) ;
	}
	public function Total(){
		$suma = 0;
		foreach( $this->lista as $key => $value ){
			$suma += $value[0];
		}
		return $suma;
	}
	public function EsValido( ){
		$this->DetalleError = "";
		if( !SQL_EsValido( $this->db ) ){
			$this->DetalleError = "Sin definir db?";
			return false;
		}		
		if( count( $this->lista ) == 0 ){
			$this->DetalleError = "Sin items en lista";
			return false;
		}
		if( ! $this->DeterminarCantidad(  $this->Total() ) ){
			$this->DetalleError = "No coinciden totales para el producto";
			return false;
		}
		return true;
	}
	
	public function GrabarAlta_sp_ReporteEntregaAlta( ){
		$q = "call sp_ReporteEntregaAlta( '".Fecha2SQL($this->fecha)."', '".$this->prod."', '".$this->obs."' );";
		$res = $this->db->query( $q );
		if( ! $res ){
			$this->DetalleError = "falla query 2 ".$this->db->error." (".$q.")";
			return false;
		}
		
		$row = $res->fetch_assoc();
		$this->idx = $row['idx'];
		$res->close();
		while( $this->db->more_results() ){
			$this->db->next_result();
		}
		return true;
	}
	public function GrabarAlta( ){
		// if( !$this->EsValido() ){
			// return false;
		// }
		if( ! $this->TestMode ){
			$q = "start transaction;";
			$res = $this->db->query( $q );
			if( ! $res ){
				return false;
			}
		}
		if( ! $this->GrabarAlta_sp_ReporteEntregaAlta() ){
			return false;
		}
		
		/* ok. ahora quiero grabar los items.
		*/
		// var_dump( $this->lista );
		foreach( $this->lista as $key => $value ){
			$cant = $value[0];
			$csc = $value[2];
			$cli = $value[1];
			if( ! $this->GrabarAltaCliente( $cant, $cli, $csc ) ){
				return false;
			}
		}
		if( ! $this->TestMode ){
			$q = "commit;";
			$res = $this->db->query( $q );
		}

		return true;
	}
	public function GrabarAltaCliente(  $cant, $cli, $csc ){
		$idx = $this->idx;
		$q = "call sp_ReporteEntregaClienteAlta( ".$idx.", '".$cli."', ".$cant.", ".$csc." );";
		$res = $this->db->query( $q );
		// var_dump( $res );
		if( !$res ){
			$this->DetalleError = "GrabarAltaCliente() ".$this->db->error." ".$cant." ".$cli;
			return false;
		}
		return last_result( $this->db );
	}
	
	public function DeterminarCantidad(  $cant  ){
		$q = "call sp_ReporteEntregaDeterminarCantidad( '".Fecha2SQL($this->fecha)."', '".$this->prod."' );";
		$res = $this->db->query( $q );
		if( $res ){
			// var_dump( $res );
			if( $row = $res->fetch_assoc() ){
				$res->close();
				while( $this->db->more_results() ){
					$this->db->next_result();
				}
				return $row['cantidad'] === $cant;
				
			}
		}
		$res->close();
		while( $this->db->more_results() ){
			$this->db->next_result();
		}
		$this->DetalleError = "DeterminarCantidad() ".$this->db->error." ".$cant;
		return false;
	
	}
	public function Agregar( $cant, $cli, $cantsc = 0 ){
		$pos = $this->Posicion( $cli );
		if( $pos === -1 ){
			$this->lista[] = [ $cant, $cli, $cantsc ];
			return true;
		}
		$this->DetalleError = "Cliente ya agregado";
		return false;
	}
	public function Modificar( $cant, $cli ){
		$pos = $this->Posicion( $cli );
		if( $pos === -1 ){
			return false;
		}
		$this->lista[ $pos ] = [ $cant, $cli ];
		return true;
	}
	public function Eliminar( $cli ){
		$pos = $this->Posicion( $cli );
		if( $pos === -1 ){
			return false;
		}
		unset( $this->lista[ $pos ] );
		return true;
	}
	public function Posicion( $cli ){
		foreach( $this->lista as $key => $value ){
			if( $value[1] === $cli ){
				return $key ;
			}
		}
		return -1;
	}
	
}
?>