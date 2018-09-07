-- Start a transaction.
BEGIN;
use distdev;

call tap.no_plan();

set @ini := "201412";
set @fin := "201412";

set @fecini := Periodo2FecIni( @ini );
set @fecfin := Periodo2FecFin( @fin );
select tap.eq( @fecini, "2014-12-01", "periodo ini");
select tap.eq( @fecfin, "2014-12-31", "periodo fin");

call sp_InformeMensualxP( @ini, @fin );

set @tmp := ( select cirnetatotal from infomensual2 where periodo = @ini );
select tap.eq( @t, 118899, "valor cir neta 201412");

set @ini := "201412";
set @fin := "201501";
call sp_InformeMensualxP( @ini, @fin );
  
select tap.eq( @cuenta, 2, "12 meses");
set @tmp := ( select count(*) from infomensual2 );
select tap.eq( @tmp, 2, "cant registros");
-- esto depende de la informacion en el SQL que sea como estaba al 1-3-15
-- select periodo, cirnetatotal from infomensual2;
   
 
CALL tap.finish();
ROLLBACK; 