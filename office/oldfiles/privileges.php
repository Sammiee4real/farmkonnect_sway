<?php require_once('config/instantiated_files.php');
       include('inc/header.php'); 
       
       $units = get_rows_from_one_table('units','date_created');
       

      $results_array = array();

      if (is_dir($log_directory))
        {
         if ($handle = opendir($log_directory))
            {
                //Notice the parentheses I added:
                while(($file = readdir($handle)) !== FALSE)
                {
                        $results_array[] = $file;
                }
                closedir($handle);
           }
        }



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
            <a href="all_roles.php" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i>All Roles</a>
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
              <h6 class="m-0 font-weight-bold text-primary">Manage Roles and Privileges </h6>
              <p class="mb-4">You can add roles and privileges in the church here</p>

              <div class="card shadow mb-4">
              <div class="row">
              <!-- <div class="col-lg-5 d-none d-lg-block bg-register-image"></div> -->
              <div class="col-lg-12">
              <div class="p-3">

              <form method="post" id="add_role_privilege_form" enctype="multipart/form-data" class="user" action="">
                <div class="form-group">
                    <label>Name of Role </label>                                
                    <input type="text" required="" class="form-control form-control-sm"  id="role_name" name="role_name" >      
                </div> 

                 <div class="form-group">
                    <label>Read/Write Access</label>   
                    <select style="width: 100%;" required="" class="form-control form-control-sm" name="read_write_access" id="read_write_access">
                         <!-- <option value="">search an option</option> -->
                         <!-- <option value="read_only">read only</option> -->
                         <option value="read_write">both(read and write)</option>
                    </select>                                               
                </div>   

                 <div class="form-group">
                    <label>Add Pages this role can access: </label>   

                     <table style="padding: 8px;" class="table table-responsive table-bordered" id="dataTable" cellspacing="0">
                        <thead>
                        <tr>
                        <th> <input type="checkbox" id="checkAll"> All</th>     
                        <th>Page</th>
                        <th>Description</th>
                        <th>Page Link</th>
                        </tr>
                        </thead>
                         <tbody>
                        <?php
                         foreach($results_array as $value){
                            // echo $value.'<hr>';
                            // if(  count(explode('.', $value)) <= 1   ){
                             $phpcheck = explode('.', $value);
                                 if(  $value != 'logout.php' && (count($phpcheck) == 2)  && $phpcheck[count($phpcheck) - 1] == 'php' && !in_array($value, $files_exception_arr) ){ 
                           ?>     
                        <tr>

                          <td>
                            <input type="checkbox"    id="<?php echo explode('.', $value)[0]; ?>" name="<?php echo explode('.', $value)[0]; ?>">
                          </td>
                          <td><?php echo explode('.', $value)[0]; ?></td>
                          <td>
                            No Description
                          </td>
                          <td><a target="_blank" href="<?php echo $value; ?>">view link</a></td>

                        </tr>

                            <script type="text/javascript">     
                              $('#checkAll').click(function () {    
                              $('input:checkbox').prop('checked', this.checked);    
                              });
                            </script>

                        <?php 
                                // }
                              }
                            }
                        ?>
                        </tbody> 
                        </table>                             
             
          <input type="submit" value="Add User Role and Privileges" id="cmd_add_user_role"  name="cmd_add_user_role" class="btn btn-primary btn-sm btn-block"/>
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
