<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="home">
        <div class="sidebar-brand-icon rotate-n-15">
          <!-- <i class="fas fa-laugh-wink"></i> -->
          <!-- <img src="../images/farmkonnect_logo.png" width="100" height="100"> -->
        </div>
        <div class="sidebar-brand-text mx-3"><?php echo $app_name; ?> <!-- <sup>2</sup> --></div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Nav Item - Dashboard -->
      <li class="nav-item active">
        <a class="nav-link" href="home">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Modules</span></a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading">
        Modules
      </div>
      <!-- Nav Item - Charts -->
     
      <li class="nav-item">
      <a class="nav-link" href="home">
      <i class="fas fa-fw fa-chart-area"></i>
      <span>Apply</span></a>
      </li>

      <li class="nav-item">
      <a class="nav-link" href="view_profile">
      <i class="fas fa-fw fa-chart-area"></i>
      <span>View Profile</span></a>
      </li>

       <?php 
            // if(   in_array('send_sms', $privileged_pages_dec) ||
            //       in_array('sms_sent_logs', $privileged_pages_dec) ||
            //       in_array('send_sms_to_all', $privileged_pages_dec) ||
            //       in_array('custom_send_sms', $privileged_pages_dec) ||
            //       in_array('blacklisted_numbers', $privileged_pages_dec)          
            //    ) {

                ?>

      

      <!-- Divider -->
      <hr class="sidebar-divider">


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