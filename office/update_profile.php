<?php 
      require_once('config/instantiated_files_update.php');
       include('inc/header.php'); 


?>
<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">
  <?php //include('inc/sidebar.php'); ?>
    <!-- Sidebar -->
    
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
       
          <?php //include('inc/top_nav.php'); ?>

        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <!-- <a href="#" data-toggle='modal' data-target = '#upload_cleaned_data' class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i>Upload Cleaned Data</a> -->
          </div>

      



    

        <div class="row">

         
          
              <div class="col-md-11">
             
                        
              

              <div class="card shadow mb-4">
              <div class="row">
              <!-- <div class="col-lg-5 d-none d-lg-block bg-register-image"></div> -->
              <div class="col-lg-4 bg-update_profile-image"><!-- <img src="img/login1.jpg" class="container-fluid"> --></div>
              <div class="col-lg-8">
              <div class="p-3 ">

                 <h1 style="margin-top: 20px;" class="h3 mb-0 text-gray-800 text-center">Great <strong><?php echo $fullname; ?></strong><br> Update Your Profile</h1>

                   <p style="color: red; text-align: center;" ><strong>Please update your profile to continue to dashboard &nbsp;&nbsp;&nbsp;<small><a  href="logout"><strong>Logout</strong></a></small></strong></p>
                  
                    <form class="user" method="POST" id="update_profile_form">
                      <label><strong>Other Names</strong></label>
                    <div class="form-group">
                      <input type="hidden" id="unique_id" name="unique_id" value="<?php echo $uid; ?>" class="form-control form-control-sm" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Enter Other Names...">
                      <input type="text" id="onames" name="onames" value="<?php echo $onames; ?>"  class="form-control form-control-sm" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Enter Other Names...">
                    </div>
                    <div class="form-group">
                      <label><strong>Address</strong></label>
                      <input type="text" id="address" name="address" value="<?php echo $address; ?>"  class="form-control form-control-sm" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Enter Home Address...">
                    </div>
                    <div class="form-group">
                      <label><strong>Select a Gender</strong></label>
                      <select class="form-control form-control-sm" name="gender" id="gender"  >
                          <option value="">Select a Gender</option>
                          <option value="male">Male</option>
                          <option value="female">Female</option>
                      </select>
                    </div>
                    <div class="form-group">
                      <label  for="dob"><strong>Date of Birth</strong></label>
                      <input type="date" id="dob" name="dob" class="form-control form-control-sm" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Enter Email Address...">
                    </div>
                    <hr>
                     <a href="" class="btn btn-sm btn-primary btn-user btn-block" id="cmd_update_profile">
                        Update Your Profile
                      </a>
                  
                     
                  </form>

                   <!-- <a href="logout">Logout</a> -->
              
           
              </div>
              </div>
              </div>




              </div>

              </div>
              


        </div>


      



          <!-- Content Row -->


          <!-- Content Row -->
         

        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

      <!-- Footer -->
    <?php include('inc/footer.php'); ?>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
<!--   <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a> -->

 <?php include('inc/scripts.php'); ?>
