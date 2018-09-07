<?php

include_once( "config.php" );
include_once( $DIST."/informes/mensualxp/SQL_InformeMensual2.php" );
include_once( $DIST."/informes/mensualxp/InformeMensual2Post.php" );

include_once( $DIST.$LIB."/fechas.php" );
include_once( $DIST.$LIB."/SQL.php" );
include_once( $DIST.$LIB."/cHTML.php" );
include_once( $DIST.$LIB."/head.php" );
include_once( $DIST.$LIB."/forms.php" );

// echo "test";
$Titulo_Pagina =  "INFORME MENSUAL 2 (Total Cir.Neta) ";

// $p es un objeto cHTML
$p = ArmarCabecera( $Titulo_Pagina );
$p->head->StyleAdd( ".col1", "width:155px;float:left;font-size:11px;font-family:Verdana;text-align:right;" );
$p->head->StyleAdd( ".col2", "width:155px;float:left;font-size:11px;font-family:Verdana;text-align:right;" );

$p->head->StyleAdd( "@media print",  ".cortarpagina {page-break-after: always;} " );
$p->head->StyleAdd( "@media screen",  ".encabezado {display: none;}" );


$post = $_POST;
if( !InformeMensual2ValidarPost( $post ) ){
	$self = $_SERVER["PHP_SELF"];
	$p->body->AddHTML( '<form name="reporte" action="'.$self.'" method="post">' );

	$txt = GenerarInput( "Desde Periodo", "perini", "", 10, "perini", "", "Escriba el periodo final de informe (AAAAMM)" ); $p->body->AddHTML( $txt );
	$txt = GenerarInput( "Hasta Periodo", "perfin", "", 10, "perfin", "", "Escriba el periodo final  de informe (AAAAMM)" ); $p->body->AddHTML( $txt );

	$p->body->AddHTML( '<input class="adminput" type="submit" value="Aceptar" id="OK">' );
	$p->body->AddHTML( '</form>' );

} else {
	/* generacion informe propiamente dicho.
	me interesa una lista de links a los reportes en PDF
	*/
	$db = SQL_Conexion();	
	if( $db === null ){
		return ;
	}
	$lista = InformeMensual2Post( $db, $post );

	$desde = $post['perini'];
	$hasta = $post['perfin'];
	$p->body->DivOpen( "", "admitem" );
	$p->body->AddHTML( "Del ".$desde. " al ".$hasta ); 
	$p->body->DivClose( );
	$p->body->AddHTML( "<hr>" );
	$p->body->DivOpen( "", "" );
		$p->body->DivOpen( "col1", "col1" ); $p->body->AddHTML( "Periodo" ); $p->body->DivClose( );
		$p->body->DivOpen( "col2", "col2" ); $p->body->AddHTML( "Cir.Neta" ); $p->body->DivClose( );
		$p->body->DivOpen( "", "" ); $p->body->AddHTML( "&nbsp;" ); $p->body->DivClose( );
	$p->body->DivClose( );
	$totales = [];
	$total1 = 0;
	$p->body->AddHTML( "<hr>" );
	
	$arrtot = [];
	$arrtot['cirnetatotal'] = 0 ;

	foreach( $lista as $key => $value ){
		$arrtot['cirnetatotal'] += $value['cirnetatotal'] ;
		
		$p->body->DivOpen( "", "admitem" );
		$p->body->DivOpen( "col1", "col1" ); $p->body->AddHTML( $value['periodo'] ); $p->body->DivClose( );
		$p->body->DivOpen( "col2", "col2" ); $p->body->AddHTML( $value['cirnetatotal'] ); $p->body->DivClose( );
		
		$p->body->DivOpen( "", "" ); $p->body->AddHTML( "&nbsp;" ); $p->body->DivClose( );
		$p->body->DivClose( );
	}
	$p->body->AddHTML( "<hr>" );
	$p->body->AddHTML( "<div class='cortarpagina'  ></div>" );
	
	$p->body->AddHTML( "<div class='encabezado'  >" );
		$p->body->AddHTML( "<hr >" );
		$p->body->DivOpen( "col1", "col1" ); $p->body->AddHTML( "Periodo" ); $p->body->DivClose( );
		$p->body->DivOpen( "col2", "col2" ); $p->body->AddHTML( "Cir.Neta" ); $p->body->DivClose( );
		$p->body->DivOpen( "", "" ); $p->body->AddHTML( "&nbsp;" ); $p->body->DivClose( );
		$p->body->AddHTML( "<hr >" );
	$p->body->AddHTML( "</div >" );
	$p->body->DivClose( );

	$p->body->DivOpen( "", "admitem" );
		$p->body->DivOpen( "col1", "col1" ); $p->body->AddHTML( "General:" ); $p->body->DivClose( );
		$p->body->DivOpen( "col2", "col2" ); $p->body->AddHTML( $arrtot['cirnetatotal'] ); $p->body->DivClose( );
		$p->body->DivOpen( "", "" ); $p->body->AddHTML( "&nbsp;" ); $p->body->DivClose( );
	$p->body->DivClose( );
	$p->body->AddHTML( "<hr>" );
	
	
}

/*
*/

$res = $p->Render();
echo $res;

?>