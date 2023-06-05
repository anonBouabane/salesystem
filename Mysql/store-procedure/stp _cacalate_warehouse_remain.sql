DELIMITER $$ 
create or replace PROCEDURE spt_stock_warehouse(date_from date ,date_to date)
BEGIN 

create TEMPORARY table tmp_stock_in

select item_id,sum(item_values) as item_stock_in
from tbl_stock_in_warehouse_detail a 
left join tbl_stock_in_warehouse b on a.siw_id =b.siw_id 
group by item_id ;

create TEMPORARY table tmp_stock_out 

select item_id,sum(item_values) as item_stock_out 
from tbl_stock_out_warehouse_detail a 
left join tbl_stock_out_warehouse b on a.sow_id = b.sow_id
 group by item_id;


 create  TEMPORARY table tmp_stock_in_day

select item_id,sum(item_values) as item_stock_in_day
from tbl_stock_in_warehouse_detail a 
left join tbl_stock_in_warehouse b on a.siw_id =b.siw_id 
where date_register BETWEEN date_from and date_to
group by item_id ;

create TEMPORARY table tmp_stock_out_day

select item_id,sum(item_values) as item_stock_out_day
from tbl_stock_out_warehouse_detail a 
left join tbl_stock_out_warehouse b on a.sow_id = b.sow_id
where date_register BETWEEN date_from and date_to
group by item_id;


create TEMPORARY table tmp_remain

select a.item_id,item_name,(item_stock_in - (case when item_stock_out is null then 0 else item_stock_out end))as remain_value
from tmp_stock_in a 
left join tmp_stock_out b on a.item_id = b.item_id 
left join tbl_item_data c on a.item_id =c.item_id;

create TEMPORARY table tmp_report 

select a.item_id,item_name,remain_value,item_stock_out_day,item_stock_in_day
from tmp_remain a left join tmp_stock_in_day b on a.item_id = b.item_id
left join tmp_stock_out_day c on a.item_id = c.item_id;

select * from tmp_report ;
END $$ 
DELIMITER ;