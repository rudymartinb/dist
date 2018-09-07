<?php
// SP_ClientesLeerLC

include_once( "config.php" );
include_once( $DIST.$LIB."/SQL.php" );
include_once( $DIST.$CLASS."/cProductos.php" );

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>

<head>
<title>EL POPULAR » Productos Consulta</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style>
#admtitulo{
	font-family:courier new;
	font-weight:bold;
	text-align:left;
	font-size:28px;
	color:black;
	padding:1px;
	border:5px;width:100%;
}

#admtitulo2{
	font-family:courier new;
	font-weight:bold;
	text-align:left;
	font-size:24px;
	color:black;
	padding:1px;
	border:5px;width:100%;
}

.admitem {
	font-family:courier new;
	font-weight:bold;
	text-align:left;
	font-size:18px;
	color:black;
	padding:1px;
	border:5px;width:100%;
}

</style>
<link href="css/base.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="http://ww.elpopular/js/jquery-1.9.0.js"></script>
<script type="text/javascript" >
$(document).ready(function(){

$("#codcli").focus();

});
</script>
</head>	
<body style='background-color:white;'>
<hr>
<div id="admtitulo">Productos Consulta</div>


<?php

$db = SQL_Conexion();
SF_Clientes_LeerLC( $db );

function SF_Clientes_LeerLC( $db ){
	$q = "call SP_ProductosLeerLC(); ";
	try{
		$res = $db->query( $q );
	} catch( Exception $e ) {
		return false;
	}
	if( $res === FALSE ) {
		return false;
	}
	echo "<table width=100%  >";
		echo "<tr>";
		echo "<td width=50>";
		echo "Cod";
		echo "</td>";
		echo "<td>";
		echo "Razón Social";
		echo "</td>";
		echo "<td>";
		echo "Domicilio";
		echo "</td>";
		echo "</tr>";
	while( $obj = $res->fetch_object() ){
		$cod = $obj->codpro ;
		$des = $obj->despro ;
		$abr = $obj->abrpro ;
		$gan = $obj->ganpro ;
		$ctl = $obj->ctlpro ;
		echo "<tr>";
		echo "<td>";
		echo "<a href='productos_cons2.php?cod=$cod'>";
		echo $cod;
		echo "</a>";
		echo "</td>";
		echo "<td>";
		echo $des;
		echo "</td>";
		echo "<td class='numero'>";
		echo $gan;
		echo "</td>";
		echo "</tr>";
	} 
	echo "</table>";
	$res->close();
	while( $db->more_results() ){
		$db->next_result();
	}
	return true;
}	


?>

<hr>
<div class="admitem"><a href='index.php'  >Volver al menú principal</a></div>
<hr>




</body>
</html>
