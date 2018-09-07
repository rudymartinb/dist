BEGIN;

use distdev;
call dev_crema;
-- Plan the tests.
call tap.no_plan();

-- 1
set @codgru := "001";
set @desgru := "GRUPO 001";
set @abrgru := "GRP001";

call distdev.sp_ClientesGruposAlta(
@codgru,
@desgru,
@abrgru
 );
 
select tap.eq( @result, true, "resultado SP");

set @tmp := (
select codgru from clientes_grupos where
codgru = @codgru );

select tap.eq( @tmp, @codgru, "resultado SELECT");

set @desgru := "GRUPO 001X";
set @abrgru := "GRP001X";

-- ALTA FALLA

call distdev.sp_ClientesGruposAlta(
@codgru,
@desgru,
@abrgru
 );
 
select tap.eq( @result, false, "resultado SP FALLA");


-- PARTE MODIFICACION
call distdev.sp_ClientesGruposModi(
@codgru,
@desgru,
@abrgru
 );

select tap.eq( @result, true, "resultado SP");

set @tmp := (
select codgru from clientes_grupos where
codgru = @codgru );

select tap.eq( @tmp, @codgru, "resultado SELECT");

-- PARTE MODI FALLA
set @codgru := "009";
set @desgru := "GRUPO 001";
set @abrgru := "GRP001";

call distdev.sp_ClientesGruposModi(
@codgru,
@desgru,
@abrgru
 );
 
select tap.eq( @result, false, "resultado Modi FALLA");

-- parte BAJA FALLA

call distdev.sp_ClientesGruposBaja(
@codgru
 );
 
select tap.eq( @result, false, "resultado Baja FALLA");

-- parte BAJA OK
set @codgru := "001";
call distdev.sp_ClientesGruposBaja(
@codgru
 );

 select tap.eq( @result, true, "resultado Baja OK");
 
CALL tap.finish();
ROLLBACK;