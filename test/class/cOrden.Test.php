<?php
use mylib\mysql_query_mock;

require_once( "config.php" );
// include_once( $DIST.$CLASS."/cAlmanaque.php" );
// include_once( $DIST.$CLASS."/cOrden.php" );
require_once( $DIST.$CLASS."/cAgendaEntrega.php" );
require_once( $DIST.$LIB."/fechas.php" );

require_once( $DIST.$CLASS."/demo/cClientesDemo.php" );
// require_once( $DIST.$CLASS."/demo/cProductoDemo.php" );

error_reporting(E_ALL);


class testOrden extends PHPUnit\Framework\TestCase {
	
// 	public function testActualizarAgenda(){
// 		// $web->cli = "001";
// 		// $web->pro = "001";
// 		// $web->Leer();
		
		
		
		
		
// 	}
	public function testOK(){
	    $db = mysql_query_mock::Builder()->build();
		
		
		
		$c = new cClientesDemo();
		$c->db = $db;
		$this->assertEquals( true, $c->GrabarAlta(), "ClienteDemo GrabarAlta" );

		$pr = cProducto::Builder()->setDB( $db )->setDemo()->build();
		$pr->db = $db;
		$this->assertEquals( true, $pr->GrabarAlta(), "PrudctoDemo GrabarAlta" );
		
		/* 
		antes de hacer todo esto 
		me falta hacer tres cosas
		generar demo de cliente
		generar demo de producto
		*/
		
		$p = new cAgendaEntrega();
		$p->db = $db;
		
		$p->periodo = "201404";
		$p->cliente = "001";
		$p->producto = "001";
		
		$this->assertEquals( true, $p->Procesar(), "procesar" );
		$this->assertEquals( "2014", $p->ano ,  "2014" );
		$this->assertEquals( "04", $p->mes ,  "04" );
		$this->assertEquals( 30, $p->cantdias ,  "30 dias" );
		
		
		$this->assertEquals( true, $p->Agregar( "01-04-2014", 10,11 ), $p->DetalleError );
		$this->assertEquals( true, $p->Agregar( "02-04-2014", 20,12 ), $p->DetalleError );
		$this->assertEquals( true, $p->Agregar( "03-04-2014", 30,13 ), $p->DetalleError );
		$this->assertEquals( true, $p->Agregar( "04-04-2014", 40,14 ), $p->DetalleError );
		
		$this->assertEquals( 10, $p->Cantidad("01-04-2014") ,  "dia 01-04-2014" );
		$this->assertEquals( 20, $p->Cantidad("02-04-2014") ,  "dia 02-04-2014" );
		$this->assertEquals( 30, $p->Cantidad("03-04-2014") ,  "dia 03-04-2014" );
		$this->assertEquals( 40, $p->Cantidad("04-04-2014") ,  "dia 04-04-2014" );

		$this->assertEquals( 11, $p->Cantidad2("01-04-2014") ,  "dia 01-04-2014" );
		$this->assertEquals( 12, $p->Cantidad2("02-04-2014") ,  "dia 02-04-2014" );
		$this->assertEquals( 13, $p->Cantidad2("03-04-2014") ,  "dia 03-04-2014" );
		$this->assertEquals( 14, $p->Cantidad2("04-04-2014") ,  "dia 04-04-2014" );
		
		$this->assertEquals(  0, $p->Cantidad2("30-04-2014") ,  "dia 30-04-2014 = 0" );
		// var_dump( $p->dias );
		
		$p2 = new cAgendaEntrega();
		$p2->db = $db;
		
		$p2->periodo = "201404";
		$p2->cliente = "001";
		$p2->producto = "001";
		$this->assertEquals( true, $p2->Procesar(), "procesar" );
		$this->assertEquals( true, $p2->Leer(), "procesar" );

		$this->assertEquals( 10, $p2->Cantidad("01-04-2014") ,  "dia 01-04-2014" );
		$this->assertEquals( 20, $p2->Cantidad("02-04-2014") ,  "dia 02-04-2014" );
		$this->assertEquals( 30, $p2->Cantidad("03-04-2014") ,  "dia 03-04-2014" );
		$this->assertEquals( 40, $p2->Cantidad("04-04-2014") ,  "dia 04-04-2014" );
		
		$this->assertEquals(  0, $p2->Cantidad("30-04-2014") ,  "dia 30-04-2014 = 0" );
		
		$this->assertEquals(  0, $p2->Cantidad("30-04-2014") ,  "dia 30-04-2014 = 0" );
		
		$this->assertEquals(  "2014", $p2->ano ,  "dia 30-04-2014 = 0" );
		$this->assertEquals(  "04", $p2->mes ,  "dia 30-04-2014 = 0" );
		$this->assertEquals(  30, $p2->cantdias ,  "dia 30-04-2014 = 0" );
		$this->assertEquals(  "01-04-2014", $p2->dia1 ,  "dia 30-04-2014 = 0" );
		$this->assertEquals(  2, $p2->ini ,  "dia de semana dia 1" );
		$this->assertEquals(  "30-03-2014", $p2->diaX ,  "dia 30-04-2014 = 0" );
		$this->assertEquals(  5, $p2->cantsemanas ,  "cantidad semanas" );
		
		/*
		tengo cliente y producto
		tengo calculado los datos basicos para armar almanaque
		el paso logico siguiente seria armar codigo html
		
		*/
		
		
		/* 
		por logica habria q generar la lista de otros productos.
		aca se genera la orden de produccion del dia.
		*/
		
		
	
		$q = "rollback;";
		try {
			$res = $db->query( $q );
		} catch ( Exception $e ) {
			$error = $e->getMessage() ;
			echo  $error;
		}
		if( $res === FALSE ) {
			$error = "Error: ". $db->error ;
			echo  $error;
		}
		
	}


	
}
?>
