<?php require_once('config/instantiated_files.php');
       include('inc/header.php'); 
     
       $param = ['unique_id','fname','lname','phone'];
       $conditions = [];
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
            <h1 class="h3 mb-0 text-gray-800">Send SMS to ALL Members</h1>
            <!-- <a href="#" data-toggle='modal' data-target = '#upload_cleaned_data' class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i>Upload Cleaned Data</a> -->
          </div>

      



    

        <div class="row">

         
          
              <div class="col-md-11">
           
              <h6 class="m-0 font-weight-bold text-primary">Send SMS to ALL Members</h6>
              <p class="mb-4">You can send sms to ALL Members</p>

              <div class="card shadow mb-4">
              <div class="row">
              <!-- <div class="col-lg-5 d-none d-lg-block bg-register-image"></div> -->
              <div class="col-lg-12">
              <div class="p-3">

              <form method="post" id="all_sms_form" enctype="multipart/form-data" class="user" action="">
               <!--  <div class="form-group">
                    <label>Message Subject </label>                                
                    <input type="text" required="" class="form-control form-control-sm"  id="sms_group_name" name="sms_group_name" >      
                </div>  -->

                <div class="form-group">
                 
                    <label>Compose Message </label>                                
                    <textarea class="form-control form-control-sm"  id="sms_content" name="sms_content"></textarea>letters count: <strong><span id="count"></span></strong>       
                </div> 

                <div class="form-group">
                    <label>ALL Member(s): </label>                                
                    <select style="width: 100%;"  required="" class="js-example-basic-multiple2" multiple="multiple" name="mem_number_list[]" id="mem_number_list">
                         
                         <?php
                           
                          foreach( $users as $mem_det){
                              $members_info = $mem_det['fname'].' '.$mem_det['lname'].' ('.$mem_det['phone'].')';

                          ?>

                          <option selected=""  value="<?php echo $mem_det['unique_id']; ?>"><?php echo $members_info; ?></option>
                              
                         <?php } ?>

                        


                    </select>                
                </div> 
                <div class="result_div"></div>     

                   
                <input type="submit" value="Send SMS to ALL Members" id="cmd_send_sms_to_all"  name="cmd_send_sms_to_all" class="btn btn-primary btn-sm btn-block"/>
                </a>
                
              </form>
             
              
           
              </div>
              </div>
              </div>


              <hr>

             

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
