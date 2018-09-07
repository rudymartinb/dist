test( "Ajax Test Agenda", function() {
	/* 
	la idea es que con cada enter se mande un ajax
	que tenga toda la info propia.
	el pak estara previamenete armado por el php 
	excepto por la parte de la cantidad q sera
	procesada en vuelo
	*/
	var pak ;
	var cant = 10;
	pak = "t1201405001001";
	pak = pak + PadN( cant, 6 );
	
	esperado = "t1201405001001000010";
	resultado = pak;
	strictEqual( resultado, esperado, "pak t1201405001001000010" );	
	
	
	


});