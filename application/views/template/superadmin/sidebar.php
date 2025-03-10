<!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-light-primary elevation-2">
    <!-- Brand Logo -->
    <a href="super_admin_dashboard" class="brand-link">
      <img src="assets/images/favicon.png" alt="Kisaan Icon" class="brand-image" style="opacity: .8">
      <span class="brand-text font-weight-light"><img class="brand-image" src="assets/images/klogo.png" alt="kisaan logo" style="opacity: .8"></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex align-items-center">
        <div class="image">
          <i class="fas fa-user-tie img-circle elevation-2 text-primary" style="font-size: .75rem;padding: 0.5rem;"></i>
        </div>
        <div class="info">
          <a href="#" class="d-block text-primary"><?php echo ucwords($_SESSION['comname']) ?></a>
          <span class="text-dark">
            WVS Admin
          </span>
        </div>
      </div>
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- dashboard links -->
          <li class="nav-item">
            <a href="super_admin_dashboard" class="nav-link <?php if ($thisPage=="dashboard"){ echo "active"; } ?>">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>Dashboard</p>
            </a>
          </li>
          <!-- Seed company details -->
          <li class="nav-item <?php if ($thisPage=="manageseedcompany" || $thisPage=="manageseedrcholder"){ echo "menu-open"; } ?>">
            <a href="#" class="nav-link <?php if ($thisPage=="manageseedcompany" || $thisPage=="manageseedrcholder"){ echo "active"; } ?>">
              <i class="nav-icon fa-solid fa-seedling"></i>
              <p>
                Seeds
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="manageseedcompany" class="nav-link <?php if ($thisPage=="manageseedcompany"){ echo "active"; } ?>">
                  <i class="fa-solid fa-building-user nav-icon"></i>
                  <p>Manage Seed Company</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="manageseedrcholder" class="nav-link <?php if ($thisPage=="manageseedrcholder"){ echo "active"; } ?>">
                  <i class="fa-solid fa-people-carry-box nav-icon"></i>
                  <p>Manage Seed RC Holder</p>
                </a>
              </li>
            </ul>
          </li>   
          <!-- Fertilizer company details -->
          <li class="nav-item <?php if ($thisPage=="manageflcompany" || $thisPage=="manageflrcholder"){ echo "menu-open"; } ?>">
            <a href="#" class="nav-link <?php if ($thisPage=="manageflcompany" || $thisPage=="manageflrcholder"){ echo "active"; } ?>">
              <i class="nav-icon fa-solid fa-sack-xmark"></i>
              <p>
                Fertilizer
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="manageflcompany" class="nav-link <?php if ($thisPage=="manageflcompany"){ echo "active"; } ?>">
                  <i class="fa-solid fa-building-user nav-icon"></i>
                  <p>Manage Fertilizer Company</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="manageflrcholder" class="nav-link <?php if ($thisPage=="manageflrcholder"){ echo "active"; } ?>">
                  <i class="fa-solid fa-people-carry-box nav-icon"></i>
                  <p>Manage Fertilizer RC Holder</p>
                </a>
              </li>
            </ul>
          </li> 
          <!-- Pesticides company details -->
          <li class="nav-item <?php if ($thisPage=="managepscompany" || $thisPage=="managerpscholder"){ echo "menu-open"; } ?>">
            <a href="#" class="nav-link <?php if ($thisPage=="managepscompany" || $thisPage=="managepsrcholder"){ echo "active"; } ?>">
              <i class="nav-icon fa-solid fa-bug"></i>
              <p>
                Pesticides
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="managepscompany" class="nav-link <?php if ($thisPage=="managepscompany"){ echo "active"; } ?>">
                  <i class="fa-solid fa-building-user nav-icon"></i>
                  <p>Manage Pesticide Company</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="managepsrcholder" class="nav-link <?php if ($thisPage=="managepsrcholder"){ echo "active"; } ?>">
                  <i class="fa-solid fa-people-carry-box nav-icon"></i>
                  <p>Manage Pesticide RC Holder</p>
                </a>
              </li>
            </ul>
          </li>
          <!-- Tarpaulin company details -->
          <li class="nav-item <?php if ($thisPage=="managetpcompany" || $thisPage=="managetprcholder"){ echo "menu-open"; } ?>">
            <a href="#" class="nav-link <?php if ($thisPage=="managetpcompany" || $thisPage=="managetprcholder"){ echo "active"; } ?>">
              <i class="nav-icon fa-solid fa-scroll"></i>
              <p>
                Tarpaulin
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="managetpcompany" class="nav-link <?php if ($thisPage=="managetpcompany"){ echo "active"; } ?>">
                  <i class="fa-solid fa-scroll nav-icon"></i>
                  <p>Manage Tarpaulin Company</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="managetprcholder" class="nav-link <?php if ($thisPage=="managetprcholder"){ echo "active"; } ?>">
                  <i class="fa-solid fa-scroll nav-icon"></i>
                  <p>Manage Tarpaulin RC Holder</p>
                </a>
              </li>
            </ul>
          </li> 
          <!-- Microirrigation company details -->
          <li class="nav-item <?php if ($thisPage=="managemicompany" || $thisPage=="managemircholder"){ echo "menu-open"; } ?>">
            <a href="#" class="nav-link <?php if ($thisPage=="managemicompany" || $thisPage=="managemircholder"){ echo "active"; } ?>">
              <i class="nav-icon fa-solid fa-arrow-up-from-ground-water"></i>
              <p>
                Micro Irrigation
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="managemicompany" class="nav-link <?php if ($thisPage=="managemicompany"){ echo "active"; } ?>">
                  <i class="fa-solid fa-building-user nav-icon"></i>
                  <p>Manage Microirrigation Company</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="managemircholder" class="nav-link <?php if ($thisPage=="managemircholder"){ echo "active"; } ?>">
                  <i class="fa-solid fa-people-carry-box nav-icon"></i>
                  <p>Manage Microirrigation RC Holder</p>
                </a>
              </li>
            </ul>
          </li>   
          <!-- Chemicals company details -->
          <li class="nav-item <?php if ($thisPage=="managecompany" || $thisPage=="managercholder"){ echo "menu-open"; } ?>">
            <a href="#" class="nav-link <?php if ($thisPage=="managecompany" || $thisPage=="managercholder"){ echo "active"; } ?> disabled">
              <i class="nav-icon fa-solid fa-flask"></i>
              <p>
                Chemicals
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="managecompany" class="nav-link <?php if ($thisPage=="managecompany"){ echo "active"; } ?>">
                  <i class="fa-solid fa-building-user nav-icon"></i>
                  <p>Manage Company</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="managercholder" class="nav-link <?php if ($thisPage=="managercholder"){ echo "active"; } ?>">
                  <i class="fa-solid fa-people-carry-box nav-icon"></i>
                  <p>Manage RC Holder</p>
                </a>
              </li>
            </ul>
          </li>     
          <!-- admin links -->
          <li class="nav-item">
            <a href="manageadmin" class="nav-link <?php if ($thisPage=="manageadmin"){ echo "active"; } ?>">
              <i class="nav-icon fa-solid fa-user-tie"></i>
              <p>Manage Admins</p>
            </a>
          </li>
          <!-- Reports -->
          <li class="nav-item <?php if ($thisPage=="client_report"){ echo "menu-open"; } ?>">
            <a href="#" class="nav-link <?php if ($thisPage=="client_report"){ echo "active"; } ?>">
              <i class="nav-icon fa-regular fa-chart-bar"></i>
              <p>
                Reports
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="client_report" class="nav-link <?php if ($thisPage=="client_report"){ echo "active"; } ?>">
                  <i class="nav-icon fa-solid fa-diagram-project"></i>
                  <p>Client Reports</p>
                </a>
              </li>              
            </ul>
          </li> 
          <!-- profile links -->          
          <li class="nav-item">
            <a href="super_admin_profile" class="nav-link <?php if ($thisPage=="userprofile"){ echo "active"; } ?>">
              <i class="nav-icon fa-regular fa-address-card"></i>
              <p>My Profile</p>
            </a>
          </li>
        </ul>
      </nav>      
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>