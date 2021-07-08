<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="home">
        <div class="sidebar-brand-icon rotate-n-15">
          <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3"><?php echo $app_name; ?> <!-- <sup>2</sup> --></div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Nav Item - Dashboard -->
      <li class="nav-item active">
        <a class="nav-link" href="home">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Dashboard</span></a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading">
        Modules
      </div>
      <!-- Nav Item - Charts -->
     
       <!-- Nav Item - Pages Collapse Menu -->
    <?php 
            if(   in_array('all_members', $privileged_pages_dec) ||
                  in_array('create_members', $privileged_pages_dec) ||
                  in_array('single_member_search', $privileged_pages_dec) ||
                  in_array('birthdays', $privileged_pages_dec) ||
                  in_array('search_by_birthmonth', $privileged_pages_dec) ||
                  in_array('search_by_unit', $privileged_pages_dec)          
               ) {

                ?>
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
          <i class="fas fa-fw fa-cog"></i>
          <span>Members</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <?php if(in_array('all_members', $privileged_pages_dec)) { ?>
            <a class="collapse-item" href="all_members.php">All Members</a>    
            <?php } ?>
                  
            
            <?php if(in_array('create_members', $privileged_pages_dec)) { ?>
            <a class="collapse-item" href="create_members.php">New Member</a>
            <?php } ?>

            

            <?php if(in_array('single_member_search', $privileged_pages_dec)) { ?>
            <a class="collapse-item" href="single_member_search.php">Single Record Search</a>
            <?php } ?>

            
            <?php if(in_array('birthdays', $privileged_pages_dec)) { ?>
            <a class="collapse-item" href="birthdays.php">Birthday Celebrants</a>
            <?php } ?>

            
            <?php if(in_array('search_by_birthmonth', $privileged_pages_dec)) { ?>
            <a class="collapse-item" href="search_by_birthmonth.php">Birthmonth Celebrants</a>
            <?php } ?>

            

            <?php if(in_array('search_by_unit', $privileged_pages_dec)) { ?>
            <a class="collapse-item" href="search_by_unit.php">Search by Unit</a>
            <?php } ?>

         
          </div>
        </div>
      </li>
     <?php } ?>



       <?php 
            if(   in_array('send_sms', $privileged_pages_dec) ||
                  in_array('sms_sent_logs', $privileged_pages_dec) ||
                  in_array('send_sms_to_all', $privileged_pages_dec) ||
                  in_array('custom_send_sms', $privileged_pages_dec) ||
                  in_array('blacklisted_numbers', $privileged_pages_dec)          
               ) {

                ?>

        <!-- Nav Item - Pages Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo2" aria-expanded="true" aria-controls="collapseTwo2">
          <i class="fas fa-fw fa-chart-area"></i>
          <span>SMS</span>
        </a>
        <div id="collapseTwo2" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">

            <?php if(in_array('all_home_cells', $privileged_pages_dec)) { ?>
            <a class="collapse-item" href="send_sms_to_all.php">SMS to All</a>
            <?php } ?>


            <?php if(in_array('all_home_cells', $privileged_pages_dec)) { ?>          
            <a class="collapse-item" href="custom_send_sms.php">Send Custom Message</a>
            <?php } ?>



            <?php if(in_array('all_home_cells', $privileged_pages_dec)) { ?>
            <a class="collapse-item" href="#"><strong>SMS Groups</strong></a>
            

            <!-- <hr class="sidebar-divider d-none d-md-block"> -->
            <!-- <a class="collapse-item" href="">View/Edit Members</a> -->
            <?php 
                  $sms_groups_list = get_rows_from_one_table('sms_groups','date_created');
                  if($sms_groups_list == null){

            		echo '<a class="collapse-item" href="#">No SMS Group Yet</a>';

                  }else{


                  foreach($sms_groups_list as $sglist){
            ?>
            <form>
              <a class="collapse-item" href="send_sms.php?id=<?php echo $sglist['sms_group_id']; ?>"><?php echo $sglist['sms_group_name']; ?></a>
            </form>
            
            <?php } } ?>


          <?php } //sms groups ?>


            <?php if(in_array('sms_sent_logs', $privileged_pages_dec)) { ?>
            <a class="collapse-item" href="sms_sent_logs.php">SMS Logs</a>
            <?php }  ?>


            <?php if(in_array('blacklisted_numbers', $privileged_pages_dec)) { ?>
            <a class="collapse-item" href="blacklisted_numbers.php">Blacklisted Numbers</a>
              <?php }  ?>


          </div>
        </div>
      </li>
   <?php }  ?>


           <!-- Premium Feature Nav Item - Pages Collapse Menu -->
