<?php require_once('config/instantiated_files.php');
       include('inc/header.php'); 
       $home_cells = get_rows_from_one_table('home_cell_definition','date_created');
       // array

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
            <h1 class="h3 mb-0 text-gray-800">Search For Accounting Entries</h1>
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
              <h6 class="m-0 font-weight-bold text-primary">Search for a Particular Accounting Entries</h6>
              <p class="mb-4">You can search for a logged accounting entry(ies) here</p>

            <div class="card shadow mb-4">


                   <div class="row">
          <!-- <div class="col-lg-5 d-none d-lg-block bg-register-image"></div> -->
          <div class="col-lg-12">
            <div class="p-3">
            
              <form method="post" id="hc_attendance_view_form"  class="user" action="">
               

                <div class="form-group">
                    <label>Search for Entries</label>   
                    <select style="width: 100%;" class="js-example-basic-single" name="home_cell_search" id="home_cell_search">
                         <option value="">Select Home Cell</option>
                         <option value="all">All</option>
                         <?php foreach($home_cells as $home_cell){
                              $cell_name = $home_cell['cell_name'];
                          ?>
                            
                            <option value="<?php echo $home_cell['unique_id']; ?>"><?php echo $cell_name; ?></option>
                              
                         <?php } ?>
                    </select>                             
                          
                </div>


                 <div class="form-group">
                    <label>Select a Date Range</label>   
                     <div class="row">
                       
                       <div class="col-md-6">
                         <label>From:</label>
                         <input type="date" style="width: 100%;"  class="form-control form-control-sm "  name="from_date" id="from_date">


                       </div>
                       <div class="col-md-6  ">
                         <label>To:</label>
                      <input type="date" style="width: 100%;"  class="form-control form-control-sm "  name="to_date" id="to_date">


                       </div>

                     </div>
      
                </div>


                  <div class="form-group">
                    
                     <div class="row">
                       
                       <div class="col-md-6">
                      
                         <input type="submit" value="Query Attendance" style="width: 100%;"  class="btn btn-sm btn-primary"  name="cmd_query_attendance" id="cmd_query_attendance">
                       </div>
                   

                     </div>
      
                </div>


                <hr>

                <div class="view_record"></div>

                
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
