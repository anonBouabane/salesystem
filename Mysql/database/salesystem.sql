-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 31, 2023 at 08:25 AM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 7.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `salesystem`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `stp_caculate_shop_stock_remain` (`warehouse_id` INT, `id_item` INT)  BEGIN

create TEMPORARY table tmp_count_stock_in

select item_id,sum(item_values) as item_in_count
from tbl_stock_in_warehouse_detail a
left join tbl_stock_in_warehouse b on a.siw_id = b.siw_id
where wh_id = warehouse_id and item_id = id_item
group by item_id;

create TEMPORARY table tmp_count_stock_out

select item_id,sum(item_values) as item_out_count
from tbl_stock_out_warehouse_detail a
left join tbl_stock_out_warehouse b  on a.sow_id = b.sow_id
where wh_id = warehouse_id  and item_id = id_item
group by item_id;


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

CREATE DEFINER=`root`@`localhost` PROCEDURE `stp_caculate_stock_remain` (`warehouse_id` INT, `user_add` INT, `id_item` INT)  BEGIN

create TEMPORARY table tmp_count_stock_in

select item_id,sum(item_values) as item_in_count
from tbl_stock_in_warehouse_detail a
left join tbl_stock_in_warehouse b on a.siw_id = b.siw_id
where wh_id = warehouse_id and item_id = id_item
group by item_id;

create TEMPORARY table tmp_count_stock_out

select item_id,sum(item_values) as item_out_count
from tbl_stock_out_warehouse_detail a
left join tbl_stock_out_warehouse b  on a.sow_id = b.sow_id
where wh_id = warehouse_id  and item_id = id_item
group by item_id;


create TEMPORARY table tmp_count_stock_pre_out

select item_id,sum(item_values) as item_pre_count
from tbl_stock_out_warehouse_detail_pre 
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

CREATE DEFINER=`root`@`localhost` PROCEDURE `stp_check_stock_shop_sale_detail` (`branch_id` INT, `id_item` INT)  BEGIN

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

CREATE DEFINER=`root`@`localhost` PROCEDURE `stp_check_stock_shop_sale_pre` (`branch_id` INT, `user_add` INT, `id_item` INT)  BEGIN

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

CREATE DEFINER=`root`@`localhost` PROCEDURE `stp_dash_board_shop_remain` (`branch_id` INT)  BEGIN

create TEMPORARY table tmp_count_stock_in

select item_id,sum(item_values) as item_in_count
from tbl_deburse_item_pre_sale_detail a
left join tbl_deburse_item_pre_sale b on a.dips_id = b.dips_id
where br_id = branch_id 
group by item_id;

create TEMPORARY table tmp_count_stock_out

select item_id,sum(item_values) as item_out_count
from tbl_bill_sale_detail a
left join tbl_bill_sale b  on a.bs_id = b.bs_id
where br_id = branch_id  
group by item_id;


create TEMPORARY table tmp_caculate_item_out

select item_id, sum(item_out_count) as item_out_count
from tmp_count_stock_out
group by item_id ;



create TEMPORARY table tmp_item_remain

select a.item_id, item_name,
(item_in_count - (case when item_out_count is null then 0 else item_out_count end))as remain_value,
item_in_count, (case when item_out_count is null then 0 else item_out_count end) as item_out_count
from tmp_count_stock_in a
left join tmp_caculate_item_out b on a.item_id = b.item_id 
left join tbl_item_data c on a.item_id = c.item_id;
 

select * from tmp_item_remain order by  remain_value asc;


END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `stp_edit_caculate_shop_stock_remain` (`warehouse_id` INT, `id_item` INT, `sow_bill` INT)  BEGIN

create TEMPORARY table tmp_count_stock_in

select item_id,sum(item_values) as item_in_count
from tbl_stock_in_warehouse_detail a
left join tbl_stock_in_warehouse b on a.siw_id = b.siw_id
where wh_id = warehouse_id and item_id = id_item
group by item_id;

create TEMPORARY table tmp_count_stock_out

select item_id,sum(item_values) as item_out_count
from tbl_stock_out_warehouse_detail a
left join tbl_stock_out_warehouse b  on a.sow_id = b.sow_id
where wh_id = warehouse_id  and item_id = id_item and a.sow_id != sow_bill
group by item_id;



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

CREATE DEFINER=`root`@`localhost` PROCEDURE `stp_edit_caculate_stock_remain` (`warehouse_id` INT, `user_add` INT, `id_item` INT, `sow_bill` INT)  BEGIN

create TEMPORARY table tmp_count_stock_in

select item_id,sum(item_values) as item_in_count
from tbl_stock_in_warehouse_detail a
left join tbl_stock_in_warehouse b on a.siw_id = b.siw_id
where wh_id = warehouse_id and item_id = id_item
group by item_id;

create TEMPORARY table tmp_count_stock_out

select item_id,sum(item_values) as item_out_count
from tbl_stock_out_warehouse_detail a
left join tbl_stock_out_warehouse b  on a.sow_id = b.sow_id
where wh_id = warehouse_id  and item_id = id_item and a.sow_id != sow_bill
group by item_id;



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

CREATE DEFINER=`root`@`localhost` PROCEDURE `stp_edit_check_stock_shop_sale_detail` (`branch_id` INT, `id_item` INT, `bill_id` INT)  BEGIN

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
where br_id = branch_id  and item_id = id_item and a.bs_id != bill_id
group by item_id;


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

CREATE DEFINER=`root`@`localhost` PROCEDURE `stp_edit_check_stock_shop_sale_pre` (`branch_id` INT, `user_add` INT, `id_item` INT)  BEGIN

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
where add_by = user_add  and item_id != id_item
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

CREATE DEFINER=`root`@`localhost` PROCEDURE `test` ()  BEGIN

create TEMPORARY table tmp_count_stock_in

select item_id,sum(item_values) as item_in_count
from tbl_deburse_item_pre_sale_detail a
left join tbl_deburse_item_pre_sale b on a.dips_id = b.dips_id
where br_id = branch_id 
group by item_id;

select * from tmp_count_stock_in ;
 
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_approve_order`
--

CREATE TABLE `tbl_approve_order` (
  `apo_id` int(11) NOT NULL,
  `apo_bill_number` varchar(30) DEFAULT NULL,
  `or_id` int(11) DEFAULT NULL,
  `br_id` int(11) DEFAULT NULL,
  `wh_id` int(11) DEFAULT NULL,
  `add_by` int(11) DEFAULT NULL,
  `date_register` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_approve_order`
--

INSERT INTO `tbl_approve_order` (`apo_id`, `apo_bill_number`, `or_id`, `br_id`, `wh_id`, `add_by`, `date_register`) VALUES
(1, '202305290001', 1, 2, 5, 3, '2023-05-29'),
(9, '202305290002', 6, 2, 7, 3, '2023-05-29'),
(11, '202305290004', 4, 2, 5, 3, '2023-05-29'),
(12, '202305290005', 3, 2, 7, 3, '2023-05-29'),
(13, '202305290006', 2, 2, 6, 3, '2023-05-29'),
(14, '202305290007', 5, 2, 6, 3, '2023-05-29');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_approve_order_detail`
--

CREATE TABLE `tbl_approve_order_detail` (
  `apod_id` int(11) NOT NULL,
  `apo_id` int(11) DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  `item_values` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_approve_order_detail`
--

INSERT INTO `tbl_approve_order_detail` (`apod_id`, `apo_id`, `item_id`, `item_values`) VALUES
(1, 1, 10, 10),
(2, 1, 9, 2),
(3, 1, 8, 10),
(4, 1, 6, 30),
(5, 1, 7, 5),
(24, 9, 15, 10),
(25, 9, 12, 3),
(28, 11, 12, 20),
(29, 12, 15, 10),
(30, 12, 14, 10),
(31, 12, 13, 10),
(32, 12, 12, 10),
(33, 12, 11, 10),
(34, 13, 5, 10),
(35, 13, 4, 5),
(36, 13, 3, 3),
(37, 13, 2, 10),
(38, 13, 1, 20),
(39, 14, 13, 20),
(40, 14, 12, 35);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_bill_sale`
--

CREATE TABLE `tbl_bill_sale` (
  `bs_id` int(11) NOT NULL,
  `sale_bill_number` varchar(30) DEFAULT NULL,
  `total_pay` int(11) DEFAULT NULL,
  `br_id` int(11) DEFAULT NULL,
  `bill_status` int(11) DEFAULT NULL,
  `payment_type` int(11) DEFAULT NULL,
  `sale_by` int(11) DEFAULT NULL,
  `date_register` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_bill_sale`
--

INSERT INTO `tbl_bill_sale` (`bs_id`, `sale_bill_number`, `total_pay`, `br_id`, `bill_status`, `payment_type`, `sale_by`, `date_register`) VALUES
(1, '202305240001', 500, 2, 2, 1, 6, '2023-05-24'),
(2, '202305250001', 6000, 2, 2, 1, 6, '2023-05-25'),
(3, '202305250002', 11000, 2, 2, 1, 6, '2023-05-25'),
(4, '202305250003', 1000, 2, 2, 1, 6, '2023-05-25'),
(5, '202305250004', 13000, 2, 2, 1, 6, '2023-05-25'),
(6, '202305250005', 5000, 2, 2, 1, 6, '2023-05-25'),
(8, '202305260002', 5000, 2, 2, 1, 6, '2023-05-26'),
(9, '202305260003', 5000, 2, 2, 1, 6, '2023-05-26');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_bill_sale_detail`
--

CREATE TABLE `tbl_bill_sale_detail` (
  `bsd_id` int(11) NOT NULL,
  `bs_id` int(11) DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  `item_values` int(11) DEFAULT NULL,
  `item_total_price` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_bill_sale_detail`
--

INSERT INTO `tbl_bill_sale_detail` (`bsd_id`, `bs_id`, `item_id`, `item_values`, `item_total_price`) VALUES
(1, 1, 1, 1, 500),
(2, 2, 5, 1, 1000),
(3, 2, 2, 1, 5000),
(4, 3, 3, 1, 1000),
(5, 3, 2, 2, 10000),
(6, 4, 3, 1, 1000),
(18, 8, 2, 1, 5000),
(54, 9, 1, 1, 500),
(72, 6, 1, 2, 1000),
(73, 6, 2, 1, 5000),
(74, 6, 4, 1, 5000),
(75, 6, 5, 1, 1000),
(76, 5, 1, 2, 1000),
(77, 5, 3, 1, 1000),
(78, 5, 6, 1, 4000),
(79, 5, 9, 1, 7000);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_bill_sale_detail_pre`
--

CREATE TABLE `tbl_bill_sale_detail_pre` (
  `bsdp_id` int(11) NOT NULL,
  `item_id` int(11) DEFAULT NULL,
  `item_values` int(11) DEFAULT NULL,
  `br_id` int(11) DEFAULT NULL,
  `add_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_bill_sale_detail_pre`
--

INSERT INTO `tbl_bill_sale_detail_pre` (`bsdp_id`, `item_id`, `item_values`, `br_id`, `add_by`) VALUES
(175, 2, 4, 1, 3);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_bill_type`
--

