-- Start a transaction.
BEGIN;
start transaction;

use distdev;

-- Plan the tests.
call tap.no_plan();

set @ventaciudad := 11489;
set @ventainterior := 407;
set @suscripcionesciudad := 285;
set @suscripcionesinterior := 12;
set @devciu := 803;
set @devint := 29;
set @sincargociudad := 95;
set @inutil := 302;
-- InfoMensualDeterminarCirPaga( 
set @circulacionnetapaga := (select  @ventaciudad+@ventainterior+@suscripcionesciudad+@suscripcionesinterior-@devciu-@devint );

-- set @circulacionnetapaga := (select @ventaciudad+@ventainterior+@suscripcionesciudad+@suscripcionesinterior-@devciu-@devint );

set @tiradabruta := (@circulacionnetapaga + @sincargociudad +@inutil +@devciu+@devint);
-- select  @circulacionnetapaga + 95 +302 +803+29;

set @cantpaginas := (select 64); -- sale total de reporte produccion
set @totpaginas := (@tiradabruta * @cantpaginas); 
-- esto sale directamente del reporte de produccion del dia.
set @totkgrs := ( round( @totpaginas*0.0028899998758935663224781572676728, 4) ); 

select tap.eq( @circulacionnetapaga, 11361, " PrecioSegunFecha"); 
select tap.eq( @tiradabruta, 12590, " PrecioSegunFecha"); 
select tap.eq( @totpaginas, 805760, " PrecioSegunFecha"); 
select tap.eq( @totkgrs, 2328.6463, " PrecioSegunFecha"); 

set @fecha := '2014-11-19';

delete from infomensual;
insert into infomensual (
	dia,
	dow,
	vtaciu,
	vtaint,
	susciu,
	susint,
	devsin,
	devciu,
	devint,
	nodis,
	kgrstotales,
	paginas
)
select
dayofmonth( fecage ),
dayofweek( fecage ),
InfoMensualDeterminarVentas1( fecage ) as vtaciu,
InfoMensualDeterminarVentas2( fecage ) as vtaint,
InfoMensualDeterminarSuscripciones( fecage ) as suscrip,
InfoMensualDeterminarSuscripcionesInterior( fecage ) as susint,
InfoMensualDeterminarDevSinCargo( fecage ) as devsin ,
InfoMensualDeterminarDevCiudad( fecage ) as devciu,
InfoMensualDeterminarDevInterior( fecage ) as devint,
InfoMensualDeterminarNoDistribuido( fecage ) as nodis,
InfoMensualDeterminarKgrsTotales( fecage )  as kgrstotales,
InfoMensualDeterminarCantPaginas( fecage ) as paginas 
from agenda as agenda_infomensual
where 
fecage >= '2014-11-01' and
fecage <= '2014-11-30';

-- idx, dia, vtaciu, vtaint, susciu, devsin, devciu, devint, nodis, 
-- cirneta, inutilizable, tirbruta, paginas, totpaginas, kgrstotales, dow
update infomensual set
cirneta = vtaciu+vtaint+susciu+susint-devciu-devint;
update infomensual set
tirbruta = cirneta+devsin+inutilizable+devciu+devint;
update infomensual set
totpaginas = paginas * tirbruta;

call 

-- set @totkgrs := ( round( @totpaginas*0.0028899998758935663224781572676728, 4) ); 


-- +95
-- select * from infomensual;




CALL tap.finish();
ROLLBACK;