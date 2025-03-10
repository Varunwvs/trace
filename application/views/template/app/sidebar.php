<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-light-primary elevation-2">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
      <!--<img src="assets/images/favicon.png" alt="Kisaan Icon" class="brand-image" style="opacity: .8">-->
      <!--<span class="brand-text font-weight-light"><img class="brand-image" src="assets/images/klogo.png" alt="kisaan logo" style="opacity: .8"></span>-->
            <span class="brand-text font-weight-light"><img class="brand-image" src="assets/images/trace-logo.png" alt="kisaan logo" style="opacity: .8"></span>

    </a>
    <?php 
        if($_SESSION['comcat']==="1"){
            $dashboard = "sdashboard";
            // if($_SESSION['comid']==='218'){
            //     $productmanage = "productmanage";
            // }else{
            //     $productmanage = "productmanages";
            // }
            $productmanage = "productmanage";
            $lyproductmanage = "lyproductmanage";
            $pproductmanage = "psdproductmanage";
            $productimport = "productimport";
            $containermanage = "containermanage";
            $userprofile = "userprofile";
            $ctype = "Seeds Company";
            $cicon = '<i class="fa-solid fa-seedling img-circle elevation-2 text-green" style="font-size: .75rem;padding: 0.5rem;"></i>';
            $kkisaanapi="kkisaanapi";
        } 
        elseif($_SESSION['comcat']==="2"){
            $dashboard = "fldashboard";
            $productmanage = "flproductmanage";
            $lyproductmanage = "flyproductmanage";
            $productimport = "flproductimport";
            $containermanage = "flcontainermanage";
            $userprofile = "fluserprofile";
            $ctype = "Fertilizer Company";
            $cicon = '<i class="fa-solid fa-sack-xmark img-circle elevation-2 text-green" style="font-size: .75rem;padding: 0.5rem;"></i>';
            $kkisaanapi="flkkisaanapi";
        } 
        elseif($_SESSION['comcat']==="3"){
            $dashboard = "midashboard";
            $productmanage = "miproductmanage";
            $lyproductmanage = "mlyproductmanage";
            $pproductmanage = "";
            $productimport = "miproductimport";
            $containermanage = "micontainermanage";
            $userprofile = "miuserprofile";
            $ctype = "Micro Irrigation Company";
            $cicon = '<i class="fa-solid fa-arrow-up-from-ground-water img-circle elevation-2 text-green" style="font-size: .75rem;padding: 0.5rem;"></i>';
            $kkisaanapi="mikkisaanapi";
        } 
        elseif($_SESSION['comcat']==="4"){
            $dashboard = "cdashboard";
            $productmanage = "cproductmanage";
            $lyproductmanage = "clyproductmanage";
            $productimport = "cproductimport";
            $containermanage = "ccontainermanage";
            $userprofile = "cuserprofile";
            $ctype = "Chemicals Company";
            $cicon = '<i class="fa-solid fa-flask img-circle elevation-2 text-green" style="font-size: .75rem;padding: 0.5rem;"></i>';
            $kkisaanapi="chkkisaanapi";
        }   
        elseif($_SESSION['comcat']==="5"){
          $dashboard = "psdashboard";
          $productmanage = "psproductmanage";
          $lyproductmanage = "plyproductmanage";
          $pproductmanage = "ppsproductmanage";
          $productimport = "psproductimport";
          $pproductbulkimport = "psbproductimport";
          $containermanage = "pscontainermanage";
          $userprofile = "psuserprofile";
          $ctype = "Pesticide Company";
          $cicon = '<i class="fa-solid fa-flask img-circle elevation-2 text-green" style="font-size: .75rem;padding: 0.5rem;"></i>';
          $kkisaanapi="pskkisaanapi";
        }  
      elseif($_SESSION['comcat']==="6"){
            $dashboard = "fldashboard";
            $productmanage = "flproductmanage";
            $lyproductmanage = "flyproductmanage";
            $productimport = "flproductimport";
            $containermanage = "flcontainermanage";
            $userprofile = "fluserprofile";
            $ctype = "Fertilizer Company";
            $cicon = '<i class="fa-solid fa-sack-xmark img-circle elevation-2 text-green" style="font-size: .75rem;padding: 0.5rem;"></i>';
            $kkisaanapi="flkkisaanapi";
        } 
        elseif($_SESSION['comcat']==="7"){
            $dashboard = "tpdashboard";
            $productmanage = "tpproductmanage";
            $lyproductmanage = "tlyproductmanage";
            $productimport = "tpproductimport";
            $containermanage = "tpcontainermanage";
            $userprofile = "tpuserprofile";
            $ctype = "Tarpaulin Company";
            $cicon = '<i class="fa-solid fa-sack-xmark img-circle elevation-2 text-green" style="font-size: .75rem;padding: 0.5rem;"></i>';
            $kkisaanapi="tpkkisaanapi";
        } 
      ?>
    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex align-items-center">
        <div class="image">
          <?php echo $cicon ?>
        </div>
        <div class="info">
          <a href="#" class="d-block info-head"><?php echo ucwords($_SESSION['comname']) ?></a>
          <span class="info-subhead">Com. ID: <?php echo strtoupper($_SESSION['comid']) ?><br></span>
          <span class="info-subhead"><?php echo strtoupper($_SESSION['role']) ?></span>
        </div>
      </div>
      
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- dashboard links -->
          <li class="nav-item">
            <a href="<?php echo $dashboard ?>" class="nav-link <?php if ($thisPage=="dashboard"){ echo "active"; } ?>">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>Dashboard</p>
            </a>
          </li>
        
       
          <!-- farmer module -->
          <li class="nav-item <?php if ($thisPage=="farmermanage" || $thisPage=="cropmanage" || $thisPage=="farmingactivitymanage" || $thisPage=="inputmanage" || $thisPage=="labourmanage" || $thisPage=="taskmanage" ){ echo "menu-open"; } ?>">
            <a href="#" class="nav-link <?php if ($thisPage=="farmermanage" || $thisPage=="cropmanage" || $thisPage=="farmingactivitymanage" || $thisPage=="inputmanage" || $thisPage=="labourmanage" || $thisPage=="taskmanage"){ echo "active"; } ?>">
            <i class="nav-icon fa-solid fa-snowflake"></i>
              <p>
                Farm Management
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
                  
              <li class="nav-item">
                <a href="farmermanage" class="nav-link <?php if ($thisPage=="farmermanage"){ echo "active"; } ?>">
                  <i class="nav-icon fa-solid fa-user-circle"></i>
                  <p>Farmer Profile</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="cropmanage" class="nav-link <?php if ($thisPage=="cropmanage"){ echo "active"; } ?>">
                  <i class="nav-icon fa-solid fa-leaf"></i>
                  <p>Crop Master</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="inputmanage" class="nav-link <?php if ($thisPage=="inputmanage"){ echo "active"; } ?>">
                  <i class="nav-icon fa-solid fa-plus-circle"></i>
                  <p>Inputs Master</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="farmingactivitymanage" class="nav-link <?php if ($thisPage=="farmingactivitymanage"){ echo "active"; } ?>">
                  <i class="nav-icon fa-solid fa-seedling"></i>
                  <p>Farming Activities</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="#" class="nav-link <?php if ($thisPage==""){ echo "active"; } ?>">
                  <i class="nav-icon fa-solid fas fa-tree"></i>
                  <p>Advisory</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="#" class="nav-link <?php if ($thisPage==""){ echo "active"; } ?>">
                  <i class="nav-icon fa-solid fas fa-angle-double-right"></i>
                  <p>Agronomy Best Practices</p>
                </a>
              </li>
            
              <li class="nav-item">
                <a href="#" class="nav-link <?php if ($thisPage==""){ echo "active"; } ?>">
                  <i class="nav-icon fa-solid  fa-calendar"></i>
                  <p>Crop Schedule</p>
                </a>
              </li>

               <!-- Harvesting form -->
              <li class="nav-item">
                    <a href="harvestingmanage" class="nav-link <?php if ($thisPage=="harvestingmanage"){ echo "active"; } ?>">
                      <i class="nav-icon fa-solid fas fa-spa"></i>
                      <p>Harvesting Details </p>
                    </a>
              </li> 

              <!-- Labour Management -->
              <li class="nav-item <?php if ($thisPage=="labourmanage" || $thisPage=="taskmanage"){ echo "menu-open"; } ?>">
                <a href="#" class="nav-link <?php if ($thisPage=="labourmanage" || $thisPage=="taskmanage"){ echo "active"; } ?>">
                <i class="nav-icon fa-solid fas fa-users"></i>
                  <p>
                    Labour Management
                    <i class="fas fa-angle-left right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                      
                  <li class="nav-item">
                    <a href="labourmanage" class="nav-link <?php if ($thisPage=="labourmanage"){ echo "active"; } ?>">
                      <i class="nav-icon fa-solid fa-user-circle"></i>
                      <p>Labour Profile</p>
                    </a>
                  </li>

                  <li class="nav-item">
                    <a href="taskmanage" class="nav-link <?php if ($thisPage=="taskmanage"){ echo "active"; } ?>">
                      <i class="nav-icon fa-solid fa-wrench"></i>
                      <p>Tasks</p>
                    </a>
                  </li>

                  <li class="nav-item">
                    <a href="labourhygiene" class="nav-link <?php if ($thisPage=="labourhygiene"){ echo "active"; } ?>">
                      <i class="nav-icon fa-solid fa-wrench"></i>
                      <p>Health & Hygiene</p>
                    </a>
                  </li>
                
                </ul>
              </li>

              <!-- Reports -->
              <li class="nav-item <?php if ($thisPage==""){ echo "menu-open"; } ?>">
                <a href="#" class="nav-link <?php if ($thisPage==""){ echo "active"; } ?>">
                <i class="nav-icon fa-solid fa-file-text"></i>
                  <p>
                    Reports
                    <i class="fas fa-angle-left right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                      
                  <li class="nav-item">
                    <a href="#" class="nav-link <?php if ($thisPage==""){ echo "active"; } ?>">
                      <i class="nav-icon fa-solid fa-plus-square"></i>
                      <p>Soil Health Testing</p>
                    </a>
                  </li>

                  <li class="nav-item">
                    <a href="#" class="nav-link <?php if ($thisPage==""){ echo "active"; } ?>">
                      <i class="nav-icon fa-solid fa-dot-circle"></i>
                      <p>Disease Management</p>
                    </a>
                  </li>
                
                </ul>
              </li>

            </ul>
          </li>

        

          <li class="nav-item <?php if ($thisPage=="productmanage" || $thisPage=="sourcingmanage" || $thisPage=="processing" || $thisPage=="raw_materials" || $thisPage=="categorymanage"){ echo "menu-open"; } ?>">
            <a href="#" class="nav-link <?php if ($thisPage=="productmanage" || $thisPage=="sourcingmanage" || $thisPage=="processing" || $thisPage=="raw_materials" || $thisPage=="categorymanage"){ echo "active"; } ?>">
            <i class="nav-icon fa-solid fa-bullseye"></i>
              <p>
                Product Management
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">

            <!-- product links -->
          <li class="nav-item">
            <a href="<?php echo $productmanage ?>" class="nav-link <?php if ($thisPage=="productmanage"){ echo "active"; } ?>">
              <i class="nav-icon fa-solid fa-boxes-packing"></i>
              <p>Manage Products</p>
            </a>
          </li> 
          
          <!-- Trace product management(t as prefix) -->
          <li class="nav-item">
            <a href="tproductmanage" class="nav-link <?php if ($thisPage=="tproductmanage"){ echo "active"; } ?>">
              <i class="nav-icon fa-solid fa-boxes-packing"></i>
              <p>Manage Trace Products</p>
            </a>
          </li> 

          <li class="nav-item">
            <a href="categorymanage" class="nav-link <?php if ($thisPage=="categorymanage"){ echo "active"; } ?>">
              <i class="nav-icon fa-solid fa-list-ul"></i>
              <p>Manage Categories</p>
            </a>
          </li> 

          <!-- sourcing -->
          <li class="nav-item <?php if ($thisPage=="sourcingmanage" || $thisPage=="vendor" || $thisPage=="raw_materials"){ echo "menu-open"; } ?>">
            <a href="#" class="nav-link <?php if ($thisPage=="sourcing_manage" || $thisPage=="vendor" || $thisPage=="raw_materials"){ echo "active"; } ?>">
            <i class="nav-icon fa-solid fa-layer-group"></i>
              <p>
                Sourcing
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
                  
              <li class="nav-item">
                <a href="vendormanage" class="nav-link <?php if ($thisPage=="vendormanage"){ echo "active"; } ?>">
                  <i class="nav-icon fa-solid fa-boxes-packing"></i>
                  <p>Vendor</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="rawmaterialmanage" class="nav-link <?php if ($thisPage=="rawmaterialmanage"){ echo "active"; } ?>">
                  <i class="nav-icon fa-solid fa-boxes-packing"></i>
                  <p>Raw Materials</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="sourcingmanage" class="nav-link <?php if ($thisPage=="sourcingmanage"){ echo "active"; } ?>">
                  <i class="nav-icon fa-solid fa-boxes-packing"></i>
                  <p>Sourcing List</p>
                </a>
              </li>
            
            </ul>
          </li>


          <!-- processing -->
          <li class="nav-item <?php if ($thisPage=="processingmanage"){ echo "menu-open"; } ?>">
            <a href="#" class="nav-link <?php if ($thisPage=="processingmanage"){ echo "active"; } ?>">
            <i class="nav-icon fa-solid fa-sliders"></i>
              <p>
                Processing
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
                  
              <li class="nav-item">
              <a href="processingmanage" class="nav-link <?php if ($thisPage=="processingmanage"){ echo "active"; } ?>">
                <i class="nav-icon fa-solid fa-boxes-packing"></i>
                <p>Processing</p>
              </a>
            </li> 
            <li class="nav-item">
              <a href="productmanage" class="nav-link <?php if ($thisPage=="packing"){ echo "active"; } ?>">
                <i class="nav-icon fa-solid fa-boxes-packing"></i>
                <p>Packing</p>
              </a>
            </li> 
            
            </ul>
          </li>

          </ul>
          </li>

          


          <!-- Distribution module -->
          <li class="nav-item <?php if ($thisPage=="ordersmanage" || $thisPage=="dispatchmanage" || $thisPage=="dealermanage" || $thisPage=="locationmanage" || $thisPage=="eiprofilemanage" || $thisPage=="warehousemanage" || $thisPage=="transfermanage"){ echo "menu-open"; } ?>">
            <a href="#" class="nav-link <?php if ($thisPage=="ordersmanage" || $thisPage=="dispatchmanage" || $thisPage=="dealermanage" || $thisPage=="locationmanage" || $thisPage=="eiprofilemanage" || $thisPage=="warehousemanage" || $thisPage=="transfermanage"){ echo "active"; } ?>">
            <i class="nav-icon fa-solid fa-boxes"></i>
              <p>
                Distribution Management
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">

            <li class="nav-item <?php if ($thisPage=="warehousemanage"){ echo "menu-open"; } ?>">
              <a href="#" class="nav-link <?php if ($thisPage=="warehousemanage"){ echo "active"; } ?>">
              <i class="nav-icon fa-solid fa-exchange"></i>
                <p>
                Warehouse Ops
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="warehousemanage" class="nav-link <?php if ($thisPage=="warehousemanage"){ echo "active"; } ?>">
                    <i class="nav-icon fa-solid fa-warehouse"></i>
                    <p>Add Warehouse</p>
                  </a>
                </li> 

                   <!-- orders -->
              <li class="nav-item">
                <a href="ordersmanage" class="nav-link <?php if ($thisPage=="ordersmanage"){ echo "active"; } ?>">
                  <i class="nav-icon fa-solid fa-cart-arrow-down"></i>
                  <p>Manage Orders</p>
                </a>
              </li> 

        
                      <li class="nav-item">
                        <a href="" class="nav-link <?php if ($thisPage==""){ echo "active"; } ?>">
                          <i class="nav-icon fa-solid fa-arrow-circle-right"></i>
                          <p>Check-In/GRN</p>
                        </a>
                      </li> 

                      <!-- Dispatch -->
                    <li class="nav-item">
                      <a href="dispatchmanage" class="nav-link <?php if ($thisPage=="dispatchmanage"){ echo "active"; } ?>">
                        <i class="nav-icon fa-solid fa-truck"></i>
                        <p>Check-Out/Dispatch</p>
                      </a>
                    </li>
                


                <li class="nav-item">
                  <a href="transfermanage" class="nav-link <?php if ($thisPage=="transfermanage"){ echo "active"; } ?>">
                    <i class="nav-icon fa-solid fa-warehouse"></i>
                    <p>Transfers</p>
                  </a>
                </li> 

              </ul>
            </li>

            <!-- Export and Import module -->
              <li class="nav-item">
                <a href="eiprofilemanage" class="nav-link <?php if ($thisPage=="eiprofilemanage"){ echo "active"; } ?>">
                  <i class="nav-icon fa-solid fa-user"></i>
                  <p>EXIM Profile</p>
                </a>
              </li>
            
            

            <li class="nav-item">
                <a href="dealermanage" class="nav-link <?php if ($thisPage=="dealermanage"){ echo "active"; } ?>">
                  <i class="nav-icon fa-solid fa-user-circle"></i>
                  <p>Dealers</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="locationmanage" class="nav-link <?php if ($thisPage=="locationmanage"){ echo "active"; } ?>">
                  <i class="nav-icon fa-solid fa-location-arrow"></i>
                  <p>Locations</p>
                </a>
              </li>
               

              <!-- Logistics -->
           <li class="nav-item <?php if ($thisPage=="vehiclemanage" || $thisPage=="drivermanage"){ echo "menu-open"; } ?>">
            <a href="#" class="nav-link <?php if ($thisPage=="vehiclemanage" || $thisPage=="drivermanage"){ echo "active"; } ?>">
            <i class="nav-icon fa-solid fa-route"></i>
              <p>
                Logistics
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
                  
              <li class="nav-item">
              <a href="vehiclemanage" class="nav-link <?php if ($thisPage=="vehiclemanage"){ echo "active"; } ?>">
                <i class="nav-icon fa-solid fa-truck"></i>
                <p>Vehicles</p>
              </a>
            </li> 
            <li class="nav-item">
              <a href="drivermanage" class="nav-link <?php if ($thisPage=="drivermanage"){ echo "active"; } ?>">
                <i class="nav-icon fa-solid fa-id-badge"></i>
                <p>Drivers</p>
              </a>
            </li> 
            <li class="nav-item">
              <a href="" class="nav-link <?php if ($thisPage==""){ echo "active"; } ?>">
                <i class="nav-icon fa-solid fa-truck-loading"></i>
                <p>Dispatch Assigned</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="" class="nav-link <?php if ($thisPage==""){ echo "active"; } ?>">
                <i class="nav-icon fa-solid fa-map-marker-alt"></i>
                <p>GPS Track</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="" class="nav-link <?php if ($thisPage==""){ echo "active"; } ?>">
                <i class="nav-icon fa-solid fa-shipping-fast"></i>
                <p>Container Track</p>
              </a>
            </li>
            
            </ul>
          </li>
              
            
            </ul>
          </li>
         
          <!-- Customer Management -->
          <li class="nav-item <?php if ($thisPage=="regproductmanage"){ echo "menu-open"; } ?>">
            <a href="#" class="nav-link <?php if ($thisPage=="regproductmanage"){ echo "active"; } ?>">
            <i class="nav-icon fa-solid fa-phone-square"></i>
              <p>
              Customer Management
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
              <ul class="nav nav-treeview">

                  <!-- registered products from public page -->
                <li class="nav-item">
                      <a href="regproductmanage" class="nav-link <?php if ($thisPage=="regproductmanage"){ echo "active"; } ?>">
                        <i class="nav-icon fa-solid fa-dot-circle"></i>
                        <p>Warranty Registration</p>
                      </a>
                </li> 

                    <!-- registered products from public page -->
                    <li class="nav-item">
                      <a href="#" class="nav-link <?php if ($thisPage=="regproductmanage"){ echo "active"; } ?>">
                        <i class="nav-icon fa-solid fa-headset"></i>
                        <p>Support Requests</p>
                      </a>
                </li> 
            
              </ul>
          </li>

          <!-- compliance -->
          <li class="nav-item <?php if ($thisPage=="eiprofilemanage"){ echo "menu-open"; } ?>">
              <a href="#" class="nav-link <?php if ($thisPage=="eiprofilemanage"){ echo "active"; } ?>">
              <i class="nav-icon fa-solid fa-exchange"></i>
                <p>
               Compliances
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">

               <!-- K-Kisaan Api links -->
                <li class="nav-item">
                  <a href="<?php echo $kkisaanapi ?>" class="nav-link">
                    <i class="nav-icon fa-solid fa-cloud-arrow-up"></i>
                    <p>KKisan QR API</p>
                  </a>
                </li>

                <li class="nav-item">
                  <a href="#" class="nav-link">
                    <i class="nav-icon fa-solid fa-cloud-arrow-up"></i>
                    <p>KSSOCA</p>
                  </a>
                </li>

                <li class="nav-item">
                  <a href="#" class="nav-link">
                    <i class="nav-icon fa-solid fa-cloud-arrow-up"></i>
                    <p>Saathi SeedTrace</p>
                  </a>
                </li>

                <li class="nav-item">
                  <a href="#" class="nav-link">
                    <i class="nav-icon fa-solid fa-cloud-arrow-up"></i>
                    <p>EUDR</p>
                  </a>
                </li>

                <li class="nav-item">
                  <a href="#" class="nav-link">
                    <i class="nav-icon fa-solid fa-cloud-arrow-up"></i>
                    <p>NPOP</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="#" class="nav-link">
                    <i class="nav-icon fa-solid fa-cloud-arrow-up"></i>
                    <p>Carbon Accounting</p>
                  </a>
                </li>

                <li class="nav-item">
                  <a href="#" class="nav-link">
                    <i class="nav-icon fa-solid fa-cloud-arrow-up"></i>
                    <p>FSSAI</p>
                  </a>
                </li>
                
                <li class="nav-item">
                  <a href="#" class="nav-link">
                    <i class="nav-icon fa-solid fa-cloud-arrow-up"></i>
                    <p>GI Tag</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="#" class="nav-link">
                    <i class="nav-icon fa-solid fa-cloud-arrow-up"></i>
                    <p>Green Choice</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="#" class="nav-link">
                    <i class="nav-icon fa-solid fa-cloud-arrow-up"></i>
                    <p>EcoCert</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="#" class="nav-link">
                    <i class="nav-icon fa-solid fa-cloud-arrow-up"></i>
                    <p>USDA Organic (NOP)</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="#" class="nav-link">
                    <i class="nav-icon fa-solid fa-cloud-arrow-up"></i>
                    <p>Jaivik Bharat</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="#" class="nav-link">
                    <i class="nav-icon fa-solid fa-cloud-arrow-up"></i>
                    <p>MAYACERT</p>
                  </a>
                </li>

              </ul>
            </li>

            <li class="nav-item <?php if ($thisPage=="carbonaccmanage"){ echo "menu-open"; } ?>">
            <a href="#" class="nav-link <?php if ($thisPage=="carbonaccmanage"){ echo "active"; } ?>">
            <i class="nav-icon fa-solid fa-list-ul"></i>
              <p>
                Carbon Accounting
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">

              <li class="nav-item <?php if ($thisPage=="ca_organization"){ echo "menu-open"; } ?>">
              <a href="#" class="nav-link <?php if ($thisPage=="ca_organization"){ echo "active"; } ?>">
              <i class="nav-icon fa-solid fas fa-angle-double-right"></i>
                <p>
                My Organization
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="ca_locationmanage" class="nav-link <?php if ($thisPage=="ca_locationmanage"){ echo "active"; } ?>">
                      <i class="nav-icon fa-solid fas fa-angle-right"></i>
                      <p>Location</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="ca_vehiclemanage" class="nav-link <?php if ($thisPage=="ca_vehiclemanage"){ echo "active"; } ?>">
                      <i class="nav-icon fa-solid fas fa-angle-right"></i>
                      <p>Vehicle</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="ca_equipmentmanage" class="nav-link <?php if ($thisPage=="ca_equipmentmanage"){ echo "active"; } ?>">
                      <i class="nav-icon fa-solid fas fa-angle-right"></i>
                      <p>Equipment</p>
                    </a>
                  </li>

                </ul>
              </li> 
            
                  
              <li class="nav-item">
                <a href="scope1entry" class="nav-link <?php if ($thisPage=="scope1entry"){ echo "active"; } ?>">
                  <i class="nav-icon fa-solid fas fa-angle-double-right"></i>
                  <p>Scope1</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="scope2entry" class="nav-link <?php if ($thisPage=="scope2entry"){ echo "active"; } ?>">
                  <i class="nav-icon fa-solid fas fa-angle-double-right"></i>
                  <p>Scope2</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="scope3entry" class="nav-link <?php if ($thisPage=="scope3entry"){ echo "active"; } ?>">
                  <i class="nav-icon fa-solid fas fa-angle-double-right"></i>
                  <p>Scope3</p>
                </a>
              </li>

              </ul>
            </li>  

            <li class="nav-item <?php if ($thisPage=="livestockmanage"){ echo "menu-open"; } ?>">
            <a href="#" class="nav-link <?php if ($thisPage=="livestockmanage"){ echo "active"; } ?>">
            <i class="nav-icon fa-solid fa-paw"></i>
              <p>
                LiveStock Management
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
                  
              <li class="nav-item">
                <a href="animalregistrationmanage" class="nav-link <?php if ($thisPage=="animalregistrationmanage"){ echo "active"; } ?>">
                  <i class="nav-icon fa-solid fas fa-angle-double-right"></i>
                  <p>Animal Registration</p>
                </a>
              </li>

              <li class="nav-item <?php if ($thisPage=="animalvaccinationmanage"){ echo "menu-open"; } ?>">
                  <a href="#" class="nav-link <?php if ($thisPage=="animalvaccinationmanage"){ echo "active"; } ?>">
                  <i class="nav-icon fa-solid fas fa-angle-double-right"></i>
                    <p>
                    Health & Medical Records
                      <i class="fas fa-angle-left right"></i>
                    </p>
                  </a>
                  <ul class="nav nav-treeview">
                    <li class="nav-item">
                    <a href="animalvaccinationmanage" class="nav-link <?php if ($thisPage=="animalvaccinationmanage"){ echo "active"; } ?>">
                      <i class="nav-icon fa-solid fas fa-angle-right"></i>
                      <p>Vaccination</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="animaldewormingmanage" class="nav-link <?php if ($thisPage=="animaldewormingmanage"){ echo "active"; } ?>">
                      <i class="nav-icon fa-solid fas fa-angle-right"></i>
                      <p>Deworming</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="animalveterinarymanage" class="nav-link <?php if ($thisPage=="animalveterinarymanage"){ echo "active"; } ?>">
                      <i class="nav-icon fa-solid fas fa-angle-right"></i>
                      <p>Veterinary</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="animalmedicationmanage" class="nav-link <?php if ($thisPage=="animalmedicationmanage"){ echo "active"; } ?>">
                      <i class="nav-icon fa-solid fas fa-angle-right"></i>
                      <p>Medication & Supplements</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="animaldiseasemanage" class="nav-link <?php if ($thisPage=="animaldiseasemanage"){ echo "active"; } ?>">
                      <i class="nav-icon fa-solid fas fa-angle-right"></i>
                      <p>Disease Tracking</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="animalmortalitymanage" class="nav-link <?php if ($thisPage=="animalmortalitymanage"){ echo "active"; } ?>">
                      <i class="nav-icon fa-solid fas fa-angle-right"></i>
                      <p>Mortality</p>
                    </a>
                  </li>
                </ul>
              </li> 
              
              <li class="nav-item">
                <a href="animalbreedingmanage" class="nav-link <?php if ($thisPage=="animalbreedingmanage"){ echo "active"; } ?>">
                  <i class="nav-icon fa-solid fas fa-angle-double-right"></i>
                  <p>Breeding</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="animalfeedingmanage" class="nav-link <?php if ($thisPage=="animalfeedingmanage"){ echo "active"; } ?>">
                  <i class="nav-icon fa-solid fas fa-angle-double-right"></i>
                  <p>Feeding</p>
                </a>
              </li>

              <li class="nav-item <?php if ($thisPage=="animaldairymanage"){ echo "menu-open"; } ?>">
                  <a href="#" class="nav-link <?php if ($thisPage=="animaldairymanage"){ echo "active"; } ?>">
                  <i class="nav-icon fa-solid fas fa-angle-double-right"></i>
                    <p>
                      Dairy Management
                      <i class="fas fa-angle-left right"></i>
                    </p>
                  </a>
                  <ul class="nav nav-treeview">
                    <li class="nav-item">
                      <a href="animaldairymanage" class="nav-link <?php if ($thisPage=="animaldairymanage"){ echo "active"; } ?>">
                        <i class="nav-icon fa-solid fas fa-angle-right"></i>
                        <p>Milk Production</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="milkingmanage" class="nav-link <?php if ($thisPage=="milkingmanage"){ echo "active"; } ?>">
                        <i class="nav-icon fa-solid fas fa-angle-right"></i>
                        <p>Milking Data</p>
                      </a>
                    </li>
                    
                  </ul>
              </li> 
              <li class="nav-item">
                    <a href="animallabourmanage" class="nav-link <?php if ($thisPage=="animallabourmanage"){ echo "active"; } ?>">
                      <i class="nav-icon fa-solid fas fa-angle-double-right"></i>
                      <p>Labour Management</p>
                    </a>
                  </li>

              <li class="nav-item">
                <a href="animalinventorymanage" class="nav-link <?php if ($thisPage=="animalinventorymanage"){ echo "active"; } ?>">
                  <i class="nav-icon fa-solid fas fa-angle-double-right"></i>
                  <p>Inventory </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="animalfinancemanage" class="nav-link <?php if ($thisPage=="animalfinancemanage"){ echo "active"; } ?>">
                  <i class="nav-icon fa-solid fas fa-angle-double-right"></i>
                  <p>Financial Records & Sales </p>
                </a>
              </li>

              <li class="nav-item <?php if ($thisPage==""){ echo "menu-open"; } ?>">
                <a href="#" class="nav-link <?php if ($thisPage=="" ){ echo "active"; } ?>">
                <i class="nav-icon fa-solid fas fa-angle-double-right"></i>
                  <p>
                  Reports & Analytics
                    <i class="fas fa-angle-left right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">

                  <li class="nav-item">
                    <a href="#" class="nav-link <?php if ($thisPage==""){ echo "active"; } ?>">
                      <i class="nav-icon fa-solid fas fa-angle-right"></i>
                      <p>Animal Growth Rate Reports </p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="#" class="nav-link <?php if ($thisPage==""){ echo "active"; } ?>">
                      <i class="nav-icon fa-solid fas fa-angle-right"></i>
                      <p>Disease Outbreak Tracking </p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="#" class="nav-link <?php if ($thisPage==""){ echo "active"; } ?>">
                      <i class="nav-icon fa-solid fas fa-angle-right"></i>
                      <p>Breeding Success Rate </p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="#" class="nav-link <?php if ($thisPage==""){ echo "active"; } ?>">
                      <i class="nav-icon fa-solid fas fa-angle-right"></i>
                      <p>Milk Yield Analysis </p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="#" class="nav-link <?php if ($thisPage==""){ echo "active"; } ?>">
                      <i class="nav-icon fa-solid fas fa-angle-right"></i>
                      <p>Feed Cost vs Milk/Meat Prod. </p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="#" class="nav-link <?php if ($thisPage==""){ echo "active"; } ?>">
                      <i class="nav-icon fa-solid fas fa-angle-right"></i>
                      <p>Financial Profitability Reports </p>
                    </a>
                  </li>

                </ul>
              </li> 

              </ul>
            </li> 


              <!-- API Management -->
           <li class="nav-item <?php if ($thisPage==""){ echo "menu-open"; } ?>">
            <a href="#" class="nav-link <?php if ($thisPage==""){ echo "active"; } ?>">
            <i class="nav-icon fa-solid fa-gears"></i>
              <p>
                API Management
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
                  
              <li class="nav-item">
                <a href="raw_materials" class="nav-link <?php if ($thisPage==""){ echo "active"; } ?>">
                  <i class="nav-icon fa-solid fa-envelope"></i>
                  <p>Msg91</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="=" class="nav-link <?php if ($thisPage==""){ echo "active"; } ?>">
                  <i class="nav-icon fa-solid fa-certificate"></i>
                  <p>Ship Rocket</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="=" class="nav-link <?php if ($thisPage==""){ echo "active"; } ?>">
                  <i class="nav-icon fa-solid fa-certificate"></i>
                  <p>Porter</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="=" class="nav-link <?php if ($thisPage==""){ echo "active"; } ?>">
                  <i class="nav-icon fa-solid fa-boxes-packing"></i>
                  <p>Razorpay</p>
                </a>
              </li>
            
              <li class="nav-item">
                <a href="=" class="nav-link <?php if ($thisPage==""){ echo "active"; } ?>">
                  <i class="nav-icon fa-solid fa-tag"></i>
                  <p>Cashfree</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="=" class="nav-link <?php if ($thisPage==""){ echo "active"; } ?>">
                  <i class="nav-icon fab fa-stripe"></i>
                  <p>Stripe</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="=" class="nav-link <?php if ($thisPage==""){ echo "active"; } ?>">
                  <i class="nav-icon fab fa-paypal"></i>
                  <p>Paypal</p>
                </a>
              </li>
            </ul>
          </li>
           

         

         
          
         

             <!-- Archive links -->
             <li class="nav-item <?php if ($thisPage=="lyproductmanage"){ echo "menu-open"; } ?>">
            <a href="#" class="nav-link <?php if ($thisPage=="lyproductmanage"){ echo "active"; } ?>">
            <i class="nav-icon fa-solid fa-box-archive"></i>
              <p>
                Archive FY23-24
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <?php if(($_SESSION['comcat']==="1" || $_SESSION['comcat']==="2" || $_SESSION['comcat']==="3" || $_SESSION['comcat']==="4" || $_SESSION['comcat']==="5" || $_SESSION['comcat']==="6" || $_SESSION['comcat']==="7")
               && ($_SESSION['role']==="company" || $_SESSION['role']==="rcholder"))  :?>            
                <li class="nav-item">
                  <a href="<?php echo $lyproductmanage ?>" class="nav-link <?php if ($thisPage=="lyproductmanage"){ echo "active"; } ?>">
                    <i class="nav-icon fa-solid fa-box-archive"></i>
                    <p>Supplies Data Archive</p>
                  </a>
                </li> 
              <?php else:?>
              <?php endif ?>
              <li class="nav-item hidden">
                <a href="<?php echo $userprofile ?>" class="nav-link <?php if ($thisPage=="userprofile"){ echo "active"; } ?>">
                  <i class="nav-icon fa-regular fa-address-card"></i>
                  <p>Manage Profile</p>
                </a>
              </li>
            </ul>
          </li>



            <!-- Setting links -->
            <li class="nav-item <?php if ($thisPage=="userprofile" || $thisPage=="productimport"){ echo "menu-open"; } ?>">
            <a href="#" class="nav-link <?php if ($thisPage=="userprofile" || $thisPage=="productimport"){ echo "active"; } ?>">
            <i class="nav-icon fa-solid fa-gear"></i>
              <p>
                Settings
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <?php if(($_SESSION['comcat']==="1" || $_SESSION['comcat']==="2" || $_SESSION['comcat']==="3" || $_SESSION['comcat']==="4" || $_SESSION['comcat']==="5"  || $_SESSION['comcat']==="6")
               && ($_SESSION['role']==="company" || $_SESSION['role']==="rcholder"))  :?>            
              <li class="nav-item">
                <a href="<?php echo $productimport ?>" class="nav-link <?php if ($thisPage=="productimport"){ echo "active"; } ?>">
                  <i class="nav-icon fa-solid fa-upload"></i>
                  <p>Import Product</p>
                </a>
              </li>
              <?php else:?>
              <?php endif ?>
              <li class="nav-item hidden">
                <a href="<?php echo $userprofile ?>" class="nav-link <?php if ($thisPage=="userprofile"){ echo "active"; } ?>">
                  <i class="nav-icon fa-regular fa-address-card"></i>
                  <p>Manage Profile</p>
                </a>
              </li>
            </ul>
          </li>

         



          <style>
            li.sub-category h3 {
              margin-bottom: 0;
              text-transform: uppercase;
              letter-spacing: 0.5px;
              font-size: 15px;
              font-weight: 500;
            }

            li.sub-category {
              color: #74829c;
              margin-bottom: 0.5rem;
              padding: 12px 30px 2px 20px;
              margin-bottom: 0;
              white-space: nowrap;
              position: relative;
              /* font-size: 0.75rem; */
            }
          </style> 
          <?php $pub = $this->db->select('public_page')->from('users')->where('id', $_SESSION['comid'])->get();?>
          <?php foreach($pub->result() as $prow): ?>
              <?php $public_page = $prow->public_page;?>
          <?php endforeach ?>
            <?php if($public_page === '1'):?>  
              <li class="sub-category" style="border-top: 1px solid #c9c8c8;padding:0;">&nbsp;</li>
              <li class="sub-category" style="background: #81b961;
                color: #fff;
                margin-bottom: 0.5rem;
                padding: 0.5rem;">
                <h3>Private Sale</h3>
              </li>  
              <li class="nav-item">
                <a href="<?php echo $pproductbulkimport ?>" class="nav-link <?php if ($thisPage=="psbproductimport"){ echo "active"; } ?>">
                  <i class="nav-icon fa-solid fa-upload"></i>
                  <p>Product Bulk Import</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo $pproductmanage ?>" class="nav-link <?php if ($thisPage=="ppsproductmanage"){ echo "active"; } ?>">
                  <i class="nav-icon fa-solid fa-boxes-packing"></i>
                  <p>Manage Products</p>
                </a>
              </li>
            <?php endif ?>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>