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
            <h1 class="h3 mb-0 text-gray-800">Make a Request for Website Building</h1>
            <!-- <a href="#" data-toggle='modal' data-target = '#upload_cleaned_data' class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i>Upload Cleaned Data</a> -->
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
              <h6 class="m-0 font-weight-bold text-primary">Let's Help You Build Your Website</h6>
              <p class="mb-4">Use the options below, so we can get your website up and running in jiffy!</p>

            <div class="card shadow mb-4">


                  <div class="row">
                     <div class="col-md-12">
                      <div class="card-body">
                          <h4>Option 1:</h4>
                          <div class="alert alert-default">
                              Send a mail to buildwebsites@churchworld.com
                          </div>
                          <hr>
                          <h4>Option 2:</h4>
                           <div class="alert alert-default">
                              Fill the form below
                          </div>
                          <hr>
                          <h4>Option 3:</h4>
                          <div class="alert alert-default">
                              Chat with one of our Engineers on whatsapp @ <a href="">08168509044</a>
                          </div>
                          <hr>
                           <hr>
                          <h4>Option 4:</h4>
                          <div class="alert alert-default">
                              Call one of our Engineers  on <a href="">08168509044</a>
                          </div>
                          <hr>
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
