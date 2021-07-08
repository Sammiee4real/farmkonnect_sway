<?php require_once('config/instantiated_files.php');
       include('inc/header.php'); 
       $home_cells = get_rows_from_one_table('home_cell_definition','date_created');
       $param = ['unique_id','fname','lname','phone'];
       $conditions = ['role'=>'2'];
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
             <a href="manage_home_cells.php" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i>Manage Home Cell</a>
          </div>

      



    

        <div class="row">

         
          
              <div class="col-md-11">
           
              <h6 class="m-0 font-weight-bold text-primary">Add Home Cells</h6>
              <p class="mb-4">You can add home cells  here</p>

              <div class="card shadow mb-4">
              <div class="row">
              <!-- <div class="col-lg-5 d-none d-lg-block bg-register-image"></div> -->
              <div class="col-lg-12">
              <div class="p-3">

              <form method="post" id="add_home_cell" enctype="multipart/form-data" class="user" action="">
                <div class="form-group">
                    <label>Name of Home Cell e.g Tower of Grace </label>                                
                    <input type="text" required="" class="form-control form-control-sm"  id="home_cell_name" name="home_cell_name" >      
                </div> 
                <div class="form-group">
                   
                    <label>Choose Cell Leader </label>
                    <select style="width: 100%;"  required="" class="js-example-basic-single"  name="cell_leader" id="cell_leader">
                      <option value="">Select Cell Leader</option>
                         <?php foreach($users as $member){
                              $members_info = $member['fname'].' '.$member['lname'].' ('.$member['phone'].')';
                          ?>
                            
                            <option value="<?php echo $member['unique_id']; ?>"><?php echo $members_info; ?></option>
                              
                         <?php } ?>
                    </select>                
                </div> 


                   <div class="form-group">
                    <label>Choose Cell Host </label>                                
                    <select style="width: 100%;"  required="" class="js-example-basic-single"  name="cell_host"  name="cell_host" id="cell_host">
                         <option value="">Select Cell Host</option>
                         
                         <?php foreach($users2 as $member){
                              $members_info = $member['fname'].' '.$member['lname'].' ('.$member['phone'].')';
                          ?>
                            
                            <option value="<?php echo $member['unique_id']; ?>"><?php echo $members_info; ?></option>
                              
                         <?php } ?>
                    </select>                
                </div> 

                <div class="form-group">
                    <label>Add atleast 1 member to this Cell </label>                                
                    <select style="width: 100%;"  required="" class="js-example-basic-multiple3" multiple="multiple" name="cell_members[]" id="cell_members">
                          <!-- <option value="">Select Member(s)</option> -->
                         
                         <?php foreach($users3 as $member){
                              $members_info = $member['fname'].' '.$member['lname'].' ('.$member['phone'].')';

                              ///further check to ensure user is not in another group
                              $check = check_if_member_in_another_home_cell($member['unique_id']);
                              $check_dec = json_decode($check ,true);
                              if(       $check_dec['status'] == 111      ){


                          ?>
                            
                            <option value="<?php echo $member['unique_id']; ?>"><?php echo $members_info; ?></option>
                              
                         <?php } else{ ?>

                            <option  disabled="" value="<?php echo $member['unique_id']; ?>"><strong><?php echo $members_info.'('.$check_dec['msg'].')'; ?></strong></option>

                         <?php }

                          }

                          ?>
                    </select>                
                </div> 

                 <div class="form-group">
                    <label>CellAddress</label>                                
                    <input type="text" required="" class="form-control form-control-sm"  id="cell_address" name="cell_address" >      
                </div> 


                 <div class="form-group">
                    <label>Other Information </label>                                
                    <input type="text" required="" class="form-control form-control-sm"  id="other_info" name="other_info" >      
                </div> 


                <input type="submit" value="Add Home Cell" id="cmd_add_home_cell"  name="cmd_add_home_cell" class="btn btn-primary btn-sm btn-block"/>
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
