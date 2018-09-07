DELIMITER $$

DROP PROCEDURE IF EXISTS `sp_InformeMensualxP` $$
CREATE DEFINER=`root`@`%` PROCEDURE `sp_InformeMensualxP`(
in myperini varchar(6),
in myperfin varchar(6)
) 
begin

   -- vaciar la tabla temporaria del informe
   delete from infomensual2;
   set @cuenta := 0;
   set @myper := myperini;
   while @myper <= myperfin  do
      call sp_InformeMensualxP2( @myper );
      set @ano := substring( @myper, 1, 4 );
      set @mes := substring( @myper, 5, 2 );
      set @myper := date_add( concat( @ano,"-",@mes,"-01"), interval 1 month );
      set @myper := concat( year( @myper ), lpad( month( @myper  ), 2, "0" ) ) ;
      set @cuenta := @cuenta + 1; 
  end while;
  
  select * from infomensual2;
  
END $$

DELIMITER ;   

