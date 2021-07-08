<?php require_once('config/instantiated_files.php');
       include('inc/header.php'); 
       $units = get_rows_from_one_table('units','date_created');
       
       if(isset($_GET['id'])){
            $member_id = $_GET['id'];
            $get_member_details = get_one_row_from_one_table_by_id('users','unique_id',$member_id,'date_created');
        
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
            <h1 class="h3 mb-0 text-gray-800">Edit Member Record</h1>
            <!-- <a href="#" data-toggle='modal' data-target = '#upload_cleaned_data' class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i>Upload Cleaned Data</a> -->
          </div>

      



    

        <div class="row">

         
          
              <div class="col-md-10">
                <div class="row">
                <div class="col-md-12">
                <?php if(!empty($msgupdate)){

                echo $msgupdate;

                }?>
                </div>
                </div>
              <h6 class="m-0 font-weight-bold text-primary">Edit Record for <?php echo $get_member_details['fname'].' '.$get_member_details['lname']; ?></h6>
              <p class="mb-4">You can edit a member record here</p>

            <div class="card shadow mb-4">


                   <div class="row">
          <!-- <div class="col-lg-5 d-none d-lg-block bg-register-image"></div> -->
          <div class="col-lg-12">
            <div class="p-3">
            
              <form method="post" id="edit_member_form" enctype="multipart/form-data" class="user" action="">
                <div class="form-group">
                    <label>First Name </label>                                
                    <input type="text" required="" class="form-control form-control-sm"  id="fname" name="fname" value="<?php echo $get_member_details['fname']; ?>" > 
                    <input type="hidden" required="" class="form-control form-control-sm"  id="member_id" name="member_id" value="<?php echo $member_id; ?>" >      
                </div>
                 <div class="form-group">
                    <label>Last Name</label>                                
                    <input type="text" required="" class="form-control form-control-sm"  id="lname" name="lname" value="<?php echo $get_member_details['lname']; ?>">      
                </div>
                <div class="form-group">
                    <label>Email</label>                                
                    <input type="email" required="" class="form-control form-control-sm"  id="email" name="email" value="<?php echo $get_member_details['email']; ?>">      
                </div>
               <div class="form-group">
                    <label>Phone</label>                                
                    <input type="number" required="" class="form-control form-control-sm"  id="phone" name="phone" value="<?php echo $get_member_details['phone']; ?>">      
                </div>

                <div class="form-group">
                    <label>Gender</label>   
                    <select class="form-control form-control-sm" name="gender" id="gender">
                         
                         <?php if($get_member_details['gender'] == 'male'){
                              echo '<option value="male">Male</option>';
                         } else{
                              echo '<option value="female">Female</option>';
                         }
                         ?>
                         <option value="male">Male</option>
                         <option value="female">Female</option>
                    </select>                             
                          
                </div>

                 <div class="form-group">
                    <label>Date of Birth--Choose any year</label>                                
                    <input type="date" required="" class="form-control form-control-sm" value="<?php echo $get_member_details['dob'];?>"  id="dob" name="dob">      
                </div>

                <div class="form-group">
                    <label>Marital Status</label>   
                    <select class="form-control form-control-sm" required="" name="marital_status" id="marital_status">
                          <?php if($get_member_details['marital_status'] == 'single'){
                              echo '<option value="single">Single</option>';
                         } else{
                              echo '<option value="married">Married</option>';
                         }
                         ?>
                         <option value="single">Single</option>
                         <option value="married">Married</option>
                    </select>                             
                          
                </div>

                <div class="alert alert-warning" id="marital_status_married">
                    <label>Wedding Anniversary Date</label>
                    <?php if($get_member_details['wedding_anniversary'] == null){?>
                    <input type="date"  class="form-control form-control-sm"    id="wedding_anniversary_date" name="wedding_anniversary_date">      
                    <?php } else{ ?>
                    <input type="date"  class="form-control form-control-sm" value="<?php echo $get_member_details['wedding_anniversary']; ?>"   id="wedding_anniversary_date" name="wedding_anniversary_date">      
                    <?php } ?>
                    <br>
                
                </div>

                <div class="form-group">
                    <label>Unit(s) in Church</label>   
                    <select style="width: 100%;" class="js-example-basic-multiple"  multiple="multiple" name="units[]" id="units">
                         <option value=""></option>
                         
                           <?php
                            $member_units = json_decode($get_member_details['units_array'],true);
                            for($i = 0 ; $i < count($member_units); $i++){
                                $get_unit_name = get_one_row_from_one_table_by_id('units','unit_id',$member_units[$i],'date_created');
                              ?>
                         <option value="<?php echo $member_units[$i];?>" selected><?php echo $get_unit_name['unit_name'];?></option>
                         <?php } ?>


                         <?php foreach($units as $unit){ if( !in_array($unit['unit_id'],$member_units)){?>       
                          <option value="<?php echo $unit['unit_id'];?> "><?php echo $unit['unit_name'];?></option>
                         <?php }   } ?>
                    </select>                             
                          
                </div>


                <div class="form-group">
                    <label>Address</label>                                
                    <input type="text" required="" class="form-control form-control-sm"  id="address" value="<?php echo $get_member_details['address']; ?>" name="address">      
                </div>           
               
                <input type="submit" value="Update Member Profile" id="cmd_edit_member"  name="cmd_edit_member" class="btn btn-primary btn-sm btn-block"/>
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
