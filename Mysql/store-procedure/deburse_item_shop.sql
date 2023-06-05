DELIMITER $$
CREATE or replace PROCEDURE deb_item_shop(date_from date ,date_to date)
BEGIN

create TEMPORARY table tmp_count_stock_in


select item_id,sum(item_values) as item_in_count
from tbl_deburse_item_pre_sale_detail a
left join tbl_deburse_item_pre_sale b on a.dips_id = b.dips_id 
group by item_id;

create TEMPORARY table tmp_count_stock_out

select item_id,sum(item_values) as item_out_count
from tbl_bill_sale_detail a
left join tbl_bill_sale b  on a.bs_id = b.bs_id
group by item_id;


create TEMPORARY table tmp_count_stock_in_day

select item_id,sum(item_values) as item_in_day
from tbl_deburse_item_pre_sale_detail a
left join tbl_deburse_item_pre_sale b on a.dips_id = b.dips_id
where date_register BETWEEN date_from and date_to
group by item_id;


create TEMPORARY table tmp_count_stock_out_day

select item_id,sum(item_values) as item_out_day
from tbl_bill_sale_detail a
left join tbl_bill_sale b  on a.bs_id = b.bs_id
where date_register BETWEEN date_from and date_to
group by item_id;
   
create TEMPORARY table tmp_item_remain

select a.item_id,item_name,
(item_in_count - (case when item_out_count is null then 0 else item_out_count end))as remain_value
from tmp_count_stock_in a
left join tmp_count_stock_out b on a.item_id = b.item_id
left join tbl_item_data c on a.item_id = c.item_id;

create TEMPORARY table tmp_report_view

select a.item_id,item_name,remain_value,item_out_day,item_in_day
from tmp_item_remain a
left join tmp_count_stock_in_day b on a.item_id = b.item_id
left join tmp_count_stock_out_day c on a.item_id = c.item_id;



select * from tmp_report_view  ;


END$$
DELIMITER ;