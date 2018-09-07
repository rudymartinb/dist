<?php
/* la idea es determinar el primer domingo de la semana
** y determinar si los domingos siguientes caen dentro del mes.
** las posibilidades son 3:
** que tenga 6, 5 o 4 semanas
** probamos con 6 primero
*/
function CantSemanas( $ano, $mes ){
	if( $ano == null ){
		return null;
	}
	if( $ano == "" ){
		return null;
	}
	if( $mes == null ){
		return null;
	}
	if( $mes == "" ){
		return null;
	}
	$nmes = intval ( $mes );
	if( $nmes < 1 or $nmes > 12 ){
		return null;
	}
	$nano = intval ( $ano );
	if( $nano < 1900 or $nano > 2100 ){
		return null;
	}
	
	$fec1  = "01-".$mes."-".$ano;
	$ini = DiaDeSemanaDMA( $fec1 );
	$dia1 = FechaRestarDias( $fec1, $ini );
	$res = FechaSumarDias( $dia1, 35 );
	
	$month = date("m",strtotime($res));
	if( $month == $mes ){
		return 6;
	}

	$res = FechaSumarDias( $dia1, 28 );
	$month = date("m",strtotime($res));
	if( $month == $mes ){
		return 5;
	}
	return 4;
}

// retorna true o false
// DD-MM-AAAA
function ValidarFecha( $cadena ){
	if( gettype( $cadena ) != "string" ){
		return false;
	}
	$correcto = "/^(\d{1,2})-(\d{1,2})-(\d{4})$/";
	preg_match($correcto, $cadena, $matches);
	if( count( $matches ) == 4  ){
		return true;
	}
	return false;
	
}

// DD-MM-AAAA HH:MM
function ValidarFechaHora( $cadena ){
	if( gettype( $cadena ) != "string" ){
		return false;
	}
	$correcto = "/^(\d{1,2})-(\d{1,2})-(\d{4})\ (\d{1,2})\:(\d{1,2})$/";
	preg_match($correcto, $cadena, $matches);
	if( count( $matches ) == 6  ){
		return true;
	}
	return false;
	
}

function fecha2SQL( $fecha ){
	if( ! ValidarFecha( $fecha ) ){
		return null;
	}
	$dia = substr( $fecha, 0, 2 );
	$mes = substr( $fecha, 3, 2 );
	$ano = substr( $fecha, 6, 4 );
	$sql = $ano."-".$mes."-".$dia;
	return $sql;
}

// DD-MM-AAAA HH:MM -> AAAA-DD-MM HH:MM ->
function FechaHora2SQL( $fecha ){
	if( ! ValidarFechaHora( $fecha ) ){
		return null;
	}
	$dia = substr( $fecha, 0, 2 );
	$mes = substr( $fecha, 3, 2 );
	$ano = substr( $fecha, 6, 4 );
	$hor = substr( $fecha, 11, 2 );
	$min = substr( $fecha, 14, 2 );
	$sql = $ano."-".$mes."-".$dia." ".$hor.":".$min;
	return $sql;
}


function ValidarFechaSQL( $cadena ){
	if( gettype( $cadena ) != "string" ){
		return false;
	}
	$correcto = "/^(\d{4})-(\d{1,2})-(\d{1,2})$/";
	preg_match($correcto, $cadena, $matches);
	if( count( $matches ) == 4  ){
		return true;
	}
	return false;
	
}

function ValidarFechaHoraSQL( $cadena ){
	if( gettype( $cadena ) != "string" ){
		return false;
	}
	$correcto = "/^(\d{4})-(\d{1,2})-(\d{1,2}) (\d{1,2}):(\d{1,2})$/";	
	preg_match($correcto, $cadena, $matches);
	if( count( $matches ) == 6  ){
		return true;
	}
	return false;
	
}

