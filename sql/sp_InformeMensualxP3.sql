
DELIMITER $$

DROP PROCEDURE IF EXISTS `sp_InformeMensualxP3` ; $$

CREATE DEFINER=`root`@`%` PROCEDURE `sp_InformeMensualxP3`(
in desde date,
in hasta date
)
uno: BEGIN

start transaction;

delete from infomensual_total;

insert into infomensual_total
SELECT
proage,
fecage,
sum( cant1 ) as cant1,
sum( cant2 ) as cant2,
sum( cant3 ) as cant3,
precio
FROM agenda
where
fecage >= desde
and
fecage <= hasta
group by concat( fecage )
;


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
	paginas,
        inutilizable,
        tirneta,
        tirbrutarp
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
InfoMensualDeterminarCantPaginas( fecage ) as paginas,
InfoMensualDeterminarInutilizable( fecage ) as inutilizable,
InfoMensualDeterminarTiradaNeta( fecage ) as tirneta,
InfoMensualDeterminarTiradaBrutaRP( fecage ) as tirbrutarp

from infomensual_total as agenda_infomensual
where
fecage >= desde and
fecage <= hasta;



update infomensual set
cirneta = vtaciu+vtaint+susciu+susint-devciu-devint;
update infomensual set
tirbruta = cirneta+devsin+inutilizable+devciu+devint;
update infomensual set
totpaginas = paginas * tirbruta;

update infomensual set
nodis = tirneta - vtaciu - vtaint - susciu-devsin  ;

commit;

-- select * from infomensual;

END $$

DELIMITER ;


