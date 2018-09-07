<?php

include_once( "config.php" );

include_once( $DIST.$LIB."/fechas.php" );
include_once( $DIST.$LIB."/SQL.php" );
include_once( $DIST.$LIB."/cHTML.php" );
include_once( $DIST.$LIB."/head.php" );
include_once( $DIST.$LIB."/forms.php" );
include_once( $DIST."/informes/mensual/infomensual_validar.php" );

// echo "test";
$Titulo_Pagina =  "INFORME MENSUAL";

// $p es un objeto cHTML
$p = ArmarCabecera( $Titulo_Pagina );
$p->head->StyleAdd( ".col1", "width:55px;float:left;font-size:11px;font-family:Verdana;text-align:right;" );
$p->head->StyleAdd( ".col2", "width:55px;float:left;font-size:11px;font-family:Verdana;text-align:right;" );
$p->head->StyleAdd( ".col3", "width:55px;float:left;font-size:11px;font-family:Verdana;text-align:right;" );
$p->head->StyleAdd( ".col4", "width:55px;float:left;font-size:11px;font-family:Verdana;text-align:right;" );
// $p->head->StyleAdd( ".col5", "width:55px;float:left;font-size:11px;font-family:Verdana;text-align:right;" );
$p->head->StyleAdd( ".col6",  "width:55px;float:left;font-size:11px;font-family:Verdana;text-align:right;" );
$p->head->StyleAdd( ".col7",   "width:55px;float:left;font-size:11px;font-family:Verdana;text-align:right;" );
$p->head->StyleAdd( ".col8",   "width:55px;float:left;font-size:11px;font-family:Verdana;text-align:right;" );
$p->head->StyleAdd( ".col9",   "width:55px;float:left;font-size:11px;font-family:Verdana;text-align:right;" );
$p->head->StyleAdd( ".cola10", "width:55px;float:left;font-size:11px;font-family:Verdana;text-align:right;" );
$p->head->StyleAdd( ".cola101", "width:55px;float:left;font-size:11px;font-family:Verdana;text-align:right;" );
$p->head->StyleAdd( ".cola11", "width:55px;float:left;font-size:11px;font-family:Verdana;text-align:right;" );
$p->head->StyleAdd( ".cola121", "width:55px;float:left;font-size:11px;font-family:Verdana;text-align:right;" );
$p->head->StyleAdd( ".cola12", "width:55px;float:left;font-size:11px;font-family:Verdana;text-align:right;" );
$p->head->StyleAdd( ".cola122", "width:55px;float:left;font-size:11px;font-family:Verdana;text-align:right;" );
$p->head->StyleAdd( ".cola13", "width:55px;float:left;font-size:11px;font-family:Verdana;text-align:right;" );
$p->head->StyleAdd( ".cola14", "width:55px;float:left;font-size:11px;font-family:Verdana;text-align:right;" );
$p->head->StyleAdd( ".cola15", "width:55px;float:left;font-size:11px;font-family:Verdana;text-align:right;" );
$p->head->StyleAdd( ".cola6",  "width:55px;float:left;font-size:11px;font-family:Verdana;text-align:right;" );
$p->head->StyleAdd( ".cola7",  "width:55px;float:left;font-size:11px;font-family:Verdana;text-align:right;" );
// $p->head->StyleAdd( ".cortarpagina",  "width:55px;float:left;font-size:11px;font-family:Verdana;text-align:right;" );
$p->head->StyleAdd( "@media print",  ".cortarpagina {page-break-after: always;} " );
$p->head->StyleAdd( "@media screen",  ".encabezado {display: none;}" );
// $p->head->StyleAdd( "@media print",  "" );
// $p->head->StyleAdd( "@media print",  ".imprimir {display: always;}" );


