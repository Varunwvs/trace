<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper bg-sky">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-4 mt-4">
          <div class="col-sm-6">
            <h1 class="m-0"><?php echo $title ?></h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <?php if($thisPageLevel==='1'): ?>
                  <li class="breadcrumb-item"><a href="midashboard">Home</a></li>
                  <li class="breadcrumb-item active"><?php echo $title ?></li>
                <?php else: ?>
                  <li class="breadcrumb-item"><a href="midashboard" tabindex="-1">Home</a></li>
                  <li class="breadcrumb-item"><?php echo $thisPageMain ?></li>
                  <li class="breadcrumb-item active"><?php echo $title ?></li>
                <?php endif ?>              
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Info boxes -->
        <div class="row">
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
              <span class="info-box-icon bg-info elevation-1"><i class="fa-solid fa-boxes-packing"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Products</span>
                <span class="info-box-number"><h3 id="pcount"></h3></span>
                <span class="info-box-number hidden">Deleted : <span id="dpcount"></span></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3 hidden">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-danger elevation-1"><i class="fa-solid fa-sitemap"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Batches</span>
                <span class="info-box-number">Active : <span id="bcount"></span></span>
                <span class="info-box-number">Deleted : <span id="dbcount"></span></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->

          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-success elevation-1"><i class="fas fa-box"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Primary Serials</span>
                <span class="info-box-number"><h3 id="ccount"></h3></span>
                <span class="info-box-number hidden">Secondary : <span id="dccount"></span></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3 hidden">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Total Product</span>
                <span class="info-box-number">Allowed: <span id="tcount"></span></span>
                <?php if($_SESSION['level']==='3' && $_SESSION['comcat']==="3" && 
                  ($_SESSION['role']==='company' || $_SESSION['role']==='rcholder')):?>
                    <span class="info-box-number">Remaining: <span id="rcount"></span></span>
                <?php else : ?>
                <?php endif ?>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Allowed Serials</span>
                <span class="info-box-number">
                    <?php $adminrole = $_SESSION['role']; ?>
                    <?php $center=substr($adminrole, 0, -6).'center';?>
                    <?php $admin=substr($adminrole, 0, -6).'admin';?>
                    <?php $result = $this->db->select('qr_quantity')->from('users')->where('role', $admin)->get(); 
                    foreach($result->result() as $qrow){
                        $qr_quantity = $qrow->qr_quantity;
                    }
                    ?>
                    <?php if($_SESSION['role']===$center): ?>
                    <h3><?php echo $qr_quantity ?></h3>
                    <?php else : ?>
                    <h3><?php echo $_SESSION['comtotqr'] ?></h3>
                    <?php endif ?>
                </span>                
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->