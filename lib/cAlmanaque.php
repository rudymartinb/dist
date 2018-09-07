<?php
/* 
usa codigo que esta en $LIB/fechas.php
*/

class cAlmanaque{
	public $periodo; // string AAAAMM
	public $listadias; // vector de strings formato DD-MM-AAAA
	public $cantsemanas; // integer
	public $ano; // string
	public $mes; // string
	public $DetalleError;
	
	
	/* en funcion del periodo asignado,
	armar el almanaque a nivel de atributos.
	Devuelve un array de array de semanas y los dias para cada vector
	*/
	public function Procesar(){
		if( ! ValidarPeriodo( $this->periodo ) ){
			return false;
		}
		$ano = substr( $this->periodo, 0, 4 );
		$mes = substr( $this->periodo, 4, 2 );
		$this->ano = $ano;
		$this->mes = $mes;
		
	
		$cantsem = CantSemanas( $ano, $mes );
		if( $cantsem == null ){
			return false;
		}
		$this->cantsemanas = $cantsem;
		
		$dia1 = PrimerDiaAlmanaque( $this->periodo );
		
		$arrsemanas = [];
		
		for( $i = 0; $i < $cantsem ; $i++ ){
			$arr = [];
			for( $dow = 0; $dow <= 6; $dow ++ ){
				$arr[] = $dia1;
				$dia1 = FechaSumarDias( $dia1, 1 );
			}
			$arrsemanas[] = $arr;
		}
		$this->listadias = $arrsemanas;
		return true;
	}
	
	/*
	*/
	public function FechaCelda( $sem, $dow ){
		if( gettype( $sem ) != "integer" ){
			return "";
		}
		if( gettype( $dow ) != "integer" ){
			return "";
		}
		if( $sem < 0 or $sem > count( $this->listadias ) ){
			return "";
		}
		if( $dow < 0 or $dow > 6 ){ 
			return "" ; 
		}
		return $this->listadias[ $sem ][$dow];
	}

	public function DiaCelda( $sem, $dow ){
		if( gettype( $sem ) != "integer" ){
			return "";
		}
		if( gettype( $dow ) != "integer" ){
			return "";
		}
		if( $sem < 0 or $sem > count( $this->listadias ) ){
			return "";
		}
		if( $dow < 0 or $dow > 6 ){ 
			return "" ; 
		}
		return substr( $this->listadias[ $sem ][$dow], 0, 2 );
	}

	public function EsMesBuscadoSemDow( $sem, $dow ){
		if( ! ValidarPeriodo( $this->periodo ) ){
			return false;
		}
	
		if( gettype( $sem ) != "integer" ){
			return "";
		}
		if( gettype( $dow ) != "integer" ){
			return "";
		}
		if( $sem < 0 or $sem > count( $this->listadias ) ){
			return "";
		}
		if( $dow < 0 or $dow > 6 ){ 
			return "" ; 
		}
		$dia = $this->listadias[ $sem ][$dow];

		return $this->EsMesBuscado( $dia );
	}

	public function EsMesBuscado( $dia ){
		if( ! ValidarPeriodo( $this->periodo ) ){
			$this->DetalleError = "Periodo no valido";
			return false;
		}
		if( ! ValidarFecha ( $dia ) ){
			$this->DetalleError = "Fecha no valido";
			return false;
		}
		$mesdia = substr( $dia,  3,2 );
		$anodia = substr( $dia,  6,4 );
		
		$ano = substr( $this->periodo , 0, 4 );
		$mes = substr( $this->periodo , 4, 2 );
		if( $mes != $mesdia or $ano != $anodia ){
			$this->DetalleError = "No coincide Mes ".$mes." ".$mesdia." ".$dia." ". $this->periodo;
			return false;
		}
		
		return $ano == $anodia and $mes == $mesdia ;
		
	}
	
	public function TituloMes(){
		if( ! ValidarPeriodo( $this->periodo ) ){
			return "";
		}
		return PeriodoEnLetras( $this->periodo );
	}

	public function ArmarCabecera() {
		$esperado = "<div class='almanaqueTitulo'>";
		$esperado .= $this->TituloMes();
		$esperado .= "</div>";
		return $esperado;
	}

}
?>