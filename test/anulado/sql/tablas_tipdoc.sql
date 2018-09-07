-- Start a transaction.
BEGIN;

use distdev;

-- Plan the tests.
call tap.no_plan();

-- 1
set @cod := "11";
set @des := "FACTURA A";


call distdev.sp_tipdoc_agregar(
@cod,
@des
 );

select tap.eq( @result, true, "item agregado"); 
-- 1

call distdev.sp_tipdoc_agregar(
@cod,
@des
 );
 
select tap.eq( @result, false, "item agregado dos veces"); 


CALL tap.finish();
ROLLBACK;