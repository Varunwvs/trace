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
                  <li class="breadcrumb-item"><a href="super_admin_dashboard">Home</a></li>
                  <li class="breadcrumb-item active"><?php echo $title ?></li>
                <?php else: ?>
                  <li class="breadcrumb-item"><a href="super_admin_dashboard" tabindex="-1">Home</a></li>
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
                <span class="info-box-text">Seeds Company</span>
                <span class="info-box-number">
                    <?php
                        // $scinfo = $this->db->select('count(*) as sccount')
                        // ->from('users')
                        // ->or_where('role','rcholder')
                        // ->or_where('role','company')
                        // ->where(array('category'=> '1', 'status'=>'1'))
                        // ->get();
                        $scinfo = $this->db->select('count(*) as sccount')->from('users')
                                ->group_start()
                                    ->group_start()
                                    ->where('role', 'rcholder')
                                    ->or_group_start()
                                        ->where('role', 'company')
                                    ->group_end()
                                    ->group_end()
                                    ->where('category', '1')
                                    ->where('status', '1')
                                ->group_end()
                        ->get();
                        // echo $this->db->last_query(); die();
                        foreach($scinfo->result() as $sc){
                            $sccount = $sc->sccount;
                        }
                        if($sccount != 0){
                            echo 'Active : '.$sccount;
                        }else{
                            echo 'Active : 0';
                        }
                    ?>
                </span>
                <span class="info-box-number">
                    <?php
                        $iscinfo = $this->db->select('count(*) as isccount')->from('users')
                                ->group_start()
                                    ->group_start()
                                    ->where('role', 'rcholder')
                                    ->or_group_start()
                                        ->where('role', 'company')
                                    ->group_end()
                                    ->group_end()
                                    ->where('category', '1')
                                    ->where('status', '0')
                                ->group_end()
                        ->get();
                        // $iscinfo = $this->db->select('count(*) as isccount')->from('users')->where(array('category'=> '1', 'status'=>'0'))->get();
                        foreach($iscinfo->result() as $isc){
                            $isccount = $isc->isccount;
                        }
                        if($isccount != 0){
                            echo 'Inactive : '.$isccount;
                        }else{
                            echo 'Inactive : 0';
                        }
                    ?>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-danger elevation-1"><i class="fa-solid fa-sack-xmark"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Fertilizer Company</span>
                <span class="info-box-number">
                <?php
                    $fcinfo = $this->db->select('count(*) as fccount')
                    ->from('users')
                    ->where(array('category'=> '2', 'status'=>'1'))
                    ->or_where('category','6')
                    ->get();
                    foreach($fcinfo->result() as $fc){
                        $fccount = $fc->fccount;
                    }
                    if($fccount != 0){
                        echo 'Active : '.$fccount;
                    }else{
                        echo 'Active : 0';
                    }
                ?>
                </span>
                <span class="info-box-number">
                <?php
                    $ifcinfo = $this->db->select('count(*) as ifccount')->from('users')->where(array('category'=> '2', 'status'=>'0'))->get();
                    foreach($ifcinfo->result() as $ifc){
                        $ifccount = $ifc->ifccount;
                    }
                    if($ifccount != 0){
                        echo 'Inactive : '.$ifccount;
                    }else{
                        echo 'Inactive : 0';
                    }
                ?>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->

          <!-- fix for small devices only -->
          <!-- <div class="clearfix hidden-md-up"></div> -->

          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-success elevation-1"><i class="fa-solid fa-tractor"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Mechanisation Company</span>
                <span class="info-box-number">
                    <?php
                        $mcinfo = $this->db->select('count(*) as mccount')->from('users')->where(array('category'=> '3', 'status'=>'1'))->get();
                        foreach($mcinfo->result() as $mc){
                            $mccount = $mc->mccount;
                        }
                        if($mccount != 0){
                            echo 'Active : '.$mccount;
                        }else{
                            echo 'Active : 0';
                        }
                    ?>
                </span>
                <span class="info-box-number">
                    <?php
                        $imcinfo = $this->db->select('count(*) as imccount')->from('users')->where(array('category'=> '3', 'status'=>'0'))->get();
                        foreach($imcinfo->result() as $imc){
                            $imccount = $imc->imccount;
                        }
                        if($imccount != 0){
                            echo 'Inctive : '.$imccount;
                        }else{
                            echo 'Inctive : 0';
                        }
                    ?>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-warning elevation-1"><i class="fa-solid fa-flask"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Chemicals Company</span>
                <span class="info-box-number">
                    <?php
                        $ccinfo = $this->db->select('count(*) as cccount')->from('users')->where(array('category'=> '4', 'status'=>'1'))->get();
                        foreach($ccinfo->result() as $cc){
                            $cccount = $cc->cccount;
                        }
                        if($cccount != 0){
                            echo 'Active : '.$cccount;
                        }else{
                            echo 'Active : 0';
                        }
                    ?>
                </span>
                <span class="info-box-number">
                    <?php
                        $iccinfo = $this->db->select('count(*) as icccount')->from('users')->where(array('category'=> '4', 'status'=>'0'))->get();
                        foreach($iccinfo->result() as $icc){
                            $icccount = $icc->icccount;
                        }
                        if($icccount != 0){
                            echo 'Inactive :'.$icccount;
                        }else{
                            echo 'Inactive : 0';
                        }
                    ?>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
        <div class="row">
            <?php $admincount = $this->db->select('id, name, role')->from('users')->where('ulevel', '2')->get();?>
            <?php $count = $admincount->num_rows(); ?>
            <?php if($count != 0): ?>
                <?php foreach($admincount->result() as $row): ?>
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box">
                            <span class="info-box-icon bg-purple elevation-1"><i class="fa-solid fa-user-tie"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text"><?php echo $row->name ?></span>
                                <span class="info-box-number">
                                    <?php $cname = preg_replace('/admin$/', '', $row->role); ?>
                                    <?= $cname ?>
                                    <?php $cnm = strtolower($cname).'center'; ?>
                                    <?php $acinfo = $this->db->select('*')->from('users')
                                    ->where(array('role'=> $cnm, 'status'=>'1'))->get(); ?>
                                    Active Center : <?php echo $ccount = $acinfo->num_rows(); ?>
                                </span>
                                <span class="info-box-number">
                                    <?php $icinfo = $this->db->select('*')->from('users')
                                    ->where(array('role'=> $cnm, 'status'=>'0'))->get(); ?>
                                    InActive Center : <?php echo $ccount = $icinfo->num_rows(); ?>
                                </span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                <?php endforeach; ?> <!-- end foreach -->
            <?php else: ?> No records found <?php endif; ?> 
        </div><!-- /.row -->
      </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->