-- Start a transaction.
BEGIN;

use distdev;

-- Plan the tests.
call tap.no_plan();

call dev_crema();


-- generar producto
-- teoricamente debemos cargar item remito tipo producto
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

-- agregar prefijo
set @pref := "0001";
set @des := "TALONARIO 1";

call distdev.sp_nrodoc1_agregar(
@pref,
@des
 );

select tap.eq( @result, true, "item talonario agregado"); 

-- agregar tipo documento
set @codtd := "11";
set @des := "FACTURA A";

call distdev.sp_tipdoc_agregar(
@codtd,
@des
 );

select tap.eq( @result, true, "item tipo comprobante agregado"); 

set @pref := "0001";
set @codtd := "11";
set @nro := 123;
call distdev.sp_nrodoc2_actualizar(
@pref,
@codtd,
@nro
 );
select tap.eq( @result, true, "actualizar nrodoc2");


-- agregar cliente
set @codgru := "001";
set @desgru := "GRUPO 001";
set @abrgru := "GRP001";

call distdev.sp_ClientesGruposAlta(
@codgru,
@desgru,
@abrgru
 );

-- cliente de prueba
set @codcli := "999";
set @raz := "CLIENTE 999";
set @dom := "PIEDRAS";
set @loc := "OLAVARRIA";
set @cpo := "7400";
set @tel := "";
set @cel := "";
set @cat := "";
SET @ganancia := 50.0;

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
 
select tap.eq( @result, true, "Cantidad Registros creados");

-- ///////////////////////////////////////
-- ///////////////////////////////////////
-- ///////////////////////////////////////

-- generar cabecera reporte
set @fecha := now();
-- set @codprod := "001" ;
set @obs := "";
call sp_ReporteEntregaAlta( @fecha, @codprod, @obs );

select tap.eq( @result, true, concat( "@result [", @DetalleError, "]" )); 
select tap.eq( @idxrep > 0, true, "idx rep"); 

select tap.eq( (select count(*) from reporteentrega2), 0, "count repoentrega2 = 0"); 
select tap.eq( (select count(*) from remitos1), 0, "count remitos1 = 0"); 

-- antes de llegar aca me falta definir PREFIJO
set @puesto := "001";
call sp_DefinirRemito( @puesto, @codtd  );
call sp_DefinirPrefijo( @puesto, @pref  );
-- agregar item entrega
call sp_ReporteEntregaClienteAlta( @idxrep, @codcli, 100, 5 );

select tap.eq( @result, true, "@result"); 
select tap.eq( @DetalleError, "", "DetalleError"); 

select tap.eq( (select count(*) from reporteentrega2), 1, "count reporteentrega2 = 1"); 
select tap.eq( (select count(*) from remitos1		), 1, "count remitos1 = 1"); 
select tap.eq( (select count(*) from remitos2		), 1, "count remitos2 = 1"); 


CALL tap.finish();
ROLLBACK;