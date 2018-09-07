test( "PadN", function() {

	
	esperado = "001";
	resultado = PadN( 1, 3 );
	strictEqual( resultado, esperado, "001" );

	esperado = "012345";
	resultado = PadN( 12345, 6 );
	strictEqual( resultado, esperado, "012345" );

	esperado = "012345";
	resultado = PadN( "12345", 6 );
	strictEqual( resultado, esperado, "012345" );	

	esperado = "012345";
	resultado = PadN( "12345", "6" );
	strictEqual( resultado, esperado, "012345" );	
	
	// ok( true , "CalcularAltoRenglon" );
	

});
