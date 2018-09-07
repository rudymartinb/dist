<?php
require( "config.php" );
require_once( $DIST.$AJAX."/ajaxAlmanaqueDiaModi.php" );

class ajaxAbrirPakTest extends PHPUnit\Framework\TestCase {
	public function testPacket1(){
		$periodo = "201406";
		$cli = "001";
		$prod = "001";
		$tipo = "t1";
		$dia = "01";
		$cant = "000003";
		
		$pak = 		"201406001001t1s01000003";
		$esperado = "201406001001t1s01000003";
		
		$this->assertEquals( $esperado, $pak , "ajaxDiaModi" );
		
		$post = [];
		$post['href']=$pak;
				
		$arr = ajaxAbrirPak( $post );
		$esperado = $tipo;
		$this->assertEquals( $esperado, $arr['tipo'] , "ajaxAbrirPak TIPO" );

		$esperado = $periodo;
		$this->assertEquals( $esperado, $arr['periodo'] , "ajaxAbrirPak periodo" );

		$esperado = $cli;
		$this->assertEquals( $esperado, $arr['cli'] , "ajaxAbrirPak cli" );

		$esperado = $prod;
		$this->assertEquals( $esperado, $arr['prod'] , "ajaxAbrirPak prod" );

		$esperado = $cant;
		$this->assertEquals( $esperado, $arr['cant'] , "ajaxAbrirPak cant" );

		$esperado = $dia;
		$this->assertEquals( $esperado, $arr['dia'] , "ajaxAbrirPak dia" );
		
	}
}
?>
