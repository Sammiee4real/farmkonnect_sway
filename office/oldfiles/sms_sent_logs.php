<?php require_once('config/instantiated_files.php');
       include('inc/header.php'); 
       $sms_log = get_rows_from_one_table('sms_log','date_created');


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
            <h1 class="h3 mb-0 text-gray-800">View Sent SMS Logs </h1>
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
              <h6 class="m-0 font-weight-bold text-primary">View SMS </h6>
              <p class="mb-4">You can view sms logs here</p>

              <div class="card shadow mb-4">
             
<style>
.ycode {
  font-family: Consolas,"courier new";
  color: crimson;
  /*background-color: #f1f1f1;*/
  background-color: #ffffff;
  padding: 2px;
  font-size: 75%;
}
</style>
              <div class="row">
                  <div class="col-lg-12 p-3">
                    <h6 class="m-3 font-weight-bold text-default">View All Sent SMS </h6>

                      <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>SN</th>
                      <th>Message</th>
                      <th>Status</th>
                      <th>Response Details</th>
                      <th>Sent By</th>
                      <!-- <th>Created By</th> -->
                    </tr>
                  </thead>
                  <tbody>
                    <?php 
                    if($sms_log == null){
                        echo "No record found";
                    }else{
                    $sn = 1;
                    foreach($sms_log as $smsl){
                      $who_created_id = $smsl['added_by'];
                      $created_by = get_one_row_from_one_table_by_id('users','unique_id',$who_created_id,'date_created');
                      $fullname = $created_by['fname'].' '.$created_by['lname'];
                      ?>
                    <tr>
                      <td><?php echo $sn; ?></td>
                      <td><?php echo urldecode($smsl['message']); ?></td>
                      <td><?php 

                          if($smsl['status'] == 'successful'){
                            echo '<small class="badge badge-success">'.$smsl['status'].'</small>'; 
                          }else{
                            echo '<small class="badge badge-danger">'.$smsl['status'].'</small>'; 
                          }


                      ?></td>
                      <td class="ycode"><a  href="#" data-target="#json_response<?php echo $smsl['log_id'];?>" data-toggle="modal">view json response</a></td>
                      
                      <td><?php echo $fullname; ?></td>
                     </tr>
                    <?php $sn++; ?>
                    
                           <!-- Upload Cleaned Data -->
              <div class="modal fade" id="json_response<?php echo $smsl['log_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="blacklist" aria-hidden="true">
              <div class="modal-dialog modal-lg " role="document">
              <div class="modal-content">
              <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Message Response</h5>
            
              <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
              </button>
              </div>
              <div class="modal-body">
                 
                  <?php echo $smsl['log_json']; ?>

                  
              </div>
              <div class="modal-footer">
              <button class="btn btn-primary" type="button" data-dismiss="modal">Close</button>

              </div>
              </div>
              </div>
              </div>

                    <?php }
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