CREATE TABLE `tbl_bill_type` (
  `bt_id` int(11) NOT NULL,
  `bt_name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_bill_type`
--

INSERT INTO `tbl_bill_type` (`bt_id`, `bt_name`) VALUES
(1, 'ລໍຖ້າ'),
(2, 'ຊຳລະແລ້ວ'),
(3, 'ຕິດຫນີ້');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_branch`
--

CREATE TABLE `tbl_branch` (
  `br_id` int(11) NOT NULL,
  `br_name` varchar(150) DEFAULT NULL,
  `br_status` int(11) DEFAULT NULL,
  `br_type` int(11) DEFAULT NULL,
  `add_by` int(11) DEFAULT NULL,
  `date_register` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_branch`
--

INSERT INTO `tbl_branch` (`br_id`, `br_name`, `br_status`, `br_type`, `add_by`, `date_register`) VALUES
(1, 'ສູນໃຫຍວັດໄຕ', 1, 1, 1, '2023-03-13'),
(2, 'ສາຂາໜອງດ້ວງ', 1, 2, 1, '2023-03-13'),
(3, 'ສາຂາສີໄຄ', 1, 1, 1, '2023-03-13'),
(4, 'ດົງນາໂຊກ', 1, 2, 1, '2023-03-13');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_branch_type`
--

CREATE TABLE `tbl_branch_type` (
  `brt_id` int(11) NOT NULL,
  `brt_name` varchar(60) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_branch_type`
--

INSERT INTO `tbl_branch_type` (`brt_id`, `brt_name`) VALUES
(1, 'ສາຂາ'),
(2, 'ແຟນຊາຍ');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_deburse_item_pre_sale`
--

CREATE TABLE `tbl_deburse_item_pre_sale` (
  `dips_id` int(11) NOT NULL,
  `dips_bill_number` varchar(30) DEFAULT NULL,
  `sow_id` int(11) DEFAULT NULL,
  `wh_id` int(11) DEFAULT NULL,
  `br_id` int(11) DEFAULT NULL,
  `add_by` int(11) DEFAULT NULL,
  `date_register` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_deburse_item_pre_sale`
--

INSERT INTO `tbl_deburse_item_pre_sale` (`dips_id`, `dips_bill_number`, `sow_id`, `wh_id`, `br_id`, `add_by`, `date_register`) VALUES
(1, '202305220001', 3, 5, 2, 6, '2023-05-22'),
(2, '202305220002', 4, 6, 2, 6, '2023-05-22');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_deburse_item_pre_sale_detail`
--

CREATE TABLE `tbl_deburse_item_pre_sale_detail` (
  `dipsd_id` int(11) NOT NULL,
  `dips_id` int(11) DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  `item_values` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_deburse_item_pre_sale_detail`
--

INSERT INTO `tbl_deburse_item_pre_sale_detail` (`dipsd_id`, `dips_id`, `item_id`, `item_values`) VALUES
(1, 1, 6, 11),
(2, 1, 7, 5),
(3, 1, 8, 10),
(4, 1, 9, 2),
(5, 1, 10, 10),
(6, 2, 1, 10),
(7, 2, 2, 10),
(8, 2, 3, 3),
(9, 2, 4, 5),
(10, 2, 5, 10);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_depart`
--

CREATE TABLE `tbl_depart` (
  `dp_id` int(11) NOT NULL,
  `dp_name` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_depart`
--

INSERT INTO `tbl_depart` (`dp_id`, `dp_name`) VALUES
(1, 'ໄອທີ'),
(2, 'ບັນຊີ'),
(3, 'ແອັດມີນ'),
(4, 'ການຂາຍ'),
(5, 'ແຟນຊາຍ'),
(6, 'ບໍລິຫານ');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_header_title`
--

CREATE TABLE `tbl_header_title` (
  `ht_id` int(11) NOT NULL,
  `ht_name` varchar(300) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_header_title`
--

INSERT INTO `tbl_header_title` (`ht_id`, `ht_name`) VALUES
(1, 'Master Data'),
(2, 'User Data'),
(3, 'System Data'),
(4, 'Sale Data');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_item_data`
--

CREATE TABLE `tbl_item_data` (
  `item_id` int(11) NOT NULL,
  `item_name` varchar(300) DEFAULT NULL,
  `barcode` varchar(50) DEFAULT NULL,
  `ipt_id` int(11) DEFAULT NULL,
  `status_item` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_item_data`
--

INSERT INTO `tbl_item_data` (`item_id`, `item_name`, `barcode`, `ipt_id`, `status_item`) VALUES
(1, 'Mineral ນໍ້າດື່ມຕຸກ 600ml', '0700697175011', 1, 1),
(2, 'Mineral ນໍ້າດື່ມຕຸກ 1500ml', '0700697175028', 1, 1),
(3, 'Mineral ນໍ້າດື່ມຕຸກ 250ml', '0700697175042', 1, 1),
(4, 'Scott Select 24Rolls C*5', '18850039203250', 2, 1),
(5, 'OK Pop Up C*120', '18850039602961', 2, 1),
(6, 'Scott soft case 120 s C*36', '18850039750150', 1, 1),
(7, 'KNORR POWDER PORK BTF LA 120X100G', '18850144255113', 2, 1),
(8, 'KNORR POWDER PK P24X450G', '18850144255120', 2, 1),
(9, 'KNORR CUBE PORK (ARARAT) 6X24X20G', '18850144255182', 2, 1),
(10, 'Mali Sweet Condensed Milk Easy Squeeze 170g C*48', '18850151951374', 2, 1),
(11, 'Cook Soybean oil 1000ml C*12', '18850180010042', 2, 1),
(12, 'Lectasoy Chocolate 250ml C*36', '18850267118135', 2, 1),
(13, 'Lectasoy Original 300ml C*36', '18850267118227', 2, 1),
(14, 'Semon 17g C*144', '18850424001065', 2, 1),
(15, 'Semon 17g P*12', '18850424001066', 2, 1),
(16, 'Euro cake 17g Custard C*144', '18850425002924', 2, 1),
(17, 'Euro butter cake 40g C*48', '18850425003846', 2, 1),
(18, 'Ellse cake 15g Vanilla C*288', '18850425004751', 3, 1),
(19, 'Ellse cake 15g Strawberry Jam C*288', '18850425011315', 3, 1),
(20, 'Squid Fish Sauce 700ml C*12', '18850620888286', 2, 1),
(21, 'Vitamilk Soya Bean Milk 300ml C*36', '18851028001154', 2, 1),
(22, 'Sofy Cooling Fresh Night Super Ultra Slim Wing 29cm. 12 pcs C*12', '18851111139030', 2, 1),
(23, 'Sofy Cooling Fresh Slim Wing 23cm. 14 pcs. C*12', '18851111153050', 2, 1),
(24, 'Dutch Mill Yogurt Drink Strawberry Flavor 180ml C*48', '18851717040013', 2, 1),
(25, 'Dutch Mill Yogurt Drink Mixed Fruits Flavor 180ml C*48', '18851717040037', 2, 1),
(26, 'Walls Cornetto Vanilla 110g', '18851932028100', 1, 1),
(27, 'Walls Cup Vanilla  55g C*24', '18851932074022', 1, 1),
(28, 'Walls Top ten Vanilla 73g C*25', '18851932080146', 1, 1),
(29, 'Walls Cornetto Chocoluv 88g C*20', '18851932113929', 2, 1),
(30, 'Walls Cup Chocolate Chip  55g C*24', '18851932123324', 2, 1),
(31, 'SUNLIGHT LEMON TURBO SW 4X3600ML', '18851932127742', 1, 1),
(32, 'COMFORT DILUTE PINK 4X3600ML', '18851932129272', 2, 1),
(33, 'VASELINE HEALTHY HANDS&NAILS 8X3X85ML', '18851932137710', 2, 1),
(34, 'Walls Top ten Chocolate 73g C*25', '18851932140239', 2, 1),
(35, 'OMO REGULAR LEWIS N 6X4X430G', '18851932177020', 2, 1),
(36, 'SUNLIGHT LEMON TURBO NEW 24X550ML', '18851932178485', 2, 1),
(37, 'COMFORT DILUTE BLUE 24X580ML', '18851932183144', 2, 1),
(38, 'COMFORT DILUTE PINK 24X580ML', '18851932183168', 2, 1),
(39, 'CITRA PEARLY WH UV LOT 4X3X400ML', '18851932209141', 2, 1),
(40, 'VASELINE HW UV LIGHTENING LOT 8X3X120ML', '18851932229675', 2, 1),
(41, 'VASELINE HB UV EXTRA BRIGHTEN 4X3X320ML', '18851932229699', 2, 1),
(42, 'Walls Magnum Almond 90g C*24', '18851932236673', 2, 1),
(43, 'Walls Magnum Classic 90g C*24', '18851932236680', 3, 1),
(44, 'COMFORT ULTRA ONE RINSE BLACK 12X24X20ML', '18851932240014', 3, 1),
(45, 'BREEZE POWER RED PILLOW NEW 6X2700G', '18851932247471', 2, 1),
(46, 'OMO REGULAR LEWIS N 6X2700G', '18851932247587', 2, 1),
(47, 'Walls Paddle Pop Big Rocket Jelly 50g C*30', '18851932250228', 2, 1),
(48, 'VASELINE INSTANT FAIR LOTION 4X3X350ML', '18851932250358', 2, 1),
(49, 'Walls Paddle Pop Mini Cola 60g C*60', '18851932251737', 2, 1),
(50, 'LUX LIQ SOFT ROSE BT D (E)P6X900ML', '18851932255391', 2, 1),
(51, 'BREEZE POWER SWEET FLOWER NEW 6X2500G', '18851932261064', 1, 1),
(52, 'Walls Take home Taro 160g C*8', '18851932261583', 1, 1),
(53, 'SUNSILK SH SOFT&SMOOTH OC 12X450ML', '18851932355039', 1, 1),
(54, 'SUNSILK SH DAMAGE RESTORE OC 12X450ML', '18851932355343', 2, 1),
(55, 'SUNSILK HC SOFT&SMOOTH SPR 12X425ML', '18851932357491', 2, 1),
(56, 'COMFORT LUX PURPLE GV 12X24X20ML', '18851932381472', 1, 1),
(57, 'COMFORT LUX RED GV 12X24X20ML', '18851932381526', 2, 1),
(58, 'COMFORT ULTRA BLUE 4B MG 12X24X22ML', '18851932381618', 2, 1),
(59, 'COMFORT ULTRA PINK 4B MG 12X24X22ML', '18851932381625', 2, 1),
(60, 'LUX SHW CRM SOFT ROSE TWIN 8X500ML', '18851932384787', 2, 1),
(61, 'LUX SHW CRM MAGICAL FB TWIN 8X500ML', '18851932384800', 2, 1),
(62, 'SUNLIGHT LEMON TURBO NEW 8X6X150ML', '18851932385739', 2, 1),
(63, 'VASELINE PURE JELLY 12X3X50ML', '18851932387948', 2, 1),
(64, 'VASELINE ALOE SOOTHE 4X3X350ML', '18851932392348', 2, 1),
(65, 'VASELINE DEEP RESTORE 4X3X350ML', '18851932392362', 2, 1),
(66, 'BREEZE POWER COLOR NEW 6X2500G', '18851932396063', 2, 1),
(67, 'Walls Cornetto Cookies and Cream 67g C*24', '18851932397015', 2, 1),
(68, 'CITRA NATURAL WH AURA LOTION 4X3X400ML', '18851932397114', 3, 1),
(69, 'PONDS WHITE BEAUTY TONE UP CREAM 24X6X7G', '18851932398357', 3, 1),
(70, 'CITRA PINKISH WH UV LOT 4X3X400ML', '18851932399439', 2, 1),
(71, 'CLEAR SH CSC 2IN1 CARAT 12X480ML', '18851932399606', 2, 1),
(72, 'CLEAR SH SAKURA FRESH CARAT 12X480ML', '18851932399620', 2, 1),
(73, 'CLEAR MEN SH CSM CARAT 12X450ML', '18851932399675', 2, 1),
(74, 'CLEAR MEN SH DCLN CARAT 12X450ML', '18851932399682', 2, 1),
(75, 'CITRA PEARLY WH UV LOT 8X3X150ML', '18851932400227', 2, 1),
(76, 'Walls Asian Delight Taro 60g C*24', '18851932404393', 1, 1),
(77, 'SUNLIGHT LEMON TURBO C (LA) 6X3X750ML', '18851932405390', 1, 1),
(78, 'DOVE SH INTENSE REPAIR DIA12X480ML', '18851932408667', 1, 1),
(79, 'Walls Top ten Double Choc 73g C*25', '18851932411957', 2, 1),
(80, 'BREEZE MATIC REGULAR TISI 2X7500G', '18851932413135', 2, 1),
(81, 'VASELINE MEN OIL MOIST P24X6X7G', '18851932415177', 1, 1),
(82, 'COMFORT ULTRA GREEN 12X24X22ML', '18851932415740', 2, 1),
(83, 'OMO-MORNING FRESH N 6X2700G', '18851932428689', 2, 1),
(84, 'KNORR JOK CUP PORK ADM P6X6X35G', '18851932429662', 2, 1),
(85, 'KNORR JOK CUP CHICKEN PD P6X6X32G', '18851932429679', 2, 1),
(86, 'KNORR JOK CUP SHRIMP ADM P6X6X35G', '18851932429686', 2, 1),
(87, 'KNORR JOK CUP PK SEAWEED ADM P6X6X35G', '18851932429693', 2, 1),
(88, 'KNORR JOK CUP FISH PD P6X6X32G', '18851932429709', 2, 1),
(89, 'SUNSILK SH SMO SPL (LA) 10X60X5ML', '18851932431160', 2, 1),
(90, 'SUNSILK SH SMO SPL (LA) 12X5ML', '18851932431161', 2, 1),
(91, 'SUNSILK HC DAMAGE RESTORE(LA) 10X60X5ML', '18851932431177', 2, 1),
(92, 'SUNSILK SH SOFT&SMOOTH OC (LA) 10X60X5ML', '18851932431184', 2, 1),
(93, 'SUNSILK SH DAMAGE RES OC (LA) 10X60X5ML', '18851932431207', 3, 1),
(94, 'SUNSILK HC SMO SPL (LA) 10X60X5ML', '18851932431214', 3, 1),
(95, 'CLEAR SH ICM CARAT (LA) 10X60X5ML', '18851932431221', 2, 1),
(96, 'CLEAR SH CSC 2IN1 CARAT (LA) 10X60X5ML', '18851932431238', 2, 1),
(97, 'CLEAR MEN SH CSM CARAT (LA) 720X5ML', '18851932431252', 2, 1),
(98, 'DOVE SH DLX INTENSE REPAIR(LA) 10X60X5ML', '18851932431269', 2, 1),
(99, 'DOVE HC INTENSE REPAIR DIA(LA)10X60X5ML', '18851932431276', 2, 1),
(100, 'KNORR CUBE TOMYAM (NEW) 6X24X24G', '18851932431337', 2, 1),
(101, 'LUX SHW CRM SOFT ROSE BT 8X500ML', '18851932437209', 1, 1),
(102, 'LUX SHW CRM MAGICAL SPELL FB BT 8X500ML', '18851932437216', 1, 1),
(103, 'Roller Corn Milk Flavor 25g C*144', '18852681040016', 1, 1),
(104, 'Roller Corn Chocolate Flavor 25g P*144', '18852681040023', 2, 1),
(105, 'Dutch Mill Yogurt Drink Mixed Berries  Flavor 180ml C*48', '18853002302042', 2, 1),
(106, 'Plearn Refined Palm Oil 1000ml C*12', '18859105800119', 1, 1),
(107, 'Scott Box 115 s C*48', '18888336013838', 2, 1),
(108, 'Scott Compack Pack 2 C*36', '18888336016280', 2, 1),
(109, 'CLOSE UP TP MENTHOL FRESH P12X12X30G', '18934839120648', 2, 1),
(110, 'CLOSE UP TP MENTHOL FRESH P12X6X160G', '18934839120662', 2, 1),
(111, 'PONDS PURE WHITE FC FOAM 4X6X100G', '18999999092181', 2, 1),
(112, 'PONDS WHITE BEAUTY FF PNCL 4X6X100G', '18999999092327', 2, 1),
(113, 'Naga Brand Rice 1Kg', '2055203820113', 2, 1),
(114, 'Fresh Egg 1pack', '2055203820115', 2, 1),
(115, 'Facial Mask 10pcs', '2055203820116', 2, 1),
(116, 'Waiwai Original 57g C*180', '28850100000013', 2, 1),
(117, 'Waiwai Pet Polo 60g C*180', '28850100000853', 2, 1),
(118, 'Waiwai Pet Polo 60g P*10', '28850100000854', 3, 1),
(119, 'Waiwai Minced pork tomyum 60g P*10', '288501000012', 3, 1),
(120, 'Waiwai Minced pork tomyum 60g C*180', '28850100001225', 2, 1),
(121, 'Maggi Soya sauce 700ml C*12', '28850124065425', 2, 1),
(122, 'Sofy Cooling Fresh Super Ultra Slim Wing 23cm. 16pcs C*24', '28851111115031', 2, 1),
(123, 'Sofy Cooling Fresh Natural Night Super Ultra Slim Wing 29cm. 10 pcs C*24', '28851111139075', 2, 1),
(124, 'Sofy Cooling Fresh Slim Wing 23cm. 4 pcs. C*24', '28851111153064', 2, 1),
(125, 'Sofy Cooling Fresh Natural Slim Wing 23cm. 4Pcs. C*24', '28851111153156', 2, 1),
(126, 'Sofy Cooling Fresh Natural Super Slim0.1 Wing 23cm. 14Pcs. C*24', '28851111157031', 1, 1),
(127, 'Sofy Cooling Fresh Extra Super Slim Wing 25cm. 12pcs C*24', '28851111158076', 1, 1),
(128, 'Sofy Cooling Fresh Extra Night Slim Wing 29cm. 4pcs C*24', '28851111159134', 1, 1),
(129, 'Sofy Body Fit Night Slim Wing 35cm. 14 pcs C*24', '28851111162059', 2, 1),
(130, 'Sofy Charcoal Fresh Night Wing 29cm 14pcs C*24', '28851111180039', 2, 1),
(131, 'Sofy Charcoal Fresh Slim Wing 23cm 4pcs C*24', '28851111198010', 1, 1),
(132, 'Sofy Charcoal Fresh Ultra Slim Wing 23cm 16pcs C*24', '28851111199055', 2, 1),
(133, 'Sofy Pantyliner Slim Pure Care Scented Sweet Rose 20pcs C*24', '28851111260038', 2, 1),
(134, 'Sofy Pantyliner Slim Cooling Fresh Scented 16pcs C*24', '28851111270013', 2, 1),
(135, 'Sofy Pantyliner Slim Cooling Fresh Scented 32pcs C*24', '28851111270037', 2, 1),
(136, 'Sofy Cooling Fresh Natural Slim Scented 16 pcs. C*24', '28851111270082', 2, 1),
(137, 'Sofy Cooling Fresh Natural Slim Scented 32 pcs. C*24', '28851111270105', 2, 1),
(138, 'MAMY POKO - WIPES Rakaprayad 70x2 C*12', '28851111423235', 2, 1),
(139, 'VASELINE MEN WHITE 100G', '4800888157966', 2, 1),
(140, 'Sofy Cooling Fresh Night Slim Wing 29cm. 5 pcs C*48', '48851111159015', 2, 1),
(141, 'Mamypoko Happy Pants Day&Night M 74 C*4', '48851111418464', 2, 1),
(142, 'Mamypoko Happy Pants Day&Night L 62 C*4', '48851111419423', 2, 1),
(143, 'Mamypoko Happy Pants Day&Night XL 54 C*4', '48851111420382', 3, 1),
(144, 'Mamypoko Happy Pants Day&Night XXL 48 C*4', '48851111421099', 3, 1),
(145, 'JN Green Cigarettes', '4897028983158', 2, 1),
(146, 'Lao Tobacco A Green', '4897028983159', 2, 1),
(147, 'Lao Tobacco A Red ', '4897028983160', 2, 1),
(148, 'Sweet Potato 1Kg', '5550725111016', 2, 1),
(149, 'Mamypoko New Born 24 C*8', '58851111400428', 2, 1),
(150, 'Sofy Body Fit Night Slim Wing 29cm. 4 pcs C*72', '68851111105221', 2, 1),
(151, 'Lifree Dry Comfort Tape M 18 C*6', '68851111606032', 1, 1),
(152, 'Lifree Dry Comfort Tape L 15 C*6', '68851111607039', 1, 1),
(153, 'Lifree Light Pants M 10(4/C) C*4', '68851111610022', 1, 1),
(154, 'Lifree Light Pants XL 8(4/C) C*4', '68851111612026', 2, 1),
(155, 'Chacha Sunflowerseeds Original 70g', '6924187890220', 2, 1),
(156, 'Mineral ນໍ້າດື່ມຕຸກ 600ml P*12', '700697175012', 1, 1),
(157, 'Mineral ນໍ້າດື່ມຕຸກ 1500ml P*6', '700697175029', 2, 1),
(158, 'Mineral ນໍ້າດື່ມຕຸກ 250ml P*12', '700697175043', 2, 1),
(159, 'BB White Cabbage 400g', '700697175044', 2, 1),
(160, 'BB Cabbage 600g', '700697175045', 2, 1),
(161, 'BB Butterhead Salad 350g', '700697175046', 2, 1),
(162, 'BB Green Pak Choy 400g', '700697175047', 2, 1),
(163, 'BB Japanese Cucuber 400g', '700697175048', 2, 1),
(164, 'BB Tomato 250g', '700697175049', 2, 1),
(165, 'BB Mini Potato 500g', '700697175050', 2, 1),
(166, 'Ovantine 3 in 1 30g', '7612100041581', 2, 1),
(167, 'Ovantine 3 in 1 30g P*22', '7612100041611', 2, 1),
(168, 'Yumyum cup  Suki 55g C*36', '78850250208272', 3, 1),
(169, 'Yumyum cup Tomyumkoung creamy 60g C*36', '78850250227839', 3, 1),
(170, 'Ruaypuan 20g C*120', '78852052150100', 2, 1),
(171, 'Pine Change 7 Cigarettes', '8801116007097', 2, 1),
(172, 'Unitel Prepaid Refill Card 10,000KIP', '8801116007098', 2, 1),
(173, 'M Phone Prepaid Refill Card 10,000KIP', '8801116007099', 2, 1),
(174, 'Fresh Egg 1pcs', '8801116007100', 2, 1),
(175, 'Scott Select 24Rolls', '8850039203253', 2, 1),
(176, 'OK Pop Up P*6', '8850039602957', 1, 1),
(177, 'OK Pop Up', '8850039602964', 1, 1),
(178, 'Scott soft case 120 s', '8850039750047', 1, 1),
(179, 'Scott soft case 120 s P*4', '8850039750153', 2, 1),
(180, 'Ovantine 3 in 1 30g 12sticks', '8850086263606', 2, 1),
(181, 'Waiwai Original 57g ', '8850100004994', 1, 1),
(182, 'Waiwai Original 57g  P*10', '8850100004995', 2, 1),
(183, 'Waiwai Pet Polo 60g', '8850100006691', 2, 1),
(184, 'Waiwai Minced pork tomyum 60g', '8850100006707', 2, 1),
(185, 'Waiwai Original 57g P*30', '8850100110114', 2, 1),
(186, 'Waiwai Pet Polo 60g P*30', '8850100111562', 2, 1),
(187, 'Waiwai Minced pork tomyum 60g P*30', '8850100126030', 2, 1),
(188, 'Biosafety Neon Toothbrush 1+1', '8850114340101', 2, 1),
(189, 'Farmhouse Sandwich Sliced Bread 480g', '8850123110108', 2, 1),
(190, 'Farmhouse Sandwich Wholewheat Bread 480g', '8850123110436', 2, 1),
(191, 'Farmhouse Cookies Mixed Fruit 50g', '8850123392016', 2, 1),
(192, 'Farmhouse Butter Cookies 50g', '8850123392030', 2, 1),
(193, 'Farmhouse Butter Cookies Chocolate 50g', '8850123392610', 3, 1),
(194, 'Maggi Oyster sauce 680ml', '8850124000675', 3, 1),
(195, 'Nescafe Coffe 3 in 1  19.7g', '8850124034519', 2, 1),
(196, 'Maggi Soya sauce 700ml', '8850124065421', 2, 1),
(197, 'Nestle Bear Brand UHT Malted 180ml', '8850125091504', 2, 1),
(198, 'Nestle Bear Brand UHT Malted 180ml P*4', '8850125091511', 2, 1),
(199, 'Nescafe Coffe 3 in 1  19.7g P*27', '8850127004397', 2, 1),
(200, 'Nescafe Coffe 3 in 1  19.7g C*648', '8850127068948', 2, 1),
(201, 'KNORR CUBE TOMYAM (NEW) P24X24G', '8850144058199', 1, 1),
(202, 'KNORR CUBE TOMYAM (NEW) 24G', '8850144059097', 1, 1),
(203, 'KNORR CUBE PORK (ARARAT) 24X20G', '8850144206385', 1, 1),
(204, 'KNORR CUBE PORK (ARARAT) 20G', '8850144206392', 2, 1),
(205, 'KNORR JOK CUP CHICKEN PD 6X32G', '8850144207863', 2, 1),
(206, 'KNORR JOK CUP CHICKEN PD 32G', '8850144207870', 1, 1),
(207, 'KNORR JOK CUP PORK ADM 6X35G', '8850144207887', 2, 1),
(208, 'KNORR JOK CUP PORK ADM 35G', '8850144207894', 2, 1),
(209, 'KNORR JOK CUP SHRIMP ADM 6X35G', '8850144208785', 2, 1),
(210, 'KNORR JOK CUP SHRIMP ADM 35G', '8850144208792', 2, 1),
(211, 'KNORR JOK CUP PK SEAWEED ADM 35G', '8850144213949', 2, 1),
(212, 'KNORR JOK CUP PK SEAWEED ADM 6X35G', '8850144214021', 2, 1),
(213, 'KNORR JOK CUP FISH PD 32G', '8850144215783', 2, 1),
(214, 'KNORR JOK CUP FISH PD 6X32G', '8850144215806', 2, 1),
(215, 'KNORR POWDER PORK BTF LA 100G', '8850144229247', 2, 1),
(216, 'KNORR POWDER PK 450G', '8850144229254', 2, 1),
(217, 'Mali Sweet Condensed Milk Easy Squeeze 170g', '8850151951377', 2, 1),
(218, 'Mali Sweet Condensed Milk Easy Squeeze 170g P*12', '8850151951384', 3, 1),
(219, 'Jele Beuatie Strawberry 140g ', '8850157100519', 3, 1),
(220, 'Jele Beautie Blackcurrant Flavor 140g', '8850157100557', 2, 1),
(221, 'Jele Beuatie Strawberry 140g P*3', '8850157102100', 2, 1),
(222, 'Jele Beuatie Strawberry 140g C*36', '8850157102117', 2, 1),
(223, 'Jele Beautie Blackcurrant Flavor 140g P*3', '8850157102186', 2, 1),
(224, 'Jele Beautie Blackcurrant Flavor 140g C*36', '8850157102193', 2, 1),
(225, 'Jele Beuatie Lychee 140g', '8850157102674', 2, 1),
(226, 'Jele Beuatie Lychee 140g P*3', '8850157102681', 1, 1),
(227, 'Jele Beuatie Lychee 140g C*36', '8850157102698', 1, 1),
(228, 'Magic farm Coconut jelly 240ml', '8850157550819', 1, 1),
(229, 'Magic farm Coconut jelly 240ml P*6', '8850157550826', 2, 1),
(230, 'Magic farm Coconut jelly 240ml C*36', '8850157550833', 2, 1),
(231, 'Cook Soybean oil 1000ml', '8850180010045', 1, 1),
(232, 'Sponsor Can 325ml', '8850228002841', 2, 1),
(233, 'Sponsor Can 325ml C*24', '8850228011836', 2, 1),
(234, 'Birdy Robusta Coffee 180ml ', '8850250000365', 2, 1),
(235, 'Yumyum bag Minced pork 63g ', '8850250000730', 2, 1),
(236, 'Yumyum bag Minced pork 63g  P*10', '8850250000731', 2, 1),
(237, 'Yumyum bag Minced pork 63g C*180', '8850250000732', 2, 1),
(238, 'Birdy Robusta Coffee 180ml P*6', '8850250002048', 2, 1),
(239, 'Yumyum bag Suki 55g', '8850250002079', 2, 1),
(240, 'Yumyum bag Suki 55g C*180', '8850250002080', 2, 1),
(241, 'Yumyum bag Suki 55g P*10', '8850250002081', 2, 1),
(242, 'yumyum bag Tomyumkoung red 63g ', '8850250002864', 2, 1),
(243, 'yumyum bag Tomyumkoung red 63g  P*10', '8850250002865', 3, 1),
(244, 'yumyum bag Tomyumkoung red 63g C*180 ', '8850250002866', 3, 1),
(245, 'Birdy Espresso Coffee 180ml', '8850250006015', 2, 1),
(246, 'Birdy Espresso Coffee 180ml P*6', '8850250006022', 2, 1),
(247, 'Yumyum cup seafood morfai 60g ', '8850250006770', 2, 1),
(248, 'Yumyum cup seafood morfai 60g P*6', '8850250006800', 2, 1),
(249, 'Yumyum cup Tomyumkoung creamy 60g', '8850250007838', 2, 1),
(250, 'Yumyum cup  Suki 55g', '8850250008279', 2, 1),
(251, 'Yumyum cup Tomyumkoung creamy 60g P*6', '8850250027836', 1, 1),
(252, 'Yumyum cup  Suki 55g P*6', '8850250028277', 1, 1),
(253, 'Yumyum bag Minced pork 63g P*30', '8850250170730', 1, 1),
(254, 'Yumyum bag Suki 55g P*30', '8850250172079', 2, 1),
(255, 'yumyum bag Tomyumkoung red 63g P*30', '8850250172864', 2, 1),
(256, 'Yumyum cup seafood morfai 60g C*36', '8850250226802', 1, 1),
(257, 'Birdy Robusta Coffee 180ml C*30', '8850250332046', 2, 1),
(258, 'Birdy Espresso Coffee 180ml C*30', '8850250336020', 2, 1),
(259, 'Lectasoy Original 300ml', '8850267112129', 2, 1),
(260, 'Lectasoy Chocolate 250ml', '8850267112136', 2, 1),
(261, 'Lectasoy Chocolate 250ml P*6', '8850267117131', 2, 1),
(262, 'Lectasoy Original 300ml P*6', '8850267117421', 2, 1),
(263, 'Clorets Original Mint 13.5g P*20', '8850338002304', 2, 1),
(264, 'Clorets Original Mint 13.5g', '8850338002311', 2, 1),
(265, 'Clorets Clearl Mint 13.5g', '8850338002922', 2, 1),
(266, 'Clorets Clearl Mint 13.5g P*20', '8850338002939', 2, 1),
(267, 'Semon 17g', '8850424001068', 2, 1),
(268, 'Euro cake 17g Custard ', '8850425002910', 3, 1),
(269, 'Euro cake 17g Custard P*12', '8850425002927', 3, 1),
(270, 'Euro butter cake 40g', '8850425003832', 2, 1),
(271, 'Euro butter cake 40g P*4', '8850425003849', 2, 1),
(272, 'Ellse cake 15g Vanilla', '8850425004747', 2, 1),
(273, 'Ellse cake 15g Vanilla P*24', '8850425004754', 2, 1),
(274, 'Ellse cake 15g Strawberry Jam', '8850425005416', 2, 1),
(275, 'Ellse cake 15g Strawberry Jam P*24', '8850425005423', 2, 1),
(276, 'Rasasurod Msg 250g', '8850464000267', 1, 1),
(277, 'Mae Ploy Chilli Suace', '8850496159704', 1, 1),
(278, 'Squid Fish Sauce 700ml', '8850620888289', 1, 1),
(279, 'Lays barbecue taste 50g P*6', '8850718701445', 2, 1),
(280, 'Lays Sour Cream 50g P*6', '8850718701490', 2, 1),
(281, 'Lays Nori Seaweed 50g P*6', '8850718701889', 1, 1),
(282, 'Tawan 3 flavor squid 17g P*12', '8850718704750', 2, 1),
(283, 'Tawan Seasoned Seaweed 17g P*12', '8850718707706', 2, 1),
(284, 'Lays barbecue taste 50g', '8850718801442', 2, 1),
(285, 'Lays Sour Cream 50g', '8850718801497', 2, 1),
(286, 'Lays Nori Seaweed 50g', '8850718801886', 2, 1),
(287, 'Tawan 3 flavor squid 17g', '8850718804757', 2, 1),
(288, 'Tawan Seasoned Seaweed 17g', '8850718807956', 2, 1),
(289, 'Lays barbecue taste 50g C*48', '8850718901449', 2, 1),
(290, 'Lays Nori Seaweed 50g C*48', '8850718901883', 2, 1),
(291, 'Tawan 3 flavor squid 17g C*96', '8850718904754', 2, 1),
(292, 'Lays Sour Cream 50g C*48', '8850718906970', 2, 1),
(293, 'Tawan Seasoned Seaweed 17g C*96', '8850718908509', 3, 1),
(294, 'Spoon Refined Sugar 1kg', '8850725111015', 3, 1),
(295, 'Taiyo Lighter', '8850725111016', 2, 1),
(296, 'SB Dinopark 55g P*3', '8850820202526', 2, 1),
(297, 'SB Dinopark 55g', '8850820202533', 2, 1),
(298, 'SB Dinopark 55g C*36', '8850820204414', 2, 1),
(299, 'Vitamilk Soya Bean Milk 300ml', '8851028001447', 2, 1),
(300, 'Vitamilk Soya Bean Milk 300ml P*3', '8851028001454', 2, 1),
(301, 'Sofy Body Fit Night Slim Wing 29cm. 4 pcs', '8851111105014', 1, 1),
(302, 'Sofy Body Fit Night Slim Wing 29cm. 16 pcs', '8851111105038', 1, 1),
(303, 'Sofy Body Fit Night Slim Wing 29cm. 4 pcs P*12', '8851111105229', 1, 1),
(304, 'Sofy Cooling Fresh Super Ultra Slim Wing 23cm. 16pcs', '8851111115037', 2, 1),
(305, 'Sofy Cooling Fresh Night Super Ultra Slim Wing 29cm. 12 pcs', '8851111139033', 2, 1),
(306, 'Sofy Cooling Fresh Natural Night Super Ultra Slim Wing 29cm. 10 pcs', '8851111139071', 1, 1),
(307, 'Sofy Body Fit Slim Wing 4 pcs. C*120', '8851111142293', 2, 1),
(308, 'Sofy Cooling Fresh Slim Wing 23cm. 14 pcs.', '8851111153053', 2, 1),
(309, 'Sofy Cooling Fresh Slim Wing 23cm. 4 pcs.', '8851111153060', 2, 1),
(310, 'Sofy Cooling Fresh Natural Slim Wing 23cm. 4Pcs.', '8851111153152', 2, 1),
(311, 'Sofy Cooling Fresh Natural Super Slim0.1 Wing 23cm. 14Pcs.', '8851111157037', 2, 1),
(312, 'Sofy Cooling Fresh Extra Super Slim Wing 25cm. 12pcs', '8851111158072', 2, 1),
(313, 'Sofy Cooling Fresh Night Slim Wing 29cm. 5 pcs', '8851111159017', 2, 1),
(314, 'Sofy Cooling Fresh Night Slim Wing 29cm. 5 pcs P*6', '8851111159024', 2, 1),
(315, 'Sofy Cooling Fresh Extra Night Slim Wing 29cm. 4pcs', '8851111159130', 2, 1),
(316, 'Sofy Body Fit Night Slim Wing 35cm. 14 pcs', '8851111162055', 2, 1),
(317, 'Sofy Charcoal Fresh Night Wing 29cm 14pcs', '8851111180035', 2, 1),
(318, 'Sofy Charcoal Fresh Slim Wing 23cm 4pcs', '8851111198016', 3, 1),
(319, 'Sofy Charcoal Fresh Slim Wing 23cm 4pcs P*6', '8851111198023', 3, 1),
(320, 'Sofy Charcoal Fresh Ultra Slim Wing 23cm 16pcs', '8851111199051', 2, 1),
(321, 'Sofy Pantyliner Slim Pure Care Scented Sweet Rose 20pcs', '8851111260034', 2, 1),
(322, 'Sofy Pantyliner Slim Pure Care Scented Sweet Rose 20pcs P*6', '8851111260041', 2, 1),
(323, 'Sofy Pantyliner Slim Cooling Fresh Scented 16pcs', '8851111270019', 2, 1),
(324, 'Sofy Pantyliner Slim Cooling Fresh Scented 16pcs P*6', '8851111270026', 2, 1),
(325, 'Sofy Pantyliner Slim Cooling Fresh Scented 32pcs', '8851111270033', 2, 1),
(326, 'Sofy Cooling Fresh Natural Slim Scented 16 pcs.', '8851111270088', 1, 1),
(327, 'Sofy Cooling Fresh Natural Slim Scented 16 pcs. P*6', '8851111270095', 1, 1),
(328, 'Sofy Cooling Fresh Natural Slim Scented 32 pcs.', '8851111270101', 1, 1),
(329, 'Sofy Body Fit Slim Wing 4 pcs.', '8851111300013', 2, 1),
(330, 'Mamypoko New Born 24', '8851111400423', 2, 1),
(331, 'Mamypoko New Born 4+1(2)', '8851111403110', 1, 1),
(332, 'Mamypoko Happy Pants Day&Night S 19', '8851111417155', 2, 1),
(333, 'Mamypoko Happy Pants Day&Night M 74', '8851111418213', 2, 1),
(334, 'Mamypoko Happy Pants Day&Night M 17', '8851111418282', 2, 1),
(335, 'Mamypoko Happy Pants Day&Night L 14', '8851111419265', 2, 1),
(336, 'Mamypoko Happy Pants Day&Night L 62(4)', '8851111419425', 2, 1),
(337, 'Mamypoko Happy Pants Day&Night XL 13', '8851111420230', 2, 1),
(338, 'Mamypoko Happy Pants Day&Night XL 54(4)', '8851111420384', 2, 1),
(339, 'Mamypoko Happy Pants Day&Night XXL 11', '8851111421022', 2, 1),
(340, 'Mamypoko Happy Pants Day&Night XXL 48(4)', '8851111421046', 2, 1),
(341, 'MAMY POKO - WIPES Rakaprayad 70x2', '8851111423231', 2, 1),
(342, 'Lifree Dry Comfort Tape M 18', '8851111606030', 2, 1),
(343, 'Lifree Dry Comfort Tape L 15', '8851111607037', 3, 1),
(344, 'Lifree Light Pants M 10(4/C)', '8851111610020', 3, 1),
(345, 'Lifree Light Pants XL 8(4/C)', '8851111612024', 2, 1),
(346, 'M-150 150ml C*50', '8851123212267', 2, 1),
(347, 'M-Storm Original 150ml', '8851123220033', 2, 1),
(348, 'M-Storm Original 150ml P*10', '8851123220040', 2, 1),
(349, 'M-Storm Original 150ml C*50', '8851123220057', 2, 1),
(350, 'C-vitt Vitamin Lemon 140ml', '8851123237000', 2, 1),
(351, 'C-vitt Vitamin Lemon 140ml P*10', '8851123237017', 1, 1),
(352, 'C-vitt Vitamin Lemon 140ml C*30', '8851123237024', 1, 1),
(353, 'C-vitt Vitamin Orange 140ml', '8851123237031', 1, 1),
(354, 'C-vitt Vitamin Orange 140ml P*10', '8851123237048', 2, 1),
(355, 'C-vitt Vitamin Orange 140ml C*30', '8851123237055', 2, 1),
(356, 'M-150 150ml', '8851123240116', 1, 1),
(357, 'M-150 150ml P*10', '8851123240117', 2, 1),
(358, 'Poy Sian Inhaler', '8851447010006', 2, 1),
(359, 'Dutchie Original Yogurt 135g', '8851717020087', 2, 1),
(360, 'Dutchie Strawberry Yogurt 135g', '8851717020117', 2, 1),
(361, 'Dutchie Nata De Coco Yogurt 135g', '8851717020148', 2, 1),
(362, 'Dutchie Original Yogurt 135g P*4', '8851717021084', 2, 1),
(363, 'Dutchie Strawberry Yogurt 135g P*4', '8851717021114', 2, 1),
(364, 'Dutchie Nata De Coco Yogurt 135g P*4', '8851717021145', 2, 1),
(365, 'Dutchmill Delight Original 100ml', '8851717030239', 2, 1),
(366, 'Dutch Mill Yogurt Drink Strawberry Flavor 180ml', '8851717040016', 2, 1),
(367, 'Dutch Mill Yogurt Drink Mixed Fruits Flavor 180ml', '8851717040030', 2, 1),
(368, 'Dutch Mill Yogurt Drink Strawberry Flavor 180ml P*4', '8851717049019', 3, 1),
(369, 'Dutch Mill Yogurt Drink Mixed Fruits Flavor 180ml P*4', '8851717049033', 3, 1),
(370, 'Dutchmill Selected Pastuerized Milk 200ml', '8851717060014', 2, 1),
(371, 'Dutchmill Selected Pastuerized Chocolate Milk 200ml', '8851717060076', 2, 1),
(372, 'Dutchmill Selected Pastuerized Coffee Milk 200ml', '8851717060205', 2, 1),
(373, 'Dutchmill Delight low sugar 100ml', '8851717901331', 2, 1),
(374, 'Dutchmill Delight low sugar 100ml', '8851717902383', 2, 1),
(375, 'Dutchmill Delight Original 100ml', '8851717902598', 2, 1),
(376, 'Walls Cornetto Vanilla 110g', '8851932028103', 1, 1),
(377, 'Walls Asian Delight Taro 60g', '8851932030656', 1, 1),
(378, 'BREEZE MATIC (NEW) BUCKET P1X8000G', '8851932070829', 1, 1),
(379, 'Walls Cup Vanilla  55g', '8851932074025', 2, 1),
(380, 'Walls Top ten Vanilla 73g C*25', '8851932080149', 2, 1),
(381, 'SUNLIGHT LEMON TURBO SW 3600ML', '8851932082808', 1, 1),
(382, 'COMFORT DILUTE PINK 3600ML', '8851932090759', 2, 1),
(383, 'Walls Cornetto Chocoluv 88g', '8851932115919', 2, 1),
(384, 'Walls Cup Chocolate Chip  55g', '8851932126366', 2, 1),
(385, 'VASELINE DEEP RESTORE 3X350ML', '8851932143356', 2, 1),
(386, 'VASELINE DEEP RESTORE 350ML', '8851932143363', 2, 1),
(387, 'VASELINE HEALTHY HANDS&NAILS 3X85ML', '8851932143561', 2, 1),
(388, 'VASELINE HEALTHY HANDS&NAILS 85ML', '8851932143578', 2, 1),
(389, 'Walls Top ten Chocolate 73g ', '8851932145329', 2, 1),
(390, 'VASELINE ALOE SOOTHE 350ML', '8851932163392', 2, 1),
(391, 'VASELINE ALOE SOOTHE 3X350ML', '8851932167789', 2, 1),
(392, 'OMO REGULAR LEWIS N 430G', '8851932186100', 2, 1),
(393, 'OMO REGULAR LEWIS N P4X430G', '8851932186117', 3, 1),
(394, 'SUNLIGHT LEMON TURBO NEW 550ML', '8851932187428', 3, 1),
(395, 'BREEZE POWER RED PILLOW NEW 2700G', '8851932187589', 2, 1),
(396, 'COMFORT DILUTE BLUE 580ML', '8851932187985', 2, 1),
(397, 'COMFORT DILUTE PINK 580ML', '8851932188005', 2, 1),
(398, 'OMO REGULAR LEWIS N 2700G', '8851932188074', 2, 1),
(399, 'COMFORT DILUTE BLUE 3X580ML', '8851932191265', 2, 1),
(400, 'COMFORT DILUTE PINK 3X580ML', '8851932191289', 2, 1),
(401, 'CITRA PEARLY WH UV LOT 400ML', '8851932221184', 1, 1),
(402, 'DOVE SH INTENSE REPAIR DIA 480ML', '8851932227544', 1, 1),
(403, 'VASELINE HW UV LIGHTENING LOT 120ML', '8851932283892', 1, 1),
(404, 'VASELINE HW UV LIGHTENING LOT P3X120ML', '8851932283908', 2, 1),
(405, 'VASELINE HB UV EXTRA BRIGHTEN 320ML', '8851932283939', 2, 1),
(406, 'VASELINE HB UV EXTRA BRIGHTEN 3X320ML', '8851932283946', 1, 1),
(407, 'Walls Magnum Almond 90g', '8851932295789', 2, 1),
(408, 'Walls Magnum Classic 90g', '8851932295796', 2, 1),
(409, 'COMFORT ULTRA ONE RINSE BLACK 20ML', '8851932300681', 2, 1),
(410, 'COMFORT ULTRA ONE RINSE BLACK P12X20ML', '8851932300682', 2, 1),
(411, 'COMFORT ULTRA ONE RINSE BLACK P24X20ML', '8851932300698', 2, 1),
(412, 'Walls Paddle Pop Big Rocket Jelly 50g', '8851932316347', 2, 1),
(413, 'VASELINE INSTANT FAIR LOTION 350ML', '8851932316583', 2, 1),
(414, 'VASELINE INSTANT FAIR LOTION 3X350ML', '8851932316590', 2, 1),
(415, 'Walls Paddle Pop Mini Cola 60g', '8851932320948', 2, 1),
(416, 'LUX LIQ SOFT ROSE BT D (E) 900ML', '8851932332187', 2, 1),
(417, 'LUX SHW CRM SOFT ROSE BT 500ML', '8851932332262', 2, 1),
(418, 'LUX SHW CRM MAGICAL SPELL FB BT 500ML', '8851932332347', 3, 1),
(419, 'BREEZE POWER SWEET FLOWER NEW 2500G', '8851932347518', 3, 1),
(420, 'Walls Take home Taro 160g', '8851932348232', 2, 1),
(421, 'SUNSILK SH SOFT&SMOOTH OC 450ML', '8851932353823', 2, 1),
(422, 'SUNSILK SH DAMAGE RESTORE OC 450ML', '8851932353854', 2, 1),
(423, 'SUNSILK HC SOFT&SMOOTH SPR 425ML', '8851932354257', 2, 1),
(424, 'COMFORT LUX PURPLE GV 20ML', '8851932363365', 2, 1),
(425, 'COMFORT LUX PURPLE GV P12X20ML', '8851932363366', 2, 1),
(426, 'COMFORT LUX RED GV 20ML', '8851932363433', 1, 1),
(427, 'COMFORT LUX RED GV P12X20ML', '8851932363434', 1, 1),
(428, 'COMFORT LUX PURPLE GV P24X20ML', '8851932363495', 1, 1),
(429, 'COMFORT LUX RED GV P24X20ML', '8851932363549', 2, 1),
(430, 'COMFORT ULTRA BLUE 4B MG 22ML', '8851932363730', 2, 1),
(431, 'COMFORT ULTRA BLUE 4B MG 22ML P*12', '8851932363731', 1, 1),
(432, 'COMFORT ULTRA PINK 4B MG 22ML', '8851932363747', 2, 1),
(433, 'COMFORT ULTRA PINK 4B MG P12X22ML', '8851932363748', 2, 1),
(434, 'COMFORT ULTRA BLUE 4B MG 24x22ML', '8851932363754', 2, 1),
(435, 'COMFORT ULTRA PINK 4B MG P24X22ML', '8851932363761', 2, 1),
(436, 'LUX SHW CRM SOFT ROSE TWIN 500ML', '8851932369367', 2, 1),
(437, 'LUX SHW CRM MAGICAL FB TWIN 500ML', '8851932369381', 2, 1),
(438, 'SUNLIGHT LEMON TURBO NEW 150ML', '8851932371025', 2, 1),
(439, 'SUNLIGHT LEMON TURBO NEW 6X150ML', '8851932371094', 2, 1),
(440, 'VASELINE PURE JELLY 50ML', '8851932375719', 2, 1),
(441, 'VASELINE PURE JELLY 3X50ML', '8851932375726', 2, 1),
(442, 'VASELINE MEN OIL MOIST 7G', '8851932383011', 2, 1),
(443, 'VASELINE MEN OIL MOIST P6X7G', '8851932383035', 3, 1),
(444, 'BREEZE POWER COLOR NEW 2500G', '8851932386432', 3, 1),
(445, 'Walls Cornetto Cookies and Cream 67g', '8851932387675', 2, 1),
(446, 'CITRA NATURAL WH AURA LOTION 400ML', '8851932387798', 2, 1),
(447, 'CITRA NATURAL WH AURA LOTION 3X400ML', '8851932387835', 2, 1),
(448, 'PONDS WHITE BEAUTY TONE UP CREAM 7G', '8851932389570', 2, 1),
(449, 'PONDS WHITE BEAUTY TONE UP CREAM 6X7G', '8851932389594', 2, 1),
(450, 'CITRA PINKISH WH UV LOT 400ML', '8851932391245', 2, 1),
(451, 'CITRA PINKISH WH UV LOT 3X400ML', '8851932391320', 1, 1),
(452, 'CLEAR SH CSC 2IN1 CARAT 480ML', '8851932391559', 1, 1),
(453, 'CLEAR SH SAKURA FRESH CARAT 480ML', '8851932391573', 1, 1),
(454, 'CLEAR MEN SH CSM CARAT 450ML', '8851932391627', 2, 1),
(455, 'CLEAR MEN SH DCLN CARAT 450ML', '8851932391634', 2, 1),
(456, 'CITRA PEARLY WH UV LOT 150ML', '8851932392556', 1, 1),
(457, 'CITRA PEARLY WH UV LOT 3X150ML', '8851932392563', 2, 1),
(458, 'SUNLIGHT LEMON TURBO C (LA) 750ML', '8851932398954', 2, 1),
(459, 'SUNLIGHT LEMON TURBO C (LA) P3X750ML', '8851932398955', 2, 1),
(460, 'Walls Top ten Double Choc 73g', '8851932406574', 2, 1),
(461, 'BREEZE MATIC REGULAR TISI 7500G', '8851932408066', 2, 1),
(462, 'COMFORT ULTRA GREEN 22ML', '8851932411639', 2, 1),
(463, 'COMFORT ULTRA GREEN P12X22ML', '8851932411640', 2, 1),
(464, 'COMFORT ULTRA GREEN P24X22ML', '8851932411714', 2, 1),
(465, 'OMO- MORNING FRESH N 2700G', '8851932430807', 2, 1),
(466, 'SUNSILK SH SMO SPL (LA) 5ML', '8851932434614', 2, 1),
(467, 'SUNSILK SH SMO SPL (LA) 60X5ML', '8851932434615', 2, 1),
(468, 'SUNSILK HC DAMAGE RESTORE(LA) 5ML', '8851932434621', 3, 1),
(469, 'SUNSILK HC DAMAGE RESTORE(LA) P12X5ML', '8851932434622', 3, 1),
(470, 'SUNSILK HC DAMAGE RESTORE(LA) P60X5ML', '8851932434623', 2, 1),
(471, 'SUNSILK SH SOFT&SMOOTH OC (LA) 5ML', '8851932434638', 2, 1),
(472, 'SUNSILK SH SOFT&SMOOTH OC (LA) P12X5ML', '8851932434639', 2, 1),
(473, 'SUNSILK SH SOFT&SMOOTH OC (LA) P60X5ML', '8851932434640', 2, 1),
(474, 'SUNSILK SH DAMAGE RES OC (LA) 5ML', '8851932434652', 2, 1),
(475, 'SUNSILK SH DAMAGE RES OC (LA) P12X5ML', '8851932434653', 2, 1),
(476, 'SUNSILK SH DAMAGE RES OC (LA) P60X5ML', '8851932434654', 1, 1),
(477, 'SUNSILK HC SMO SPL (LA) 5ML', '8851932434669', 1, 1),
(478, 'SUNSILK HC SMO SPL (LA) P12X5ML', '8851932434670', 1, 1),
(479, 'SUNSILK HC SMO SPL (LA) P60X5ML', '8851932434671', 2, 1),
(480, 'CLEAR SH ICM CARAT (LA) 5ML', '8851932434676', 2, 1),
(481, 'CLEAR SH ICM CARAT (LA) 5ML P*12', '8851932434677', 1, 1),
(482, 'CLEAR SH ICM CARAT (LA) 5ML P*60', '8851932434678', 2, 1),
(483, 'CLEAR SH CSC 2IN1 CARAT (LA) 5ML', '8851932434683', 2, 1),
(484, 'CLEAR SH CSC 2IN1 CARAT (LA) P12X5ML', '8851932434684', 2, 1),
(485, 'CLEAR SH CSC 2IN1 CARAT (LA) P60X5ML', '8851932434685', 2, 1),
(486, 'CLEAR MEN SH CSM CARAT (LA) 5ML', '8851932434706', 2, 1),
(487, 'CLEAR MEN SH CSM CARAT (LA) 12X5ML', '8851932434707', 2, 1),
(488, 'CLEAR MEN SH CSM CARAT (LA) 60X5ML', '8851932434708', 2, 1),
(489, 'DOVE SH DLX INTENSE REPAIR(LA) 5ML', '8851932434713', 2, 1),
(490, 'DOVE SH DLX INTENSE REPAIR(LA) 12X5ML', '8851932434714', 2, 1),
(491, 'DOVE SH DLX INTENSE REPAIR(LA) 60X5ML', '8851932434715', 2, 1),
(492, 'DOVE HC INTENSE REPAIR DIA(LA) 5ML', '8851932434720', 2, 1),
(493, 'DOVE HC INTENSE REPAIR DIA(LA)12X5ML', '8851932434721', 3, 1),
(494, 'DOVE HC INTENSE REPAIR DIA(LA) 60X5ML', '8851932434722', 3, 1),
(495, 'Coke can 325ml P*12', '8851959000786', 2, 1),
(496, 'Fanta Green Cream can 325ml P*12', '8851959000823', 2, 1),
(497, 'Sprite can 325ml P*12', '8851959000830', 2, 1),
(498, 'Minute maid pulpy Orange Bottle 290ml P*12', '8851959000908', 2, 1),
(499, 'Coke can 325ml', '8851959132012', 2, 1),
(500, 'Fanta Strawberry can 325ml', '8851959132173', 2, 1),
(501, 'Fanta Green Cream can 325ml', '8851959132180', 1, 1),
(502, 'Sprite can 325ml', '8851959132364', 1, 1),
(503, 'Schwepper Lime 330ml', '8851959132678', 1, 1),
(504, 'Minute maid pulpy Orange Bottle 290ml', '8851959140949', 2, 1),
(505, 'Coke Bottle 500ml', '8851959141014', 2, 1),
(506, 'Coke 1250ml', '8851959144015', 1, 1),
(507, 'Fanta Strawberry 1250ml', '8851959144176', 2, 1),
(508, 'Fanta Green Cream 1250ml', '8851959144183', 2, 1),
(509, 'Fanta  Orange Bottle 450ml', '8851959158166', 2, 1),
(510, 'Fanta Strawberry Bottle 450ml', '8851959158173', 2, 1),
(511, 'Fanta Green Cream Bottle 450ml', '8851959158180', 2, 1),
(512, 'Sprite Bottle 450ml', '8851959158364', 2, 1),
(513, 'Fanta Strawberry can 325ml P*24', '8851959232170', 2, 1),
(514, 'Coke 1250ml P*6', '8851959444016', 2, 1),
(515, 'Fanta Strawberry 1250ml P*6', '8851959444177', 2, 1),
(516, 'Fanta Green Cream 1250ml P*6', '8851959444184', 2, 1),
(517, 'Coke Bottle 500ml P*12', '8851959458013', 2, 1),
(518, 'Fanta  Orange Bottle 450ml P*12', '8851959458167', 3, 1),
(519, 'Fanta Strawberry Bottle 450ml P*12', '8851959458174', 3, 1),
(520, 'Fanta Green Cream Bottle 450ml P*12', '8851959458181', 2, 1),
(521, 'Sprite Bottle 450ml P*12', '8851959458365', 2, 1),
(522, 'Schwepper Lime 330ml P*6', '8851959632673', 2, 1),
(523, 'Taro Bar B Q 13.6g', '8852044180314', 2, 1),
(524, 'Taro Bar B Q 13.6g P*6', '8852044190313', 2, 1),
(525, 'Taro Korean Seaweed 13.6g', '8852044507814', 2, 1),
(526, 'Taro Korean Seaweed 13.6g P*6', '8852044567818', 1, 1),
(527, 'Ruaypuan 20g', '8852052150101', 1, 1),
(528, 'Ruaypuan 20g P*12', '8852052350105', 1, 1),
(529, 'Roller Corn Milk Flavor 25g', '8852681010012', 2, 1),
(530, 'Roller Corn Milk Flavor 25g P*12', '8852681010013', 2, 1),
(531, 'Roller Corn Chocolate Flavor 25g', '8852681010029', 1, 1),
(532, 'Roller Corn Chocolate Flavor 25g C*12', '8852681010030', 2, 1),
(533, 'Dna Sesame X2 180ml', '8853002080066', 2, 1),
(534, 'Dna Sesame X2 180ml C*48', '8853002080073', 2, 1),
(535, 'Dna Sesame X2 180ml P*4', '8853002080110', 2, 1),
(536, 'Dutch Mill Yogurt Drink Mixed Berries Flavor 180ml', '8853002302038', 2, 1),
(537, 'Dutch Mill Yogurt Drink Mixed Berries Flavor 180ml P*4', '8853002302045', 2, 1),
(538, 'Oishi Greentea Honey Lemon 380ml', '8854698009669', 2, 1),
(539, 'Oishi Greentea Honey Lemon 380ml C*24', '8854698009799', 2, 1),
(540, 'TKN Seaweed Classic Flavour 8g', '8857107230050', 2, 1),
(541, 'TKN Seaweed Classic Flavour 8g P*12', '8857107230051', 2, 1),
(542, 'TKN Seaweed Hot & Spicy Flavour 8g', '8857107230081', 2, 1),
(543, 'TKN Seaweed Hot & Spicy Flavour 8g P*12', '8857107230082', 3, 1),
(544, 'TKN Seaweed Classic Flavour 8g C*120', '8857107230210', 3, 1),
(545, 'TKN Seaweed Hot & Spicy Flavour 8g C*120', '8857107230227', 2, 1),
(546, 'Ichitan Green Tea Genmai 420ml', '8858891300264', 2, 1),
(547, 'Ichitan Green Tea Genmai 420ml C*24', '8858891300288', 2, 1),
(548, 'Yenyen Chrysanthemum Honey 400ml', '8858891301728', 2, 1),
(549, 'Yenyen Chrysanthemum Honey 400ml C*24', '8858891301759', 2, 1),
(550, 'Mae Boonlam Fermented Fish Sauce 400ml', '8858981500031', 2, 1),
(551, 'Mae Boonlam Fermented Fish Sauce 400ml P*12', '8858981501335', 1, 1),
(552, 'Plearn Refined Palm Oil 1000ml', '8859105800112', 1, 1),
(553, 'Sting Energy Berry Blast 330ml', '8859313500484', 1, 1),
(554, 'Sting Energy Berry Blast 330ml P*24', '8859313500485', 2, 1),
(555, 'Sting Energy Gold Rush 330ml', '8859313500491', 2, 1),
(556, 'Sting Energy Gold Rush 330ml P*24', '8859313500492', 1, 1),
(557, 'Dao Coffee Original 20g 25 Sachet ', '8859448902245', 2, 1),
(558, 'Dao Coffee Espresso 20g 25 Sachet ', '8859448902252', 2, 1),
(559, 'Dao Coffee Turbo 20g 25 Sachet ', '8859448902269', 2, 1),
(560, 'Mamypoko New Born 4+1(2) C*12', '88851111403053', 2, 1),
(561, 'Mamypoko Happy Pants Day&Night S 19 C*8', '88851111417151', 2, 1),
(562, 'Mamypoko Happy Pants Day&Night M 17 C*8', '88851111418288', 2, 1),
(563, 'Mamypoko Happy Pants Day&Night L 14 C*8', '88851111419261', 2, 1),
(564, 'Mamypoko Happy Pants Day&Night XL 13 C*8', '88851111420236', 2, 1),
(565, 'Mamypoko Happy Pants Day&Night XXL 11 C*8', '88851111421028', 2, 1),
(566, 'Scott Compack Pack 2', '8888336007960', 2, 1),
(567, 'Scott Box 115 s', '8888336013824', 2, 1),
(568, 'Scott Box 115 s P*4', '8888336013831', 3, 1),
(569, 'CLOSE UP TP MENTHOL FRESH 30G', '8934839120641', 3, 1),
(570, 'CLOSE UP TP MENTHOL FRESH 12X30G', '8934839120658', 2, 1),
(571, 'CLOSE UP TP MENTHOL FRESH 160G', '8934839120665', 2, 1),
(572, 'CLOSE UP TP MENTHOL FRESH P6X160G', '8934839120672', 2, 1),
(573, 'PONDS WHITE BEAUTY FF PNCL 100G', '8999999053031', 2, 1),
(574, 'PONDS PURE WHITE FC FOAM 100G', '8999999053048', 2, 1),
(575, 'PONDS WHITE BEAUTY FF PNCL6X100G', '8999999056278', 2, 1),
(576, 'PONDS PURE WHITE FC FOAM 6X100G', '8999999056285', 1, 1),
(577, 'VASELINE MEN WHITE P2X6X100G', '8999999167677', 1, 1),
(578, 'Maggi Oyster sauce 680ml C*12', '90850125074866', 1, 1),
(580, 'ຕຸກນ້ຳ', '12345', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_item_extract`
--

CREATE TABLE `tbl_item_extract` (
  `iex_id` int(11) NOT NULL,
  `item_id` int(11) DEFAULT NULL,
  `item_id_extract` int(11) DEFAULT NULL,
  `extract_values` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_item_pack_type`
--

CREATE TABLE `tbl_item_pack_type` (
  `ipt_id` int(11) NOT NULL,
  `ipt_name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_item_pack_type`
--

INSERT INTO `tbl_item_pack_type` (`ipt_id`, `ipt_name`) VALUES
(1, 'ອັນ'),
(2, 'ແພັກ'),
(3, 'ແກັດ');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_item_price`
--

CREATE TABLE `tbl_item_price` (
  `ip_id` int(11) NOT NULL,
  `item_id` int(11) DEFAULT NULL,
  `item_price` int(11) DEFAULT NULL,
  `br_id` int(11) DEFAULT NULL,
  `status_item_price` int(11) DEFAULT NULL,
  `add_by` int(11) DEFAULT NULL,
  `date_register` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_item_price`
--

INSERT INTO `tbl_item_price` (`ip_id`, `item_id`, `item_price`, `br_id`, `status_item_price`, `add_by`, `date_register`) VALUES
(1, 10, 5000, 2, 1, 6, '2023-05-22'),
(2, 9, 7000, 2, 1, 6, '2023-05-22'),
(3, 8, 3000, 2, 1, 6, '2023-05-22'),
(4, 7, 4000, 2, 1, 6, '2023-05-22'),
(5, 6, 4000, 2, 1, 6, '2023-05-22'),
(6, 5, 1000, 2, 1, 6, '2023-05-22'),
(7, 4, 5000, 2, 1, 6, '2023-05-22'),
(8, 3, 1000, 2, 1, 6, '2023-05-22'),
(9, 2, 5000, 2, 1, 6, '2023-05-22'),
(10, 1, 500, 2, 1, 6, '2023-05-22'),
(11, 15, 3000, 2, 1, 6, '2023-05-23'),
(12, 14, 5000, 2, 1, 6, '2023-05-23'),
(13, 13, 10000, 2, 1, 6, '2023-05-23'),
(14, 12, 5000, 2, 1, 6, '2023-05-23'),
(15, 11, 10000, 2, 1, 6, '2023-05-23');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_order_request`
--

CREATE TABLE `tbl_order_request` (
  `or_id` int(11) NOT NULL,
  `or_bill_number` varchar(30) DEFAULT NULL,
  `br_id` int(11) DEFAULT NULL,
  `wh_id` int(11) DEFAULT NULL,
  `or_status` int(11) DEFAULT NULL,
  `add_by` int(11) DEFAULT NULL,
  `date_register` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_order_request`
--

INSERT INTO `tbl_order_request` (`or_id`, `or_bill_number`, `br_id`, `wh_id`, `or_status`, `add_by`, `date_register`) VALUES
(1, '202305220001', 2, 5, 2, 6, '2023-05-22'),
(2, '202305220002', 2, 6, 2, 6, '2023-05-22'),
(3, '202305230001', 2, 7, 2, 6, '2023-05-23'),
(4, '202305290001', 2, 5, 2, 6, '2023-05-29'),
(5, '202305290002', 2, 6, 2, 6, '2023-05-29'),
(6, '202305290003', 2, 7, 2, 6, '2023-05-29');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_order_request_detail`
--

CREATE TABLE `tbl_order_request_detail` (
  `ord_id` int(11) NOT NULL,
  `or_id` int(11) DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  `item_values` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_order_request_detail`
--

INSERT INTO `tbl_order_request_detail` (`ord_id`, `or_id`, `item_id`, `item_values`) VALUES
(1, 1, 10, 10),
(2, 1, 9, 2),
(3, 1, 8, 10),
(4, 1, 6, 30),
(5, 1, 7, 5),
(6, 2, 5, 10),
(7, 2, 4, 5),
(8, 2, 3, 3),
(9, 2, 2, 10),
(10, 2, 1, 20),
(11, 3, 15, 10),
(12, 3, 14, 10),
(13, 3, 13, 10),
(14, 3, 12, 10),
(15, 3, 11, 10),
(16, 4, 12, 20),
(17, 5, 13, 20),
(18, 5, 12, 35),
(19, 6, 15, 10),
(20, 6, 12, 3);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_order_status`
--

CREATE TABLE `tbl_order_status` (
  `os_id` int(11) NOT NULL,
  `os_name` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_order_status`
--

INSERT INTO `tbl_order_status` (`os_id`, `os_name`) VALUES
(1, 'ລໍຖ້າກວດສອບ'),
(2, 'ກວດສອບແລ້ວ'),
(3, 'ຍົກເລີກ');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_page_title`
--

CREATE TABLE `tbl_page_title` (
  `pt_id` int(11) NOT NULL,
  `pt_name` varchar(300) DEFAULT NULL,
  `ptf_name` varchar(100) DEFAULT NULL,
  `st_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_page_title`
--

INSERT INTO `tbl_page_title` (`pt_id`, `pt_name`, `ptf_name`, `st_id`) VALUES
(1, 'ພະແນກ', 'depart.php', 4),
(2, 'ຫນ້າຟັງຊັ້ນ', 'page-function.php', 4),
(3, 'ສ້າງສິດ', 'roles.php', 3),
(4, 'ຜູ້ໃຊ້', 'user-staff.php', 3),
(5, 'ຈັດການສິດ', 'role-manage.php ', 3),
(6, 'ສາງສິນຄ້າ', 'warehouse.php', 4),
(7, 'ສາຂາແຟນຊາຍ', 'branch.php', 4),
(8, 'ຂໍ້ມູນສິນຄ້າ', 'item-master-data.php', 2),
(10, 'ຮັບເຄື່ອງເຂົ້າສາງ', 'stock-in-admin.php', 2),
(11, 'ຂໍເບີກສິນຄ້າ', 'request-order.php', 2),
(12, 'ສິນຄ້າ-ລາຄາ', 'item-price.php', 2),
(13, 'ກວດສອບອໍເດີ້', 'request-order-check.php', 2),
(14, 'ເບີກສິນຄ້າອອກສາງ', 'approval-list.php', 2),
(15, 'ຮັບເຄື່ອງເຂົ້າຮ້ານ', 'receive-item-branch.php', 2),
(16, 'ເບີກສິນຄ້າເພື່ອຂາຍ', 'deburse-item-shop.php', 2),
(17, 'ຂາຍສິນຄ້າ', 'sale-item-for-customer.php', 5),
(18, 'ກະດານສັງລວມ', 'index.php', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_payment_type`
--

CREATE TABLE `tbl_payment_type` (
  `pt_id` int(11) NOT NULL,
  `payment_name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_payment_type`
--

INSERT INTO `tbl_payment_type` (`pt_id`, `payment_name`) VALUES
(1, 'ເງິນສົດ'),
(2, 'ເງິນໂອນ');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_roles`
--

CREATE TABLE `tbl_roles` (
  `r_id` int(11) NOT NULL,
  `role_name` varchar(150) DEFAULT NULL,
  `role_level` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_roles`
--

INSERT INTO `tbl_roles` (`r_id`, `role_name`, `role_level`) VALUES
(1, 'ຊຸບເປີແອັດມີນ', 1),
(2, 'ບັນຊີ', 4),
(3, 'ແອັດມີນສາງ', 3),
(4, 'ແອັດມີນລະບົບ', 2),
(5, 'ການຂາຍ', 3),
(6, 'ແຟນຊາຍ', 5),
(7, 'ແອັດມີນແຟນຊາຍ', 5);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_role_level`
--

CREATE TABLE `tbl_role_level` (
  `rl_id` int(11) NOT NULL,
  `rl_name` varchar(90) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_role_level`
--

INSERT INTO `tbl_role_level` (`rl_id`, `rl_name`) VALUES
(1, 'Level 1'),
(2, 'Level 2'),
(3, 'Level 3'),
(4, 'Level 4'),
(5, 'Level 5');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_role_page`
--

CREATE TABLE `tbl_role_page` (
  `rp_id` int(11) NOT NULL,
  `role_id` int(11) DEFAULT NULL,
  `ht_id` int(11) DEFAULT NULL,
  `st_id` int(11) DEFAULT NULL,
  `pt_id` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_role_page`
--

INSERT INTO `tbl_role_page` (`rp_id`, `role_id`, `ht_id`, `st_id`, `pt_id`) VALUES
(228, 1, 4, 5, 17),
(227, 1, 3, 4, 7),
(226, 1, 3, 4, 6),
(225, 1, 3, 4, 2),
(224, 1, 3, 4, 1),
(223, 1, 2, 3, 5),
(194, 6, 3, 4, 6),
(21, 7, 2, 3, 4),
(22, 7, 3, 4, 6),
(23, 4, 2, 3, 4),
(24, 4, 2, 3, 5),
(25, 4, 3, 4, 1),
(26, 4, 3, 4, 2),
(27, 4, 3, 4, 6),
(28, 4, 3, 4, 7),
(222, 1, 2, 3, 4),
(221, 1, 2, 3, 3),
(220, 1, 1, 2, 16),
(219, 1, 1, 2, 15),
(218, 1, 1, 2, 14),
(217, 1, 1, 2, 13),
(216, 1, 1, 2, 12),
(193, 6, 2, 3, 4),
(192, 6, 1, 2, 16),
(191, 6, 1, 2, 15),
(113, 3, 1, 2, 8),
(114, 3, 1, 2, 10),
(115, 3, 1, 2, 12),
(116, 3, 1, 2, 13),
(117, 3, 1, 2, 14),
(118, 3, 2, 3, 4),
(119, 3, 3, 4, 6),
(190, 6, 1, 2, 12),
(189, 6, 1, 2, 11),
(215, 1, 1, 2, 11),
(214, 1, 1, 2, 10),
(195, 6, 4, 5, 17),
(213, 1, 1, 2, 8);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_stock_in_warehouse`
--

CREATE TABLE `tbl_stock_in_warehouse` (
  `siw_id` int(11) NOT NULL,
  `siw_bill_number` varchar(30) DEFAULT NULL,
  `apo_id` int(11) DEFAULT NULL,
  `bill_type` int(11) DEFAULT NULL,
  `br_id` int(11) DEFAULT NULL,
  `wh_id` int(11) DEFAULT NULL,
  `add_by` int(11) DEFAULT NULL,
  `date_register` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_stock_in_warehouse`
--

INSERT INTO `tbl_stock_in_warehouse` (`siw_id`, `siw_bill_number`, `apo_id`, `bill_type`, `br_id`, `wh_id`, `add_by`, `date_register`) VALUES
(4, '202305290001', NULL, 1, 1, 1, 3, '2023-05-29'),
(7, '202305290002', NULL, 1, 1, 1, 3, '2023-05-29'),
(8, '202305290003', NULL, 1, 1, 1, 3, '2023-05-29'),
(9, '202305290004', NULL, 1, 1, 1, 3, '2023-05-29'),
(10, '202305300001', NULL, 1, 1, 1, 3, '2023-05-30'),
(11, '202305300002', NULL, 1, 1, 1, 3, '2023-05-30'),
(12, '202305300003', NULL, 1, 1, 1, 3, '2023-05-30'),
(13, '202305300004', NULL, 1, 1, 1, 3, '2023-05-30'),
(14, '202305300005', NULL, 1, 1, 1, 3, '2023-05-30'),
(15, '202305300006', NULL, 1, 1, 1, 3, '2023-05-30'),
(16, '202305300007', NULL, 1, 1, 1, 3, '2023-05-30'),
(17, '202305300001', 14, 2, 2, 6, 6, '2023-05-30');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_stock_in_warehouse_detail`
--

CREATE TABLE `tbl_stock_in_warehouse_detail` (
  `siwd_id` int(11) NOT NULL,
  `siw_id` int(11) DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  `item_values` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_stock_in_warehouse_detail`
--

INSERT INTO `tbl_stock_in_warehouse_detail` (`siwd_id`, `siw_id`, `item_id`, `item_values`) VALUES
(48, 4, 1, 10),
(49, 4, 11, 200),
(50, 4, 2, 30),
(51, 4, 4, 12),
(52, 4, 12, 10),
(53, 8, 15, 15),
(54, 10, 12, 100),
(55, 11, 12, 30),
(56, 12, 12, 10),
(57, 13, 13, 120),
(58, 14, 14, 30),
(59, 15, 15, 15),
(60, 16, 4, 45),
(61, 17, 13, 1),
(62, 17, 12, 2);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_stock_in_warehouse_detail_pre`
--

CREATE TABLE `tbl_stock_in_warehouse_detail_pre` (
  `siwdp_id` int(11) NOT NULL,
  `item_id` int(11) DEFAULT NULL,
  `item_values` int(11) DEFAULT NULL,
  `add_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_stock_out_warehouse`
--

CREATE TABLE `tbl_stock_out_warehouse` (
  `sow_id` int(11) NOT NULL,
  `sow_bill_number` varchar(30) DEFAULT NULL,
  `bill_type` int(11) DEFAULT NULL,
  `apo_id` int(11) DEFAULT NULL,
  `br_id` int(11) DEFAULT NULL,
  `wh_id` int(11) DEFAULT NULL,
  `add_by` int(11) DEFAULT NULL,
  `date_register` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_stock_out_warehouse`
--

INSERT INTO `tbl_stock_out_warehouse` (`sow_id`, `sow_bill_number`, `bill_type`, `apo_id`, `br_id`, `wh_id`, `add_by`, `date_register`) VALUES
(3, '202305290001', 1, 9, 1, 1, 3, '2023-05-29'),
(4, '202305300001', 1, 11, 1, 1, 3, '2023-05-30'),
(5, '202305300002', 1, 12, 1, 1, 3, '2023-05-30'),
(21, '202305300003', 1, 12, 1, 1, 3, '2023-05-30'),
(22, '202305300004', 1, 12, 1, 1, 3, '2023-05-30'),
(23, '202305300005', 1, 12, 1, 1, 3, '2023-05-30'),
(24, '202305300006', 1, 13, 1, 1, 3, '2023-05-30'),
(25, '202305300007', 1, 14, 1, 1, 3, '2023-05-30'),
(26, '202305300008', 1, 1, 1, 1, 3, '2023-05-30');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_stock_out_warehouse_detail`
--

CREATE TABLE `tbl_stock_out_warehouse_detail` (
  `sowd_id` int(11) NOT NULL,
  `sow_id` int(11) DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  `item_values` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_stock_out_warehouse_detail`
--

INSERT INTO `tbl_stock_out_warehouse_detail` (`sowd_id`, `sow_id`, `item_id`, `item_values`) VALUES
(8, 3, 12, 3),
(9, 3, 15, 10),
(10, 4, 12, 20),
(11, 5, 11, 10),
(12, 5, 12, 10),
(13, 5, 13, 10),
(32, 21, 14, 4),
(34, 22, 14, 6),
(35, 23, 15, 10),
(36, 24, 1, 20),
(37, 24, 2, 10),
(38, 24, 3, 3),
(39, 24, 4, 5),
(40, 24, 5, 10),
(41, 25, 12, 35),
(42, 25, 13, 20),
(43, 26, 7, 5),
(44, 26, 6, 30),
(45, 26, 8, 10),
(46, 26, 9, 2),
(47, 26, 10, 10);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_stock_out_warehouse_detail_pre`
--

CREATE TABLE `tbl_stock_out_warehouse_detail_pre` (
  `sowdp_id` int(11) NOT NULL,
  `wh_id` int(11) DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  `item_values` int(11) DEFAULT NULL,
  `apo_id` int(11) DEFAULT NULL,
  `add_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_stock_out_warehouse_detail_pre`
--

INSERT INTO `tbl_stock_out_warehouse_detail_pre` (`sowdp_id`, `wh_id`, `item_id`, `item_values`, `apo_id`, `add_by`) VALUES
(138, 6, 13, 1, NULL, 6);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_sub_title`
--

CREATE TABLE `tbl_sub_title` (
  `st_id` int(11) NOT NULL,
  `st_name` varchar(300) DEFAULT NULL,
  `icon_code` varchar(100) DEFAULT NULL,
  `ht_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_sub_title`
--

INSERT INTO `tbl_sub_title` (`st_id`, `st_name`, `icon_code`, `ht_id`) VALUES
(1, 'ລູກຄ້າ', 'mdi-home-account', 1),
(2, 'ສິນຄ້າ', 'mdi-expand-all', 1),
(3, 'ຜູ້ໃຊ້', 'mdi-account-supervisor', 2),
(4, 'ຂໍ້ມູນລະບົບ', 'mdi-server', 3),
(5, 'ການຂາຍ', 'mdi-palette-swatch', 4),
(6, 'ຢ້ຽມຢາມ', 'mdi-flag-variant', 4);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

CREATE TABLE `tbl_user` (
  `usid` int(11) NOT NULL,
  `full_name` varchar(300) DEFAULT NULL,
  `user_name` varchar(30) DEFAULT NULL,
  `user_password` varchar(30) DEFAULT NULL,
  `role_id` int(11) DEFAULT NULL,
  `depart_id` int(11) DEFAULT NULL,
  `br_id` int(11) DEFAULT NULL,
  `user_status` int(11) DEFAULT NULL,
  `add_by` int(11) DEFAULT NULL,
  `date_register` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`usid`, `full_name`, `user_name`, `user_password`, `role_id`, `depart_id`, `br_id`, `user_status`, `add_by`, `date_register`) VALUES
(1, 'ຊຸບເປິແອັດມີນ', 'superadmin', '123', 1, 1, 1, 1, 1, '2023-03-13'),
(2, 'ບັນຊີ', 'accountant', '123', 2, 2, 1, 1, 1, '2023-03-13'),
(3, 'ແອັດມີນສາງ', 'adminstock', '123', 3, 3, 1, 1, 1, '2023-03-13'),
(4, 'ແອັດມິນລະບົບ', 'adminsystem', '123', 4, 1, 1, 1, 1, '2023-03-13'),
(5, 'ການຂາຍ', 'sale', '123', 5, 4, 1, 1, 1, '2023-03-13'),
(6, 'ສາຂາໜອງດ້ວງ', 'nongduang', '123', 6, 5, 2, 1, 1, '2023-03-13'),
(7, 'billy', 'billy', '123', 7, 5, 2, 1, 6, '2023-03-13');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_warehouse`
--

CREATE TABLE `tbl_warehouse` (
  `wh_id` int(11) NOT NULL,
  `wh_name` varchar(150) DEFAULT NULL,
  `wh_status` int(11) DEFAULT NULL,
  `wh_type` int(11) DEFAULT NULL,
  `br_id` int(11) DEFAULT NULL,
  `add_by` int(11) DEFAULT NULL,
  `date_register` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_warehouse`
--

INSERT INTO `tbl_warehouse` (`wh_id`, `wh_name`, `wh_status`, `wh_type`, `br_id`, `add_by`, `date_register`) VALUES
(1, 'ສາງໃຫຍ່ວັດໄຕ', 1, 1, 1, 1, '2023-03-13'),
(3, 'ສາງໃຫຍ່ສີໄຄ', 1, 1, 1, 4, '2023-03-13'),
(5, 'ສາງໜອງດ້ວງ', 1, 2, 2, 6, '2023-04-26'),
(6, 'ສາງໜອງຕະຫລາດໜອງດ້ວງ', 1, 2, 2, 6, '2023-04-26'),
(7, 'ສາຂາໜອງດ້ວງໃຫມ່', 1, 2, 2, 6, '2023-05-08');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_warehouse_type`
--

CREATE TABLE `tbl_warehouse_type` (
  `wht_id` int(11) NOT NULL,
  `wht_name` varchar(90) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_warehouse_type`
--

INSERT INTO `tbl_warehouse_type` (`wht_id`, `wht_name`) VALUES
(1, 'ສາງໃຫຍ່'),
(2, 'ສາງສາຂາ'),
(3, 'ສາງແຟນໄຊນ');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_approve_order`
--
ALTER TABLE `tbl_approve_order`
  ADD PRIMARY KEY (`apo_id`);

--
-- Indexes for table `tbl_approve_order_detail`
--
ALTER TABLE `tbl_approve_order_detail`
  ADD PRIMARY KEY (`apod_id`);

--
-- Indexes for table `tbl_bill_sale`
--
ALTER TABLE `tbl_bill_sale`
  ADD PRIMARY KEY (`bs_id`);

--
-- Indexes for table `tbl_bill_sale_detail`
--
ALTER TABLE `tbl_bill_sale_detail`
  ADD PRIMARY KEY (`bsd_id`);

--
-- Indexes for table `tbl_bill_sale_detail_pre`
--
ALTER TABLE `tbl_bill_sale_detail_pre`
  ADD PRIMARY KEY (`bsdp_id`);

--
-- Indexes for table `tbl_bill_type`
--
ALTER TABLE `tbl_bill_type`
  ADD PRIMARY KEY (`bt_id`);

--
-- Indexes for table `tbl_branch`
--
ALTER TABLE `tbl_branch`
  ADD PRIMARY KEY (`br_id`);

--
-- Indexes for table `tbl_branch_type`
--
ALTER TABLE `tbl_branch_type`
  ADD PRIMARY KEY (`brt_id`);

--
-- Indexes for table `tbl_deburse_item_pre_sale`
--
ALTER TABLE `tbl_deburse_item_pre_sale`
  ADD PRIMARY KEY (`dips_id`);

--
-- Indexes for table `tbl_deburse_item_pre_sale_detail`
--
ALTER TABLE `tbl_deburse_item_pre_sale_detail`
  ADD PRIMARY KEY (`dipsd_id`);

--
-- Indexes for table `tbl_depart`
--
ALTER TABLE `tbl_depart`
  ADD PRIMARY KEY (`dp_id`);

--
-- Indexes for table `tbl_header_title`
--
ALTER TABLE `tbl_header_title`
  ADD PRIMARY KEY (`ht_id`);

--
-- Indexes for table `tbl_item_data`
--
ALTER TABLE `tbl_item_data`
  ADD PRIMARY KEY (`item_id`);

--
-- Indexes for table `tbl_item_extract`
--
ALTER TABLE `tbl_item_extract`
  ADD PRIMARY KEY (`iex_id`);

--
-- Indexes for table `tbl_item_pack_type`
--
ALTER TABLE `tbl_item_pack_type`
  ADD PRIMARY KEY (`ipt_id`);

--
-- Indexes for table `tbl_item_price`
--
ALTER TABLE `tbl_item_price`
  ADD PRIMARY KEY (`ip_id`);

--
-- Indexes for table `tbl_order_request`
--
ALTER TABLE `tbl_order_request`
  ADD PRIMARY KEY (`or_id`);

--
-- Indexes for table `tbl_order_request_detail`
--
ALTER TABLE `tbl_order_request_detail`
  ADD PRIMARY KEY (`ord_id`);

--
-- Indexes for table `tbl_order_status`
--
ALTER TABLE `tbl_order_status`
  ADD PRIMARY KEY (`os_id`);

--
-- Indexes for table `tbl_page_title`
--
ALTER TABLE `tbl_page_title`
  ADD PRIMARY KEY (`pt_id`);

--
-- Indexes for table `tbl_payment_type`
--
ALTER TABLE `tbl_payment_type`
  ADD PRIMARY KEY (`pt_id`);

--
-- Indexes for table `tbl_roles`
--
ALTER TABLE `tbl_roles`
  ADD PRIMARY KEY (`r_id`);

--
-- Indexes for table `tbl_role_level`
--
ALTER TABLE `tbl_role_level`
  ADD PRIMARY KEY (`rl_id`);

--
-- Indexes for table `tbl_role_page`
--
ALTER TABLE `tbl_role_page`
  ADD PRIMARY KEY (`rp_id`);

--
-- Indexes for table `tbl_stock_in_warehouse`
--
ALTER TABLE `tbl_stock_in_warehouse`
  ADD PRIMARY KEY (`siw_id`);

--
-- Indexes for table `tbl_stock_in_warehouse_detail`
--
ALTER TABLE `tbl_stock_in_warehouse_detail`
  ADD PRIMARY KEY (`siwd_id`);

--
-- Indexes for table `tbl_stock_in_warehouse_detail_pre`
--
ALTER TABLE `tbl_stock_in_warehouse_detail_pre`
  ADD PRIMARY KEY (`siwdp_id`);

--
-- Indexes for table `tbl_stock_out_warehouse`
--
ALTER TABLE `tbl_stock_out_warehouse`
  ADD PRIMARY KEY (`sow_id`);

--
-- Indexes for table `tbl_stock_out_warehouse_detail`
--
ALTER TABLE `tbl_stock_out_warehouse_detail`
  ADD PRIMARY KEY (`sowd_id`);

--
-- Indexes for table `tbl_stock_out_warehouse_detail_pre`
--
ALTER TABLE `tbl_stock_out_warehouse_detail_pre`
  ADD PRIMARY KEY (`sowdp_id`);

--
-- Indexes for table `tbl_sub_title`
--
ALTER TABLE `tbl_sub_title`
  ADD PRIMARY KEY (`st_id`);

--
-- Indexes for table `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`usid`);

--
-- Indexes for table `tbl_warehouse`
--
ALTER TABLE `tbl_warehouse`
  ADD PRIMARY KEY (`wh_id`);

--
-- Indexes for table `tbl_warehouse_type`
--
ALTER TABLE `tbl_warehouse_type`
  ADD PRIMARY KEY (`wht_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_approve_order`
--
ALTER TABLE `tbl_approve_order`
  MODIFY `apo_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `tbl_approve_order_detail`
--
ALTER TABLE `tbl_approve_order_detail`
  MODIFY `apod_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `tbl_bill_sale`
--
ALTER TABLE `tbl_bill_sale`
  MODIFY `bs_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tbl_bill_sale_detail`
--
ALTER TABLE `tbl_bill_sale_detail`
  MODIFY `bsd_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;

--
-- AUTO_INCREMENT for table `tbl_bill_sale_detail_pre`
--
ALTER TABLE `tbl_bill_sale_detail_pre`
  MODIFY `bsdp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=176;

--
-- AUTO_INCREMENT for table `tbl_bill_type`
--
ALTER TABLE `tbl_bill_type`
  MODIFY `bt_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_branch`
--
ALTER TABLE `tbl_branch`
  MODIFY `br_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_branch_type`
--
ALTER TABLE `tbl_branch_type`
  MODIFY `brt_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_deburse_item_pre_sale`
--
ALTER TABLE `tbl_deburse_item_pre_sale`
  MODIFY `dips_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_deburse_item_pre_sale_detail`
--
ALTER TABLE `tbl_deburse_item_pre_sale_detail`
  MODIFY `dipsd_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tbl_depart`
--
ALTER TABLE `tbl_depart`
  MODIFY `dp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbl_header_title`
--
ALTER TABLE `tbl_header_title`
  MODIFY `ht_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_item_data`
--
ALTER TABLE `tbl_item_data`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=584;

--
-- AUTO_INCREMENT for table `tbl_item_extract`
--
ALTER TABLE `tbl_item_extract`
  MODIFY `iex_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_item_pack_type`
--
ALTER TABLE `tbl_item_pack_type`
  MODIFY `ipt_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_item_price`
--
ALTER TABLE `tbl_item_price`
  MODIFY `ip_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `tbl_order_request`
--
ALTER TABLE `tbl_order_request`
  MODIFY `or_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_order_request_detail`
--
ALTER TABLE `tbl_order_request_detail`
  MODIFY `ord_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `tbl_order_status`
--
ALTER TABLE `tbl_order_status`
  MODIFY `os_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_page_title`
--
ALTER TABLE `tbl_page_title`
  MODIFY `pt_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `tbl_payment_type`
--
ALTER TABLE `tbl_payment_type`
  MODIFY `pt_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_roles`
--
ALTER TABLE `tbl_roles`
  MODIFY `r_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tbl_role_level`
--
ALTER TABLE `tbl_role_level`
  MODIFY `rl_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_role_page`
--
ALTER TABLE `tbl_role_page`
  MODIFY `rp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=229;

--
-- AUTO_INCREMENT for table `tbl_stock_in_warehouse`
--
ALTER TABLE `tbl_stock_in_warehouse`
  MODIFY `siw_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `tbl_stock_in_warehouse_detail`
--
ALTER TABLE `tbl_stock_in_warehouse_detail`
  MODIFY `siwd_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT for table `tbl_stock_in_warehouse_detail_pre`
--
ALTER TABLE `tbl_stock_in_warehouse_detail_pre`
  MODIFY `siwdp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=383;

--
-- AUTO_INCREMENT for table `tbl_stock_out_warehouse`
--
ALTER TABLE `tbl_stock_out_warehouse`
  MODIFY `sow_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `tbl_stock_out_warehouse_detail`
--
ALTER TABLE `tbl_stock_out_warehouse_detail`
  MODIFY `sowd_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `tbl_stock_out_warehouse_detail_pre`
--
ALTER TABLE `tbl_stock_out_warehouse_detail_pre`
  MODIFY `sowdp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=139;

--
-- AUTO_INCREMENT for table `tbl_sub_title`
--
ALTER TABLE `tbl_sub_title`
  MODIFY `st_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `usid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tbl_warehouse`
--
ALTER TABLE `tbl_warehouse`
  MODIFY `wh_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbl_warehouse_type`
--
ALTER TABLE `tbl_warehouse_type`
  MODIFY `wht_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
