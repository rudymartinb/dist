<?php
include_once( "config.php" );
include_once( $DIST.$LIB."/cHTML.php" );

error_reporting(E_ALL);
$p = new cHTML();

$p->head->titulo = "";
$p->head->AddMeta( "http-equiv='Content-Type' content='text/html; charset=iso-8859-1'"  );
$p->head->AddCSS( "/css/base.css" );
$p->head->AddCSS( "/resources/qunit-1.13.0.css" );
$p->head->AddJS( "http://ww.elpopular/js/jquery-1.9.0.js" );

$p->body->AddJS( "/resources/qunit-1.13.0.js" );
$p->body->AddJS( "/js/PadN.js" );
$p->body->AddJS( "/test/js/testPadN.js" );

$p->body->AddJS( "/test/js/testAjaxAgendaModi.js" );


$p->body->AddDiv( "qunit", ""  );
$p->body->AddDiv( "qunit-fixture", ""  );
$p->body->AddDiv( "divtest", ""  );
$res = $p->Render();
echo $res;
?>
