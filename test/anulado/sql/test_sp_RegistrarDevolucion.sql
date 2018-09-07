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


-- agregar item entrega
call sp_RegistrarDevolucion( now(), @codcli, @codprod, 13  );

select tap.eq( @result, true, "@result"); 
select tap.eq( @DetalleError, "", "DetalleError"); 

select tap.eq( (select count(*) from devoluciones), 1, "count devoluciones = 1"); 
select tap.eq( (select candev from devoluciones ), 13, "count devoluciones = 1"); 
-- select tap.eq( (select count(*) from remitos1		), 1, "count remitos1 = 1"); 
-- select tap.eq( (select count(*) from remitos2		), 1, "count remitos2 = 1"); 


CALL tap.finish();
ROLLBACK;