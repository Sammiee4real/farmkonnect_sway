<?php require_once('config/instantiated_files.php');


if($dob === NULL || $address === NULL || $gender === NULL || $onames === NULL  ){
        header('location: update_profile');

}
 include('inc/header.php'); 

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
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
             <a href="#" data-target="#applyModal" data-toggle="modal" class="d-none d-sm-inline-block btn btn-lg btn-primary shadow-sm"><i class="fas fa-landmark"></i> Apply</a>
          </div>

          <!-- Content Row -->
          <div class="row">


            <!-- Pending Requests Card Example -->
            <div class="col-xl-4 col-md-6 mb-4">
              <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">My Wallet Balance</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800">&#8358;00.00</div>
                    </div>
                   <div class="col-auto">
                      <i class="fas fa-wallet fa-2x text-gray-300"></i>
                      <!-- <i class="fas fa-wallet"></i> -->
                    </div>
                  </div>
                </div>
              </div>
            </div>

             <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-4 col-md-6 mb-4">
              <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Disbursed</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800">&#8358;0.00</div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>


             <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-4 col-md-6 mb-4">
              <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-success text-uppercase mb-1">My Running Projects</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800">0</div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

           
           

     
          </div>


           <!-- Logout Modal-->
  <div class="modal fade" id="applyModal" tabindex="-1" role="dialog" aria-labelledby="applyModal" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content modal-lg">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">We will be back in a Jiffy!</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
             <p>We are putting things in place for you. You are our Priority.</p>
            <div class="row">
              <div class="col-lg-12">
                 <img class="container-fluid" src="img/coming_soon.jpg">
                
              </div>
            </div>
          
        
        </div>
        <div class="modal-footer">
          <!-- <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button> -->
          <button class="btn btn-primary" data-dismiss="modal">Close</button>
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
