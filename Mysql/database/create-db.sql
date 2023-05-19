create or REPLACE table tbl_branch (
br_id int not null PRIMARY KEY AUTO_INCREMENT,
br_name varchar(150),
br_status int,
br_type int,
add_by int,
date_register date
);


create table tbl_branch_type (
brt_id int not null PRIMARY KEY AUTO_INCREMENT,
brt_name varchar(60)
);

create or replace table tbl_warehouse (
wh_id int not null PRIMARY KEY AUTO_INCREMENT,
wh_name varchar(150),
wh_status int,
wh_type int,
br_id int,
add_by int,
date_register date
);

create or replace table tbl_warehouse_type (
wht_id int not null PRIMARY KEY AUTO_INCREMENT,
wht_name varchar(90) 
);
 

create or replace table tbl_user (
    usid int not null PRIMARY KEY AUTO_INCREMENT,
    full_name varchar(300),
    user_name varchar(30), 
    user_password varchar(30),
    role_id int,
    depart_id int,
    br_id int,
    user_status int,
    add_by int,
    date_register date
);


create table tbl_role_level(
    rl_id int not null PRIMARY KEY AUTO_INCREMENT,
    rl_name varchar(90)
);



create table tbl_item_pack_type (
    ipt_id int not null PRIMARY KEY AUTO_INCREMENT,
    ipt_name varchar(100)
);

create or replace table tbl_item_data (
    item_id int not null PRIMARY KEY AUTO_INCREMENT,
    item_name varchar(300),
    barcode varchar(50),  
    ipt_id int ,
    status_item int
);

create or replace table tbl_item_extract (
    iex_id int not null PRIMARY KEY AUTO_INCREMENT,
    item_id int,
    item_id_extract int,
    extract_values int
);

create or replace table tbl_item_price (
    ip_id  int not null PRIMARY KEY AUTO_INCREMENT,
    item_id int, 
    item_price int,
    br_id int,
    status_item_price int,
    add_by int,
    date_register date
);

create or replace table tbl_order_request(
    or_id int not null PRIMARY KEY AUTO_INCREMENT,
    or_bill_number varchar(30),
    br_id int,
    wh_id int,
    or_status int,
    add_by int,
    date_register date
);



create or replace table tbl_order_request_detail (
    ord_id int not null PRIMARY KEY AUTO_INCREMENT,
    or_id int,
    item_id int,
    item_values int 
);

create or replace table tbl_order_status (
os_id int not null PRIMARY KEY AUTO_INCREMENT,
os_name varchar(150)
);


create or replace table tbl_approve_order (
    apo_id int not null PRIMARY KEY AUTO_INCREMENT,
    apo_bill_number varchar(30),
    or_id int,
    br_id int,
    wh_id int,
    ar_status int,
    add_by int,
    date_register date  
);

create or replace table tbl_approve_order_detail (
    apod_id int not null PRIMARY KEY AUTO_INCREMENT,
    apo_id int,
    item_id int,
    item_values int 
);

create  or replace table tbl_approve_order_status(
    aos_id int not null PRIMARY KEY AUTO_INCREMENT,
    aos_name varchar(150)
);

create or replace table tbl_stock_in_warehouse (
     siw_id int not null PRIMARY KEY AUTO_INCREMENT,
     siw_bill_number varchar(30),
     apo_id int,
     bill_type int,
     br_id int,
     wh_id int, 
     add_by int,
     date_register date
);

create or replace table tbl_stock_in_warehouse_detail_pre (
    siwdp_id int not null PRIMARY KEY AUTO_INCREMENT, 
    item_id int,
    item_values int, 
    add_by int
);

create or replace table tbl_stock_in_warehouse_detail (
    siwd_id int not null PRIMARY KEY AUTO_INCREMENT,
    siw_id int,
    item_id int,
    item_values int 
);


create or replace table tbl_stock_out_warehouse (
     sow_id int not null PRIMARY KEY AUTO_INCREMENT,
     sow_bill_number varchar(30),
     bill_type int,
     apo_id int,
     br_id int,
     wh_id int,
     add_by int,
     date_register date
);

create or replace table tbl_stock_out_warehouse_detail (
    sowd_id int not null PRIMARY KEY AUTO_INCREMENT,
    sow_id int,
    item_id int,
    item_values int  
);

create or replace table tbl_stock_out_warehouse_detail_pre (
    sowdp_id int not null PRIMARY KEY AUTO_INCREMENT, 
    wh_id int,
    item_id int,
    item_values int,
    add_by int
);

create or replace table tbl_stock_transfer_warehouse (
     stw_id int not null PRIMARY KEY AUTO_INCREMENT,
     stw_bill_number varchar(30),
     or_id int,
     br_id_from int,
     wh_id_from int,
     br_id_to int,
     wh_id_to int,
     add_by int,
     date_register date
);


create or replace table tbl_stock_transfer_warehouse_detail (
    stwd_id int not null PRIMARY KEY AUTO_INCREMENT,
    stw_id int,
    item_id int,
    item_values int  
);


create or replace table tbl_deburse_item_pre_sale (
    dips_id int not null PRIMARY KEY AUTO_INCREMENT,
    dips_bill_number varchar(30),
    sow_id int,
    wh_id int,
    br_id int,
    add_by int,
    date_register date
);



create or replace table tbl_deburse_item_pre_sale_detail (
    dipsd_id int not null PRIMARY KEY AUTO_INCREMENT,
    dips_id int,
    item_id int,
    item_values int
);
 

create or replace table tbl_bill_sale (
    bs_id int not null PRIMARY KEY AUTO_INCREMENT,
    sale_bill_number varchar(30),
    br_id int,
    add_by int,
    bill_status int,
    payment_type int,
    sale_by int,
    date_register date
);

create or replace table tbl_bill_sale_detail(
    bsd_id int not null PRIMARY KEY AUTO_INCREMENT,
    bs_id int,
    item_id int,
    item_values int, 
    item_total_price int
);


create or replace table tbl_bill_sale_detail_pre(
    bsdp_id int not null PRIMARY KEY AUTO_INCREMENT, 
    item_id int,
    item_values int,  
    add_by int
);


 