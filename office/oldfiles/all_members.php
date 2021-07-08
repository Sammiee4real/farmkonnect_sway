<?php require_once('config/instantiated_files.php');
       include('inc/header.php'); 
       $units = get_rows_from_one_table('units','date_created');

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
            <h1 class="h3 mb-0 text-gray-800">All Members</h1>
            <a href="single_member_search.php"  data-target = '#upload_cleaned_data' class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i>Single Record Search</a>
          </div>

      



    

        <div class="row">

         
          
              <div class="col-md-12">
                <div class="row">
                <div class="col-md-12">
                <?php if(!empty($msgupdate)){

                echo $msgupdate;

                }?>
                </div>
                </div>
              <h6 class="m-0 font-weight-bold text-primary">View Members</h6>
              <p class="mb-4">You can view a members' profiles here</p>

            <div class="card shadow mb-4">


                  <div class="row">
                     <div class="col-md-12">
                      <div class="card-body">
                      <div class="table-responsive">
                      <!-- <table class="table table-bordered" id="dataTableServer" width="100%" cellspacing="0"> -->
                      <table id="dataTableServer" class="table table-bordered display " style="width:100%">
                      <thead>
                      <tr>
                      <th>Action</th>
                      <th>First name</th>
                      <th>Last name</th>
                      <th>Phone</th>
                      <th>Email</th>
                      <th>Address</th>
                      <th>Date of Birth</th>
                      </tr>
                      </thead>
                      <tfoot>
                      <tr>
                      <th>Edit</th>
                      <th>First name</th>
                      <th>Last name</th>
                      <th>Phone</th>
                      <th>Email</th>
                      <th>Address</th>
                      <th>Date of Birth</th>
                      </tr>
                      </tfoot>

                      </table>
                      </div>
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

 



<!-- <script type="text/javascript">
     
      $(document).ready(function() {
            $('#example').DataTable( {
            "processing": true,
            "serverSide": true,
            "ajax": "all_members_server.php"
            } );
      } );

</script> -->

 <?php include('inc/scripts.php'); ?>
