<?php require_once('config/instantiated_files.php');
       include('inc/header.php'); 
       $files = get_rows_from_one_table('files_tbl','date_created');


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
            <h1 class="h3 mb-0 text-gray-800">Library/Store: Audios</h1>
            <!-- <a href="#" data-toggle='modal' data-target = '#upload_cleaned_data' class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i>Upload Cleaned Data</a> -->
          </div>

      



    

        <div class="row">

         
          
              <div class="col-md-10">
                <div class="row">
                <div class="col-md-12">
                <?php if(!empty($msg)){

                echo $msg;

                }?>
                  <a href="add_files.php" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i>Add Files</a>
                </div>
                </div>
               
                  <br>
              <h6 class="m-0 font-weight-bold text-primary">View Files Here</h6>
              <p class="mb-4">You can view files in the church here</p>

              <div class="card shadow mb-4">
              <!-- <hr> -->

              <div class="row">
                  <div class="col-lg-12 p-3">
                    <!-- <h6 class="m-3 font-weight-bold text-default">View Youtube Videos</h6> -->
                      <div class="table-responsive">
           

                  <table id="files_table" class="table table-bordered display " style="width:100%">
                      <thead>
                      <tr>
                      <!-- <th>Action</th> -->
                     <!-- <th>SN</th> -->
                      <th>File Title</th>
                      <th>Visibility</th>
                      <th>File path</th>
                       <th>Date Added</th>
                      <th>Added By</th>
                      </tr>
                      </thead>
                      <tfoot>
                      <tr>
                      <!-- <th>Action</th> -->
                     <!-- <th>SN</th> -->
                      <th>File Title</th>
                      <th>Visibility</th>
                      <th>File path</th>
                       <th>Date Added</th>
                      <th>Added By</th>
                      </tr>
                      </tfoot>

                      </table>

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
