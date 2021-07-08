<?php require_once('config/instantiated_files.php');
       include('inc/header.php'); 
       $home_cells = get_rows_from_one_table('home_cell_definition','date_created');
       $param = ['unique_id','fname','lname','phone'];
       $conditions = ['role'=>2];
       $users = get_rows_from_one_table_with_sql_param($param,'users',$conditions,'date_created');
       $users2 = get_rows_from_one_table_with_sql_param($param,'users',$conditions,'date_created');
       $users3 = get_rows_from_one_table_with_sql_param($param,'users',$conditions,'date_created');


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
             <a href="add_home_cells.php" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i>Add Home Cell</a>
          </div>

      



    

        <div class="row">

         
          
              <div class="col-md-11">
           
              <h6 class="m-0 font-weight-bold text-primary">Manage Home Cells</h6>
              <p class="mb-4">You can manage home cells here</p>



              <div class="card shadow mb-4">
           

              <div class="row">
                  <div class="col-lg-12 p-3">
                    <h6 class="m-3 font-weight-bold text-default">View All Home Cells</h6>

                      <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>SN</th>
                      <th>Home Cell Name</th>
                      <th>Cell Host</th>
                      <th>Cell Leader</th>
                      <th>Address</th>
                      <th>Other Information</th>
                      <th>Created By</th>
                      <th>action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php 
                    if($home_cells == null){
                        echo "No record found";
                    }else{
                    $sn = 1;
                    foreach($home_cells as $home_cell){
                      $who_created_id = $home_cell['added_by'];
                      $created_by = get_one_row_from_one_table_by_id('users','unique_id',$who_created_id,'date_created');
                      $fullname = $created_by['fname'].' '.$created_by['lname'];
                      ?>
                    <tr>
                      <td><?php echo $sn; ?></td>
                      <td><?php echo $home_cell['cell_name']; ?></td>
                       <td><?php 
                          $cell_host = $home_cell['cell_host']; 
                          $cell_host_det = get_one_row_from_one_table_by_id('users','unique_id',$cell_host,'date_created');
                            $ffname = $cell_host_det['fname'].' '.$cell_host_det['lname'];
                            $phone = $cell_host_det['phone'];
                              echo $ffname.': '.$phone;
                              
                               // <a href="#" style="color:red; font-size: 13px;" >delete</a>
                       

                       ?></td>

                      <td><?php 
                           $cell_leader = $home_cell['leaders_list']; 
                         
                            $leaders_list_det = get_one_row_from_one_table_by_id('users','unique_id',$cell_leader,'date_created');
                            $ffname = $leaders_list_det['fname'].' '.$leaders_list_det['lname'];
                            $phone = $leaders_list_det['phone'];
                              echo $ffname.': '.$phone;
                        
                       

                       ?></td>
                      <td><?php echo $home_cell['address']; ?></td>
                      <td><?php echo $home_cell['other_info']; ?></td>
                      <td><?php echo $fullname; ?></td>
                      <td><a href="#" class="btn btn-sm btn-primary" style="font-size: 13px;" data-toggle="modal" data-target="#view<?php echo $home_cell['unique_id']; ?>">Edit</a></td>
                     </tr>

                     <div class="modal fade" id="view<?php echo $home_cell['unique_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="blacklist" aria-hidden="true">
                  <div class="modal-dialog " role="document">
                  <div class="modal-content">
                  <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Updating Members of Home Cell: <br> <strong><?php echo $home_cell['cell_name']; ?></strong></h5>

                  <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span>
                  </button>
                  </div>
                  <div class="modal-body">
                  <form method="POST" id="update_home_cell_members_form<?php echo $home_cell['unique_id']; ?>">
                    <input type="hidden" name="home_cell_id" id="home_cell_id" value="<?php echo $home_cell['unique_id']; ?>">
                    <div class="form-group">
                    <label>You can add/remove Members from List:<!--  <br><strong>You can add Non-members too<br>
                      For Non-Members Addition: eg name_phone i.e SamsonOjewole_08168509044</strong>  -->
                    </label>                                
                    <select style="width: 100%;"  required="" class="js-example-basic-multiple" multiple="multiple" name="member_list_<?php echo $home_cell['unique_id']; ?>[]" id="member_list_<?php echo $home_cell['unique_id']; ?>">
                         
                         <?php
                          $get_homecell_map = get_one_row_from_one_table_by_id('home_cell_map','home_cell_id',$home_cell['unique_id'],'date_created');
                            $get_homecell_members = json_decode($get_homecell_map['members_list'],true);

                          for( $i=0; $i < count($get_homecell_members); $i++){
                              $mem_det = get_one_row_from_one_table_by_id('users','unique_id',$get_homecell_members[$i],'date_created');
                              $members_info = $mem_det['fname'].' '.$mem_det['lname'].' ('.$mem_det['phone'].')';



                          ?>

                          <option selected value="<?php echo $get_homecell_members[$i]; ?>"><?php echo $members_info; ?></option>
                              
                         <?php } ?>

                         <?php foreach($users as $all_users){ if( !in_array($all_users['unique_id'],$get_homecell_members)){
                          
                           $fullname_other_members = $all_users['fname'].' '.$all_users['lname'].' ('.$all_users['phone'].')';

                             ///further check to ensure user is not in another group
                              $check = check_if_member_in_another_home_cell($all_users['unique_id']);
                              $check_dec = json_decode($check ,true);
                              if(       $check_dec['status'] == 111      ){

                          ?>       
                          <option value="<?php echo $all_users['unique_id'];?> "><?php echo $fullname_other_members;?></option>
                         <?php } else{ ?>
  
                            <option disabled="" value="<?php echo $all_users['unique_id'];?> "><?php echo $fullname_other_members.' '.$check_dec['msg']; ?></option>

                        <?php }

                         }  


                           } ?>


                    </select>                
                </div>         

                  <input type="submit" class="cmd_update_home_cell" name="update_home_cell_<?php echo $home_cell['unique_id']; ?>" id="<?php echo $home_cell['unique_id']; ?>" style="color: green;" value="Update List"> | <a href="#" style="color: red;" data-dismiss="modal">Cancel</a>

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
