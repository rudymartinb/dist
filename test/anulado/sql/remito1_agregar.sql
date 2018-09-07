-- Start a transaction.
BEGIN;

use distdev;

-- Plan the tests.
call tap.no_plan();

call dev_crema();


select tap.eq( true, (select count(*) from remitos2) = 0, "remitos2" );

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
 
select tap.eq( @result, true, "result");

-- agregar prefijo
set @pref := "0001";
set @des := "TALONARIO 1";

call distdev.sp_nrodoc1_agregar(
@pref,
@des
 );

select tap.eq( @result, true, "result"); 

-- agregar tipo documento
set @codtd := "51";
set @des := "REMITO";

call distdev.sp_tipdoc_agregar(
@codtd,
@des
 );

 call sp_nrodoc2_actualizar(
@pref ,
@codtd,
123 );

select tap.eq( @result, true, "item agregado"); 
 
call sp_remito1_agregar( @codcli, @pref, @codtd, "2014-09-01" );

select tap.eq( @result, true, concat( "result: ", @DetalleError ) );
select tap.eq( @idxrem > 0, true, "idxrem" );
select tap.eq( "0001-00000123", (select nrorem1 from remitos1 ), "remito agregado"); 

-- probamos agregar item
-- vamos a necesitar producto
set @codprod := "001";
set @desprod := "PROD 001";
set @abrprod := "PROD 001";
set @dia1 := true;
set @dia2 := true;
set @dia3 := true;
set @dia4 := true;
set @dia5 := true;
set @dia6 := true;
set @dia7 := true;


call SP_ProductoAlta(
@codprod,
@desprod,
@abrprod,
@dia1,
@dia2,
@dia3,
@dia4,
@dia5,
@dia6,
@dia7,
10,
11,
12,
13,
14,
15,
16,
17,
true,
true
);

select tap.eq( @DetalleError, "", "DetalleError"); 
select tap.eq( @result, true, "@result "); 

call sp_remito2_agregar( @idxrem, @codprod, 100 );

select tap.eq( @DetalleError, "", "DetalleError"); 
select tap.eq( @result, true, "@result "); 

select tap.eq( true, (select count(*) from remitos2) > 0, "remitos2" );

CALL tap.finish();
ROLLBACK;