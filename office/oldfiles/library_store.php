<?php require_once('config/instantiated_files.php');

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
       
          <?php include('inc/top_nav_lib.php'); ?>

        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <!-- <div class="d-sm-flex align-items-center justify-content-between mb-4"> -->
            <!-- <h1 class="h3 mb-0 text-gray-800">DIGC Ibadan Library</h1> -->
         <!--    <a href="create_members.php" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i>Register a New Member</a> -->
          <!-- </div> -->

          <div class="row">
              <div class="col-md-6">
                <!--   <a href="#"></a> | <a href="#"></a> |  <a href="#">Youtube</a> |  <a href="#">Audios</a>  -->
                 <div class="dropdown mb-4">
                    <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      Choose Type
                    </button>
                    <div class="dropdown-menu animated--fade-in" aria-labelledby="dropdownMenuButton">
                      <a class="dropdown-item" href="#">Documents</a>
                      <a class="dropdown-item" href="#">Audio</a>
                      <a class="dropdown-item" href="#">Videos</a>
                      
                    </div>
                  </div>
              </div>
          </div>

          <!-- Content Row -->
          <div class="row">


            <!-- Pending Requests Card Example -->
    <!--         <div class="col-xl-4 col-md-6 mb-4">
              <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Members</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800">18</div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-comments fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div> -->

           
          </div>

          <!-- Content Row -->


          <!-- Content Row -->
         

        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

      <!-- Footer -->
    <?php //include('inc/footer.php'); ?>
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
