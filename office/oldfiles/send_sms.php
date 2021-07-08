<?php require_once('config/instantiated_files.php');
       include('inc/header.php'); 
       if(isset($_GET['id'])){
          $sms_group_id = $_GET['id'];
       }else{
         header('location: home.php');
       }
       $sms_groups = get_rows_from_one_table('sms_groups','date_created');
       $param = [];
       $conditions = ['sms_group_id'=>$sms_group_id];
       $the_sms_group = get_one_row_from_one_table_with_sql_param($param,'sms_groups',$conditions,'date_created');
       $group_name = $the_sms_group['sms_group_name'];


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
            <h1 class="h3 mb-0 text-gray-800">Send SMS to this group: <?php echo $group_name; ?></h1>
            <!-- <a href="#" data-toggle='modal' data-target = '#upload_cleaned_data' class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i>Upload Cleaned Data</a> -->
          </div>

      



    

        <div class="row">

         
          
              <div class="col-md-11">
           
              <h6 class="m-0 font-weight-bold text-primary">Send SMS to this Group</h6>
              <p class="mb-4">You can send sms to this sms group</p>

              <div class="card shadow mb-4">
              <div class="row">
              <!-- <div class="col-lg-5 d-none d-lg-block bg-register-image"></div> -->
              <div class="col-lg-12">
              <div class="p-3">

              <form method="post" id="send_sms_group_form" enctype="multipart/form-data" class="user" action="">
               <!--  <div class="form-group">
                    <label>Message Subject </label>                                
                    <input type="text" required="" class="form-control form-control-sm"  id="sms_group_name" name="sms_group_name" >      
                </div>  -->

                <div class="form-group">
                   <input type="hidden" id="sms_group_id" name="sms_group_id" value="<?php echo $sms_group_id; ?>">
                    <label>Compose Message </label>                                
                    <textarea class="form-control form-control-sm"  id="sms_content" name="sms_content"></textarea>letters count: <strong><span id="count"></span></strong>       
                </div> 

                <div class="form-group">
                    <label>SMS Group List </label>                                
                    <select readonly style="width: 100%;"  required="" class="js-example-basic-multiple2" multiple="multiple" name="mem_number_list[]" id="mem_number_list">
                         
                         <?php
                            $numbers_list22 = json_decode($the_sms_group['numbers_list'],true);


                          for( $i=0; $i < count($numbers_list22); $i++){
                              $mem_det = get_one_row_from_one_table_by_id('users','unique_id',$numbers_list22[$i],'date_created');
                              $members_info = $mem_det['fname'].' '.$mem_det['lname'].' ('.$mem_det['phone'].')';

                          ?>

                          <option selected value="<?php echo $numbers_list22[$i]; ?>"><?php echo $members_info; ?></option>
                              
                         <?php } ?>

                        


                    </select>                
                </div> 
                <div class="result_div"></div>     
                     

                   
                <input type="submit" value="Send SMS" id="cmd_send_group_sms"  name="cmd_send_group_sms" class="btn btn-primary btn-sm btn-block"/>
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
