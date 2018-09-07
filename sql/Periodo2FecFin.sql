DELIMITER $$

DROP FUNCTION IF EXISTS `Periodo2FecFin` $$
CREATE DEFINER=`root`@`%` FUNCTION `Periodo2FecFin`(
myper varchar(6)
) 
RETURNS date

BEGIN
set @ano := substring( myper, 1, 4 );
set @mes := substring( myper, 5, 2 );
return date_add(  date_add( concat( @ano,"-",@mes,"-01"), interval 1 month ), interval -1 day )  ; 
END $$

DELIMITER ;