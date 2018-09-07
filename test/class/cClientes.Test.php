<?php

/*
include_once( "../ajax/ajaxCategoriaGrabarAlta.php" );

*/

require( "config.php" );
require_once( $DIST.$CLASS."/demo/cClientesDemo.php" );
require_once( $DIST.$CLASS."/demo/cClientesGruposDemo.php" );

require_once( $DIST."/src/db/mysqldb.php" );
require_once( $DIST."/src/db/ejecutarquery.php" );

//require_once( $DIST.$CLASS.$DEMO."/cFakeDB.php" );
require_once( $DIST."/../myphplib/db/mysql_wrapper.php" );

error_reporting(E_ALL);

class cClienteTest extends PHPUnit\Framework\TestCase {

	/*
	 * nota del 20171115
	 * 
	 * ejecutar query se agrego en estos dias
	 * 
	 * pero la idea es que use la clase mylib/mysql_wrapper
	 * 
	 * dado que hay codigo q depende de esto, se torna necesario armar otra clase
	 * 
	*/
	public function testOK(){

		$db = MySQLDB();          
		
		ejecutar_query( "start transaction;" );		

		$gru = new cClientesGruposDemo();
		$gru->db = $db;
		$this->assertTrue( $gru->GrabarAlta(), "GrabarAlta : ". $gru->DetalleError ) ;

		$cli = new cClientesDemo();
		$cli->db = $db;
		$cli->grupo = $gru->cod;
		$this->assertTrue( $cli->GrabarAlta() , "GrabarAlta : ". $cli->DetalleError ) ;
		$this->assertTrue( $cli->GrabarModi() , "GrabarAlta : ". $cli->DetalleError ) ;

		$cli2 = new cClientes();
		$cli2->db = $db;
		$cli2->cod = $cli->cod;
		$this->assertTrue( $cli2->Leer(), "Leer: ".$cli2->DetalleError ) ;
		
		$this->assertEquals( $cli2->raz , $cli->raz , "raz");
		$this->assertEquals( $cli2->dom , $cli->dom , "dom");
		$this->assertEquals( $cli2->cpo , $cli->cpo , "cpo");
		$this->assertEquals( $cli2->loc , $cli->loc , "loc");
		$this->assertEquals( $cli2->tel , $cli->tel , "tel");
		$this->assertEquals( $cli2->zona, $cli->zona, "zona");
		$this->assertTrue( $cli2->zona == "AA"  , "zona");
		$this->assertEquals( $cli2->gan , $cli->gan , "gan");
		
		ejecutar_query( "rollback;" );		

		
	
	}


	
}
?>