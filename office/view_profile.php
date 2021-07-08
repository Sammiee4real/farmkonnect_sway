<?php require_once('config/instantiated_files.php');
       include('inc/header.php'); 
       $all_users = get_rows_from_one_table('admin_users','date_created');

       $roles = get_rows_from_one_table('role_privileges','date_added');

     


?>
<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">
  <?php include('inc/sidebar.php'); ?>
    <!-- Sidebar -->
    
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
       
          <?php include('inc/top_nav.php'); ?>

        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">View Profile</h1>
            <!--  <a href="add_users.php" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i>View Your Profile</a> -->
          </div>

      



    

        <div class="row">

         
          
              <div class="col-md-11">
           
              <h6 class="m-0 font-weight-bold text-primary">View Your Profile</h6>
              <p class="mb-4">You can view your profile here</p>



              <div class="card shadow mb-4">
           

              <div class="row">
                  <div class="col-lg-1">
                  </div>
                  <div class="col-lg-8 p-3">
                  
                    <div class="alert alert-success">
                        First Name: <?php echo $first_name; ?><br>
                        Last Name: <?php echo $last_name; ?><br>
                        Email: <?php echo $email; ?><br>
                        Phone: <?php echo $phone; ?><br>
                        Date of Birth: <?php echo $dob; ?><br>
                        Date of Registration: <?php echo $date_created; ?><br>
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
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

 <?php include('inc/scripts.php'); ?>
