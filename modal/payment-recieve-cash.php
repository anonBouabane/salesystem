<?php

include("../setting/checksession.php");
include("../setting/conn.php");




$row_price = $conn->query("

select sum(item_price) as total_price
from tbl_bill_sale_detail_pre a
left join tbl_item_price b on a.item_id = b.item_id and a.br_id = b.br_id
WHERE a.add_by = '$id_users'
group by  a.add_by 
")->fetch(PDO::FETCH_ASSOC);

if (empty($row_price['total_price'])) {
    $total_price = 0;
} else {
    $total_price = $row_price['total_price'];
}




?>

<fieldset style="width:543px;">
    <legend class="text-center">
        <i class="facebox-header">
            <i class="edit large icon text-center">ຍອດຊຳລະ: <?php echo number_format("$total_price", 0, ",", ".") ?> ກີບ
            </i>
        </i>
    </legend>
    <div class="col-md-12 mt-4">
        <form method="post" id="confirmpaymodal" name="pricecalculator">

            <div class="form-group">
                <div class="row">
                    <div class="col-lg-6">
                        ຮັບເງິນ
                    </div>
                    <div class="col-lg-6 text-right">
                        <label>ເງິນທອນ <span id="dollar"><?php echo "$total_price"; ?></span> (ກີບ)</label>
                        <input type="hidden" name="nairaRateToday" value="<?php echo "$total_price"; ?>">
                    </div>
                </div>
                <input type="number" name="monney_recieve" class="form-control" onchange="calculateTotal()" value="0" />
                <input type="hidden" name="monney_pay" value="<?php echo "$total_price"; ?>">
            </div>

            <div class="row   no-gutters justify-content-center">
                <div class="col-lg-3">
                    <div class="form-group">
                        <div class="custom-control custom-radio d-inline-block mr-3 mb-3">
                            <input type="radio" id="cash" name="paytype" value="1" class="custom-control-input" checked>
                            <label class="custom-control-label" for="cash">ເງິນສົດ</label>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="form-group">
                        <div class="custom-control custom-radio d-inline-block mr-3 mb-3">
                            <input type="radio" id="tran" name="paytype" value="2" class="custom-control-input">
                            <label class="custom-control-label" for="tran">ເງິນໂອນ</label>
                        </div>
                    </div>
                </div>
            </div>







            <div class="form-group" align="right">
                <button type="submit" class="btn btn-sm btn-primary">ຊຳລະເງິນ</button>
            </div>

            <table class="align-middle mb-0 table table-borderless  " id="tableList">
                <thead>
                    <tr>
                        <th>ຊື່ສິນຄ້າ</th>
                        <th>ຈຳນວນ</th>
                        <th>ລາຄາ</th>
                        <th>ລວມ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php

                    $total_bill_price = 0;
                    $stmt4 = $conn->prepare("select a.item_id,sum(item_values) as item_sale, item_name, item_price
                    from tbl_bill_sale_detail_pre a
                    left join tbl_item_data b on a.item_id = b.item_id
                    left join tbl_item_price c on a.item_id = c.item_id and a.br_id = c.br_id
                    where a.add_by = '$id_users' and a.br_id = '$br_id'
                    group by a.item_id,item_name,item_price ");

                    $stmt4->execute();
                    $i = 1;
                    if ($stmt4->rowCount() > 0) {
                        while ($row4 = $stmt4->fetch(PDO::FETCH_ASSOC)) {
                            $item_id = $row4['item_id'];
                            $item_name = $row4['item_name'];
                            $item_sale = $row4['item_sale'];
                            $item_price = $row4['item_price'];

                            $total_price = $item_sale * $item_price;

                    ?>
                    <tr>
                        <input type="hidden" name="item_id_modal[]" id="item_id_modal<?php echo $x; ?>"
                            value='<?php echo "$item_id"; ?>' class="form-control">
                        <td>
                            <?php
                                    echo mb_strimwidth("$item_name", 0, 50, "...");
                                    ?>
                        </td>
                        <td>
                            <input type="hidden" name="item_value[]" id="item_value<?php echo $x; ?>"
                                value='<?php echo "$item_sale"; ?>' class="form-control">

                            <?php echo "$item_sale"; ?>
                        </td>
                        <td>

                            <?php echo number_format("$item_price", 0, ",", ".") ?>
                        </td>
                        <td>
                            <input type="hidden" name="total_price[]" id="item_price_total<?php echo $x; ?>"
                                value='<?php echo "$total_price"; ?>' class="form-control">

                            <?php echo number_format("$total_price", 0, ",", ".") ?>
                        </td>


                    </tr>
                    <?php
                            $total_bill_price += $total_price;
                            $i++;
                        }
                    }
                    ?>
                </tbody>
            </table>



        </form>
    </div>
</fieldset>



<script type="text/javascript">
function calculateTotal() {

    var nairaRate = document.pricecalculator.nairaRateToday
    .value; //get NGN rate today from admin and assign to nairaRate


    dollarValue = eval(document.pricecalculator.monney_recieve.value -
    nairaRate); //multiply nairaInput by nairaRate to get dollarValue


    document.getElementById('dollar').innerHTML =
    dollarValue; //pass dollarValue to dollar to show auto-calculation onscreen
}
</script>