<?php
		   
class cAgendaEntrega{
	public $db;
	public $DetalleError = "";
	
	public $cliente = ""; // 
	public $periodo = ""; 
	public $producto = "";
	
	public $mes = 0;
	public $ano = 0;
	public $cantdias = 0;
	
	// dia de semana dia 01 del mes en cuestion
	public $ini; 
	
	public $dia1;
	public $diaX; // dia inicial almanaque
	public $cantsemanas;
	
	
	
	public $dias = [];
	
	public function Valido(){
		if( $this->db == null ){
			return false; 
		}
		if( $this->cliente == "" ){
			return false; 
		}
		if( $this->periodo == "" ){
			return false; 
		}
		if( $this->producto == "" ){
			return false; 
		}
		if( $this->mes == 0 ){
			return false; 
		}
		if( $this->ano == 0 ){
			return false; 
		}
		if( $this->cantdias == 0 ){
			return false; 
		}
		
		return true;
	}
	public function Agregar( $fecha, $cant1, $cant2 ){
		if( ! $this->Valido() ){
			return false;
		}
		$this->dias[] = [ $fecha, $cant1, $cant2 ];
		
		$q = "call sp_agendaEntrega( ";
		$q .= "'".$this->cliente."',";
		$q .= "'".$this->producto."',";
		$q .= "'".fecha2SQL( $fecha )."',";		
		$q .= " ".$cant1." ,";
		$q .= " ".$cant2." );";
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
			if( $obj = $res->fetch_object() ){
				$quepaso = $obj->result;
				while ( $this->db->more_results() ){
					$this->db->next_result();
				}
				$this->DetalleError = $this->db->error; 
				if( $quepaso ) {
					return true;
				}
			}
		}
		
		return true;
		
	}
	
	public function Leer(  ){
		if( ! $this->Valido() ){
			return false;
		}
		$this->dias = [  ];
		
		$q = "call sp_agendaLeer( ";
		$q .= "'".$this->cliente."',";
		$q .= "'".$this->producto."' );";
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
				$dia = Sql2Fecha( $obj->fecage );
				$cant1 = $obj->cant1;
				$cant2 = $obj->cant2;
				$this->dias[] = [ $dia, $cant1, $cant2 ];
			}
			while ( $this->db->more_results() ){
				$this->db->next_result();
			}
		}

		
		return true;
		
	}
	
	public function Cantidad( $fecha ){
		$dias = $this->dias;
		for( $i = 0; $i < count( $dias ); $i ++ ){
			if( $dias[$i][0] == $fecha ){
				return $dias[$i][1];
			}
		}
		return null;
	}

	public function Cantidad2( $fecha ){
		$dias = $this->dias;
		for( $i = 0; $i < count( $dias ); $i ++ ){
			if( $dias[$i][0] == $fecha ){
				return $dias[$i][2];
			}
		}
		return null;
	}
	
	public function Procesar(){
		$this->ano = substr( $this->periodo, 0, 4 );
		$this->mes = substr( $this->periodo, 4, 2 );
		$this->cantdias = cal_days_in_month(CAL_GREGORIAN, $this->mes, $this->ano);;
		$this->dia1 = "01-".$this->mes."-".$this->ano;
		$this->ini = DiaDeSemanaDMA( $this->dia1 );
		// determinar el primer dia de la semana del almanaque
		$this->diaX = FechaRestarDias( $this->dia1, $this->ini );
		
		$this->cantsemanas =  CantSemanas( $this->ano, $this->mes ) ;
		
		return true;
	}
	public function Grabar(){
		// $q = "call sp_agendaEntrega( "
		// $q .= "'".$this->cliente."',";
		// $q .= "'".$this->producto."',";
		// $q .= "'".$this->producto."',";
	}
}
?>