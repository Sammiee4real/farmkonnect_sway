<?php require_once('config/instantiated_files.php');
       include('inc/header.php'); 
       $all_users = get_rows_from_one_table('admin_users','date_created');

       $roles = get_rows_from_one_table('role_privileges','date_added');

     


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
             <a href="add_users.php" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i>Add a User</a>
          </div>

      



    

        <div class="row">

         
          
              <div class="col-md-11">
           
              <h6 class="m-0 font-weight-bold text-primary">Manage All Users</h6>
              <p class="mb-4">You can manage all users here</p>



              <div class="card shadow mb-4">
           

              <div class="row">
                  <div class="col-lg-12 p-3">
                    <h6 class="m-3 font-weight-bold text-default">View All Users</h6>

                      <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>SN</th>
                      <th>First Name</th>
                      <th>Last Name</th>
                      <th>Role</th>               
                      <th>Email</th>               
                      <th>Added By</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php 
                    if($all_users == null){
                        echo "No record found";
                    }else{
                    $sn = 1;
                    foreach($all_users as $user){
                      $who_created_id = $user['added_by'];
                      $user_unique_id = $user['unique_id'];
                      $rolle = $user['role'];
                      $created_by = get_one_row_from_one_table_by_id('admin_users','unique_id',$who_created_id,'date_created');
                      $fullname = $created_by['fname'].' '.$created_by['lname'];
                      $user_id = $created_by['unique_id'];


                      $role_det = get_one_row_from_one_table_by_id('role_privileges','role_id',$rolle,'date_added');
                      $role_name = $role_det['role_name'];

                      ?>
                    <tr>
                      <td><?php echo $sn; ?></td>
                      <td><?php echo $user['fname']; ?></td>
                      <td><?php echo $user['lname']; ?></td>
                      <td><?php echo $role_name; ?></td>
                      <td><?php echo $user['email']; ?></td>
                      <td><?php echo $uid == $who_created_id ? "You":$fullname; ?></td>
                      <td>
                        <a href="#" class="btn btn-sm btn-success" style="font-size: 13px;" data-toggle="modal" data-target="#edit<?php echo $user['unique_id']; ?>">Edit</a>
                      </td>   
                     </tr>

                <div class="modal fade" id="edit<?php echo $user['unique_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="blacklist" aria-hidden="true">
                  <div class="modal-dialog " role="document">
                  <div class="modal-content modal-lg">
                  <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Editing Details of <br> <strong><?php echo $user['fname'].' '.$user['lname']; ?></strong></h5>

                  <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span>
                  </button>
                  </div>
                  <div class="modal-body">
                 

              <form method="post" id="edit_user_form<?php echo $user['unique_id'];?>" enctype="multipart/form-data" class="user" action="">
                <div class="form-group">
                    <label>First Name </label>                                
                    <input type="text" required="" value="<?php echo $user['fname']; ?>" class="form-control form-control-sm"  id="first_name" name="first_name" >  

                     <input type="hidden" required="" value="<?php echo $user['unique_id']; ?>" class="form-control form-control-sm"  id="user_id" name="user_id" >   

                </div> 

                <div class="form-group">
                    <label>Last Name </label>                                
                    <input type="text" required="" class="form-control form-control-sm" value="<?php echo $user['lname']; ?>"  id="last_name" name="last_name" >      
                </div> 


                <div class="form-group">
                    <label>Phone </label>                                
                    <input type="text" required="" class="form-control form-control-sm"  id="phone" name="phone" value="<?php echo $user['phone'];?>" >      
                </div> 

                  <div class="form-group">
                    <label>Email </label>                                
                    <input type="text" required="" class="form-control form-control-sm" value="<?php echo $user['email']; ?>"  id="email" name="email" >      
                </div> 


                 <div class="form-group">
                    <label>Password(Optional) </label>                                
                    <input type="text"  class="form-control form-control-sm" value=""  id="password" name="password" >      
                </div> 


                 <div class="form-group">
                    <label>Role</label>   
                    <select style="width: 100%;" required="" class="form-control form-control-sm" name="role" id="role">
                         <option value="<?php echo $user['role'];?>"><?php echo $role_name;?></option>
                        <?php foreach($roles as $role){?>
                          <option value="<?php echo $role['role_id']; ?>"><?php echo $role['role_name']; ?></option>
                        <?php } ?>
                    </select>                                               
                </div>   

                     <input type="submit" value="Edit a User" id="<?php echo $user['unique_id'];?>"  name="<?php echo $user['unique_id'];?>" class="btn btn-primary btn-sm btn-block cmd_edit_user_class"/>
                </a>
                
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
