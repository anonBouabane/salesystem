DELIMITER $$
CREATE or replace PROCEDURE stp_check_stock_shop_sale(branch_id int, user_add int,id_item int)
BEGIN

create TEMPORARY table tmp_count_stock_in

select item_id,sum(item_values) as item_in_count
from tbl_deburse_item_pre_sale_detail a
left join tbl_deburse_item_pre_sale b on a.dips_id = b.dips_id
where br_id = branch_id and item_id = id_item
group by item_id;

create TEMPORARY table tmp_count_stock_out

select item_id,sum(item_values) as item_out_count
from tbl_bill_sale_detail a
left join tbl_bill_sale b  on a.bs_id = b.bs_id
where br_id = branch_id  and item_id = id_item
group by item_id;


create TEMPORARY table tmp_count_stock_pre_out

select item_id,sum(item_values) as item_pre_count
from tbl_bill_sale_detail_pre 
where add_by = user_add  and item_id = id_item
group by item_id ;


create TEMPORARY table tmp_union_item_out

SELECT item_id, item_out_count
FROM tmp_count_stock_out  
union all
SELECT item_id, item_pre_count
FROM tmp_count_stock_pre_out ;


create TEMPORARY table tmp_caculate_item_out

select item_id, sum(item_out_count) as item_out_count
from tmp_union_item_out
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