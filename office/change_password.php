<?php 
  require_once('config/database_functions.php');
  if(!isset($_GET['passcode'])){
     header('location: reset_link_error');
  }else{
     $passcode = $_GET['passcode'];
     $verify_password_link = verify_password_link($passcode);
     $verify_password_link_dec = json_decode($verify_password_link,true);
     if($verify_password_link_dec['status'] != 111  ){
       header('location: reset_link_error');
     }
  }

 include('inc/header.php'); 

?>


<body class="bg-gradient-primary">

  <div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

      <div class="col-xl-10 col-lg-12 col-md-9">

        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
              <div class="col-lg-6 d-none d-lg-block bg-reset_password-image"></div>
              <div class="col-lg-6">
                <div class="p-5">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4"><span><strong>SWAY AG-3K</strong></span><br> Change Password</h1>
                  </div>
                  <form class="user" method="POST" id="change_password_form">
                  
                    <div class="form-group">
                      <input type="hidden" id="passcode" name="passcode" class="form-control form-control-user" id="exampleInputEmail" value="<?php echo $passcode; ?>" aria-describedby="emailHelp" placeholder="New Password" >
                      <input type="password" id="password" name="password" class="form-control form-control-user" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="New Password" >
                    </div>

                      <div class="form-group">
                      <input type="password" id="cpassword" name="cpassword" class="form-control form-control-user" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Confirm New Password" >
                    </div>

                  
                    <a href="" class="btn btn-sm btn-primary btn-user btn-block" id="cmd_change_password">
                      Reset Password
                    </a>
                     <a href="index" class="text-center"  >
                      <!-- class="btn btn-sm btn-google btn-user btn-block" -->
                      <i class="fa fa-keyw"></i> Return to Login
                    </a>
                    

                   
                  </form>
                  <hr>
                 <!--  <div class="text-center">
                    <a class="small" href="#">Forgot Password?</a>
                  </div>
                  <div class="text-center">
                    <a class="small" href="#">Create an Account!</a>
                  </div> -->
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

    </div>

  </div>

 
 <?php include('inc/scripts.php'); ?>
