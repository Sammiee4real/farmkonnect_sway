<?php require_once('config/instantiated_files.php');
       include('inc/header.php'); 
       $all_roles = get_rows_from_one_table('role_privileges','date_created');
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
             <a href="privileges.php" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i>Add a Role</a>
          </div>

      



    

        <div class="row">

         
          
              <div class="col-md-11">
           
              <h6 class="m-0 font-weight-bold text-primary">Manage All Roles</h6>
              <p class="mb-4">You can manage all roles here</p>



              <div class="card shadow mb-4">
           

              <div class="row">
                  <div class="col-lg-12 p-3">
                    <h6 class="m-3 font-weight-bold text-default">View All Roles</h6>

                      <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>SN</th>
                      <th>Role Name</th>
                      <th>Read/Write Access</th>               
                      <th>Added By</th>
                      <th></th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php 
                    if($all_roles == null){
                        echo "No record found";
                    }else{
                    $sn = 1;
                    foreach($all_roles as $role){
                      $who_created_id = $role['added_by'];
                      $created_by = get_one_row_from_one_table_by_id('admin_users','unique_id',$who_created_id,'date_created');
                      $fullname = $created_by['fname'].' '.$created_by['lname'];
                      ?>
                    <tr>
                      <td><?php echo $sn; ?></td>
                      <td><?php echo $role['role_name']; ?></td>
                      <td><?php echo $role['read_write_access']; ?></td>
                       <td><?php echo $fullname; ?></td>
                      
                      <td><a href="#" class="btn btn-sm btn-primary" style="font-size: 13px;" data-toggle="modal" data-target="#view<?php echo $role['role_id']; ?>">View</a></td>

                       <td><a href="edit_role.php?rid=<?php echo $role['role_id']; ?>" class="btn btn-sm btn-danger" style="font-size: 13px;">Edit</a></td>

                     </tr>

                <div class="modal fade" id="view<?php echo $role['role_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="blacklist" aria-hidden="true">
                  <div class="modal-dialog " role="document">
                  <div class="modal-content">
                  <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">View Pages Access of Role <br> <strong><?php echo $role['role_name']; ?></strong></h5>

                  <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span>
                  </button>
                  </div>
                  <div class="modal-body">
                  <form method="POST" id="view_roles_<?php echo $role['role_id']; ?>">
                    <input type="hidden" name="home_cell_id" id="home_cell_id" value="<?php echo $role['role_id']; ?>">
                    <div class="form-group">
                    <label>View Page List:
                    </label>                                
                    <ul>
                         
                         <?php
                      
                          $pages_access = json_decode($role['pages_access'],true);

                          for( $i=0; $i < count($pages_access); $i++){        
                              $this_page = $pages_access[$i];
                          ?>

                          <li><?php echo $this_page; ?></li>
                              
                         <?php


                          } //for

                       echo '</ul> ';
                        
                            ?>


                                   
                </div>         

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
