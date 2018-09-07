<?php


include_once( "config.php" );
include_once( $DIST."/informes/facturacion/GenerarListaInfoFacturacionDetallada.php" );
include_once( $DIST."/informes/facturacion/InfoFacturacionValidarPost.php" );
include_once( $DIST."/informes/facturacion/detalle_cliente_validar.php" );
include_once( $DIST.$LIB."/fechas.php" );
include_once( $DIST.$LIB."/SQL.php" );
include_once( $DIST.$LIB."/cHTML.php" );
include_once( $DIST.$LIB."/head.php" );
include_once( $DIST.$LIB."/forms.php" );

// echo "test";
$Titulo_Pagina =  "INFORME DETALLADO DE FACTURACION";

// $p es un objeto cHTML
$p = ArmarCabecera( $Titulo_Pagina );

$p->head->StyleAdd( ".col1", "width:90px;float:left;font-size:11px;font-family:Verdana;" );
$p->head->StyleAdd( ".col2", "width:60px;float:left;font-size:11px;font-family:Verdana;text-align:right;" );
$p->head->StyleAdd( ".col3", "width:60px;float:left;font-size:11px;font-family:Verdana;text-align:right;" );
$p->head->StyleAdd( ".col4", "width:60px;float:left;font-size:11px;font-family:Verdana;text-align:right;" );
$p->head->StyleAdd( ".col5", "width:100px;float:left;font-size:11px;font-family:Verdana;text-align:right;" );
$p->head->StyleAdd( ".col7", "width:100px;float:left;font-size:11px;font-family:Verdana;text-align:right;" );
// $p->head->StyleAdd( ".col8", "width:100px;float:left;font-size:11px;font-family:Verdana;text-align:right;" );
// $p->head->StyleAdd( ".col6", "width:100px;float:left;font-size:14px;font-family:courier new;text-align:right;" );
// $p->head->StyleAdd( ".col5",     	  		"width:100px;float:left;font-family:courier new;" );
// $p->head->StyleAdd( ".col6",     	  		"width:100px;float:left;font-family:courier new;" );
// $p->head->StyleAdd( ".col7",     	  		"width:100px;float:left;font-family:courier new;" );
// $p->head->StyleAdd( ".col8",     	  		"width:100px;float:left;font-family:courier new;" );


