DELIMITER $$
CREATE or replace PROCEDURE stp_edit_caculate_stock_remain(warehouse_id int, user_add int,id_item int, sow_bill int)
BEGIN

create TEMPORARY table tmp_count_stock_in

select item_id,sum(item_values) as item_in_count
from tbl_stock_in_warehouse_detail a
left join tbl_stock_in_warehouse b on a.siw_id = b.siw_id
where wh_id = warehouse_id and item_id = id_item
group by item_id,a.siw_id;

create TEMPORARY table tmp_count_stock_out

select item_id,sum(item_values) as item_out_count
from tbl_stock_out_warehouse_detail a
left join tbl_stock_out_warehouse b  on a.sow_id = b.sow_id
where wh_id = warehouse_id  and item_id = id_item and a.sow_id != sow_bill
group by item_id,a.sow_id;



create TEMPORARY table tmp_caculate_item_out

select item_id, sum(item_out_count) as item_out_count
from tmp_count_stock_out
group by item_id ;



create TEMPORARY table tmp_item_remain

select a.item_id, item_name,
(item_in_count - (case when item_out_count is null then 0 else item_out_count end))as remain_value
from tmp_count_stock_in a
left join tmp_caculate_item_out b on a.item_id = b.item_id 
left join tbl_item_data c on a.item_id = c.item_id;
 

select * from tmp_item_remain  ;


END$$
DELIMITER ;