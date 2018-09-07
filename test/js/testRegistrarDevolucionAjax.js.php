<?php
// include_once( "config.php" );
include_once( "testBaseJS.php" );
// include_once( $DIST.$LIB."/testBaseJS.php" );
$arr = [];
$arr[] = "/test/js/testRegistrarDevolucionAjax.js";
$arr[] = "/js/RegistrarDevolucionAjax.js.php";
$arr[] = "/js/MandarAjax.js.php";
GenerarWebTestParaJS( $arr );
?>
