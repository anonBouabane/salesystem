DELIMITER $$
CREATE or replace PROCEDURE rptcountmsdata(`startdate` VARCHAR(20), `enddate` VARCHAR(20))
BEGIN

create TEMPORARY table tmp_count_item


SELECT ( case 
when name_company = 'Tyres Derler' then 'Tyres Center' 
when name_company = 'Tyres Modern Trade' then 'Tyres Center'
else name_company end) as name_company, 
 count(item_header_code) as count_item
FROM tbl_item_code_list a
left join tbl_item_company_code b on a.item_header_code = b.item_company_code
where date_register between startdate and enddate
group by item_header_code ;

create TEMPORARY table tmp_count_item_sum

select name_company, sum(count_item) as count_item
 from tmp_count_item
 group by name_company;


create TEMPORARY table tmp_count_cus 

SELECT ( case 
when acc_name = 'Tyres Derler' then 'Tyres Center' 
when acc_name = 'Tyres Modern Trade' then 'Tyres Center'
else acc_name end) as acc_name, 
count(a.acc_code) as count_customer 
FROM tbl_customer a 
left join tbl_account_company b on a.acc_code = b.company_code 
where date_register between startdate and enddate
group by a.acc_code;
    
 create TEMPORARY table tmp_count_cus_sum

select acc_name,sum(count_customer) as count_customer
 from tmp_count_cus
group by acc_name;


create TEMPORARY table tmp_join

select * from tmp_count_item_sum a
left join tmp_count_cus_sum b on a.name_company = b.acc_name ;
 

select acc_name,count_item,count_customer  from tmp_join where acc_name is not null;


END$$
DELIMITER ;