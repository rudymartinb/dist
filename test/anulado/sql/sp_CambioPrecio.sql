BEGIN;

use distdev;

-- Plan the tests.
call tap.no_plan();


set @codpro := "001";
set @fec := "2014-11-01";
call sp_CambioPrecio( @codpro, @fec,  11,12,13,14,15,16,17 );
set @result := (select pre1 from productos_precios where propre = @codpro and desdepre = @fec );
select tap.eq( @result, 11, "primer cambio");

call sp_CambioPrecio( @codpro, @fec,  11,12,13,14,15,16,17 );
set @result := (select pre1 from productos_precios where propre = @codpro and desdepre = @fec );
select tap.eq( @result, 11, "primer cambio -- repetir");


set @fec := "2014-11-10";
call sp_CambioPrecio( @codpro, @fec,  12,13,14,15,16,17,18 );
set @result := (select pre1 from productos_precios where propre = @codpro and desdepre = @fec limit 1 );
select tap.eq( @result, 12, "segundo cambio");

set @fec := "2014-11-17";
call sp_CambioPrecio( @codpro, @fec,  13,14,15,16,17,18,19 );
set @result := (select pre1 from productos_precios where propre = @codpro and desdepre = @fec limit 1 );
select tap.eq( @result, 13, "tercer cambio");

set @fec := "2014-11-05"; -- Mie
select tap.eq( dayofweek( @fec )-1, 3, "miercoles?");
set @que := (select pre3 from productos_precios where propre = @codpro and @fec >= desdepre order by desdepre desc limit 1 );
select tap.eq( @que, 13, "precio miercoles antes del segundo cambio -- 1");

set @que := (select PrecioSegunFecha( @codpro, @fec ) );
select tap.eq( @que, 13, "precio miercoles antes del segundo cambio");

set @fec := "2014-11-12"; -- Mie
select tap.eq( dayofweek( @fec )-1, 3, "miercoles?");
set @que := (select PrecioSegunFecha( @codpro, @fec ) );
select tap.eq( @que, 14, "precio miercoles despues del segundo cambio");

set @fec := "2014-11-19"; -- Mie
select tap.eq( dayofweek( @fec )-1, 3, "miercoles?");
set @que := (select PrecioSegunFecha( @codpro, @fec ) );
select tap.eq( @que, 15, "precio miercoles despues del segundo cambio");


CALL tap.finish();
ROLLBACK;