$post = $_GET;
if( InfoFactDetalleCli_ValidarPost( $post ) ){
	// $desde = $post['desde'];
	// $hasta = $post['hasta'];

	/* generacion informe propiamente dicho.
	me interesa una lista de links a los reportes en PDF
	*/
	$db = SQL_Conexion();	
	if( $db === null ){
		return ;
	}
	// 
	// InfoFacturacionPostGenerarListaClientes
	$lista = InfoFacturacionPostDetalleCliente( $db, $post );

	$prod = $post['prod'];
	$cli = $post['cli'];
	$desde = $post['desde'];
	$hasta = $post['hasta'];
		if( count( $lista ) > 0 ){
		$p->body->DivOpen( "", "admitem" );
		$p->body->AddHTML( "Cliente ".$lista[0]['cliage']." ".$lista[0]['razcli'] ); 
		$p->body->DivClose( );
	}
	$p->body->DivOpen( "", "admitem" );
	$p->body->AddHTML( "Del ".$desde. " al ".$hasta ); 
	$p->body->DivClose( );
	$p->body->AddHTML( "<hr>" );
	$p->body->DivOpen( "", "" );
		$p->body->DivOpen( "col1", "col1" ); $p->body->AddHTML( "Fecha" ); $p->body->DivClose( );
		$p->body->DivOpen( "col2", "col2" ); $p->body->AddHTML( "CCC" ); $p->body->DivClose( );
		$p->body->DivOpen( "col3", "col3" ); $p->body->AddHTML( "CSC" ); $p->body->DivClose( );
		$p->body->DivOpen( "col4", "col4" ); $p->body->AddHTML( "Dev" ); $p->body->DivClose( );
		$p->body->DivOpen( "col5", "col5" ); $p->body->AddHTML( "Precio" ); $p->body->DivClose( );
		// $p->body->DivOpen( "col6", "col6" ); $p->body->AddHTML( "Total" ); $p->body->DivClose( );
		$p->body->DivOpen( "col7", "col7" ); $p->body->AddHTML( "Facturacion" ); $p->body->DivClose( );
		// $p->body->DivOpen( "col8", "col8" ); $p->body->AddHTML( "N.Cred." ); $p->body->DivClose( );
		// $p->body->DivOpen( "col5", "col5" ); $p->body->AddHTML( "Jue" ); $p->body->DivClose( );
		// $p->body->DivOpen( "col6", "col6" ); $p->body->AddHTML( "Vie" ); $p->body->DivClose( );
		// $p->body->DivOpen( "col7", "col7" ); $p->body->AddHTML( "Sab" ); $p->body->DivClose( );
		// $p->body->DivOpen( "col8", "col8" ); $p->body->AddHTML( "Dom" ); $p->body->DivClose( );
		$p->body->DivOpen( "", "" ); $p->body->AddHTML( "&nbsp;" ); $p->body->DivClose( );
	$p->body->DivClose( );
	$total1 = 0;
	$total2 = 0;
	$total3 = 0;
	$total4 = 0;
	$total5 = 0;
	$total8 = 0;

	$p->body->AddHTML( "<hr>" );
	foreach( $lista as $key => $value ){
		$total1 += $value['cant1'];
		$total2 += $value['cant2'];
		$total5 += $value['cant3'];
		// $total3 += $value['total'];
		$total4 += $value['ganancia'];
		$total8 += $value['ncred'];
		$p->body->DivOpen( "", "admitem" );
		// $p->body->DivOpen( "col1", "col1" ); $p->body->AddHTML( "<a href='detalle_cliente.php?prod=".$prod."&cli=".md5( $value['cliage'] )."&desde=".fecha2sql($desde)."&hasta=".fecha2sql($hasta)."'>".$value['razcli']."</a>" ); $p->body->DivClose( );
		$p->body->DivOpen( "col1", "col1" ); $p->body->AddHTML( sql2fecha( $value['fecage'] ) ); $p->body->DivClose( );
		$p->body->DivOpen( "col2", "col2" ); $p->body->AddHTML( $value['cant1'] ); $p->body->DivClose( );
		$p->body->DivOpen( "col3", "col3" ); $p->body->AddHTML( $value['cant2'] ); $p->body->DivClose( );
		$p->body->DivOpen( "col4", "col4" ); $p->body->AddHTML( $value['cant3'] ); $p->body->DivClose( );
		$p->body->DivOpen( "col5", "col5" ); $p->body->AddHTML(  number_format( $value['preciog'],2) ); $p->body->DivClose( );
		// $p->body->DivOpen( "col6", "col6" ); $p->body->AddHTML(  number_format( $value['total'],2) ); $p->body->DivClose( );
		$p->body->DivOpen( "col7", "col7" ); $p->body->AddHTML(  number_format( $value['ganancia'],2) ); $p->body->DivClose( );
		// $p->body->DivOpen( "col8", "col8" ); $p->body->AddHTML(  number_format( $value['ncred'],2) ); $p->body->DivClose( );
		// $p->body->AddHTML( "<a href='detalle_cliente.php?cli=".$value['cliage']."'>".$value['razcli']."</a>"." ".$value['cant1']." ".$value['cant2']." ".$value['total'] );
		$p->body->DivOpen( "", "" ); $p->body->AddHTML( "&nbsp;" ); $p->body->DivClose( );
		$p->body->DivClose( );
	}
	$p->body->AddHTML( "<hr>" );
	$p->body->DivOpen( "", "admitem" );
		$p->body->DivOpen( "col1", "col1" ); $p->body->AddHTML( "&nbsp;" ); $p->body->DivClose( );
		$p->body->DivOpen( "col2", "col2" ); $p->body->AddHTML( $total1 ); $p->body->DivClose( );
		$p->body->DivOpen( "col3", "col3" ); $p->body->AddHTML( $total2 ); $p->body->DivClose( );
		$p->body->DivOpen( "col4", "col4" ); $p->body->AddHTML( $total5 ); $p->body->DivClose( );
		$p->body->DivOpen( "col5", "col5" ); $p->body->AddHTML( "&nbsp;" ); $p->body->DivClose( );
		// $p->body->DivOpen( "col6", "col6" ); $p->body->AddHTML(  number_format( $total3,2) ); $p->body->DivClose( );
		$p->body->DivOpen( "col7", "col7" ); $p->body->AddHTML(  number_format( $total4,2) ); $p->body->DivClose( );
		// $p->body->DivOpen( "col8", "col8" ); $p->body->AddHTML(  number_format( $total8,2) ); $p->body->DivClose( );
		// $p->body->AddHTML( "<a href='detalle_cliente.php?cli=".$value['cliage']."'>".$value['razcli']."</a>"." ".$value['cant1']." ".$value['cant2']." ".$value['total'] );
		$p->body->DivOpen( "", "" ); $p->body->AddHTML( "&nbsp;" ); $p->body->DivClose( );
	$p->body->DivClose( );
	$p->body->AddHTML( "<hr>" );
	
	
} else {
	// aca falta compeltar con redirect para la pagina anterior
}

/*
*/

$res = $p->Render();
echo $res;


?>