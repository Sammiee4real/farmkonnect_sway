<?php require_once('config/instantiated_files.php');
       include('inc/header.php'); 
      if( isset($_GET['iid']) ){
          $iid = $_GET['iid'];
      }

      $param = ['item_id','visibility','item_type','item_name'];
      $conditions = ['item_id'=>$iid];
      $accounting_item_det = get_one_row_from_one_table_with_sql_param($param,'accounting_items',$conditions,'date_added');
      $item_title = $accounting_item_det['item_name'];
      $visibility = $accounting_item_det['visibility'];

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
             <a href="all_accounting_items.php" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i>View All Items</a>
          </div>

      



    

        <div class="row">

         
          
              <div class="col-md-11">
           
              <h6 class="m-0 font-weight-bold text-primary">Edit Accounting Item:  <?php echo $item_title; ?></h6>
              <p class="mb-4">You can add accounting items  here</p>

              <div class="card shadow mb-4">
              <div class="row">
              <!-- <div class="col-lg-5 d-none d-lg-block bg-register-image"></div> -->
              <div class="col-lg-12">
              <div class="p-3">

              <form method="post" id="edit_acct_item_form" enctype="multipart/form-data" class="user" action="">
              
              <div class="form-group">
                   <input type="hidden" id="item_id" name="item_id" value="<?php echo $iid; ?>">
                    <label>Change Visibility* </label>
                    <select style="width: 100%;"  required="" class="jform-control form-control-sm"  name="visibility" id="visibility">
                            <option value="<?php echo $visibility;  ?>"><?php echo $visibility==0?'hide':'show';  ?></option>
                            <option value="1">show</option>
                            <option value="0">hide</option>
                     </select>                
                </div> 


               
                <input type="submit" value="Update Visibility" id="cmd_edit_acct_item"  name="cmd_edit_acct_item" class="btn btn-primary btn-sm btn-block"/>
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
