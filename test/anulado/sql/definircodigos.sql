-- Start a transaction.
BEGIN;

use distdev;

-- Plan the tests.
call tap.no_plan();

call dev_crema();

-- agregar prefijo
set @pref := "0001";
set @des := "TALONARIO 1";

call distdev.sp_nrodoc1_agregar(
@pref,
@des
 );

select tap.eq( @result, true, "item talonario agregado"); 

-- agregar tipo documento
set @codtd := "51";
set @des := "REMITO";

call distdev.sp_tipdoc_agregar(
@codtd,
@des
 );

select tap.eq( @result, true, "item tipo comprobante agregado"); 

-- select tap.eq( (select count(*) from reporteentrega2), 1, "count reporteentrega2 = 1"); 
set @result := false;
set @DetalleError := "";

set @puesto := "001";

call distdev.sp_definirPrefijo( @puesto, @pref );
select tap.eq( @result, true, "@result");

call distdev.sp_definirRemito( @puesto, @codtd );

select tap.eq( @result, true, "@result"); 
select tap.eq( @DetalleError, "", "DetalleError"); 

set @xremito := "";
set @xprefijo := "";
call distdev.sp_leerRemito( @puesto );
select tap.eq( @xremito, @codtd, "leer remito"); 
call distdev.sp_leerPrefijo( @puesto );
select tap.eq( @xprefijo, @pref, "leer prefijo"); 



CALL tap.finish();
ROLLBACK;