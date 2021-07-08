<?php require_once('config/instantiated_files.php');
       include('inc/header.php'); 
      // $home_cells = get_rows_from_one_table('home_cell_definition','date_created');
       // array


       if(isset($_POST['cmd_add_entries'])){
              // print_r($_POST);
              foreach ($_POST as $key => $value) {
                  echo "key:".$key."  Value:".$value.'<br>';
              }
       }

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
            <h1 class="h3 mb-0 text-gray-800">Log Accounting Entries</h1>

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
              <h6 class="m-0 font-weight-bold text-primary">Log Accounting Entries</h6>
              <p class="mb-4">You can log accounting entries here ---- incomes, expenses</p>

            <div class="card shadow mb-4">

         

          <div class="row">
          <!-- <div class="col-lg-5 d-none d-lg-block bg-register-image"></div> -->
            <div class="col-lg-12">
            <div class="p-3">
             
              <form method="post" id="hc_attendance_log_formddd"  class="user" action="">

                    <label>Select Transaction Date</label>   
                        <input type="date" required="" id="transaction_date" class="form-control form-control-sm col-5" name="transaction_date"><hr>   

                   <a href="#" id="add_entries" class="btn btn-primary btn-sm">+add entries</a>

              <input type="hidden" id="counterr" name="counterr" value="0"><br>
              <label><span id="counterr2">0</span> rows added</label>
              <br>
              <table class="table table-bordered add_input_div" id="dataTable" width="100%" cellspacing="0"><thead><tr><th>Item*</th><th>Amount*</th><th>Description</th><th></th></tr></thead><tbody>
              <tfoot>
                <th colspan="3"><input type="submit" value="Submit Entries" class="btn btn-primary" name="cmd_add_entries" id="cmd_add_entries"></th>
                <th></th>
             
              </tfoot>
              <tbody></table>


                
              </form>
             
              
           
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
