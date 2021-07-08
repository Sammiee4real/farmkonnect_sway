<?php require_once('config/instantiated_files.php');
       include('inc/header.php'); 
       $youtube_videos = get_rows_from_one_table('youtube_videos','date_added');


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
            <h1 class="h3 mb-0 text-gray-800">Library/Store: Youtube Videos</h1>
            <!-- <a href="#" data-toggle='modal' data-target = '#upload_cleaned_data' class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i>Upload Cleaned Data</a> -->
          </div>

      



    

        <div class="row">

         
          
              <div class="col-md-10">
                <div class="row">
                <div class="col-md-12">
                <?php if(!empty($msg)){

                echo $msg;

                }?>
                  <a href="add_youtube_videos.php" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i>Add Youtube Videos</a>
                </div>
                </div>
               
                  <br>
              <h6 class="m-0 font-weight-bold text-primary">View Youtube Videos Here</h6>
              <p class="mb-4">You can view youtube videos in the church here</p>

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
                      <th>Video Author</th>
                      <th>Visibility</th>
                      <th>Video link</th>
                      <th>Date Added</th>
                      
                      <th>Added By</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php 
                    if($youtube_videos == null){
                        echo "No record found";
                    }else{
                    $sn = 1;
                    foreach($youtube_videos as $yvid){
                      $who_created_id = $yvid['added_by'];
                      $visibility = $yvid['visibility'];
                      
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
                      <td><?php echo $yvid['title']; ?></td>
                      <td><?php echo $yvid['author']; ?></td>
                      <td><?php echo $visib; ?></td>
                     <!-- <td> -->
                      <?php //echo $yvid['embedded_code']; ?>
                      <!-- </td> -->
                      <td>
                        

                      <a href="#" data-toggle="modal" data-target="#tt<?php echo $yvid['youtube_id']; ?>">
                      See Video
                      </a>

                      <div class="modal fade" id="tt<?php echo $yvid['youtube_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog modal-lg" role="document">
                      <div class="modal-content">
                      <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">Video for the title: <strong><?php echo $yvid['title']; ?></strong></h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                      </button>
                      </div>
                      <div class="modal-body">
                        
                        <div style="max-width: 50px;"><?php echo $yvid['embedded_code']; ?></div>


                      </div>
                      <div class="modal-footer">
                      <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> -->
                      <button type="button" class="btn btn-primary">Close</button>
                      </div>
                      </div>
                      </div>
                      </div>

                      </td>

                    


                 


                      
                      <td><?php echo date('F-d-Y',strtotime($yvid['date_added'])); ?></td>
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
