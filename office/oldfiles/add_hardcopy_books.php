<?php require_once('config/instantiated_files.php');
       include('inc/header.php'); 
        $hbooks = get_rows_from_one_table('hardcopy_books_tbl','date_added');

       if(isset($_POST['cmd_add_ebook'])){
            $title = $_POST['title'];
            $author = $_POST['author'];
            $visibility = $_POST['visibility'];
            $price_type = $_POST['ebook_price_type'];
            $price = $_POST['price_material'];
            $description = $_POST['more_info'];
            $file_name = $_FILES['file']['name'];
            $type = $_FILES['file']['type'];
            $size = $_FILES['file']['size'];
            $tmpName = $_FILES['file']['tmp_name'];


            $addebook = add_ebook($title,$author,$visibility,$price_type,$price,$description,$file_name, $size, $tmpName,$type,$uid);
            $addebook_dec = json_decode($addebook,true);
            if($addebook_dec['status'] != '111'){
                $msg = "<div class='alert alert-danger' >".$addebook_dec['msg']."</div><br>";
            }else{
                $msg = "<div class='alert alert-success' >".$addebook_dec['msg']."</div><br>";
                header('Refresh:5; url=ebooks.php');
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
            <h1 class="h3 mb-0 text-gray-800">Library/Store: Ebooks</h1>
            <!-- <a href="#" data-toggle='modal' data-target = '#upload_cleaned_data' class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i>Upload Cleaned Data</a> -->
          </div>

      



    

        <div class="row">

         
          
              <div class="col-md-10">
                <div class="row">
                <div class="col-md-12">
                <?php if(!empty($msg)){

                echo $msg;

                }?>
                 <a href="hardcopy_books.php" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i>View Hardcopy books</a>
                 
                </div>
                </div><br>
       <h6 class="m-0 font-weight-bold text-primary">Add Hardcopy book</h6>
              <p class="mb-4">You can add hardcopy books in the church here</p>

              <div class="card shadow mb-4">
              <div class="row">
              <!-- <div class="col-lg-5 d-none d-lg-block bg-register-image"></div> -->
              <div class="col-lg-12">
              <div class="p-3">

              <form method="post" id="add_hardcopy_book" enctype="multipart/form-data" class="user" action="">
                <div class="form-group">
                    <label>Title</label>                                
                    <input type="text" required="" class="form-control form-control-sm"  id="title" name="title" >      
                </div>          
                <div class="form-group">
                    <label>Author</label>                                
                    <input type="text" required="" class="form-control form-control-sm"  id="author" name="author" >      
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
                    <label>Type</label>                                
                    <select id="hardcopy_book_price_type" name="hardcopy_book_price_type" class="form-control form-control-sm">
                      <option value="">select an option</option>
                      <option value="0">Free</option>
                      <option value="1">Premium</option>
                    </select>      
                </div> 

                
            

              <div id="display_hardcopy_book_price" class="alert alert-sm alert-success">

                 
                  <div class="form-group">
                  <label>Price of Material &#8358;</label>                                
                  <input type="number" min="0"   class="form-control form-control-sm"  id="price_material" name="price_material" >      
                  </div>

              </div>

          <!--    <div class="form-group">
                       <label>Upload file. Maximum of 10Mb</label>                                
                <input type="file"  class="form-control form-control-sm"  name="file" >      
                </div> -->

                 <div class="form-group">
                    <label>About the Book</label>                                
                                                  
                    <textarea type="text" required="" class="form-control form-control-sm"  id="more_info" name="more_info" ></textarea>      
                </div> 

                <input type="submit" value="Add Hardcopy book" id="cmd_add_hardcopy_book"  name="cmd_add_hardcopy_book" class="btn btn-primary btn-sm btn-block"/>
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
