<?php

include_once( "config.php" );
include_once( $DIST."/informes/facturacion/GenerarListaInfoFacturacionDetallada.php" );
include_once( $DIST."/informes/facturacion/InfoFacturacionValidarPost.php" );
include_once( $DIST.$LIB."/fechas.php" );
include_once( $DIST.$LIB."/SQL.php" );
include_once( $DIST.$LIB."/cHTML.php" );
include_once( $DIST.$LIB."/head.php" );
include_once( $DIST.$LIB."/forms.php" );

// echo "test";
$Titulo_Pagina =  "INFORME DETALLADO DE NOTAS DE CREDITO";

// $p es un objeto cHTML
$p = ArmarCabecera( $Titulo_Pagina );
$p->head->StyleAdd( ".col1",     	  		"width:300px;float:left;font-size:12px;font-family:Verdana;" );
// $p->head->StyleAdd( ".col2",     	  		"width:55px;float:left;font-size:12px;font-family:Verdana;text-align:right;" );
// $p->head->StyleAdd( ".col3",     	  		"width:55px;float:left;font-size:12px;font-family:Verdana;text-align:right;" );
$p->head->StyleAdd( ".col4",     	  		"width:55px;float:left;font-size:12px;font-family:Verdana;text-align:right;" );
// $p->head->StyleAdd( ".col5",     	  		"width:100px;float:left;font-size:12px;font-family:courier new;text-align:right;" );
// $p->head->StyleAdd( ".col6",     	  		"width:100px;float:left;font-size:12px;font-family:Verdana;text-align:right;" );
$p->head->StyleAdd( ".col7",     	  		"width:100px;float:left;font-size:12px;font-family:Verdana;text-align:right;" );
// $p->head->StyleAdd( ".col7",     	  		"width:100px;float:left;font-size:14px;font-family:courier new;text-align:right;" );

// $p->head->StyleAdd( ".col1",     	  		"width:400px;float:left;font-family:courier new;" );
// $p->head->StyleAdd( ".col2",     	  		"width:80px;float:left;font-family:courier new;text-align:right;" );
// $p->head->StyleAdd( ".col3",     	  		"width:80px;float:left;font-family:courier new;text-align:right;" );
// $p->head->StyleAdd( ".col4",     	  		"width:80px;float:left;font-family:courier new;text-align:right;" );
// $p->head->StyleAdd( ".col5",     	  		"width:160px;float:left;font-family:courier new;text-align:right;" );
// $p->head->StyleAdd( ".col6",     	  		"width:160px;float:left;font-family:courier new;text-align:right;" );

// $p->head->StyleAdd( ".col5",     	  		"width:100px;float:left;font-family:courier new;" );
// $p->head->StyleAdd( ".col6",     	  		"width:100px;float:left;font-family:courier new;" );
// $p->head->StyleAdd( ".col7",     	  		"width:100px;float:left;font-family:courier new;" );
// $p->head->StyleAdd( ".col8",     	  		"width:100px;float:left;font-family:courier new;" );


