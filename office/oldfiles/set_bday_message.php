<?php require_once('config/instantiated_files.php');
       include('inc/header.php'); 
  $message = "";
  $message_param = ['message'];
  $conditions = ['id'=>1];
  $get_set_message = get_one_row_from_one_table_with_sql_param($message_param,'bday_message',$conditions,'last_updated');
  if($get_set_message != null){

      $message = $get_set_message['message'];

  }
  else{
  $message = "It's so beautiful to know that today is your birthday... We pray that all your heart desires come speedily in Jesus name...We love you dearly...
  Dunamis Ibadan";
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
              <h6 class="m-0 font-weight-bold text-primary">Set Birthday Message: Ensure it does not run into 2 message i.e double cost per sms</h6>
              <p class="mb-4">You can set birthday message here: this message drops as sms on birthdays<br>
              <span style="color: red;"><strong>Please ensure your message does not have the following words contained in it, else, sms will not deliver <ul><li>wow</li><li>useless</li><li>crazy</li><li>stupid</li></ul>More will be added as much as possible</strong></span></p>
              

              <div class="card shadow mb-4">
              <div class="row">
              <!-- <div class="col-lg-5 d-none d-lg-block bg-register-image"></div> -->
              <div class="col-lg-12">
              <div class="p-3">

              <form method="post" id="bday_message_form" enctype="multipart/form-data" class="user" action="">
                    
                 <div class="form-group">
                    <label>Birthday Message </label>                                
                    <textarea class="form-control form-control-sm"  id="sms_content" name="sms_content"><?php echo $message; ?></textarea>letters count: <strong><span id="count"></span></strong>       
                </div>     
                <input type="submit" value="Update Automatic Birthday Message" id="cmd_update_bday_message"  name="cmd_update_bday_message" class="btn btn-primary btn-sm btn-block"/>
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
