<!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-green">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link text-white" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto"> 
      <!-- Navbar Search -->
      <li class="nav-item">
        <a class="nav-link" data-widget="navbar-search" href="#" role="button">
          <i class="fas fa-search text-white"></i>
        </a>
        <div class="navbar-search-block" style="padding: 0 7rem;">
          <form class="form-inline" method="post" action="searchresult">
            <div class="input-group input-group-sm">
              <div class="input-group-prepend bg-white border border-0">
                <select class="border border-0" name="srchcat" id="srchcat" style="background:#e6e6e6;">
                  <!--<option value="upc">UPC</option>-->
                  <!--<option value="upc">UCC</option>-->
                  <option value="palias">Primary Alias</option>
                  <option value="salias">Secondary Alias</option>
                  <!--<option value="upc">Product Name</option>-->
                  <!--<option value="upc">Batch No</option>-->
                </select>
              </div>
              <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search" name="srchterm" id="srchterm">
              <div class="input-group-append bg-white">
                <button class="btn btn-navbar" type="submit">
                  <i class="fas fa-search"></i>
                </button>
                <button type="submit" name="submit" id="submit" class="btn btn-navbar" type="button" data-widget="navbar-search">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
          </form>
        </div>
      </li> 
      <li class="nav-item">
        <?php
            $help = '';
            if($_SESSION['comcat']==='1'){
                $help='help';
            }elseif($_SESSION['comcat']==='2' || $_SESSION['comcat']==='6'){
                $help='flhelp';
            }elseif($_SESSION['comcat']==='3'){
                $help='mihelp';
            }elseif($_SESSION['comcat']==='5'){
                $help='pshelp';
            }
        ?>
        <a class="nav-link text-white" href="<?php echo $help ?>" role="button">
          <i class="fa-solid fa-circle-info"></i></a>
      </li>
      <!-- Logout-->
      <li class="nav-item">
        <a class="nav-link text-white" href="logout" role="button">
          <i class="fas fa-sign-out-alt"></i> Logout</a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->