$post = $_POST;
if( !InfoFacturacionValidarPost( $post ) ){
	$self = $_SERVER["PHP_SELF"];
	$p->body->AddHTML( '<form name="reporte" action="'.$self.'" method="post">' );

	$desde = "01-".date("m-Y");
	$hasta = "01-".date('m-Y',strtotime("+1 month"));
	$hasta = FechaRestarDias( $hasta, 1 );
	
	$txt = GenerarInput( "Producto", "prod", "", 3, "prod", "001", "Escriba el codigo de producto" ); $p->body->AddHTML( $txt );
	$txt = GenerarInput( "Desde Fecha", "desde", "", 10, "desde", "$desde", "Escriba la fecha inicial de informe (DD-MM-AAAA)" ); $p->body->AddHTML( $txt );
	$txt = GenerarInput( "Hasta Fecha", "hasta", "", 10, "hasta", "$hasta", "Escriba la fecha final de informe (DD-MM-AAAA)" ); $p->body->AddHTML( $txt );

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
	$lista = InfoFacturacionPostGenerarListaClientes( $db, $post );
	$prod = $post['prod'];
	$desde = $post['desde'];
	$hasta = $post['hasta'];
	$p->body->DivOpen( "", "admitem" );
	$p->body->AddHTML( "Del ".$desde. " al ".$hasta ); 
	$p->body->DivClose( );
	$p->body->AddHTML( "<hr>" );
	$p->body->DivOpen( "", "" );
		$p->body->DivOpen( "col1", "col1" ); $p->body->AddHTML( "Cliente" ); $p->body->DivClose( );
		// $p->body->DivOpen( "col2", "col2" ); $p->body->AddHTML( "CCC" ); $p->body->DivClose( );
		// $p->body->DivOpen( "col3", "col3" ); $p->body->AddHTML( "CSC" ); $p->body->DivClose( );
		$p->body->DivOpen( "col4", "col4" ); $p->body->AddHTML( "Dev" ); $p->body->DivClose( );
		// $p->body->DivOpen( "col5", "col5" ); $p->body->AddHTML( "Total" ); $p->body->DivClose( );
		// $p->body->DivOpen( "col6", "col6" ); $p->body->AddHTML( "Facturacion" ); $p->body->DivClose( );
		$p->body->DivOpen( "col7", "col7" ); $p->body->AddHTML( "N.Créd." ); $p->body->DivClose( );
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
	$total7 = 0;
	$p->body->AddHTML( "<hr>" );
	foreach( $lista as $key => $value ){
		$total1 += $value['cant1'];
		$total2 += $value['cant2'];
		// $total3 += $value['total'];
		$total4 += $value['ganancia'];
		$total5 += $value['cant3'];
		$total7 += $value['ncred'];
		$p->body->DivOpen( "", "admitem" );
		$p->body->DivOpen( "col1", "col1" ); $p->body->AddHTML( "<a href='detalle_cliente_nc.php?prod=".$prod."&cli=".md5( $value['cliage'] )."&desde=".$desde."&hasta=".$hasta."'>".$value['cliage']." ".$value['razcli']."</a>" ); $p->body->DivClose( );
		// $p->body->DivOpen( "col2", "col2" ); $p->body->AddHTML( $value['cant1'] ); $p->body->DivClose( );
		// $p->body->DivOpen( "col3", "col3" ); $p->body->AddHTML( $value['cant2'] ); $p->body->DivClose( );
		$p->body->DivOpen( "col4", "col4" ); $p->body->AddHTML( $value['cant3'] ); $p->body->DivClose( );
		// $p->body->DivOpen( "col5", "col5" ); $p->body->AddHTML(  number_format( $value['total'],2) ); $p->body->DivClose( );
		// $p->body->DivOpen( "col6", "col6" ); $p->body->AddHTML(  number_format( $value['ganancia'],2) ); $p->body->DivClose( );
		$p->body->DivOpen( "col7", "col7" ); $p->body->AddHTML(  number_format( $value['ncred'],2) ); $p->body->DivClose( );
		// $p->body->AddHTML( "<a href='detalle_cliente.php?cli=".$value['cliage']."'>".$value['razcli']."</a>"." ".$value['cant1']." ".$value['cant2']." ".$value['total'] );
		$p->body->DivOpen( "", "" ); $p->body->AddHTML( "&nbsp;" ); $p->body->DivClose( );
		$p->body->DivClose( );
	}
	$p->body->AddHTML( "<hr>" );
	$p->body->DivOpen( "", "admitem" );
		$p->body->DivOpen( "col1", "col1" ); $p->body->AddHTML( "&nbsp;" ); $p->body->DivClose( );
		// $p->body->DivOpen( "col2", "col2" ); $p->body->AddHTML( $total1 ); $p->body->DivClose( );
		// $p->body->DivOpen( "col3", "col3" ); $p->body->AddHTML( $total2 ); $p->body->DivClose( );
		$p->body->DivOpen( "col4", "col4" ); $p->body->AddHTML( $total5 ); $p->body->DivClose( );
		// $p->body->DivOpen( "col5", "col5" ); $p->body->AddHTML(  number_format( $total3,2) ); $p->body->DivClose( );
		// $p->body->DivOpen( "col6", "col6" ); $p->body->AddHTML(  number_format( $total4,2) ); $p->body->DivClose( );
		$p->body->DivOpen( "col7", "col7" ); $p->body->AddHTML(  number_format( $total7,2) ); $p->body->DivClose( );
		// $p->body->AddHTML( "<a href='detalle_cliente.php?cli=".$value['cliage']."'>".$value['razcli']."</a>"." ".$value['cant1']." ".$value['cant2']." ".$value['total'] );
		$p->body->DivOpen( "", "" ); $p->body->AddHTML( "&nbsp;" ); $p->body->DivClose( );
	$p->body->DivClose( );
	$p->body->AddHTML( "<hr>" );
	
	
}

/*
*/

$res = $p->Render();
echo $res;

?>