$post = $_POST;
if( !InfoMenusualValidarPost( $post ) ){
	$self = $_SERVER["PHP_SELF"];
	$p->body->AddHTML( '<form name="reporte" action="'.$self.'" method="post">' );

	$desde = "01-".date("m-Y");
	$hasta = "01-".date('m-Y',strtotime("+1 month"));
	$hasta = FechaRestarDias( $hasta, 1 );
	
	$txt = GenerarInput( "Producto", "codprod", "", 3, "codprod", "001", "Escriba el codigo de producto" ); $p->body->AddHTML( $txt );
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
	$lista = InfoMenusualPost( $db, $post );
	$prod = $post['codprod'];
	$desde = $post['desde'];
	$hasta = $post['hasta'];
	$p->body->DivOpen( "", "admitem" );
	$p->body->AddHTML( "Del ".$desde. " al ".$hasta ); 
	$p->body->DivClose( );
	$p->body->AddHTML( "<hr>" );
	$p->body->DivOpen( "", "" );
		$p->body->DivOpen( "col1", "col1" ); $p->body->AddHTML( "Dia" ); $p->body->DivClose( );
		$p->body->DivOpen( "col2", "col2" ); $p->body->AddHTML( "Vta.Ciu" ); $p->body->DivClose( );
		$p->body->DivOpen( "col3", "col3" ); $p->body->AddHTML( "Vta.Int" ); $p->body->DivClose( );
		$p->body->DivOpen( "col4", "col4" ); $p->body->AddHTML( "Sus.Ciu." ); $p->body->DivClose( );
		// $p->body->DivOpen( "col5", "col5" ); $p->body->AddHTML( "Sus.Int." ); $p->body->DivClose( );
		$p->body->DivOpen( "col6", "col6" ); $p->body->AddHTML( "S.Costo" ); $p->body->DivClose( );
		$p->body->DivOpen( "col7", "col7" ); $p->body->AddHTML( "Dev.Ciu." ); $p->body->DivClose( );
		$p->body->DivOpen( "col8", "col8" ); $p->body->AddHTML( "Dev.Int." ); $p->body->DivClose( );
		$p->body->DivOpen( "col9", "col9" ); $p->body->AddHTML( "No Dist." ); $p->body->DivClose( );
		$p->body->DivOpen( "cola10", "cola10" ); $p->body->AddHTML( "Neta Paga" ); $p->body->DivClose( );
		$p->body->DivOpen( "cola101", "cola101" ); $p->body->AddHTML( "Prom." ); $p->body->DivClose( );
		$p->body->DivOpen( "cola11", "cola11" ); $p->body->AddHTML( "Inutiliz." ); $p->body->DivClose( );
		$p->body->DivOpen( "cola12", "cola121" ); $p->body->AddHTML( "Tir.Neta" ); $p->body->DivClose( );
		$p->body->DivOpen( "cola12", "cola12" ); $p->body->AddHTML( "Tir.Bruta" ); $p->body->DivClose( );
		// $p->body->DivOpen( "cola122", "cola122" ); $p->body->AddHTML( "Bruta RP" ); $p->body->DivClose( );
		$p->body->DivOpen( "cola13", "cola13" ); $p->body->AddHTML( "Pag" ); $p->body->DivClose( );
		$p->body->DivOpen( "cola14", "cola14" ); $p->body->AddHTML( "Tot.Pag." ); $p->body->DivClose( );
		$p->body->DivOpen( "cola15", "cola15" ); $p->body->AddHTML( "Kgrs.Tot" ); $p->body->DivClose( );
		$p->body->DivOpen( "", "" ); $p->body->AddHTML( "&nbsp;" ); $p->body->DivClose( );
	$p->body->DivClose( );
	$totales = [];
	$total1 = 0;
	$total2 = 0;
	$total3 = 0;
	$total4 = 0;
	$p->body->AddHTML( "<hr>" );
	
	$arrdias = [];
	for( $i = 1; $i <= 7; $i++){
		$arr = [];
		$arr['vtaciu'] = 0 ;
		$arr['vtaint'] = 0;
		$arr['susciu'] = 0; 
		$arr['susint'] = 0;
		$arr['devsin'] = 0;
		$arr['devciu'] = 0;
		$arr['devint'] = 0;
		$arr['nodis'] = 0;
		$arr['cirneta'] = 0;
		$arr['cantdias'] = 0;
		// $arr['cantdiasdow'] = 0;
		// $arr['cantdiasdow'][1] = 0;
		// $arr['cantdiasdow'][2] = 0;
		// $arr['cantdiasdow'][3] = 0;
		// $arr['cantdiasdow'][4] = 0;
		// $arr['cantdiasdow'][5] = 0;
		// $arr['cantdiasdow'][6] = 0;
		// $arr['cantdiasdow'][7] = 0;
		$arr['inutilizable'] = 0;
		$arr['tirneta'] = 0;
		$arr['tirbruta'] = 0;
		$arr['tirbrutarp'] = 0;
		$arr['paginas'] = 0;
		$arr['totpaginas'] = 0;
		$arr['kgrstotales'] = 0;
		$arrdias[$i] = $arr;
	}
	$arrtot = [];
	$arrtot['vtaciu'] = 0 ;
	$arrtot['vtaint'] = 0;
	$arrtot['susciu'] = 0; 
	$arrtot['susint'] = 0;
	$arrtot['devsin'] = 0;
	$arrtot['devciu'] = 0;
	$arrtot['devint'] = 0;
	$arrtot['nodis'] = 0;
	$arrtot['cirneta'] = 0;
	$arrtot['cantdias'] = 0;
	$arrtot['inutilizable'] = 0;
	$arrtot['tirneta'] = 0;
	$arrtot['tirbruta'] = 0;
	$arrtot['tirbrutarp'] = 0;
	$arrtot['paginas'] = 0;
	$arrtot['totpaginas'] = 0;
	$arrtot['kgrstotales'] = 0;

	foreach( $lista as $key => $value ){
		
		// $arrtot['dia'] += $value['dia'] ;
		$arrtot['vtaciu'] += $value['vtaciu'] ;
		$arrtot['vtaint'] += $value['vtaint'] ;
		$arrtot['susciu'] += $value['susciu'] ;
		$arrtot['susint'] += $value['susint'] ;
		$arrtot['devsin'] += $value['devsin'] ;
		$arrtot['devciu'] += $value['devciu'] ;
		$arrtot['devint'] += $value['devint'] ;
		$arrtot['nodis'] += $value['nodis'] ;
		$arrtot['cirneta'] += $value['cirneta'] ;
		$arrtot['inutilizable'] += $value['inutilizable'] ;
		$arrtot['tirneta'] += $value['tirneta'] ;
		$arrtot['tirbruta'] += $value['tirbruta'] ;
		$arrtot['tirbrutarp'] += $value['tirbrutarp'] ;
		$arrtot['paginas'] += $value['paginas'] ;
		$arrtot['totpaginas'] += $value['totpaginas'] ;
		$arrtot['kgrstotales'] += $value['kgrstotales'] ;
		
		$dow = $value['dow'];
		$arrdias[$dow]['vtaciu'] += $value['vtaciu'] ;
		$arrdias[$dow]['vtaint'] += $value['vtaint'] ;
		$arrdias[$dow]['susciu'] += $value['susciu'] ;
		$arrdias[$dow]['susint'] += $value['susint'] ;
		$arrdias[$dow]['devsin'] += $value['devsin'] ;
		$arrdias[$dow]['devciu'] += $value['devciu'] ;
		$arrdias[$dow]['devint'] += $value['devint'] ;
		$arrdias[$dow]['nodis'] += $value['nodis'] ;
		$arrdias[$dow]['cirneta'] += $value['cirneta'] ;
		if( $value['vtaciu'] > 0 ){
			$arrtot['cantdias'] += 1 ;
			$arrdias[$dow]['cantdias'] += 1 ;
			// $arrdias[$dow]['cantdiasdow'] += 1 ;
		}
		
		$arrdias[$dow]['inutilizable'] += $value['inutilizable'] ;
		$arrdias[$dow]['tirneta'] += $value['tirneta'] ;
		$arrdias[$dow]['tirbruta'] += $value['tirbruta'] ;
		$arrdias[$dow]['tirbrutarp'] += $value['tirbrutarp'] ;
		$arrdias[$dow]['paginas'] += $value['paginas'] ;
		$arrdias[$dow]['totpaginas'] += $value['totpaginas'] ;
		$arrdias[$dow]['kgrstotales'] += $value['kgrstotales'] ;
		
		$p->body->DivOpen( "", "admitem" );
		$p->body->DivOpen( "col1", "col1" ); $p->body->AddHTML( $value['dia'] ); $p->body->DivClose( );
		$p->body->DivOpen( "col2", "col2" ); $p->body->AddHTML( $value['vtaciu'] ); $p->body->DivClose( );
		$p->body->DivOpen( "col3", "col3" ); $p->body->AddHTML( $value['vtaint'] ); $p->body->DivClose( );
		$p->body->DivOpen( "col4", "col4" ); $p->body->AddHTML( $value['susciu'] ); $p->body->DivClose( );
		// $p->body->DivOpen( "col5", "col5" ); $p->body->AddHTML( $value['susint'] ); $p->body->DivClose( );
		$p->body->DivOpen( "col6", "col6" ); $p->body->AddHTML( $value['devsin'] ); $p->body->DivClose( );
		$p->body->DivOpen( "col7", "col7" ); $p->body->AddHTML( $value['devciu'] ); $p->body->DivClose( );
		$p->body->DivOpen( "col8", "col8" ); $p->body->AddHTML( $value['devint'] ); $p->body->DivClose( );
		$p->body->DivOpen( "col9", "col9" ); $p->body->AddHTML( $value['nodis'] ); $p->body->DivClose( );
		$p->body->DivOpen( "cola10", "cola10" ); $p->body->AddHTML( $value['cirneta'] ); $p->body->DivClose( );
		$p->body->DivOpen( "cola101", "cola101" ); $p->body->AddHTML( "&nbsp;" ); $p->body->DivClose( );
		$p->body->DivOpen( "cola11", "cola11" ); $p->body->AddHTML( $value['inutilizable'] ); $p->body->DivClose( );
		$p->body->DivOpen( "cola121", "cola121" ); $p->body->AddHTML( $value['tirneta'] ); $p->body->DivClose( );
		$p->body->DivOpen( "cola12", "cola12" ); $p->body->AddHTML( $value['tirbruta'] ); $p->body->DivClose( );
		// $p->body->DivOpen( "cola122", "cola122" ); $p->body->AddHTML( $value['tirbrutarp'] ); $p->body->DivClose( );
		$p->body->DivOpen( "cola13", "cola13" ); $p->body->AddHTML( $value['paginas'] ); $p->body->DivClose( );
		$p->body->DivOpen( "cola14", "cola14" ); $p->body->AddHTML( $value['totpaginas'] ); $p->body->DivClose( );
		$p->body->DivOpen( "cola15", "cola15" ); $p->body->AddHTML( $value['kgrstotales'] ); $p->body->DivClose( );
		
		$p->body->DivOpen( "", "" ); $p->body->AddHTML( "&nbsp;" ); $p->body->DivClose( );
		$p->body->DivClose( );
	}
	$p->body->AddHTML( "<hr>" );
	$p->body->AddHTML( "<div class='cortarpagina'  ></div>" );
	
	$p->body->AddHTML( "<div class='encabezado'  >" );
		// $p->body->DivOpen( "", "" );
		$p->body->AddHTML( "<hr >" );
		// $p->body->DivOpen( "", "ClearBoth" ); $p->body->AddHTML( "&nbsp;" ); $p->body->DivClose( );
		$p->body->DivOpen( "col1", "col1" ); $p->body->AddHTML( "Dia" ); $p->body->DivClose( );
		$p->body->DivOpen( "col2", "col2" ); $p->body->AddHTML( "Vta.Ciu" ); $p->body->DivClose( );
		$p->body->DivOpen( "col3", "col3" ); $p->body->AddHTML( "Vta.Int" ); $p->body->DivClose( );
		$p->body->DivOpen( "col4", "col4" ); $p->body->AddHTML( "Sus.Ciu." ); $p->body->DivClose( );
		// $p->body->DivOpen( "col5", "col5" ); $p->body->AddHTML( "Sus.Int." ); $p->body->DivClose( );
		$p->body->DivOpen( "col6", "col6" ); $p->body->AddHTML( "S.Costo" ); $p->body->DivClose( );
		$p->body->DivOpen( "col7", "col7" ); $p->body->AddHTML( "Dev.Ciu." ); $p->body->DivClose( );
		$p->body->DivOpen( "col8", "col8" ); $p->body->AddHTML( "Dev.Int." ); $p->body->DivClose( );
		$p->body->DivOpen( "col9", "col9" ); $p->body->AddHTML( "No Dist." ); $p->body->DivClose( );
		$p->body->DivOpen( "cola10", "cola10" ); $p->body->AddHTML( "Neta P." ); $p->body->DivClose( );
		$p->body->DivOpen( "cola101", "cola101" ); $p->body->AddHTML( "Prom." ); $p->body->DivClose( );
		$p->body->DivOpen( "cola11", "cola11" ); $p->body->AddHTML( "Inutiliz." ); $p->body->DivClose( );
		$p->body->DivOpen( "cola12", "cola121" ); $p->body->AddHTML( "Tir.Neta" ); $p->body->DivClose( );
		$p->body->DivOpen( "cola12", "cola12" ); $p->body->AddHTML( "Tir.Bruta" ); $p->body->DivClose( );
		// $p->body->DivOpen( "cola122", "cola122" ); $p->body->AddHTML( "Bruta RP" ); $p->body->DivClose( );
		$p->body->DivOpen( "cola13", "cola13" ); $p->body->AddHTML( "Pag" ); $p->body->DivClose( );
		$p->body->DivOpen( "cola14", "cola14" ); $p->body->AddHTML( "Tot.Pag." ); $p->body->DivClose( );
		$p->body->DivOpen( "cola15", "cola15" ); $p->body->AddHTML( "Kgrs.Tot" ); $p->body->DivClose( );
		$p->body->DivOpen( "", "" ); $p->body->AddHTML( "&nbsp;" ); $p->body->DivClose( );
		$p->body->AddHTML( "<hr >" );
	// $p->body->DivClose( );
	$p->body->AddHTML( "</div >" );
	$p->body->DivClose( );

	// $p->body->AddHTML( "<hr class='cortarpagina'>" );
	$p->body->DivOpen( "", "admitem" );
		$p->body->DivOpen( "col1", "col1" ); $p->body->AddHTML( "General:" ); $p->body->DivClose( );
		$p->body->DivOpen( "col2", "col2" ); $p->body->AddHTML( $arrtot['vtaciu'] ); $p->body->DivClose( );
		$p->body->DivOpen( "col3", "col3" ); $p->body->AddHTML( $arrtot['vtaint'] ); $p->body->DivClose( );
		$p->body->DivOpen( "col4", "col4" ); $p->body->AddHTML( $arrtot['susciu'] ); $p->body->DivClose( );
		// $p->body->DivOpen( "col5", "col5" ); $p->body->AddHTML( $arrtot['susint'] ); $p->body->DivClose( );
		$p->body->DivOpen( "col6", "col6" ); $p->body->AddHTML( $arrtot['devsin'] ); $p->body->DivClose( );
		$p->body->DivOpen( "col7", "col7" ); $p->body->AddHTML( $arrtot['devciu'] ); $p->body->DivClose( );
		$p->body->DivOpen( "col8", "col8" ); $p->body->AddHTML( $arrtot['devint'] ); $p->body->DivClose( );
		$p->body->DivOpen( "col9", "col9" ); $p->body->AddHTML( $arrtot['nodis'] ); $p->body->DivClose( );
		$p->body->DivOpen( "cola10", "cola10" ); $p->body->AddHTML( $arrtot['cirneta'] ); $p->body->DivClose( );
		$prom = $arrtot['cirneta'] / $arrtot['cantdias'] ;
		$p->body->DivOpen( "cola101", "cola101" ); $p->body->AddHTML( round( $prom, 0 ) ); $p->body->DivClose();
		$p->body->DivOpen( "cola11", "cola11" ); $p->body->AddHTML( $arrtot['inutilizable'] ); $p->body->DivClose( );
		$p->body->DivOpen( "cola121", "cola121" ); $p->body->AddHTML( $arrtot['tirneta'] ); $p->body->DivClose( );
		$p->body->DivOpen( "cola12", "cola12" ); $p->body->AddHTML( $arrtot['tirbruta'] ); $p->body->DivClose( );
		// $p->body->DivOpen( "cola122", "cola122" ); $p->body->AddHTML( $arrtot['tirbrutarp'] ); $p->body->DivClose( );
		$p->body->DivOpen( "cola13", "cola13" ); $p->body->AddHTML( $arrtot['paginas'] ); $p->body->DivClose( );
		$p->body->DivOpen( "cola14", "cola14" ); $p->body->AddHTML( $arrtot['totpaginas'] ); $p->body->DivClose( );
		$p->body->DivOpen( "cola15", "cola15" ); $p->body->AddHTML( $arrtot['kgrstotales'] ); $p->body->DivClose( );
		// $p->body->DivOpen( "col3", "col3" ); $p->body->AddHTML( $total2 ); $p->body->DivClose( );
		// $p->body->DivOpen( "col4", "col4" ); $p->body->AddHTML( $total5 ); $p->body->DivClose( );
		// $p->body->DivOpen( "col5", "col5" ); $p->body->AddHTML(  number_format( $total3,2) ); $p->body->DivClose( );
		// $p->body->DivOpen( "col6", "col6" ); $p->body->AddHTML(  number_format( $total4,2) ); $p->body->DivClose( );
		// $p->body->AddHTML( "<a href='detalle_cliente.php?cli=".$value['cliage']."'>".$value['razcli']."</a>"." ".$value['cant1']." ".$value['cant2']." ".$value['total'] );
		$p->body->DivOpen( "", "" ); $p->body->AddHTML( "&nbsp;" ); $p->body->DivClose( );
	$p->body->DivClose( );
	for( $i = 1; $i<= 7; $i++){
		
		switch( $i ){
			case 1:{ $cdow = "Dom"; break; }
			case 2:{ $cdow = "Lun"; break; }
			case 3:{ $cdow = "Mar"; break; }
			case 4:{ $cdow = "Mie"; break; }
			case 5:{ $cdow = "Jue"; break; }
			case 6:{ $cdow = "Vie"; break; }
			case 7:{ $cdow = "Sab"; break; }
		}
		$p->body->AddHTML( "<hr>" );
		$p->body->DivOpen( "", "admitem" );
			$p->body->DivOpen( "col1", "col1" ); $p->body->AddHTML( $cdow ); $p->body->DivClose( );
			$p->body->DivOpen( "col2", "col2" ); $p->body->AddHTML( $arrdias[$i]['vtaciu'] ); $p->body->DivClose( );
			$p->body->DivOpen( "col3", "col3" ); $p->body->AddHTML( $arrdias[$i]['vtaint'] ); $p->body->DivClose( );
			$p->body->DivOpen( "col4", "col4" ); $p->body->AddHTML( $arrdias[$i]['susciu'] ); $p->body->DivClose( );
			$p->body->DivOpen( "col6", "col6" ); $p->body->AddHTML( $arrdias[$i]['devsin'] ); $p->body->DivClose( );
			$p->body->DivOpen( "col7", "col7" ); $p->body->AddHTML( $arrdias[$i]['devciu'] ); $p->body->DivClose( );
			$p->body->DivOpen( "col8", "col8" ); $p->body->AddHTML( $arrdias[$i]['devint'] ); $p->body->DivClose( );
			$p->body->DivOpen( "col9", "col9" ); $p->body->AddHTML( $arrdias[$i]['nodis'] ); $p->body->DivClose( );
			$p->body->DivOpen( "cola10", "cola10" ); $p->body->AddHTML( $arrdias[$i]['cirneta'] ); $p->body->DivClose( );
			$prom = $arrdias[$i]['cirneta']  / $arrdias[$i]['cantdias']  ;
			$p->body->DivOpen( "cola101", "cola101" ); $p->body->AddHTML( round( $prom,0) ); $p->body->DivClose( );
			$p->body->DivOpen( "cola11", "cola11" ); $p->body->AddHTML( $arrdias[$i]['inutilizable'] ); $p->body->DivClose( );
			$p->body->DivOpen( "cola121", "cola121" ); $p->body->AddHTML( $arrdias[$i]['tirneta'] ); $p->body->DivClose( );
			$p->body->DivOpen( "cola12", "cola12" ); $p->body->AddHTML( $arrdias[$i]['tirbruta'] ); $p->body->DivClose( );
			$p->body->DivOpen( "cola13", "cola13" ); $p->body->AddHTML( $arrdias[$i]['paginas'] ); $p->body->DivClose( );
			$p->body->DivOpen( "cola14", "cola14" ); $p->body->AddHTML( $arrdias[$i]['totpaginas'] ); $p->body->DivClose( );
			$p->body->DivOpen( "cola15", "cola15" ); $p->body->AddHTML( $arrdias[$i]['kgrstotales'] ); $p->body->DivClose( );
			$p->body->DivOpen( "", "" ); $p->body->AddHTML( "&nbsp;" ); $p->body->DivClose( );
		$p->body->DivClose( );	
	}
	$p->body->AddHTML( "<hr>" );
	
	
}

/*
*/

$res = $p->Render();
echo $res;

?>