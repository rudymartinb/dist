<?php
error_reporting(E_ALL);

use mylib\mysql_query_mock;

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

	public function test_cliente_agregar(){
		
	    $db = mylib\mysql_query_mock::Builder()->build();
		

		$cli = new cClientesDemo();
		$cli->db = $db;
		
		$query = "call SP_ClientesAlta( '997','SARASA','PIEDRAS','00','OLAVARRIA','7400', 50  ,'AA' ,'997' );";
		$db->esperar( $query, function() { $this->assertTrue(true); } );
		
		// $cli->grupo = $gru->cod;
		$cli->GrabarAlta();
		
		//~ $this->assertTrue(  , "GrabarAlta : ". $cli->DetalleError ) ;
		//~ $this->assertTrue( $cli->GrabarModi() , "GrabarAlta : ". $cli->DetalleError ) ;

		//~ $cli2 = new cClientes();
		//~ $cli2->db = $db;
		//~ $cli2->cod = $cli->cod;
		//~ $this->assertTrue( $cli2->Leer(), "Leer: ".$cli2->DetalleError ) ;
		
		//~ $this->assertEquals( $cli2->raz , $cli->raz , "raz");
		//~ $this->assertEquals( $cli2->dom , $cli->dom , "dom");
		//~ $this->assertEquals( $cli2->cpo , $cli->cpo , "cpo");
		//~ $this->assertEquals( $cli2->loc , $cli->loc , "loc");
		//~ $this->assertEquals( $cli2->tel , $cli->tel , "tel");
		//~ $this->assertEquals( $cli2->zona, $cli->zona, "zona");
		//~ $this->assertTrue( $cli2->zona == "AA"  , "zona");
		//~ $this->assertEquals( $cli2->gan , $cli->gan , "gan");
		
		//~ ejecutar_query( "rollback;" );		

		
	
	}
	
		
	public function test_cliente_modi(){
		
	    $db = mylib\mysql_query_mock::Builder()->build();
		
		$cli = new cClientesDemo();
		$cli->db = $db;
		
		$query = "call SP_ClientesModi( '997','SARASA','PIEDRAS','00','OLAVARRIA','7400', 50 ,'AA' ,'997' );";

		$db->esperar( $query, function() { $this->assertTrue( true ); } );
		
		// $cli->grupo = $gru->cod;
		$cli->GrabarModi();
	}

	public function test_cliente_leer(){
		
	    $db = mylib\mysql_query_mock::Builder()->build();
		
		$cli = new cClientesDemo();
		$cli->db = $db;
		
		// codcli, razcli, domcli, loccli, cpocli, telcli, gancli, zona, grucli, md5cli
		$devolver = [];
		$devolver[0]["codcli"] = "997";
		$devolver[0]["razcli"] = "SARASA!";
		$devolver[0]["domcli"] = "";
		$devolver[0]["loccli"] = "";
		$devolver[0]["cpocli"] = "";
		$devolver[0]["telcli"] = "";
		$devolver[0]["gancli"] = "";
		$devolver[0]["zona"] = "";
		$devolver[0]["grucli"] = "";
		$devolver[0]["md5cli"] = "";
		
		$query = "call SP_ClientesLeer( '997' ); ";

		$db->esperar( $query, function() use($devolver) { 
		    return $devolver;  
		} );
		
		// $cli->grupo = $gru->cod;
		$cli->Leer();
		
		$this->assertEquals( "SARASA!", $cli->get_raz() );
	}

	
}
?>