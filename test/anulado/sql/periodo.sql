-- Start a transaction.
BEGIN;

use distdev;

-- Plan the tests.
call tap.no_plan();

-- 1
set @periodo := "201502";
set @fecini := "2015-02-01";
set @fecfin := "2015-02-28";

set @result := Periodo2FecIni( @periodo );
select tap.eq( @result, @fecini, "Fecha Inicial");
set @result := Periodo2FecFin( @periodo );
select tap.eq( @result, @fecfin, "Fecha Final");

CALL tap.finish();
ROLLBACK;