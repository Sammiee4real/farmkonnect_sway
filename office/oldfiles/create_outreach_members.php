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
            <h1 class="h3 mb-0 text-gray-800">Create New Outreach Member</h1>
          
            <a href="all_outreach_members.php" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i>View All</a>
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
              <h6 class="m-0 font-weight-bold text-primary">Create New Outreach Member</h6>
              <p class="mb-4">You can add a new outreach member here</p>

            <div class="card shadow mb-4">


                   <div class="row">
          <!-- <div class="col-lg-5 d-none d-lg-block bg-register-image"></div> -->
          <div class="col-lg-12">
            <div class="p-3">
            
              <form method="post" id="create_outreach_member_form" enctype="multipart/form-data" class="user" action="">
                <div class="form-group">
                    <label>First Name </label>                                
                    <input type="text" required="" class="form-control form-control-sm"  id="fname" name="fname" >      
                </div>
                 <div class="form-group">
                    <label>Last Name</label>                                
                    <input type="text" required="" class="form-control form-control-sm"  id="lname" name="lname">      
                </div>
              
               <div class="form-group">
                    <label>Phone</label>                                
                    <input type="number" required="" class="form-control form-control-sm"  id="phone" name="phone">      
                </div>

                  <div class="form-group">
                    <label>Email</label>                                
                    <input type="email" class="form-control form-control-sm"  id="email" name="email">      
                </div>


                  <div class="form-group">
                  <label>Address</label>                                
                  <input type="text" required="" class="form-control form-control-sm"  id="address" name="address">      
                  </div>

                
               
                <input type="submit" value="Create Out-reach Member" id="cmd_outreach_create_member"  name="cmd_outreach_create_member" class="btn btn-primary btn-sm btn-block"/>
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
