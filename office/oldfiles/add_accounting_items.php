<?php require_once('config/instantiated_files.php');
       include('inc/header.php'); 
  

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
             <a href="all_accounting_items.php" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i>View Accounting Items</a>
          </div>

      



    

        <div class="row">

         
          
              <div class="col-md-11">
           
              <h6 class="m-0 font-weight-bold text-primary">Add Accounting Item</h6>
              <p class="mb-4">You can add accounting items  here</p>

              <div class="card shadow mb-4">
              <div class="row">
              <!-- <div class="col-lg-5 d-none d-lg-block bg-register-image"></div> -->
              <div class="col-lg-12">
              <div class="p-3">

              <form method="post" id="add_acct_item_form" enctype="multipart/form-data" class="user" action="">
                <div class="form-group">
                    <label>Name of Item e.g Offering, Purchase of diesel etc*</label>                                
                    <input type="text" required="" class="form-control form-control-sm"  id="item_name" name="item_name" >      
                </div> 
                <div class="form-group">
                   
                    <label>Choose Item Type* </label>
                    <select style="width: 100%;"  required="" class="jform-control form-control-sm"  name="item_type" id="item_type">
                            <option value="">Select an option</option>
                            <option value="income">Income</option>
                            <option value="expense">Expenditure</option>
                     </select>                
                </div> 


                 <div class="form-group">
                    <label>Item Description </label>                                
                    <input type="text"  class="form-control form-control-sm"  id="item_description" name="item_description" >      
                </div> 


                <input type="submit" value="Add Item" id="cmd_add_acct_item"  name="cmd_add_acct_item" class="btn btn-primary btn-sm btn-block"/>
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
