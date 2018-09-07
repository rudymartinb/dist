-- sp_ReporteProduccionEliminar
BEGIN;

use distdev;

-- Plan the tests.
call tap.no_plan();

call sp_ReporteProduccionEliminar( 0 );

select tap.eq( true, true, "sp_ReporteProduccionEliminar");


CALL tap.finish();

rollback;