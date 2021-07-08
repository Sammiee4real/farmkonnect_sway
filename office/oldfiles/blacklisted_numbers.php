<?php require_once('config/instantiated_files.php');
       include('inc/header.php'); 
       $members = get_rows_from_one_table('users','date_created');
       $blacklist_members = get_rows_from_one_table('blacklisted_numbers','date_created');


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
            <h1 class="h3 mb-0 text-gray-800">Blacklisted Numbers</h1>
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
              <h6 class="m-0 font-weight-bold text-primary">Add Number(s) to SMS Blaclist</h6>
              <p class="mb-4">These numbers will not recieve sms...they might be members who are no longer in town due to work transfer, wedding relocation etc</p>

              <div class="card shadow mb-4">
              <div class="row">
              <!-- <div class="col-lg-5 d-none d-lg-block bg-register-image"></div> -->
              <div class="col-lg-12">
              <div class="p-3">

              <form method="get" id="add_unit_form" enctype="multipart/form-data" class="user" action="">
                <div class="form-group">
                    <label>Add Numbers to Blacklist </label>                                
                    <select style="width: 100%;"  required="" class="js-example-basic-multiple" multiple="multiple" name="blackist_numbers[]" id="blackist_numbers">
                         
                         <?php foreach($members as $members){
                              $members_info = $members['fname'].' '.$members['lname'].' ('.$members['phone'].')';
                          ?>
                            
                            <option value="<?php echo $members['unique_id']; ?>"><?php echo $members_info; ?></option>
                              
                         <?php } ?>
                    </select>                
                </div>          
                <a href="#" data-toggle="modal" data-target="#blacklist"   id="cmd_sms_blackist"  name="cmd_sms_blackist" class="btn btn-success btn-sm">Add to Blacklist</a> 
               | 
               <a href="#" data-toggle="modal" data-target="#blacklist_remove"   id="cmd_sms_blackist_undo"  name="cmd_sms_blackist_undo" class="btn btn-danger btn-sm">Remove from Blacklist</a> 
                   
                
              </form>

                   <!-- Upload Cleaned Data -->
              <div class="modal fade" id="blacklist" tabindex="-1" role="dialog" aria-labelledby="blacklist" aria-hidden="true">
              <div class="modal-dialog " role="document">
              <div class="modal-content">
              <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Blacklist Addition Confirmation</h5>
            
              <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
              </button>
              </div>
              <div class="modal-body">
                  <h5>Are you sure you want to blacklist these numbers?</h5>
                  
                  <form method="POST">

                    <div id="display_blacklist"></div>
                    <input type="submit" name="confirm_add_to_blacklist" id="confirm_add_to_blacklist" style="color: green;" value="YES"> | <a href="#" style="color: red;" data-dismiss="modal">Cancel</a>
                    
                  </form>

                    <div id="final_display_blacklist"></div>

                  
              </div>
              <div class="modal-footer">
              <button class="btn btn-danger" type="button" data-dismiss="modal">Cancel</button>

              </div>
              </div>
              </div>
              </div>
             
              
           
              </div>
              </div>
              </div>



                  <!-- Upload Cleaned Data -->
              <div class="modal fade" id="blacklist_remove" tabindex="-1" role="dialog" aria-labelledby="blacklist" aria-hidden="true">
              <div class="modal-dialog " role="document">
              <div class="modal-content">
              <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Blacklist Undo Action</h5>
            
              <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
              </button>
              </div>
              <div class="modal-body">
                  <h5>Are you sure you want to remove this numbers from the list of  blacklisted?</h5>
                  
                  <form method="POST">

                    <div id="display_blacklist2"></div>
                    <input type="submit" name="confirm_remove_from_blacklist" id="confirm_remove_from_blacklist" style="color: green;" value="YES, Remove from Blacklist"> | <a href="#" style="color: red;" data-dismiss="modal">Cancel</a>
                    
                  </form>

                    <div id="final_display_blacklist2"></div>

                  
              </div>
              <div class="modal-footer">
              <button class="btn btn-danger" type="button" data-dismiss="modal">Cancel</button>

              </div>
              </div>
              </div>
              </div>
             
              
           
              </div>
              </div>
              </div>


              <hr>

              <div class="row">
                  <div class="col-lg-12 p-3">
                    <h6 class="m-3 font-weight-bold text-default">View All Blacklisted Numbers</h6>

                      <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>SN</th>
                      <th>Blacklisted Name</th>
                      <th>Blacklisted Phone</th>
                      <th>Date Created</th>
                      <th>Created By</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php 
                    if($blacklist_members == null){
                        echo "No record found";
                    }else{
                    $sn = 1;
                    foreach($blacklist_members as $blacklist_member){
                      $who_created_id = $blacklist_member['created_by'];
                      $blacklisted_user_id = $blacklist_member['blacklisted_user_id'];
                    
                      $created_by = get_one_row_from_one_table_by_id('users','unique_id',$who_created_id,'date_created');
                      $fullname = $created_by['fname'].' '.$created_by['lname'];

                      $blacklisted_user_det = get_one_row_from_one_table_by_id('users','unique_id',$blacklisted_user_id,'date_created');
                      $fullname_b = $blacklisted_user_det['fname'].' '.$blacklisted_user_det['lname'];
                      ?>
                    <tr>
                      <td><?php echo $sn; ?></td>
                      <td><?php echo $fullname_b; ?></td>
                      <td><?php echo $blacklist_member['blacklist_phone']; ?></td>
                      <td><?php echo date('F-d-Y',strtotime($blacklist_member['date_created'])); ?></td>
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
