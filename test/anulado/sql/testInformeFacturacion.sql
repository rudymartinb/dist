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

-- agregar cliente
set @codgru := "999";
set @desgru := "GRUPO 999";
set @abrgru := "GRP999";

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
SET @ganancia := 70.0;

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

set @fecha := "2012-01-01";
 
call sp_CambioPrecio( @codprod, @fecha, 11,12,13,14,15,16,17 );
 
-- select tap.eq( @result, true, "Cantidad Registros creados");

call sp_AgendaActualizarCant1( @codcli, @codprod, @fecha, 1000 );
call sp_AgendaActualizarCant2( @codcli, @codprod, @fecha, 50 );

select tap.eq( (select count(*) from agenda), 1, "count agenda = 1"); 

set @fecha := "2012-01-10";
call sp_AgendaActualizarCant1( @codcli, @codprod, @fecha, 1001 );
call sp_AgendaActualizarCant2( @codcli, @codprod, @fecha, 51 );

select tap.eq( (select count(*) from agenda), 2, "count agenda = 1"); 

set @fecha := "2012-01-01";
select tap.eq( (select PrecioSegunFecha(@codprod,@fecha) ), 17, " PrecioSegunFecha"); 



/*
el informe tiene que ser
por producto
por cliente
detalle fecha - cantidades - precio tapa - total a facturar
*/


CALL tap.finish();
ROLLBACK;
