<?php require_once('config/instantiated_files.php');
       include('inc/header.php'); 
       $home_cells = get_rows_from_one_table('home_cell_definition','date_created');

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
            <h1 class="h3 mb-0 text-gray-800">View Members in a Home Cell</h1>
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
              <h6 class="m-0 font-weight-bold text-primary">View Members in a Home Cell</h6>
              <p class="mb-4">You can view members in a particular home cell here etc</p>

            <div class="card shadow mb-4">


                   <div class="row">
          <!-- <div class="col-lg-5 d-none d-lg-block bg-register-image"></div> -->
          <div class="col-lg-12">
            <div class="p-3">
            
              <form method="post" id="home_cell_member_search_form"  class="user" action="">
               

                <div class="form-group">
                    <label>Search for a Home Cell</label>   
                    <select style="width: 100%;" class="js-example-basic-single" name="home_cell_members_search" id="home_cell_members_search">
                         <option value="">search for a home cell</option>
                         <?php foreach($home_cells as $home_cell){
                              $cell_name = $home_cell['cell_name'];
                          ?>
                            
                            <option value="<?php echo $home_cell['unique_id']; ?>"><?php echo $cell_name; ?></option>
                              
                         <?php } ?>
                    </select>                             
                          
                </div>

                <hr>

                <div id="home_cell_members_search_result"></div>

                
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
