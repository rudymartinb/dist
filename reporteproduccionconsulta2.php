<?php 
// ordprod_nueva.php

include_once( "config.php" );


include_once( $DIST.$LIB."/fechas.php" );
include_once( $DIST.$LIB."/cHTML.php" );

include_once( $DIST.$LIB."/SQL.php" );
include_once( $DIST.$CLASS."/cProducto.php" );

include_once( $DIST."/ProcesarReporteProduccion.php" );

error_reporting(E_ALL);


$db = SQL_Conexion();
	


$p = new cHTML();

$p->head->titulo = "Consulta de Reporte Produccion";
$p->head->AddMeta( "http-equiv='Content-Type' content='text/html; charset=iso-8859-1'"  );
$p->head->AddCSS( "/css/base.css" );
$p->head->AddJS( "/js/MandarAjax.js.php" );

$p->head->StyleAdd( "#admtitulo",     	  "font-family:courier new;font-weight:bold;text-align:left;font-size:28px;color:black;padding:1px;border:5px;width:100%;" );
$p->head->StyleAdd( "#admtitulo2",     	  "font-family:courier new;font-weight:bold;text-align:left;font-size:24px;color:black;padding:1px;border:5px;width:100%;" );
$p->head->StyleAdd( ".admitem",     	  "font-family:courier new;font-weight:bold;text-align:left;font-size:18px;color:black;padding:1px;border:5px;width:100%;" );
$p->head->StyleAdd( ".textolink",     	  "font-family:courier new;font-weight:bold;text-align:left;font-size:16px;padding:1px;border:5px;width:100%;" );
// $p->head->StyleAdd( "hr",     	  "border: none;height: 2px;color: #333;background-color: #333;" );


$p->head->StyleAdd( ".inputText",     	  	"width:50px;" );
$p->head->StyleAdd( ".marginright10",     	"margin-right:10px;" );
$p->head->StyleAdd( ".padright10",     	  	"padding-right:10px;" );
$p->head->StyleAdd( ".size50",     	  		"width:50px;" );
$p->head->StyleAdd( ".size100",     	  	"width:100px;" );
$p->head->StyleAdd( ".size150",     	  	"width:150px;" );
$p->head->StyleAdd( ".size200",     	  	"width:200px;" );
$p->head->StyleAdd( ".size400",     	  	"width:400px;" );
$p->head->StyleAdd( ".size600",     	  	"width:600px;" );
$p->head->StyleAdd( ".tahoma",     	  		"font-family:tahoma;" );
$p->head->StyleAdd( ".couriernew",     	  	"font-family:courier new;" );
$p->head->StyleAdd( ".bold",     	  		"font-weight:bold;" );
$p->head->StyleAdd( ".fs12",     	  		"font-size:12px;" );
$p->head->StyleAdd( ".fs14",     	  		"font-size:14px;" );
$p->head->StyleAdd( ".ClearBoth",     	  	"clear:both;" );
$p->head->StyleAdd( ".floatLeft",     	  	"float:left;" );
$p->head->StyleAdd( ".textoIzquierda",     	"text-align:left;" );
$p->head->StyleAdd( ".textoCentrado",     	"text-align:center;" );
$p->head->StyleAdd( ".textoDerecha",     	"text-align:right;" );
$p->head->StyleAdd( ".borde1",    		  	"border-style:solid;border-width:1px;" );
$p->head->StyleAdd( ".almanaqueCelda",    	"width:100px;height:70px;" );
$p->head->StyleAdd( ".almanaqueCeldaFDM", 	"width:100px;height:70px;" );
$p->head->StyleAdd( ".fondoGrisClaro", 		"background-color:lightgray;" );
$p->head->StyleAdd( ".fondoRosa", 			"background-color:#FF9999;" );
$p->head->StyleAdd( ".almanaqueRenglon",  	"clear:both;" );
$p->head->StyleAdd( "@media print { .ocultar", "display:none !important; }" );

$p->head->AddJS( "http://ww.elpopular/js/jquery-1.9.0.js" );


$p->head->AddJS( "/js/PadN.js" );
$p->head->AddJS( "/js/focus.js" );
$p->head->AddJS( "/js/MandarAjax.js.php" );
// $p->head->AddJS( "/resources/qunit-1.13.0.js" );
// $p->body->AddJS( "/js/cBrowse.js" );


$p->head->AddJS( "/ajax/ajaxAlmanaqueDiaModi.js.php" );


$p->body->DivOpen( "admtitulo", "titulo" );
$p->body->AddHTML( "Consulta Reporte Produccion" );
$p->body->DivClose( );

$post = $_GET;

