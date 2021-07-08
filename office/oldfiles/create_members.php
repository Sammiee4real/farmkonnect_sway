<?php require_once('config/instantiated_files.php');
       include('inc/header.php'); 

       $convert_stat = 0; 

       if(isset($_GET['convid'])){
          $convid = $_GET['convid'];
          
          $param = ['unique_id','fname','lname','phone','email','address'];
          $conditions = ['conversion_status'=>0];
          $outreach_member = get_one_row_from_one_table_with_sql_param($param,'outreach_members',$conditions,'date_created');
          
          if($outreach_member == null){
                   $convert_stat = 0;
          }else{
                    $fname = $outreach_member['fname'];
                    $phone = $outreach_member['phone'];
                    $email = $outreach_member['email'];
                    $lname = $outreach_member['lname'];
                    $address = $outreach_member['address'];
                    $convert_stat = 1;
          }
    


        }

       $units = get_rows_from_one_table('units','date_created');

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
            <h1 class="h3 mb-0 text-gray-800">Create New Member</h1>
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
              <h6 class="m-0 font-weight-bold text-primary">Create New Member</h6>
              <p class="mb-4">You can add a new member here</p>

            <div class="card shadow mb-4">


                   <div class="row">
          <!-- <div class="col-lg-5 d-none d-lg-block bg-register-image"></div> -->
          <div class="col-lg-12">
            <div class="p-3">
            
              <form method="post" id="create_member_form" enctype="multipart/form-data" class="user" action="">
              
              <?php  
                  if($convert_stat == 1){
              ?>  <div class="form-group">
                    <label>First Name </label>                                
                    <input type="text" required="" value="<?php echo $fname; ?>" class="form-control form-control-sm"  id="fname" name="fname" >      
                </div>
                 <div class="form-group">
                    <label>Last Name</label>                                
                    <input type="text" required="" value="<?php echo $lname; ?>" class="form-control form-control-sm"  id="lname" name="lname">      
                </div>
                <div class="form-group">
                    <label>Email</label>                                
                    <input type="email" required="" value="<?php echo $email; ?>" class="form-control form-control-sm"  id="email" name="email">      
                </div>
               <div class="form-group">
                    <label>Phone</label>                                
                    <input type="number" required="" class="form-control form-control-sm" value="<?php echo $phone; ?>"  id="phone" name="phone">      
                </div>

              <?php } else{?>

                    <div class="form-group">
                    <label>First Name </label>                                
                    <input type="text" required="" class="form-control form-control-sm"  id="fname" name="fname" >      
                </div>
                 <div class="form-group">
                    <label>Last Name</label>                                
                    <input type="text" required="" class="form-control form-control-sm"  id="lname" name="lname">      
                </div>
                <div class="form-group">
                    <label>Email</label>                                
                    <input type="email" required="" class="form-control form-control-sm"  id="email" name="email">      
                </div>
               <div class="form-group">
                    <label>Phone</label>                                
                    <input type="number" required="" class="form-control form-control-sm"  id="phone" name="phone">      
                </div>

              <?php } ?>
              



              <div class="form-group">
                    <label>Gender</label>   
                    <select class="form-control form-control-sm" name="gender" id="gender">
                         <option value="">select an option</option>
                         <option value="male">Male</option>
                         <option value="female">Female</option>
                    </select>                                     
                </div>

                 <div class="form-group">
                    <label>Date of Birth--Choose any year</label>                                
                    <input type="date" required="" class="form-control form-control-sm"  id="dob" name="dob">      
                </div>

                <div class="form-group">
                    <label>Marital Status</label>   
                    <select class="form-control form-control-sm" required="" name="marital_status" id="marital_status">
                         <option value="">select an option</option>
                         <option value="single">Single</option>
                         <option value="married">Married</option>
                    </select>                             
                          
                </div>

                <div class="alert alert-warning" id="marital_status_married">
                    <label>Wedding Anniversary Date</label>
                    <input type="date"  class="form-control form-control-sm"   id="wedding_anniversary_date" name="wedding_anniversary_date">      
                      <br>
                </div>


                

                 <div class="form-group">
                    <label>Unit(s) in Church</label>   
                    <select style="width: 100%;" class="js-example-basic-multiple"  multiple="multiple" name="units[]" id="units">
                         <option value=""></option>
                         <?php foreach($units as $unit){?>
                         <option value="<?php echo $unit['unit_id'];?>"><?php echo $unit['unit_name'];?></option>
                         <?php } ?>
                    </select>                             
                          
                </div>


                <div class="form-group">
                    <label>Address</label>                                
                   <?php  
                  if($convert_stat == 1){
                    ?> 
                    <input type="text" required="" class="form-control form-control-sm" value="<?php echo $address; ?>"  id="address" name="address"> 
                    <?php }else{
                      echo '<input type="text" required="" class="form-control form-control-sm"  id="address" name="address">';
                    }?>     
                </div>           
               
                <input type="submit" value="Create Member" id="cmd_create_member"  name="cmd_create_member" class="btn btn-primary btn-sm btn-block"/>
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
