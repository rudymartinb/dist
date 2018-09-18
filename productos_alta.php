<?php

require_once( "config.php" );

require_once( $DIST.$CLASS."/cProducto.php" );
require_once( $DIST.$LIB."/PadN.php" );
require_once( $DIST."/src/infrastructure/sql.php" );

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <head>
    	<title>EL POPULAR - Productos Altas</title>
    	<meta http-equiv="Content-Type" content="text/html; charset='utf-8'">
    		<link href="css/producto_alta.css" rel="stylesheet" type="text/css" />
    	<link href="css/base.css" rel="stylesheet" type="text/css" />
    	<script type="text/javascript" src="http://ww.elpopular/js/jquery-1.9.0.js"></script>
    	<script type="text/javascript" >
            $(document).ready(function(){
            	$("#cod").focus();
            });
        </script>
    </head>	
	<body style='background-color:white;'>
        <hr>
        <div id="admtitulo">Productos Altas</div>

<?php
if( isset( $_POST ) ){
	if( count( $_POST ) >0  ){
		$post = $_POST;
		$db = new mylib\mysql_wrapper();
		
		$servidor = new DemoServidorSQL();
		$usuario = new DemoUsuarioSQL();
		$db->abrir( $usuario, $servidor );
		
		// $db = SQL_Conexion();
		$cod = $_POST['cod'];
		$des = $_POST['des'];
		$abr = $_POST['abr'];
		if( isset($_POST['ctl']) )
            $ctl = $_POST['ctl'];
        else
            $ctl = false;
      
		
		$o = cProducto::Builder()
    		->setDB($db )
    		->setCod( $cod )
    		->setDes( $des )
    		->setAbr( $abr )
    		->setCtrl( $ctl )
    		->build();

    	$o->GrabarAlta();
		echo "<hr>Datos grabados: ".$cod." : ".$des;

	}
}

?>
        <hr>
        <div class="admitem"><a href='index.php'  >Volver al menú principal</a></div>
        
        <hr>
        <form action="productos_alta.php" method="post">
        
        	<div class="admitem">Código:</div>
        	<input class="adminput" type=text value="" id="cod" name="cod" maxlength=3 >
        	<div class="admmensa">Escriba el código de tres dígitos a utilizar</div>
        	
        	<div class="admitem">Descripción:</div>
        	<input class="adminput" type=text value="" id="des" name="des" maxlength=100 >
        	<div class="admmensa">Escriba la descripciín correspondiente</div>
        	<hr>
        
        	<div class="admitem">Abreviatura:</div>
        	<input class="adminput" type=text value="" id="abr" name="abr" maxlength=15 >
        	<div class="admmensa">Escriba la abreviatura</div>
        	<hr>
        	<div class="admitem">Control Papel:</div>
        	<input class="adminput" type="checkbox" value="" id="ctl" name="ctl">
        	<div class="admmensa">Active la casilla para habilitar</div>
        	<hr>
        	<input class="adminput" type="submit" value="Agregar" id="OK">
        </form>
        <hr>
        <div class="admitem"><a href='index.php'  >Volver al menú principal</a></div>
        <hr>
    
    </body>
</html>