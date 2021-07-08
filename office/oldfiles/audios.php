<?php require_once('config/instantiated_files.php');
       include('inc/header.php'); 
       $audios = get_rows_from_one_table('audios','date_added');


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
            <h1 class="h3 mb-0 text-gray-800">Library/Store: Audios</h1>
            <!-- <a href="#" data-toggle='modal' data-target = '#upload_cleaned_data' class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i>Upload Cleaned Data</a> -->
          </div>

      



    

        <div class="row">

         
          
              <div class="col-md-10">
                <div class="row">
                <div class="col-md-12">
                <?php if(!empty($msg)){

                echo $msg;

                }?>
                  <a href="add_audios.php" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i>Add Audios</a>
                </div>
                </div>
               
                  <br>
              <h6 class="m-0 font-weight-bold text-primary">View Audios Here</h6>
              <p class="mb-4">You can view audios in the church here</p>

              <div class="card shadow mb-4">
              <!-- <hr> -->

              <div class="row">
                  <div class="col-lg-12 p-3">
                    <!-- <h6 class="m-3 font-weight-bold text-default">View Youtube Videos</h6> -->
                      <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>SN</th>
                      <th>Video Title</th>
                      <!-- <th>Video</th> -->
                      <th>Audio Author</th>
                      <th>Visibility</th>
                      <th>Audio link</th>
                      <th>Date Added</th>
                      
                      <th>Added By</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php 
                    if($audios == null){
                        echo "No record found";
                    }else{
                    $sn = 1;
                    foreach($audios as $audio){
                      $who_created_id = $audio['added_by'];
                      $visibility = $audio['visibility'];
                      
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
                      <td><?php echo $audio['title']; ?></td>
                      <td><?php echo $audio['author']; ?></td>
                      <td><?php echo $visib; ?></td>
                     <!-- <td> -->
                      <?php //echo $audio['embedded_code']; ?>
                      <!-- </td> -->
                      <td>
                        <a target="blank" href="<?php echo $audio['audio_link']; ?>">download audio</a>
                      </td>
                      <td><?php echo date('F-d-Y',strtotime($audio['date_added'])); ?></td>
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
