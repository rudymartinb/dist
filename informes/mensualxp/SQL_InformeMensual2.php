<?php
/* Informe Mensual 2 (el total de circulacion neta por periodo)
*/
function SQL_InformeMensual2( $db, $perini, $perfin ){
   if( ! ValidarPeriodo( $perini ) ) 
      return null;
   
   if( ! ValidarPeriodo( $perfin ) )
      return null;
   
   $q = "call sp_InformeMensualxP( '".$perini."' , '".$perfin."' );";

   $res = $db->query( $q );
   if( $res === true ){
      return [];
   }
   if($res) {
      $lista = [];
      while( $obj = $res->fetch_assoc() ){
         $lista[] = $obj ;
      }
      $res->close();
   }
   return $lista;   
}

?>