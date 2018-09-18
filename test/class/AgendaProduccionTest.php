<?php
use mylib\mysql_query_mock;

// require( "config.php" );
// include_once( $DIST.$CLASS."/cAlmanaque.php" );
require_once( $DIST.$CLASS."/cOrden.php" );
require_once( $DIST.$CLASS."/cAgendaEntrega.php" );
require_once( $DIST.$LIB."/fechas.php" );

require_once( $DIST.$CLASS."/demo/cClientesDemo.php" );
require_once( $DIST.$CLASS."/demo/cClientesGruposDemo.php" );
require_once( $DIST.$CLASS."/demo/cProductoDemo.php" );

error_reporting( E_ALL );
 
class AgendaProduccionTest extends PHPUnit\Framework\TestCase {
	public function testAgenda(){ 
	    
	    $db = mysql_query_mock::Builder()->build();
	    
	    
		// $db = SQL_Conexion();
		
		$gru = new cClientesGruposDemo();
		$gru->db = $db;
		$gru->GrabarAlta();
		$this->assertTrue( $gru->GrabarAlta() == 1 , "GrabarAlta : ". $gru->DetalleError ) ;
				
		$cli = new cClientesDemo();
		$cli->db = $db;
		$cli->gru = $gru->cod;
		$this->assertEquals(true, $cli->GrabarAlta() ,"Cli GrabarAlta".$cli->DetalleError );

		$pro = cProducto::Builder()->setDB( $db )->setDemo()->build();
		// $pro = new cProductoDemo();
		$pro->db = $db;
		$this->assertEquals(true, $pro->GrabarAlta() ,"pro GrabarAlta" );

		$pro1 = cProducto::Builder()->setDB( $db )->setDemo()->build();
		$pro1->db = $db;
		$pro1->cod = "990";
		$this->assertEquals(true, $pro1->GrabarAlta() ,"pro GrabarAlta" );

		$pro2 = cProducto::Builder()->setDB( $db )->setDemo()->build();
		$pro2->db = $db;
		$pro2->cod = "991";
		$this->assertEquals(true, $pro2->GrabarAlta() ,"pro GrabarAlta" );

		/* 
		tengo cliente,
		tengo producto
		tengo periodo
		*/
		$periodo = "201405";
		
		$agenda = new cAgendaEntrega();
		$agenda->periodo = $periodo;
		$agenda->cliente = $cli->cod;
		$agenda->producto = $pro->cod;
		$this->assertEquals(true,  $agenda->procesar(), "Procesar Agenda" );
		
		

		
		
	
	}
}
?>