<!--       <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#heading11" aria-expanded="true" aria-controls="collapseTwo2">
            <i class="fas fa-fw fa-chart-area"></i>
          <span>Library/Store</span>
        </a>
        <div id="heading11" class="collapse" aria-labelledby="heading11" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="ebooks.php">E-books</a>          
            <a class="collapse-item" href="hardcopy_books.php">Hardcopy books</a>                   
            <a class="collapse-item" href="audios.php">Audios</a>          
            <a class="collapse-item" href="youtube_videos.php">Youtube Videos</a>          
            <a class="collapse-item" href="#">Premium Orders</a>          
            <a class="collapse-item" href="library_store">Visit Store</a>                    
          </div>
        </div>
      </li> 

      -another premium feature is advanced payment feature or integration
      -live streaming
      -advanced custom reporting with graphical display
      -complex accounting feature
      -social media integration:: displaying likes, notifications etc on site, analytics
      -
      -
    -->

  <?php 
            if(   in_array('all_home_cells', $privileged_pages_dec) ||
                  in_array('home_cell_members', $privileged_pages_dec) ||
                  in_array('log_hc_attendance', $privileged_pages_dec) ||
                  in_array('evaluate_attendance', $privileged_pages_dec)            
               ) {

                ?>
         <!-- Nav Item - Pages Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo5" aria-expanded="true" aria-controls="collapseTwo2">
          <i class="fas fa-fw fa-chart-area"></i>
          <span>Home Cells</span>
        </a>
        <div id="collapseTwo5" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <?php if(in_array('all_home_cells', $privileged_pages_dec)) { ?>
            <a class="collapse-item" href="all_home_cells.php">All Home Cells</a>  
            <?php } ?>

            <!-- <a class="collapse-item" href="all_home_cells.php">Add Members to a Home Cells</a>           -->
            
            <?php if(in_array('home_cell_members', $privileged_pages_dec)) { ?>
            <a class="collapse-item" href="home_cell_members.php">Home Cell Members</a>
            <?php } ?>


            <?php if(in_array('log_hc_attendance', $privileged_pages_dec)) { ?>
            <a class="collapse-item" href="log_hc_attendance.php">Log Attendance</a>
            <?php } ?>


            <?php if(in_array('evaluate_attendance', $privileged_pages_dec)) { ?>
            <a class="collapse-item" href="evaluate_attendance.php">Evaluate Attendance</a>
            <?php } ?>

          </div>
        </div>
      </li>
    <?php } ?>


  

  <?php 
            if(   in_array('all_outreach_members', $privileged_pages_dec) ||
                  in_array('create_outreach_members', $privileged_pages_dec) ||
                  in_array('send_sms_outreach', $privileged_pages_dec) ||
                  in_array('all_outreach_members', $privileged_pages_dec)            
               ) {

                ?>
          <!-- Nav Item - Pages Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo5k" aria-expanded="true" aria-controls="collapseTwo2">
          <i class="fas fa-fw fa-chart-area"></i>
            <span>Members Out-reach</span></a>
          
        </a>
        <div id="collapseTwo5k" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">


            <?php if(in_array('all_outreach_members', $privileged_pages_dec)) { ?>
            <a class="collapse-item" href="all_outreach_members.php">All Outreach Members</a>   
            <?php } ?>

            <!-- <a class="collapse-item" href="all_home_cells.php">Add Members to a Home Cells</a> 
                      -->
            
            <?php if(in_array('create_outreach_members', $privileged_pages_dec)) { ?>
            <a class="collapse-item" href="create_outreach_members.php">Create Out-reach Member</a>
            <?php } ?>

          
            <?php if(in_array('send_sms_outreach', $privileged_pages_dec)) { ?>
            <a class="collapse-item" href="send_sms_outreach.php">Send SMS</a>
            <?php } ?>

            
            <?php if(in_array('all_outreach_members', $privileged_pages_dec)) { ?>
            <a class="collapse-item" href="all_outreach_members.php">Convert to Member</a>
            <?php } ?>

            <!-- <a class="collapse-item" href="evaluate_attendance.php">Evaluate Attendance</a> -->
          </div>
        </div>
      </li>
    <?php } ?>




   <?php 
            if(   in_array('log_service_attendance', $privileged_pages_dec) ||
                  in_array('manage_service_attendance', $privileged_pages_dec) ||
                  in_array('see_all_service_attendance', $privileged_pages_dec) ||
                  in_array('see_all_service_attendance', $privileged_pages_dec) ||
                  in_array('member_in_reach', $privileged_pages_dec)            
               ) {

                ?>
             <!-- Nav Item - Pages Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo5kjj" aria-expanded="true" aria-controls="collapseTwo2">
          <i class="fas fa-fw fa-chart-area"></i>
            <span>Attendance Module</span></a>
          
        </a>
        <div id="collapseTwo5kjj" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">

            <?php if(in_array('log_service_attendance', $privileged_pages_dec)) { ?>
            <a class="collapse-item" href="log_service_attendance.php">Log by Unit</a>  
            <?php } ?>

            
            <?php if(in_array('manage_service_attendance', $privileged_pages_dec)) { ?>
            <a class="collapse-item" href="manage_service_attendance.php">Manage all attendance</a> 
            <?php } ?>

           
            <?php if(in_array('see_all_service_attendance', $privileged_pages_dec)) { ?>
             <a class="collapse-item" href="see_all_service_attendance.php">See all attendance</a>
            <?php } ?>

           
            <?php if(in_array('evaluate_attendance', $privileged_pages_dec)) { ?>
            <a class="collapse-item" href="evaluate_attendance.php">Evaluate attendance</a>
             <?php } ?>
      

            <?php if(in_array('member_in_reach', $privileged_pages_dec)) { ?>
            <a class="collapse-item" href="member_in_reach.php">Member In-reach</a>
            <?php } ?>



          </div>
        </div>
      </li>

    <?php } ?>




   

       <?php 
            if(  in_array('view_files', $privileged_pages_dec) ||
                 in_array('add_files', $privileged_pages_dec)           
               ) {

                ?>
     <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo5oo" aria-expanded="true" aria-controls="collapseTwo2">
          <i class="fas fa-fw fa-chart-area"></i>
            <span>Files Management</span></a>
          
        </a>
        <div id="collapseTwo5oo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">

            <?php if(in_array('view_files', $privileged_pages_dec)) { ?>
            <a class="collapse-item" href="view_files.php">All Files</a>    
            <?php } ?>

            <!-- <a class="collapse-item" href="all_home_cells.php">Add Members to a Home Cells</a>           -->

            <?php if(in_array('add_files', $privileged_pages_dec)) { ?>
            <a class="collapse-item" href="add_files.php">Create New File</a>
            <?php } ?>

          </div>
        </div>
      </li>
    <?php } ?>
      

     <!--  <li class="nav-item">
      <a class="nav-link" href="#">
      <i class="fas fa-fw fa-chart-area"></i>
      <span>Programme Archive</span></a>
      </li> -->


       <?php 
            if(  in_array('log_income', $privileged_pages_dec) ||
                 in_array('log_expenses', $privileged_pages_dec) ||
                 in_array('search_acct_entries', $privileged_pages_dec) ||
                 in_array('view_acct_entries', $privileged_pages_dec)                   
               ) {

                ?>
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo52o" aria-expanded="true" aria-controls="collapseTwo2">
          <i class="fas fa-fw fa-chart-area"></i>
            <span>Basic Accounting</span></a>
          
        </a>
        <div id="collapseTwo52o" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            
            <?php if(in_array('log_income', $privileged_pages_dec)) { ?>
              <a class="collapse-item" href="log_income.php">Log income entry</a>   
            <?php } ?>


            <?php if(in_array('log_expenses', $privileged_pages_dec)) { ?>       
            <a class="collapse-item" href="log_expenses.php">Log expense entry</a> 
            <?php } ?>


           <?php if(in_array('view_acct_entries', $privileged_pages_dec)) { ?>         
            <a class="collapse-item" href="view_acct_entries.php">View entries</a>
            <?php } ?>

             <?php if(in_array('search_acct_entries', $privileged_pages_dec)) { ?>         
            <a class="collapse-item" href="search_acct_entries.php">Search a range</a>
            <?php } ?>
          

          </div>
        </div>
      </li>
     <?php } ?>



   <?php if(in_array('reports', $privileged_pages_dec)) { ?>
      <li class="nav-item">
      <a class="nav-link" href="reports.php">
      <i class="fas fa-fw fa-chart-area"></i>
      <span>Reports</span></a>
      </li>
  <?php } ?>



   <?php if(in_array('website_request', $privileged_pages_dec)) { ?>
      <li class="nav-item">
      <a class="nav-link" href="website_request.php">
      <i class="fas fa-fw fa-chart-area"></i>
      <span>Website Request</span></a>
      </li>
  <?php } ?>

    

     <!--   <li class="nav-item">
      <a class="nav-link" href="#">
      <i class="fas fa-fw fa-chart-area"></i>
      <span>Accounting Module</span></a>
      </li> -->


    <!--   <li class="nav-item">
      <a class="nav-link" href="#">
      <i class="fas fa-fw fa-chart-area"></i>
      <span>Social Media Handles</span></a>
      </li>


       <li class="nav-item">
        <a class="nav-link" href="#">
          <i class="fas fa-fw fa-chart-area"></i>
          <span>Advanced Online Giving</span></a>
      </li>

       -->


       <!-- ///just set payment page then get the transactions into a table view::::::::use flutterwave -->
   <?php if(in_array('online_giving', $privileged_pages_dec)) { ?>
      <li class="nav-item">
      <a class="nav-link" href="online_giving.php">
      <i class="fas fa-fw fa-chart-area"></i>
      <span>Online Givings</span></a>
      </li>
    <?php } ?>
     <!--   <li class="nav-item">
      <a class="nav-link" href="#">
      <i class="fas fa-fw fa-chart-area"></i>
      <span>Privileges</span></a>
      </li> -->
   
      <!--   <li class="nav-item">
      a basic flow of app usage in pdf
      <a class="nav-link" href="#">
      <i class="fas fa-fw fa-chart-area"></i>
      <span>Help</span></a>
      </li> -->

      <!-- Nav Item - Pages Collapse Menu -->
     <!--  if( $current_page != 'add_unit'  &&
              $current_page != 'set_bday_message'  &&
              $current_page != 'add_sms_groups'  &&
              $current_page != 'add_home_cells'  &&
              $current_page != 'manage_home_cells'  &&
              $current_page != 'add_accounting_items' &&
              $current_page != 'all_accounting_items' &&
              $current_page != 'privileges' &&
              $current_page != 'add_users' ) 
              
            -->

       <?php 
            if(  in_array('add_unit', $privileged_pages_dec) ||
                 in_array('set_bday_message', $privileged_pages_dec) ||
                 in_array('add_sms_groups', $privileged_pages_dec) ||
                 in_array('add_home_cells', $privileged_pages_dec) ||
                 in_array('manage_home_cells', $privileged_pages_dec) ||
                 in_array('add_accounting_items', $privileged_pages_dec) ||
                 in_array('all_accounting_items', $privileged_pages_dec) ||
                 in_array('privileges', $privileged_pages_dec)  ||
                 in_array('all_users', $privileged_pages_dec)  ||
                 in_array('add_users', $privileged_pages_dec) 
               ) {

                ?>

      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo3" aria-expanded="true" aria-controls="collapseTwo3">
          <i class="fas fa-fw fa-cog"></i>
          <span>Settings</span>
        </a>
        <div id="collapseTwo3" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <?php if(in_array('add_unit', $privileged_pages_dec)) { ?>
            <a class="collapse-item" href="add_unit.php">Units/Departments</a>
            <?php } ?>
            <!-- <a class="collapse-item" href="add_unit.php">Offering Categories</a> -->
             <?php if(in_array('set_bday_message', $privileged_pages_dec)) { ?>
            <a class="collapse-item" href="set_bday_message.php">Automatic Birthday SMS</a>
            <?php } ?>

             <?php if(in_array('add_sms_groups', $privileged_pages_dec)) { ?>
            <a class="collapse-item" href="add_sms_groups.php">SMS Groups</a>
            <?php } ?>

             <?php if(in_array('add_home_cells', $privileged_pages_dec)) { ?>
            <a class="collapse-item" href="add_home_cells.php">Add Home Cells</a>
            <?php } ?>

             <?php if(in_array('manage_home_cells', $privileged_pages_dec)) { ?>
            <a class="collapse-item" href="manage_home_cells.php">Manage Home Cells</a>
            <?php } ?>

             <?php if(in_array('add_accounting_items', $privileged_pages_dec)) { ?>
            <a class="collapse-item" href="add_accounting_items.php">Add Accounting items</a>
            <?php } ?>

             <?php if(in_array('all_accounting_items', $privileged_pages_dec)) { ?>
            <a class="collapse-item" href="all_accounting_items.php">All Accounting items</a>
            <?php } ?>

             <?php if(in_array('privileges', $privileged_pages_dec)) { ?>
            <a class="collapse-item" href="privileges.php">Privileges</a>
            <?php } ?>

              <?php if(in_array('all_users', $privileged_pages_dec)) { ?>
            <a class="collapse-item" href="all_users.php">Users</a>
            <?php } ?>

             <?php if(in_array('add_users', $privileged_pages_dec)) { ?>
            <a class="collapse-item" href="add_users.php">Add User</a>
            <?php } ?>

           

          </div>
        </div>
      </li>
    <?php }  ?>


      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Heading -->
      <!--     <div class="sidebar-heading">
      Addons
      </div> -->

      <li class="nav-item">
      <a class="nav-link" href="./logout">
      <i class="fas fa-fw fa-chart-area"></i>
      <span>Logout</span></a>
      </li>

  
      <!-- Divider -->
      <hr class="sidebar-divider d-none d-md-block">

      <!-- Sidebar Toggler (Sidebar) -->
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>

    </ul>