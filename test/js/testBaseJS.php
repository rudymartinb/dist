<?php
/* la idea de este codigo 
es me permita definir uno o varios JS 
y genere la web para correr el phantom
desde la consolta de linux.
*/
include_once( "config.php" );
include_once( $DIST.$LIB."/cHTML.php" );

error_reporting(E_ALL);
function GenerarWebTestParaJS( $js ){
	$p = new cHTML();

	
	$p->head->AddMeta( "http-equiv='Content-Type' content='text/html; charset=iso-8859-1'"  );
	$p->head->AddCSS( "/css/base.css" );
	$p->head->AddCSS( "/resources/qunit-1.13.0.css" );
	$p->head->AddJS( "http://ww.elpopular/js/jquery-1.9.0.js" );

	$p->body->AddJS( "/resources/qunit-1.13.0.js" );
	$p->body->AddJS( "/js/PadN.js" );
	// $p->body->AddJS( "/test/js/testPadN.js" );
	$tipo = gettype( $js );
	switch( $tipo ){
		case "string": {
			$p->head->titulo = $js;
			$p->body->AddJS( $js );
			break;
		}
		case "array":{
			foreach( $js as $key => $value ){
				if( $p->head->titulo === "" ){
					$p->head->titulo = $value;
				}
				$p->body->AddJS( $value );
			}
			// completar
		}
	}
	$p->body->AddDiv( "qunit", ""  );
	$p->body->AddDiv( "qunit-fixture", ""  );
	$p->body->AddDiv( "divtest", ""  );
	$res = $p->Render();
	// eliminar echo y poner return
	echo $res;
}

?>
