DELIMITER $$
DROP PROCEDURE IF EXISTS `sp_InformeMensualxP2` $$
CREATE DEFINER=`root`@`%` PROCEDURE `sp_InformeMensualxP2`(
in myper varchar(6)
) 
begin

set @fecini := Periodo2FecIni( myper );
set @fecfin := Periodo2FecFin( myper );

call sp_InformeMensualxP3( @fecini , @fecfin );

set @t := (select sum( cirneta ) from infomensual );
if @t is not null then
insert into infomensual2 set  
periodo = myper,
cirnetatotal = IFNULL( @t, 0 );
end if;

END $$

DELIMITER ;  

