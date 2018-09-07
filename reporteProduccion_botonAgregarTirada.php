<?php
/* el chiste de todo esto es que puede ser invocado desde un ajax
** por lo tanto en este punto se torna necesario evaluar POST
** para determinar como viene la mano.
*/
include_once( "config.php" );
include_once( $DIST.$LIB."/cHTML.php" );


if( isset( $_POST ) ){
	$post = $_POST;
	if( isset( $post['nro'] ) ){
		$nro = $post['nro'];
		echo BotonAgregarTirada( $nro );
	}
}

/* probablemente tenga q cambiarle el nombre por algo menos generico, 
** dado que ya lo use en otro php 
*/
function GenerarInput( $tit, $id, $idclass, $len, $name, $value, $mensa ){
	$txt = "";
	$txt .= '<div class="admitem">'.$tit.':</div>' ;
	$txt .= '<input class="adminput1 '.$idclass.'" type=text value="'.$value.'" id="'.$id.'" name="'.$name.'" maxlength="'.$len.'">' ;
	$txt .= '<div class="admmensa">'.$mensa.'</div>' ;
	return $txt;
}


function BotonAgregarTirada( $nro ){
/* parte reporte tiradas
esto termina con un script del lado del cliente,
q x ajax carga de nuevo los controles,
pero con un id diferente
*/
$p = new cHTML();
$p->body->DivOpen( 'tirada'.$nro );
$p->body->AddHTML( '<hr>' );
$p->body->AddHTML( '<div class="admitem">Tirada Nro '.$nro.'</div>' );


$p->body->AddHTML( '<hr>' );

$p->body->DivOpen( 'hora' );

$p->body->DivOpen( 'hora_ini', 'size400 floatLeft' );
$txt = GenerarInput( "Hora Inicial", "horaini".$nro, "", 5, "horaini".$nro, "", "Escriba la hora inicial" );
$p->body->AddHTML( $txt );
$p->body->DivClose();

$p->body->DivOpen( 'hora_fin', '' );
$txt = GenerarInput( "Hora Final", "horafin".$nro, "", 5, "horafin".$nro, "", "Escriba la hora de finalización" );
$p->body->AddHTML( $txt );
$p->body->DivClose(); // horafin
$p->body->DivClose(); // hora

// $p->body->AddHTML( '<div class="clearBoth">&nbsp;</div>' );
$p->body->DivOpen( 'nro_maqini' );
$p->body->DivOpen( 'nromaqini' , 'size400 floatLeft' );
$txt = GenerarInput( "Nro. Inicial Maquina", "maqini".$nro, "", 10, "maqini".$nro, "", "Escriba el nro inicial de maquina" );
$p->body->AddHTML( $txt );
$p->body->DivClose();

$p->body->DivOpen( 'nro_maqfin' , '' );
$txt = GenerarInput( "Nro. Final Maquina", "maqfin".$nro, "", 10, "maqfin".$nro, "", "Escriba el nro final de maquina" );
$p->body->AddHTML( $txt );
$p->body->DivClose();
$p->body->DivClose();


$txt = GenerarInput( "Tirada Bruta", "tiradabruta".$nro, "", 10, "tiradabruta".$nro, "", "Escriba la Tirada Bruta" ); $p->body->AddHTML( $txt );
$txt = GenerarInput( "Carga", "carga".$nro, "", 10, "carga".$nro, "", "Escriba la carga" ); $p->body->AddHTML( $txt );
$txt = GenerarInput( "Desperdicio", "desperdicio".$nro, "", 10, "desperdicio".$nro, "", "Escriba el desperdicio" ); $p->body->AddHTML( $txt );
// $txt = GenerarInput( "Tirada Neta", "tiradaneta".$nro, "", 10, "tiradaneta".$nro, "", "Escriba la tirada neta" ); $p->body->AddHTML( $txt );
$txt = GenerarInput( "Kgrs", "kgrs".$nro, "", 10, "kgrs".$nro, "", "Escriba los kgrs" ); $p->body->AddHTML( $txt );
$txt = GenerarInput( "Cant. Páginas Color", "pagcolor".$nro, "", 10, "pagcolor".$nro, "", "Escriba la cantidad de paginas a color" ); $p->body->AddHTML( $txt );
$txt = GenerarInput( "Cant. Páginas Total", "pagtotal".$nro, "", 10, "pagtotal".$nro, "", "Escriba la cantidad total de paginas " ); $p->body->AddHTML( $txt );


$p->body->AddHTML( '<hr>' );
$p->body->DivClose();

$res = $p->RenderBody();
return $res;

}

?>