-- Start a transaction.
BEGIN;

use distdev;

-- Plan the tests.
call tap.no_plan();

-- set @nada := 1;

call test.sarasa1();
select tap.eq( row_count(), 0, "rowcount sarasa1 ");

select tap.eq( @cantfilas, 1, "Cantidad Registros rowcount sarasa1");
select tap.eq( last_insert_id() > 0, true, "last_insert_id");
select last_insert_id() ;

-- call test.dummy();

-- select tap.eq( row_count(), 0, "Cantidad Registros rowcount call test dummy");


CALL tap.finish();
ROLLBACK;