-- Start a transaction.
BEGIN;

use distdev;

-- Plan the tests.
call tap.no_plan();

call dev_crema;
-- 1

-- parametros para el armado del comando sql
set @cantidad := 0;

-- parametros cliente de prueba
set @codcli := "999";
set @raz := "CLIENTE 999";
set @dom := "PIEDRAS";
set @loc := "OLAVARRIA";
set @cpo := "7400";
set @tel := "";
set @cel := "";
set @cat := "";
SET @ganancia := 60.0;
	
-- select tap.eq( "raz like '%SARASAXX%'", sf_buscar_todos_param( "", "raz", @raz ), "armado1");

call distdev.SP_ClientesModi(
@codcli,
@raz,
@dom,
@tel,
@loc,
@cpo,
@ganancia,
"", "000"
 );
 
select tap.eq( 1, @cantidad, "Cantidad Registros creados");

set @codcli := "999";
set @raz := "CLIENTE 999X";
set @dom := "PIEDRAS";
set @loc := "OLAVARRIA";
set @cpo := "7400";
set @tel := "";
set @cel := "";
set @cat := "";
SET @ganancia := 60.0;

call distdev.SP_ClientesBaja(
@codcli
 );

select tap.eq( 0, (select count(*) from clientes where codcli = @codcli), "Baja Cliente");


CALL tap.finish();
ROLLBACK;