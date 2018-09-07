DELIMITER $$

DROP FUNCTION IF EXISTS `Periodo2FecIni` $$
CREATE DEFINER=`root`@`%` FUNCTION `Periodo2FecIni`(
myper varchar(6)
) 
RETURNS date

BEGIN
set @ano := substring( myper, 1, 4 );
set @mes := substring( myper, 5, 2 ); 
return concat( @ano,"-",@mes,"-01") ;
END $$

DELIMITER ;