if( $post != null ){
	// $fecha = $post['fecha'];
	$db = SQL_Conexion();
	if( ! SQL_EsValido( $db ) ){
		$p->body->AddHTML( "no se pudo abrir la db "  );
		return false;
	}
	// $p->body->AddHTML( "no se pudo abrir la db "  );
	// $fecini = $post['fecini'];
	// $fecfin = $post['fecfin'];
	$idx = $post['id'];
	
	$rp = new cReporteProduccion();
	$rp->db = $db;
	$rp->idx = (int) $idx;
	if( $rp->LeerIdx() ){
		// $p->body->AddHTML( "DETALLE REPORTE:" );
		
		/*
		public $fecha;
		public $TotalKgrs;
		public $TotalKgrsCapaBlanca;
		public $pro;
		public $Observaciones = "";
		public $tiradas = [];
		*/
		$pro = new cProducto();
		$pro->db = $db;
		$pro->cod = $rp->pro;
		$pro->Leer();
		$p->body->AddHTML( "<hr>" );
		$p->body->DivOpen("","admitem");
		$p->body->AddHTML( "Producto: ".$rp->pro." ".$pro->des );
		$p->body->DivClose();
		$p->body->DivOpen("","admitem");
		$p->body->AddHTML( "Fecha: ".$rp->fecha );
		$p->body->DivClose();
		$p->body->DivOpen("","admitem");
		$p->body->AddHTML( "Total Kgrs: ".$rp->TotalKgrs );
		$p->body->DivClose();		
		$p->body->DivOpen("","admitem");
		$p->body->AddHTML( "Total Kgrs Capa Blanca: ".$rp->TotalKgrsCapaBlanca );
		$p->body->DivClose();
		
		$p->body->DivOpen("","admitem");
		$p->body->AddHTML( "Tirada Neta: ".$rp->TiradaNeta );
		$p->body->DivClose();
		
		$p->body->DivOpen("","admitem");
		$p->body->AddHTML( "Observaciones: ".$rp->Observaciones );
		$p->body->DivClose();
		
		$p->body->DivOpen("","admitem");
		$p->body->AddHTML( "Cant Tiradas: ". count( $rp->tiradas ) );
		$p->body->DivClose();

		// $idx = $rp->idx;
		$p->body->AddHTML( '<a class="textolink" href="produccion/reporteproduccion_modicab.php?idx='.$idx.'" >Modificar</a>' );
		
		
		
		for( $i = 0; $i < count( $rp->tiradas ) ; $i++ ){
			$rt = $rp->tiradas[$i];
			$p->body->AddHTML( "<hr>" );
			$p->body->DivOpen("","admitem");
			$p->body->AddHTML( "Nro Tirada: " . $rt->nro  );
			$p->body->DivClose();
			$p->body->DivOpen("","admitem");
			$p->body->AddHTML( "Hora Inicial: " . $rt->horaini  );
			$p->body->DivClose();
			$p->body->DivOpen("","admitem");
			$p->body->AddHTML( "Hora Final: " . $rt->horafin );
			$p->body->DivClose();			
			$p->body->DivOpen("","admitem");
			$p->body->AddHTML( "Nro Inicial Maquina: " . $rt->MaqIni  );
			$p->body->DivClose();
			$p->body->DivOpen("","admitem");
			$p->body->AddHTML( "Nro Final Maquina: " . $rt->MaqFin );
			$p->body->DivClose();	
			$p->body->DivOpen("","admitem");
			$p->body->AddHTML( "Tirada Bruta: " . $rt->TiradaBruta );
			$p->body->DivClose();
			$p->body->DivOpen("","admitem");
			$p->body->AddHTML( "Kgrs: " . $rt->Kgrs );
			$p->body->DivClose();
			$p->body->DivOpen("","admitem");
			$p->body->AddHTML( "Paginas Total: " . $rt->pagtotal );
			$p->body->DivClose();			
			$p->body->DivOpen("","admitem");
			$p->body->AddHTML( "Paginas Color: " . $rt->pagcolor );
			$p->body->DivClose();
			$p->body->AddHTML( '<a class="textolink" href="produccion/reporteproduccion_moditir.php?idx='.$rt->idx.'" >Modificar</a>' );
		}
		$p->body->AddHTML( "<hr>" );
		$p->body->AddHTML( '<input class="adminput" type="submit" value="Eliminar Reporte" id="DelTirada">' );
		$p->body->AddHTML( '<script>
			$("#DelTirada").click( function() {
				var r = confirm("Confirma Eliminar el Reporte?");
				if (r == true) {
					var este = { "nro": nro  };
					data = MandarAjax( "/produccion/Ajax_EliminarReporte.php", este );
				}
				return false;
			} );
			</script>
		' );


	} else {
		$p->body->AddHTML( "No se pudo leer ". $rp->DetalleError );
		// echo ;
	}

}

$p->body->DivOpen( "", "admitem ClearBoth " );
$p->body->AddHTML( "<a href='index.php' class='ocultar'>Volver al men� principal</a>" );
$p->body->DivClose( );


$res = $p->Render();
echo $res;




?>