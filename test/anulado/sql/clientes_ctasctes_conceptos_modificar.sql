-- Start a transaction.
BEGIN;

use distdev;

-- Plan the tests.
call tap.no_plan();

-- 1
set @codcon := "011";
set @descon := "FACTURA A";


call distdev.sp_clientes_ctasctes_conceptos_agregar(
@codcon,
@descon
 );

select tap.eq( @result, true, "concepto agregado"); 
-- 1

call distdev.sp_clientes_ctasctes_conceptos_modificar(
@codcon,
@descon
 );

select tap.eq( @result, true, "concepto modificado"); 

call distdev.sp_clientes_ctasctes_conceptos_modificar(
"XXX",
@descon
 );

select tap.eq( @result, false, "concepto modificado"); 


CALL tap.finish();
ROLLBACK;