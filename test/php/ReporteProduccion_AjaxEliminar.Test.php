<?php
// testReporteProduccion_AjaxEliminar.php

require( "config.php" );
require_once( $DIST.$LIB."/SQL.php" );
require_once( $DIST.$LIB."/fechas.php" );
require_once( $DIST."/produccion/Ajax_EliminarReporte.php" );

error_reporting(E_ALL);

class ReporteProduccion_AjaxEliminar_Test extends PHPUnit\Framework\TestCase {
	/* pruebas que pueden fallar por cuanto dependen de un SQL
	** con catalogo y tablas
	*/
	public function testValidarPost(){
		$post = [];
		$post['nro'] = 1;
		$this->assertEquals( true, ajax_EliminarReporteProduccion_ValidarPost( $post )   );
	}
	public function testReal(){
		$db = SQL_Conexion_Demo();
		$q = "start transaction;";
		try {
			$res = $db->query( $q );
		} catch ( Exception $e ) {
			$error = $e->getMessage() ;
			echo  $error;
			return;
		}
		$post = [];
		$post['nro'] = 0;
		// en realidad no borra nada
		// pero quiero que se ejecute el comando contra el mysql
		$this->assertEquals( true, ajax_EliminarReporteProduccion( $db, $post )   );
		$this->assertEquals( true, ajax_EliminarReporteProduccion( $db, $post )   );
		$q = "rollback;";
		try {
			$res = $db->query( $q );
		} catch ( Exception $e ) {
			$error = $e->getMessage() ;
			echo  $error;
			return;
		}
	}
	
	//~ public function testEjecutarAjax(){
		//~ $db = $this->getMock('mysqli');
		//~ /*
		//~ */
		//~ $db->expects(
			//~ $this->at(0)
		//~ )
		//~ ->method('query')
		//~ ->will($this->returnValue(true));

		
		//~ $post = [];
		//~ $post['nro'] = 1;
		//~ $this->assertEquals( true, ajax_EliminarReporteProduccion( $db, $post )   );

		//~ // $l = [];
		//~ // $arr=[];
		//~ // $arr['codcli'] = "001";
		//~ // $arr['razcli'] = "CLIENTE 001";
		//~ // $l[] = $arr;
		
		//~ // $arr=[];
		//~ // $arr['codcli'] = "002";
		//~ // $arr['razcli'] = "CLIENTE 002";
		//~ // $l[] = $arr;
		
		//~ // mysqli_result
		//~ // $res = $this->getMockBuilder('mysqli_result')
			 //~ // ->disableOriginalConstructor()
			 //~ // ->getMock();
			 
		//~ // $res->expects($this->at(0))
		//~ // ->method('fetch_assoc')
		//~ // ->will($this->returnValue($l[0]));

		//~ // $res->expects($this->at(1))
		//~ // ->method('fetch_assoc')
		//~ // ->will($this->returnValue($l[1]));		

		//~ // $db->expects($this->at(0))
		//~ // ->method('more_results')
		//~ // ->will($this->returnValue(true));

		//~ // $db->expects($this->at(1))
		//~ // ->method('more_results')
		//~ // ->will($this->returnValue(true));
		//~ // $db->expects($this->at(2))
		//~ // ->method('more_results')
		//~ // ->will($this->returnValue(false));

		//~ // $db->expects($this->at(0))
		//~ // ->method('query')
		//~ // ->will($this->returnValue($res));
		
		//~ // call sp_ReporteEntregaAlta
		//~ // $db->expects($this->at(1))
		//~ // ->method('query')
		//~ // ->will($this->returnValue($res));

		
		//~ /* 
		//~ tomar la lista de clientes
		//~ y generar el form
		//~ $rec = new cReporteEntregaClientes();
		//~ $rec->db = $db;
		//~ $lista = $rec->ObtenerListaClientes();
		//~ $this->assertEquals( "array", gettype( $lista ) );
		
		//~ $this->assertEquals( 2, count( $lista ), "cant items devueltos" );
		//~ $this->assertEquals( "001", $lista[0]['codcli'], "cant items devueltos" );
		//~ $this->assertEquals( "002", $lista[1]['codcli'], "cant items devueltos" );

		//~ $this->assertEquals( '<input type=hidden value="001" id="CLI001" name="CLI001" >', 
		//~ $rec->GenerarHidden( $lista[0]['codcli'], "CLI001" )  );
		
		//~ $this->assertEquals( '<input class="adminput1 floatLeft " type=text value="" id="CCC001" name="CCC001" maxlength="10" style="width:50px;">', 
		//~ $rec->GenerarInput( $lista[1]['razcli'], "CCC001", "", 10, "", "" )  );

		//~ $this->assertEquals( '<input class="adminput1 floatLeft " type=text value="" id="CSC001" name="CSC001" maxlength="10" style="width:50px;">', 
		//~ $rec->GenerarInput( $lista[1]['razcli'], "CSC001", "", 10, "", "" )  );		

		//~ $this->assertEquals( '<div class="tituloInput floatLeft size400">CLIENTE 001:</div>', 
		//~ $rec->GenerarTitulo( $lista[0]['razcli'] )  );		
		//~ */
		
	//~ }
	
}
?>