function Sql2fecha( $fecha ){
	if( ! ValidarFechaSQL( $fecha ) ){
		return null;
	}
	/* AAAA-MM-DD
	** 0123456789
	*/
	$ano = substr( $fecha, 0, 4 );
	$mes = substr( $fecha, 5, 2 );
	$dia = substr( $fecha, 8, 2 );
	$devolver = $dia."-".$mes."-".$ano;
	return $devolver;
}

function Sql2FechaHora( $fecha ){
	if( ! ValidarFechaHoraSQL( $fecha ) ){
		return null;
	}
	
	$correcto = "/^(\d{4})-(\d{1,2})-(\d{1,2}) (\d{1,2}):(\d{1,2})$/";	
	preg_match($correcto, $fecha, $matches);
	if( count( $matches ) == 6  ){
		// var_dump( $matches );
		$devolver = $matches[3]."-";
		$devolver .= $matches[2]."-";
		$devolver .= $matches[1]." ";
		$devolver .= $matches[4].":";
		$devolver .= $matches[5];
		return $devolver;
	}
	
	return null;
}
function DiaDeSemanaDMA( $fecha ){
	if( strlen( $fecha ) != 10 ){
		return null;
	}
	if( ! ValidarFecha( $fecha ) ){
		return null; 
	}
	return date( "w", strtotime( fecha2SQL( $fecha ) ) );
}
function FechaRestarDias( $fecha, $dias ){
	if( strlen( $fecha ) != 10 ){
		return null;
	}
	if( ! ValidarFecha( $fecha ) ){
		return null; 
	}
	$t = strtotime( $fecha );
	$t = $t - ( $dias * 24 * 60 * 60 );
	$res = date( "d-m-Y", $t );
	return $res;
}

function FechaSumarDias( $fecha, $dias ){

	if( strlen( $fecha ) != 10 ){
		return null;
	}
	if( ! ValidarFecha( $fecha ) ){
		return null; 
	}
	$t = strtotime( $fecha );
	$t = $t + ( $dias * 24 * 60 * 60 );
	$res = date( "d-m-Y", $t );
	return $res;
}

function ValidarPeriodo( $periodo ){
	if( gettype( $periodo ) != "string" ){
		return false;
	}
	$correcto = "/^(\d{6})$/";
	preg_match( $correcto, $periodo, $matches );
	if( count( $matches ) == 2  ){
		return true;
	}
	return false;
	
}
function CantidadDias( $periodo ){
	if ( ! ValidarPeriodo( $periodo ) ){
		return null;
	}
	$ano = substr( $periodo, 0, 4 );
	$mes = substr( $periodo, 4, 2 );
	$cantdias = cal_days_in_month(CAL_GREGORIAN, $mes, $ano);
	return $cantdias;
}
function PrimerDiaAlmanaque( $periodo ){
	if ( ! ValidarPeriodo( $periodo ) ){
		return null;
	}
	$ano = substr( $periodo, 0, 4 );
	$mes = substr( $periodo, 4, 2 );
	$dia1 = "01-".$mes."-".$ano;
	$ini = DiaDeSemanaDMA( $dia1 );
	$diaX = FechaRestarDias( $dia1, $ini );
	return $diaX;
	
}
function MesEnLetras( $mes ){
	switch( $mes ){
		case 1:{ return "Enero"; }
		case 2:{ return "Febrero"; }
		case 3:{ return "Marzo"; }
		case 4:{ return "Abril"; }
		case 5:{ return "Mayo"; }
		case 6:{ return "Junio"; }
		case 7:{ return "Julio"; }
		case 8:{ return "Agosto"; }
		case 9:{ return "Septiembre"; }
		case 10:{ return "Octubre"; }
		case 11:{ return "Noviembre"; }
		case 12:{ return "Diciembre"; }
		default: { return ""; }
	}
}
function PeriodoEnLetras( $periodo ){
	if ( ! ValidarPeriodo( $periodo ) ){
		return "";
	}
	$ano = substr( $periodo, 0, 4 );
	$mes = substr( $periodo, 4, 2 );
	$res = MesEnLetras( $mes )." ".$ano;
	return $res;
}

?>