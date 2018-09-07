/* 11:49 19/06/2014
falta crear un producto y desacoplar con codigos existentes

*/

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
 
-- select tap.eq( "raz like '%SARASAXX%'", sf_buscar_todos_param( "", "raz", @raz ), "armado1");

set @codpro := "001";
set @fec := "2014-05-01";
set @cant := 11;
call distdev.sp_AgendaActualizarCant1(
@codcli,
@codpro,
@fec,
@cant);

select tap.eq( @result, true, "resultado");

set @tmp := (
select cant1 from agenda
where
cliage = @codcli and
proage = @codpro and
fecage = @fec
);

select tap.eq( @cant, @tmp, "resultado");



/* test tiene q fallar
*/
set @codcli := "666";
set @codpro := "666";
set @fec := "2014-05-01";
set @cant := 11;
call distdev.sp_AgendaActualizarCant1(
@codcli,
@codpro,
@fec,
@cant);

select tap.eq( @result, false, "resultado");

/* test tiene q fallar
*/
set @codcli := "001";
set @codpro := "666";
set @fec := "2014-05-01";
set @cant := 11;
call distdev.sp_AgendaActualizarCant1(
@codcli,
@codpro,
@fec,
@cant);

select tap.eq( @result, false, "resultado");


CALL tap.finish();
ROLLBACK;