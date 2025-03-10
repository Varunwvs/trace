<!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-light-primary elevation-2">
    <!-- Brand Logo -->
    <a href="admin_dashboard" class="brand-link">
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
            Admin
          </span>
        </div>
      </div>
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- dashboard links -->
          <li class="nav-item">
            <a href="admin_dashboard" class="nav-link <?php if ($thisPage=="dashboard"){ echo "active"; } ?>">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>Dashboard</p>
            </a>
          </li>
          <!-- Center links -->
          <li class="nav-item">
            <a href="admin_manage_center" class="nav-link <?php if ($thisPage=="managecenter"){ echo "active"; } ?>">
            <i class="nav-icon fa-solid fa-street-view"></i>
              <p>Manage Center</p>
            </a>
          </li>  
          <!-- Product links -->
          <li class="nav-item">
            <a href="admin_manage_product" class="nav-link <?php if ($thisPage=="manageproduct"){ echo "active"; } ?>">
            <i class="nav-icon fa-solid fa-boxes-packing"></i>
              <p>Manage Product</p>
            </a>
          </li>  
          <!-- Product Import links -->
          <li class="nav-item">
            <a href="admin_import_product" class="nav-link <?php if ($thisPage=="productimport"){ echo "active"; } ?>">
              <i class="nav-icon fa-solid fa-upload"></i>
              <p>Import Product</p>
            </a>
          </li>
           <!-- K-Kisaan Api links -->
           <?php if($_SESSION['comcat']==='3'): ?>
           <li class="nav-item">
            <a href="mikkisaanapi" class="nav-link">
              <i class="nav-icon fa-solid fa-cloud-arrow-up"></i>
              <p>KKisan QR Api</p>
            </a>
          </li>
          <?php else : ?>
          <li class="nav-item">
            <a href="kkisaanapi" class="nav-link">
              <i class="nav-icon fa-solid fa-cloud-arrow-up"></i>
              <p>KKisan QR Api</p>
            </a>
          </li>
          <?php endif ?>
          <!-- profile links -->          
          <li class="nav-item">
            <a href="admin_profile" class="nav-link <?php if ($thisPage=="admin_profile"){ echo "active"; } ?>">
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