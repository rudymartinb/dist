-- Start a transaction.
BEGIN;

use distdev;

-- Plan the tests.
call tap.no_plan();

call dev_crema();

set @pref := "0001";
set @des := "TALONARIO 1";

call distdev.sp_nrodoc1_agregar(
@pref,
@des
 );
 
select tap.eq( @result, true, "prefijo agregado"); 
select tap.eq( (select prefijo from nrodoc1 where prefijo = @pref) = @pref, true, "prefijo agregado"); 

set @

call distdev.sp_tipdoc_alta(
@codtd,
@destd
 );




CALL tap.finish();
ROLLBACK;