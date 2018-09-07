-- Start a transaction.
BEGIN;

use dist;

-- Plan the tests.
call tap.no_plan();

call dev_crema();
-- generar producto
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


CALL tap.finish();
ROLLBACK;