<?php
/* fuente de soporte para reporteproduccion.php y anexos
*/
require_once( "config.php" );
require_once( $DIST.$CLASS."/cReporteTirada.php" );
require_once( $DIST.$LIB."/TiposDatos.php" );
require_once( $DIST.$LIB."/fechas.php" );
require_once( $DIST.$CLASS."/cReporteProduccion.php" );
require_once( $DIST.$CLASS."/cReporteTirada.php" );

function ObtenerListaReportesProduccion( $db, $fecini, $fecfin ){
	$arr = [];
	if( ! SQL_EsValido( $db ) ){
		return -1;
	}	
	if( ! ValidarFecha( $fecini ) ){
		return -1;
	}
	if( ! ValidarFecha( $fecfin ) ){
		return -1;
	}
	
	$q = "call sp_InfoReportesProduccionEF( ";
	$q .= "'".Fecha2SQL( $fecini )."' ,";
	$q .= "'".Fecha2SQL( $fecfin )."' )";
	try {
		$res = $db->query( $q );
	} catch ( Exception $e ) {
		// $this->DetalleError = 
		error_log( "Exception: ".$e->getMessage()."\n" );
		return false;
	}
	if( $res === FALSE ) {
		// $this->DetalleError = "Error: ". 
		error_log( "SQL Error: ".$db->error );
		return false;
	}
	if( $db->more_results() ) {
		
		while( $obj = $res->fetch_assoc() ){
			$arr[] = $obj;
		}
		
		while ( $db->more_results() ){
			$db->next_result();
		}
	}
	
	
	return $arr;
}

function ProcesarReporteProduccionVerificar( $post ){
	if( ! isset( $post ) ){
		return "sin datos";
	}
	$rp = new cReporteProduccion();
	// $rp->db = $db;
	if( ! $rp->VerificarPost( $post ) ){
		return $rp->DetalleError;
	}
}

/*
 * 
CREATE DEFINER=`root`@`%` PROCEDURE `sp_InfoReportesProduccionEF`(
in fecini date,
in fecfin date)
uno: BEGIN

select * from reporteproduccion1
inner join productos on prorep = codpro
where fecrep >= fecini and fecrep <= fecfin
order by fecrep;

END
*/
function ProcesarReporteProduccion( $db, $post ){
	// echo " hay post? ";

	if( ! SQL_EsValido( $db ) ){
		// echo "no se pudo abrir la db " ;
		return false;
	}
	// $DetalleError = ProcesarReporteProduccionVerificar( $post );
	$rp = new cReporteProduccion();
	$rp->db = $db;

	if( ! $rp->VerificarPost( $post ) ){
		echo ( "Post no valido: ".$rp->DetalleError );
		return false;
	}
	if( ! $rp->GrabarAltaPost( $post ) ){
		error_log( "Error al grabar reporte produccion: ".$rp->DetalleError );
		return false;
	}
	return true;

	
	// return true;
}

?>
