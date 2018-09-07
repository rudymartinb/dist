-- Start a transaction.
BEGIN;

use distdev;

-- Plan the tests.
call tap.no_plan();

call dev_crema();

-- simular cliente
set @codgru := "001";
set @desgru := "GRUPO 001";
set @abrgru := "GRP001";

call distdev.sp_ClientesGruposAlta(
@codgru,
@desgru,
@abrgru
 );

 -- parametros cliente de prueba
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


-- simular tipo de documento
set @codtd := "11";
set @des := "FACTURA A";

call distdev.sp_tipdoc_agregar(
@codtd,
@des
 );

select tap.eq( @result, true, "item agregado"); 


-- simular nro de documento actualizado
set @pref := "0001";
set @des := "TALONARIO 1";

call distdev.sp_nrodoc1_agregar(
@pref,
@des
 );

select tap.eq( @result, true, "item agregado"); 

set @pref := "0001";
set @codtd := "11";
set @nro := 123;
call distdev.sp_nrodoc2_actualizar(
@pref,
@codtd,
@nro
 );
select tap.eq( @result, true, "actualizar nrodoc2");


-- simular remito
set @fecha = "2014-09-01";
call distdev.sp_remito1_agregar(
	@codcli,
	@pref,
	@codtd,
	@fecha
);

select tap.eq( @DetalleError, "", "DetalleError remito 1"); 
select tap.eq( @result, true, "result remito"); 

select tap.eq( @idxrem > 0, true, "idx remito 1"); 
select tap.eq( (select nrorem1 from remitos1 where idx = @idxrem ), "0001-00000123", "nro remito"); 
select tap.eq( (select prox from nrodoc2 where codtd = @codtd and prefijo = @pref ), 124, "prox nro documento"); 

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

select tap.eq( @DetalleError, "", "DetalleError"); 
select tap.eq( @result, true, "@result "); 

select tap.eq( @nrorem , "0001-00000123", "@nrorem "); 

-- item remito

-- armar funcion que determine cuanto cobrarle a un cliente 
-- en funcion del precio del dia

select tap.eq( distdev.CalcularPrecio( 200,  60 ) , 120, "CalcularPrecio() "); 

-- en funcion de la fecha del remito suponemos que es la edicion.
-- determinar el precio que corresponde del producto
select tap.eq( distdev.DeterminarPrecioSegunDOW( 1,  "001" ) , 11, "DeterminarPrecioSegunDOW() "); 

select tap.eq( distdev. DeterminarPrecioClienteSegunFecha( @fecha,  @codcli, @codprod ) , 6, "DeterminarPrecioClienteSegunFecha() "); 

/* el precio lo tiene que sacar de la tabla de producto.
*/
set @cant := 50;
call sp_remito2_agregar( 
@idxrem,
@codprod,
@cant );

select tap.eq( @DetalleError, "", "sp_remito2_agregar DetalleError" ); 
select tap.eq( @result, true, concat( "@result [", @DetalleError, "]" )); 

set @xprecio := DeterminarPrecioClienteSegunFecha( @fecha,  @codcli, @codprod ) * @cant;
select tap.eq( @xprecio, (select bimrem1 from remitos1 where idx = @idxrem ), "bimrem1 " ); 

-- movimiento de cta cte cliente

call sp_clientes_ctacte_agregar( 
	@codcli,
	@fecha,
	@codtd,
	@nrorem,
	@xprecio, 
0 );
-- );

select tap.eq( @result, true, concat( "@result [", @DetalleError, "]" )); 

set @saldo := (select saldo from clientes_ctasctes_saldos where codcli =  @codcli );
select tap.eq( @saldo, @xprecio, "saldo cc"); 
-- 1
-- 1

CALL tap.finish();
ROLLBACK;