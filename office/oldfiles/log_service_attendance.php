<?php require_once('config/instantiated_files.php');
       include('inc/header.php'); 
       $units = get_rows_from_one_table('units','date_created');
     
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
            <h1 class="h3 mb-0 text-gray-800">Manage Services Attendance By Unit

              <?php 
                
                  


               ?>
            </h1>
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
              <h6 class="m-0 font-weight-bold text-primary">Manage Services Attendance By Unit</h6>
              <p class="mb-4">You can log attendance of members present in services here etc</p>

            <div class="card shadow mb-4">


                   <div class="row">
          <!-- <div class="col-lg-5 d-none d-lg-block bg-register-image"></div> -->
          <div class="col-lg-12">
            <div class="p-3">
            
              <form method="post" id="service_attendance_log_form"  class="user" action="">
               

                 <div class="form-group">
                    <label>Select a Unit</label>   
                    <select style="width: 100%;" class="js-example-basic-single"  name="units" id="units">
                         <option value="">Select a Unit</option>
                         <?php foreach($units as $unit){?>
                         <option value="<?php echo $unit['unit_id'];?>"><?php echo $unit['unit_name'];?></option>
                         <?php } ?>
                    </select>                             
                          
                </div>


                 <div class="form-group">
                    <label>Pick Service Date( This Lists All Sundays in <?php echo date('Y'); ?>)</label>   
                    <select style="width: 100%;" class="js-example-basic-single" name="service_attendance_date" id="service_attendance_date">
                         <option value="">Select a Sunday Service Date</option>
                         <?php 
                         $current_date = date('Y-m-d');
                         $result = getDateForSpecificDayBetweenDates(FIRST_DAY_OF_YEAR,LAST_DAY_OF_YEAR,7);
                         $last_sunday = date('Y-m-d', strtotime("last Sunday"));
                         $next_sunday = date('Y-m-d', strtotime("next Sunday"));
                          
                           echo '<option value="'.$last_sunday.'">'.date('F-d-Y',strtotime( $last_sunday ) ).'(Last Sunday)</option>';
                           echo '<option value="'.$next_sunday.'">'.date('F-d-Y',strtotime( $next_sunday ) ).'(Next Sunday)</option>';

                         for($i = 0; $i < count($result); $i++) {

                            if( strtotime($current_date) > strtotime($result[$i])){
                          ?>                   
                            <option value="<?php echo $result[$i]; ?>"><?php echo  date('F-d-Y',strtotime($result[$i])); ?></option>               
                         <?php }

                            }

                          ?>
                    </select>                             
                          
                </div>

                <hr>

                <div id="display_service_members"></div>

                
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
