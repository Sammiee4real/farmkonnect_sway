<?php require_once('config/instantiated_files.php');
       include('inc/header.php'); 
       
       if(isset($_POST['cmd_add_file'])){
            $title = $_POST['title'];
            $visibility = $_POST['visibility'];

            $file_name = $_FILES['file_name']['name'];
            $type = $_FILES['file_name']['type'];
            $size = $_FILES['file_name']['size'];
            $tmp_name = $_FILES['file_name']['tmp_name'];

 
            $add_files = add_files($title,$visibility,$uid,$file_name,$type,$size,$tmp_name);
            $add_files_dec = json_decode($add_files,true);
            if($add_files_dec['status'] != '111'){
                $msg = "<div class='alert alert-danger' >".$add_files_dec['msg']."</div><br>";
            }else{
                $msg = "<div class='alert alert-success' >".$add_files_dec['msg']."</div><br>";
                header('Refresh:5; url=view_files.php');
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
            <h1 class="h3 mb-0 text-gray-800">Files</h1>
            <!-- <a href="#" data-toggle='modal' data-target = '#upload_cleaned_data' class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i>Upload Cleaned Data</a> -->
          </div>

      



    

        <div class="row">

         
          
              <div class="col-md-10">
                <div class="row">
                <div class="col-md-12">
                <?php if(!empty($msg)){

                echo $msg;

                }?>
                  <a href="view_files.php" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i>View Files</a>
                 
                </div>
                </div>
                 <br>
              <h6 class="m-0 font-weight-bold text-primary">Add Files Here</h6>
              <p class="mb-4">You can add Files in the church here...files like homecell manuals, message manuals etc</p>

              <div class="card shadow mb-4">
              <div class="row">
              <!-- <div class="col-lg-5 d-none d-lg-block bg-register-image"></div> -->
              <div class="col-lg-12">
              <div class="p-3">

              <form method="post" id="add_file" enctype="multipart/form-data" class="user" action="">
                <div class="form-group">
                    <label>Title</label>                                
                    <input type="text" required="" class="form-control form-control-sm"  id="title" name="title" >      
                </div>          
            

                 <div class="form-group">
                    <label>Visibility</label>                                
                    <select  id="visibility" name="visibility" class="form-control form-control-sm">
                      <option value="">select an option</option>
                      <option value="1">show</option>
                      <option value="0">hide</option>
                    </select>      
                </div> 

               <div class="form-group">
                       <label>Upload the file(pdf, docx etc)</label> <br>
                       <input placeholder="Upload file" type="file" name="file_name" id="file_name" required="" class="form-control form-control-sm"><br>
                         
                </div>

        

                <input type="submit" value="Add File" id="cmd_add_file"  name="cmd_add_file" class="btn btn-primary btn-sm btn-block"/>
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
