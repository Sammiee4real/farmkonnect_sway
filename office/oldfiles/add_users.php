<?php require_once('config/instantiated_files.php');
       include('inc/header.php'); 
      
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
            <a href="all_users.php" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i>All Users</a>
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
              <h6 class="m-0 font-weight-bold text-primary">Add Users</h6>
              <p class="mb-4">You can add users(e.g HOD, Church Admin etc) in the church here</p>

              <div class="card shadow mb-4">
              <div class="row">
              <!-- <div class="col-lg-5 d-none d-lg-block bg-register-image"></div> -->
              <div class="col-lg-12">
              <div class="p-3">

              <form method="post" id="add_user_form<?php echo $phone; ?>" enctype="multipart/form-data" class="user" action="">
                <div class="form-group">
                    <label>First Name </label>                                
                    <input type="text" required="" class="form-control form-control-sm"  id="first_name" name="first_name" >      
                      
                </div> 

                <div class="form-group">
                    <label>Last Name </label>                                
                    <input type="text" required="" class="form-control form-control-sm"  id="last_name" name="last_name" >      
                </div> 


                <div class="form-group">
                    <label>Phone </label>                                
                    <input type="text" required="" class="form-control form-control-sm"  id="phone" name="phone" >      
                </div> 

                  <div class="form-group">
                    <label>Email </label>                                
                    <input type="text" required="" class="form-control form-control-sm"  id="email" name="email" >      
                </div> 

                <div class="form-group">
                    <label>Password </label>                                
                    <input type="text" required="" class="form-control form-control-sm"  id="password" name="password" >      
                </div> 

                 <div class="form-group">
                    <label>Role</label>   
                    <select style="width: 100%;" required="" class="form-control form-control-sm" name="role" id="role">
                         <option value="">search an option</option>
                        <?php foreach($roles as $role){?>
                          <option value="<?php echo $role['role_id']; ?>"><?php echo $role['role_name']; ?></option>
                        <?php } ?>
                    </select>                                               
                </div>   

                     <input type="submit" value="Add a User" id="cmd_add_user"  name="cmd_add_user" class="btn btn-primary btn-sm btn-block"/>
                </a>
                
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
