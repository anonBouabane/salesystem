<?php

$host = "localhost";
$user = "root";
$pass = "";
$db   = "kpexam";
$conn = null;

try {
  $conn = new PDO("mysql:host={$host};dbname={$db};", $user, $pass);
} catch (Exception $e) {
}
$conn->exec("set names utf8");


$id = $_GET['id'];

$selExmne = $conn->query("SELECT * FROM examinee_tbl WHERE exmne_id='$id' ")->fetch(PDO::FETCH_ASSOC);

?>

<fieldset style="width:543px;">
  <legend><i class="facebox-header"><i class="edit large icon"></i>&nbsp;ແກ້ໄຂ ຜູ້ໃຊ້: <b>( <?php echo strtoupper($selExmne['exmne_fullname']); ?> )</b></i></legend>
  <div class="col-md-12 mt-4">
    <form method="post" id="updateExamineeFrm">
      <div class="form-group">
        <legend>ຊື່ ນາມສະກຸນ</legend>
        <input type="hidden" name="exmne_id" value="<?php echo $id; ?>">
        <input type="" name="exFullname" class="form-control" required="" value="<?php echo $selExmne['exmne_fullname']; ?>">
      </div>

      <div class="form-group">
        <legend>ຊື່ ນາມສະກຸນ</legend>
        <input type="" name="cp_code" class="form-control" required="" value="<?php echo $selExmne['cp_code']; ?>">
      </div>

      <div class="form-group">
        <legend>ເພດ</legend>
        <select class="form-control" name="exGender">
          <option value="<?php echo $selExmne['exmne_gender']; ?>"><?php echo $selExmne['exmne_gender']; ?></option>
          <option value="male">Male</option>
          <option value="female">Female</option>
        </select>
      </div>



      <div class="form-group">
        <legend>Password</legend>
        <input type="" name="exPass" class="form-control" required="" value="<?php echo $selExmne['exmne_password']; ?>">
      </div>


      <div class="form-group" align="right">
        <button type="submit" class="btn btn-sm btn-primary">ແກ້ໄຂ</button>
      </div>
    </form>
  </div>
</fieldset>