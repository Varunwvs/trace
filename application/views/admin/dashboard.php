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
                  <li class="breadcrumb-item"><a href="admin_dashboard">Home</a></li>
                  <li class="breadcrumb-item active"><?php echo $title ?></li>
                <?php else: ?>
                  <li class="breadcrumb-item"><a href="admin_dashboard" tabindex="-1">Home</a></li>
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
              <span class="info-box-icon bg-info elevation-1"><i class="fa-solid fa-seedling"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Centers</span>
                <span class="info-box-number">
                    <?php
                        $adminrole = $_SESSION['role'];
                        $admin=substr($adminrole, 0, -5).'admin';
                        $center=substr($adminrole, 0, -5).'center';
                        $scinfo = $this->db->select('count(*) as sccount')->from('users')->where(array('role'=> $center, 'status'=>'1'))->get();
                        foreach($scinfo->result() as $sc){
                            $sccount = $sc->sccount;
                        }
                        if($sccount != 0){
                            echo $sccount.' Active';
                        }else{
                            echo '0 Active';
                        }
                    ?>
                </span>
                <span class="info-box-number">
                    <?php
                        $iscinfo = $this->db->select('count(*) as isccount')->from('users')->where(array('role'=> $center, 'status'=>'0'))->get();
                        foreach($iscinfo->result() as $isc){
                            $isccount = $isc->isccount;
                        }
                        if($isccount != 0){
                            echo $isccount.' Inactive';
                        }else{
                            echo '0 Inactive';
                        }
                    ?>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
        </div>
        <!-- /.row -->
      </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->