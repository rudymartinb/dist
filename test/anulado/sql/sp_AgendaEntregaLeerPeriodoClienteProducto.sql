BEGIN;

use distdev;

-- Plan the tests.
call tap.no_plan();

-- 1


call distdev.sp_AgendaEntregaLeerPeriodoClienteProducto(
"001",
"001",
"201406"
 );
 
 select tap.eq( @result, true, "resultado");

CALL tap.finish();
ROLLBACK;