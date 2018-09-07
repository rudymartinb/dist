-- Start a transaction.
BEGIN;

use distdev;

-- Plan the tests.
call tap.no_plan();

-- 1
set @codgru := "001";
set @desgru := "GRUPO 001";
set @abrgru := "GRP001";

call distdev.sp_ClientesGruposAlta(
@codgru,
@desgru,
@abrgru
 );
-- 1

-- parametros para el armado del comando sql
set @cantidad := 0;

-- parametros cliente de prueba
set @codcli := "999";
set @raz := "CLIENTE 999";
set @dom := "PIEDRAS";
set @loc := "OLAVARRIA";
set @cpo := "7400";
set @tel := "";
set @cel := "";
set @cat := "";
SET @ganancia := 60.0;
	
-- select tap.eq( "raz like '%SARASAXX%'", sf_buscar_todos_param( "", "raz", @raz ), "armado1");


call distdev.SP_ClientesAlta(
@codcli,
@raz,
@dom,
@tel,
@loc,
@cpo,
@ganancia,
"", @codgru
 );
 
 
select tap.eq( 1, @cantidad, "Cantidad Registros creados");

set @codcli := "999";
set @raz := "CLIENTE 999X";
set @dom := "PIEDRAS";
set @loc := "OLAVARRIA";
set @cpo := "7400";
set @tel := "";
set @cel := "";
set @cat := "";
SET @ganancia := 60.0;


call distdev.SP_ClientesModi(
@codcli,
@raz,
@dom,
@tel,
@loc,
@cpo,
@ganancia,
"", @codgru
 );
 

select tap.eq( @raz, (select razcli from clientes where codcli = @codcli), "Modificacion de Raz");


CALL tap.finish();
ROLLBACK;