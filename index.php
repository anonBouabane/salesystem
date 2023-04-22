<!DOCTYPE html>
<html lang="en">
<head>
  <head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
   <link id="main-css-href" rel="stylesheet" href="css/3style.css" />
  
 
 

  
</head>

</head>
  <body class="bg-light-gray" id="body">
          <div class="container d-flex align-items-center justify-content-center" style="min-height: 100vh">
          <div class="d-flex flex-column justify-content-between">
            <div class="row justify-content-center">
              <div class="col-lg-6 col-md-10">
                <div class="card card-default mb-0">
                  <div class="card-header pb-0">
                    <div class="app-brand w-100 d-flex justify-content-center border-bottom-0">
                      <a class="w-auto pl-0" href="index.php">
                        <img src="images/newicon.png" alt="Mono">
                    
                      </a>
                    </div>
                  </div>
                  <div class="card-body px-5 pb-5 pt-0">
				  <br>

                    <h4 class="text-dark mb-6 text-center">KPSMP</h4>
					
					

                    <form method="post" id="adminLoginFrm" class="login100-form validate-form ">
					
                      <div class="row">
					  
                        <div class="form-group col-md-12 mb-4">
                          <input class="form-control input-lg" name="username" id="username" type="text"  aria-describedby="emailHelp"
                            placeholder="email">
                        </div>
                        <div class="form-group col-md-12 ">
                          <input type="password" class="form-control input-lg" name="pass" id="pass" placeholder="Password">
                        </div>
                        <div class="col-md-12 text-center">

                      

                          <button type="submit" name="btnlogin"  class="btn btn-primary btn-pill mb-4">Sign In</button>
 
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
		 <script type="text/javascript" src="js/jquery.js"></script>
		 <script type="text/javascript" src="js/sweetalert.js"></script>
		   <script>
		   
			// Admin Log in
			$(document).on("submit","#adminLoginFrm", function(){
			   $.post("query/loginExe.php", $(this).serialize(), function(data){
				  if(data.res == "invalid")
				  {
					Swal.fire(
					  'ແຈ້ງເຕືອນ',
					  'ຢູສເຊີ້ ຫຼື ລະຫັດຜ່ານບໍ່ຖືກຕ້ອງ',
					  'error'
					)
				  }else if(data.res == "inactive")
				  {
					Swal.fire(
					  'ແຈ້ງເຕືອນ',
					  'ຢູສເຊີ້ປິດການນຳໃຊ້ ກະລຸນາຕິດຕໍ່ຫາພະແນກໄອທີ',
					  'error'
					)
				  }
				  else if(data.res == "success")
				  {
					$('body').fadeOut();
					window.location.href='page/index.php';
				  }
			   },'json');

			   return false;
			}); 
		   </script>

</body>
</html>
