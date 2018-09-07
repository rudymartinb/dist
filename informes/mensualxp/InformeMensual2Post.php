<?php

function InformeMensual2ValidarPost( $post ){
   if( $post == null )
      return false;
   if( count( $post ) != 2 ){
      return false;
   }
   if( !isset( $post['perini'] ) ) return false;
   if( !isset( $post['perfin'] ) ) return false;
      
   return true;
}
function InformeMensual2Post( $db, $post ) {
   $perini = $post['perini'] ;
   $perfin = $post['perfin'] ;
   return SQL_InformeMensual2( $db, $perini, $perfin );
 
}
?>