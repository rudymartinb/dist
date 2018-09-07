-- Start a transaction.
BEGIN;

use lib;

-- Plan the tests.
call tap.no_plan();

select tap.eq( PadN( 1, 3), "001", "padn 1"); 
select tap.eq( PadN( 123, 4), "0123", "padn 0123"); 
select tap.eq( PadN( 123, 3), "123", "padn 123"); 


CALL tap.finish();
ROLLBACK;