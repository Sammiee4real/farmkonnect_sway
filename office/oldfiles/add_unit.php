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
            <h1 class="h3 mb-0 text-gray-800">Settings</h1>
            <!-- <a href="#" data-toggle='modal' data-target = '#upload_cleaned_data' class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i>Upload Cleaned Data</a> -->
          </div>

      



    

        <div class="row">

         
          
              <div class="col-md-11">
                <div class="row">
                <div class="col-md-12">
                <?php if(!empty($msgupdate)){

                echo $msgupdate;

                }?>
                </div>
                </div>
              <h6 class="m-0 font-weight-bold text-primary">Add Unit</h6>
              <p class="mb-4">You can add units in the church here</p>

              <div class="card shadow mb-4">
              <div class="row">
              <!-- <div class="col-lg-5 d-none d-lg-block bg-register-image"></div> -->
              <div class="col-lg-12">
              <div class="p-3">

              <form method="post" id="add_unit_form" enctype="multipart/form-data" class="user" action="">
                <div class="form-group">
                    <label>Name of Unit </label>                                
                    <input type="text" required="" class="form-control form-control-sm"  id="unit_name" name="unit_name" >      
                </div>          
                <input type="submit" value="Add Unit/Department" id="cmd_add_unit"  name="cmd_add_unit" class="btn btn-primary btn-sm btn-block"/>
                </a>
                
              </form>
             
              
           
              </div>
              </div>
              </div>


              <hr>

              <div class="row">
                  <div class="col-lg-12 p-3">
                    <h6 class="m-3 font-weight-bold text-default">View All Units</h6>

                      <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>SN</th>
                      <th>Name</th>
                      <th>Date Created</th>
                      <th>Created By</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php 
                    if($units == null){
                        echo "No record found";
                    }else{
                    $sn = 1;
                    foreach($units as $unit){
                      $who_created_id = $unit['created_by'];
                      $created_by = get_one_row_from_one_table_by_id('users','unique_id',$who_created_id,'date_created');
                      $fullname = $created_by['fname'].' '.$created_by['lname'];
                      ?>
                    <tr>
                      <td><?php echo $sn; ?></td>
                      <td><?php echo $unit['unit_name']; ?></td>
                      <td><?php echo date('F-d-Y',strtotime($unit['date_created'])); ?></td>
                      <td><?php echo $fullname; ?></td>
                     </tr>
                    <?php $sn++;
                        }
                     } ?>
                   
                  </tbody>
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
