<?php
/* 
todas las clases de php
deberian derivar de esta clase
*/
class cBasica {
	public function __set($name, $value){
		 throw new Exception("Variable no definida: ".$name."=".$value);
	}
}
?>