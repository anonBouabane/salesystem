<aside class="left-sidebar sidebar-dark" id="left-sidebar">
  <div id="sidebar" class="sidebar sidebar-with-footer">
    <!-- Aplication Brand -->
    <div class="app-brand">
      <a href="index.php">
        <img src="../images/iconmenu.png" alt="Mono">
        <span class="brand-name"> KPSMP</span>
      </a>
    </div>
    <!-- begin sidebar scrollbar -->
    <div class="sidebar-left" data-simplebar style="height: 100%;">
      <!-- sidebar menu -->
      <ul class="nav sidebar-inner" id="sidebar-menu">

        <li class="<?php if ($header_click == 0) {
                      echo "active";
                    } ?>">

          <a class="sidenav-item-link" href="index.php">
            <i class="mdi mdi-briefcase-account-outline"></i>
            <span class="nav-text">ກະດານສັງລວມ</span>
          </a>
        </li>
        <?php


        $stmt = $conn->prepare(" SELECT distinct a.ht_id,ht_name 
        FROM tbl_header_title a
        left join tbl_role_page b on a.ht_id = b.ht_id
        where role_id ='$role_id' 
        order by  a.ht_id asc ");
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
          while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

            $ht_id = $row['ht_id'];
            $ht_name = $row['ht_name'];
        ?>

            <li class="section-title"> <?php echo "$ht_name"; ?></li>


            <?php

            $stmt1 = $conn->prepare("SELECT distinct a.st_id,st_name,role_id,icon_code
            FROM tbl_sub_title a
            left join tbl_role_page b on a.st_id = b.st_id 
            where a.ht_id = '$ht_id' and role_id ='$role_id'
            order by a.st_id asc ");
            $stmt1->execute();
            if ($stmt1->rowCount() > 0) {
              while ($row1 = $stmt1->fetch(PDO::FETCH_ASSOC)) {

                $st_name = $row1['st_name'];
                $st_id = $row1['st_id'];
                $icon_code = $row1['icon_code'];



            ?>
                <li class='has-sub <?php if ($header_click == "$st_id") {
                                      echo "active expand";
                                    } ?>'>
                  <a class="sidenav-item-link" href="javascript:void(0)" data-toggle="collapse" data-target='#<?php echo "$st_name"; ?>' aria-expanded="false" aria-controls="<?php echo "$st_name"; ?>">
                    <i class="mdi <?php echo "$icon_code"; ?>"></i>
                    <span class="nav-text"> <?php echo "$st_name"; ?> </span> <b class="caret"></b>
                  </a>

                  <ul class='collapse <?php if ($header_click == "$st_id") {
                                        echo "show";
                                      } ?>' id="<?php echo "$st_name"; ?>" data-parent="#sidebar-menu">
                    <div class="sub-menu">

                      <?php

                      $stmt2 = $conn->prepare(" SELECT pt_name,ptf_name
                      FROM tbl_page_title a
                      left join tbl_role_page b on a.pt_id = b.pt_id 
                      where a.st_id = '$st_id' and role_id ='$role_id'
                      order by a.pt_id asc ");
                      $stmt2->execute();
                      if ($stmt2->rowCount() > 0) {
                        while ($row2 = $stmt2->fetch(PDO::FETCH_ASSOC)) {

                          $pt_name = $row2['pt_name'];
                      ?>


                          <li class="<?php if ($header_name ==  $row2['pt_name']) {
                                        echo "active";
                                      } ?>">
                            <a class="sidenav-item-link" href='<?php echo $row2['ptf_name'] ?>'>
                              <span class="nav-text"><?php echo "$pt_name"; ?></span>

                            </a>
                          </li>

                      <?php
                        }
                      }


                      ?>






                    </div>
                  </ul>

              <?php

              }
            }

              ?>




                </li>


            <?php
          }
        }
            ?>







      </ul>

    </div>


  </div>
</aside>