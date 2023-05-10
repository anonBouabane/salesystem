DELIMITER $$
CREATE or replace PROCEDURE `rptexportpjp`(`startdate` VARCHAR(20), `enddate` VARCHAR(20))
BEGIN

create TEMPORARY table tmpcheckin

 SELECT 
concat(date_check,' ',time_check_in) as time_check_in,
concat(staff_code,' ',staff_cp,' ',staff_name) as staff_name,
'IN' as types,
concat(cus_code,' ',c_shop_name) as c_shop_name,
date_check,cus_code
FROM tbl_visited_customer a 
left join tbl_customer b on a.cus_code = b.c_code 
left join tbl_staff_sale d on a.check_by = d.user_ids
where time_check_in is not null and date_check between startdate and enddate ;

create TEMPORARY table tmpcheckout 
     SELECT 
concat(date_check,' ',time_check_out) as time_check_out,
concat(staff_code,' ',staff_cp,' ',staff_name) as staff_name,
'OUT' as types,
concat(cus_code,' ',c_shop_name) as c_shop_name,
date_check,cus_code
FROM tbl_visited_customer a 
left join tbl_customer b on a.cus_code = b.c_code 
left join tbl_staff_sale d on a.check_by = d.user_ids
where time_check_out is not null and date_check between startdate and enddate ;


create TEMPORARY table tmprptprexport

select * from tmpcheckin
union all
select * from tmpcheckout;
 

select  time_check_in,staff_name,types,c_shop_name,date_check from tmprptprexport order by cus_code,date_check,types;


END$$
DELIMITER ;