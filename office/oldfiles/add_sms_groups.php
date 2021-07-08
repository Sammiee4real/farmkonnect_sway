<?php require_once('config/instantiated_files.php');
       include('inc/header.php'); 
       $sms_groups = get_rows_from_one_table('sms_groups','date_created');
       $param = ['unique_id','fname','lname','phone'];
       $conditions = ['role'=>'2'];
       $users = get_rows_from_one_table_with_sql_param($param,'users',$conditions,'date_created');


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
           
              <h6 class="m-0 font-weight-bold text-primary">Add SMS Group</h6>
              <p class="mb-4">You can add sms groups  here</p>

              <div class="card shadow mb-4">
              <div class="row">
              <!-- <div class="col-lg-5 d-none d-lg-block bg-register-image"></div> -->
              <div class="col-lg-12">
              <div class="p-3">

              <form method="post" id="add_sms_group_form" enctype="multipart/form-data" class="user" action="">
                <div class="form-group">
                    <label>Name of Group e.g Youth Excos </label>                                
                    <input type="text" required="" class="form-control form-control-sm"  id="sms_group_name" name="sms_group_name" >      
                </div> 
                <div class="form-group">
                    <label>Add atleast 1 number to sms group </label>                                
                    <select style="width: 100%;"  required="" class="js-example-basic-multiple" multiple="multiple" name="number_list[]" id="number_list">
                         
                         <?php foreach($users as $member){
                              $members_info = $member['fname'].' '.$member['lname'].' ('.$member['phone'].')';
                          ?>
                            
                            <option value="<?php echo $member['unique_id']; ?>"><?php echo $members_info; ?></option>
                              
                         <?php } ?>
                    </select>                
                </div>                   
                <input type="submit" value="Add SMS Group" id="cmd_add_sms_group"  name="cmd_add_sms_group" class="btn btn-primary btn-sm btn-block"/>
                </a>
                
              </form>
             
              
           
              </div>
              </div>
              </div>


              <hr>

              <div class="row">
                  <div class="col-lg-12 p-3">
                    <h6 class="m-3 font-weight-bold text-default">View All SMS Groups</h6>

                      <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>SN</th>
                      <th>Group Name</th>
                      <th>Group List</th>
                      <th>Date Created</th>
                      <th>Created By</th>
                      <th>action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php 
                    if($sms_groups == null){
                        echo "No record found";
                    }else{
                    $sn = 1;
                    foreach($sms_groups as $sms_group){
                      $who_created_id = $sms_group['created_by'];
                      $created_by = get_one_row_from_one_table_by_id('users','unique_id',$who_created_id,'date_created');
                      $fullname = $created_by['fname'].' '.$created_by['lname'];
                      ?>
                    <tr>
                      <td><?php echo $sn; ?></td>
                      <td><?php echo $sms_group['sms_group_name']; ?></td>
                      <td><?php 
                          $number_list =  json_decode($sms_group['numbers_list'],true);
                          echo '<ul>';
                          for($k=0; $k < count($number_list);$k++){
                            $number_list_det = get_one_row_from_one_table_by_id('users','unique_id',$number_list[$k],'date_created');
                            $ffname = $number_list_det['fname'].' '.$number_list_det['lname'];
                            $phone = $number_list_det['phone'];
                              echo '<li>'.$ffname.': '.$phone.'</li>';
                               // <a href="#" style="color:red; font-size: 13px;" >delete</a>
                          }
                          echo '</ul>';

                       ?></td>
                      <td><?php echo date('F-d-Y',strtotime($sms_group['date_created'])); ?></td>
                      <td><?php echo $fullname; ?></td>
                      <td><a href="#" class="btn btn-primary btn-sm" style="font-size: 13px;" data-toggle="modal" data-target="#view<?php echo $sms_group['sms_group_id']; ?>">Edit</a></td>
                     </tr>

                     <div class="modal fade" id="view<?php echo $sms_group['sms_group_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="blacklist" aria-hidden="true">
                  <div class="modal-dialog " role="document">
                  <div class="modal-content">
                  <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Updating Number List of <?php echo $sms_group['sms_group_name']; ?></h5>

                  <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span>
                  </button>
                  </div>
                  <div class="modal-body">
                  <form method="POST" id="update_sms_group_form<?php echo $sms_group['sms_group_id']; ?>">
                    <input type="hidden" name="grid" id="grid" value="<?php echo $sms_group['sms_group_id']; ?>">
                    <div class="form-group">
                    <label>You can add/remove from Number List </label>                                
                    <select style="width: 100%;"  required="" class="js-example-basic-multiple2" multiple="multiple" name="number_list_<?php echo $sms_group['sms_group_id']; ?>[]" id="number_list_<?php echo $sms_group['sms_group_id']; ?>">
                         
                         <?php
                            $numbers_list22 = json_decode($sms_group['numbers_list'],true);


                          for( $i=0; $i < count($numbers_list22); $i++){
                              $mem_det = get_one_row_from_one_table_by_id('users','unique_id',$numbers_list22[$i],'date_created');
                              $members_info = $mem_det['fname'].' '.$mem_det['lname'].' ('.$mem_det['phone'].')';

                          ?>

                          <option selected value="<?php echo $numbers_list22[$i]; ?>"><?php echo $members_info; ?></option>
                              
                         <?php } ?>

                         <?php foreach($users as $all_users){ if( !in_array($all_users['unique_id'],$numbers_list22)){
                          
                           $fullname_other_members = $all_users['fname'].' '.$all_users['lname'].' ('.$all_users['phone'].')';

                          ?>       
                          <option value="<?php echo $all_users['unique_id'];?> "><?php echo $fullname_other_members;?></option>
                         <?php }   } ?>


                    </select>                
                </div>         

                  <input type="submit" class="cmd_update_sms_group" name="update_sms_group_<?php echo $sms_group['sms_group_id']; ?>" id="<?php echo $sms_group['sms_group_id']; ?>" style="color: green;" value="Update List"> | <a href="#" style="color: red;" data-dismiss="modal">Cancel</a>

                  </form>

                 


                  </div>
                  <div class="modal-footer">
                  <button class="btn btn-danger" type="button" data-dismiss="modal">Cancel</button>

                  </div>
                  </div>
                  </div>
                  </div>







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
