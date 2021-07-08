<?php require_once('config/database_functions.php');
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
                  <center>
                      <img src="../images/farmkonnect_logo.png" style="width:160px; height: 100px;" class="u-logo-image u-logo-image-1">
                      </center>
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4"><span><strong>SWAY AG-3K</strong></span><br> Reset Password</h1>
                  </div>
                  <form class="user" method="POST" id="reset_password_form">
                    <div class="form-group">
                      <input type="email" id="email" name="email" class="form-control form-control-user" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Enter Your Registered Email Address...">
                    </div>
              
                    <a href="" class="btn btn-sm btn-primary btn-user btn-block" id="cmd_password_reset">
                      Get Password Reset Link
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
