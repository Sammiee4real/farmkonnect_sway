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
            <h1 class="h3 mb-0 text-gray-800">Search Members By Unit(s)</h1>
            <!-- <a href="#" data-toggle='modal' data-target = '#upload_cleaned_data' class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i>Upload Cleaned Data</a> -->
          </div>

      



    

        <div class="row">

         
          
              <div class="col-md-12">
               
              <h6 class="m-0 font-weight-bold text-primary">Search Members By Unit(s)</h6>
              <p class="mb-4">You can search for members in one or more units</p>

            <div class="card shadow mb-4">


                   <div class="row">
          <!-- <div class="col-lg-5 d-none d-lg-block bg-register-image"></div> -->
          <div class="col-lg-12">
            <div class="p-3">
            
              <form method="post" id="unit_member_search_form" enctype="multipart/form-data" class="user" action="">
               

                <div class="form-group">
                    <label>Search for Members in unit(s)</label>   
                    <select style="width: 100%;" class="js-example-basic-multiple" multiple="multiple" name="member_unit_search[]" id="member_unit_search">
                         
                         <?php foreach($units as $unit){
                              $unit_name = $unit['unit_name'];
                          ?>
                            
                            <option value="<?php echo $unit['unit_id']; ?>"><?php echo $unit_name; ?></option>
                              
                         <?php } ?>
                    </select>                             
                          
                </div>

                <div class="form-group">
                       <input type="submit" value="Search" name="cmd_search_by_unit"  class="btn btn-sm btn-primary"   id="cmd_search_by_unit" >                            
                </div>



                <hr>

                <div id="search_result_by_unit"></div>

                
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
