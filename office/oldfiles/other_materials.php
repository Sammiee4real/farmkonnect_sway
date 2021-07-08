<?php require_once('config/instantiated_files.php');
       include('inc/header.php'); 
       $hbooks = get_rows_from_one_table('hardcopy_books_tbl','date_added');

       if(isset($_POST['cmd_add_hardcopy_book'])){
            $title = $_POST['title'];
            $author = $_POST['author'];
            $visibility = $_POST['visibility'];
            $price_type = $_POST['hardcopy_book_price_type'];
            $price = $_POST['price_material'];
            $description = $_POST['more_info'];
            // $file_name = $_FILES['file']['name'];
            // $type = $_FILES['file']['type'];
            // $size = $_FILES['file']['size'];
            // $tmpName = $_FILES['file']['tmp_name'];


            $add_hardcopy_book = add_hardcopy_book($title,$author,$visibility,$price_type,$price,$description,$uid);
            $add_hardcopy_book_dec = json_decode($add_hardcopy_book,true);
            if($add_hardcopy_book_dec['status'] != '111'){
                $msg = "<div class='alert alert-danger' >".$add_hardcopy_book_dec['msg']."</div><br>";
            }else{
                $msg = "<div class='alert alert-success' >".$add_hardcopy_book_dec['msg']."</div><br>";
                header('Refresh:5; url=hardcopy_books.php');
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
            <h1 class="h3 mb-0 text-gray-800">Library/Store: Other Materials </h1>
            <!-- <a href="#" data-toggle='modal' data-target = '#upload_cleaned_data' class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i>Upload Cleaned Data</a> -->
          </div>

      



    

        <div class="row">

         
          
              <div class="col-md-10">
                <div class="row">
                <div class="col-md-12">
                <?php if(!empty($msg)){

                echo $msg;

                }?>
                </div>
                </div>
              <h6 class="m-0 font-weight-bold text-primary">Add Hardcopy book</h6>
              <p class="mb-4">You can add hardcopy books in the church here. Such materials are Anointing Oil, Bible etc</p>

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


              <hr>

              <div class="row">
                  <div class="col-lg-12 p-3">
                    <h6 class="m-3 font-weight-bold text-default">View All Hardcopy books</h6>

                      <div class="table-responsive">
                <table class="table table-bordered table-responsive" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>SN</th>
                      <th>Book Title</th>
                      <th>Author</th>
                      <th>Visibility</th>
                      <th>Date Added</th>
                      <th>Added By</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php 
                    if($hbooks == null){
                        echo "No record found";
                    }else{
                    $sn = 1;
                    foreach($hbooks as $hbook){
                      $who_created_id = $hbook['added_by'];
                      $visibility = $hbook['visibility'];
                      
                      if($visibility == 1){
                          $visib = "<span style='color:green;'>Yes</span>";
                      }
                      if($visibility == 0){
                          $visib = "<span style='color:red;'>No</span>";
                      }

                      $created_by = get_one_row_from_one_table_by_id('users','unique_id',$who_created_id,'date_created');
                      $fullname = $created_by['fname'].' '.$created_by['lname'];
                      ?>
                    <tr>
                      <td><?php echo $sn; ?></td>
                      <td><?php echo $hbook['title']; ?></td>
                      <td><?php echo $hbook['author']; ?></td>
                      <td><?php echo $visib; ?></td>
                      <td><?php echo date('F-d-Y',strtotime($hbook['date_added'])); ?></td>
                      <td><?php echo $fullname; ?></td>
                     </tr>
                    <?php $sn++;
                        }
                     } ?>
                   
                  </tbody>
                </table>
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
