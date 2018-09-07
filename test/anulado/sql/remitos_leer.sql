-- Start a transaction.
BEGIN;

use distdev;

-- Plan the tests.
call tap.no_plan();
use distdev;

call sp_remitos_leer( "2014-09-01" );

-- select tap.eq( @result, false, "@result "); 
-- select tap.eq( @DetalleError, false, "@DetalleError "); 

CALL tap.finish();
ROLLBACK;