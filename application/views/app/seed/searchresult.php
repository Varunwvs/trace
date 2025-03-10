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
                  <li class="breadcrumb-item"><a href="sdashboard">Home</a></li>
                  <li class="breadcrumb-item active"><?php echo $title ?></li>
                <?php else: ?>
                  <li class="breadcrumb-item"><a href="sdashboard" tabindex="-1">Home</a></li>
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
    <div class="content">
      <div class="container-fluid">
        <div class="row">  
          <div class="col-lg-12">
            <div class="card">                
              <div class="card-block tab-icon">
                <div class="row"> 
                  <div class="col-12 text-sm"> 
                    <!-- company id -->
                    <?php $comid = $_SESSION['comid'];?>
                    <!-- UPC Search -->                    
                    <?php if($srchcat==="upc"): ?>
                      <!-- Starts Product Search -->
                      <?php $pinfo = $this->db->select('p_code, p_name, p_category, sub_category')
                            ->from('seedproduct')->where(array('p_code'=>$srchterm, 'c_id'=>$comid))
                            ->get(); ?> 
                      <?php $count = $pinfo->num_rows(); ?>
                      <?php if($count != 0): ?>
                        <h3 class="mb-3">Product Details</h3>
                        <table class="table table-striped table-bordered nowrap" style="width:100%;">
                          <thead class="bg-primary">
                            <tr>
                              <th>#</th>
                              <th>UPC</th>
                              <th>Product Name</th> 
                              <th>Category</th>
                              <th>Sub Category</th>
                            </tr>
                          </thead>  
                          <tbody>
                            <?php $i = 1; ?>
                            <?php foreach($pinfo->result() as $row): ?>
                              <tr>
                                <td><?php echo $i++ ?></td>
                                <td><?php echo $row->p_code ?></td>
                                <td><?php echo $row->p_name ?></td>
                                <td><?php echo $row->p_category ?></td>
                                <td><?php echo $row->sub_category ?></td>
                              </tr>    
                            <?php endforeach ?>
                          </tbody>
                        </table>
                        <?php else: ?> No product info found! or no product is created yet!  
                      <?php endif; ?><!-- if count is > 0 --> 
                      <!-- Ends Product Search -->

                      <!-- Starts Batch Search -->
                      <?php foreach($pinfo->result() as $row): ?>
                        <?php $binfo = $this->db->select('id, pid, p_code, batch_no, s_no_qty, mfd_date, exp_date')
                                    ->from('seedbatch')->where(array('p_code'=>$srchterm, 'c_id'=>$comid))
                                    ->get(); ?>
                        <?php $bcount = $binfo->num_rows(); ?>
                        <?php if($bcount != '0'):?>
                          <h3 class="mb-3 mt-3">Batch Details</h3>
                          <table class="table table-striped table-bordered nowrap" style="width:100%;">
                            <thead class="bg-primary">
                              <tr>
                                <th>#</th>
                                <th>UPC</th>
                                <th>Batch Number</th>
                                <th>Qty</th> 
                                <th>Mfg. Date</th>
                                <th>Exp. Date</th>
                              </tr>
                            </thead>  
                            <tbody>
                              <?php $i = 1; ?>
                              <?php foreach($binfo->result() as $brow): ?>
                                <tr>
                                  <td><?php echo $i++ ?></td>
                                  <td><?php echo $brow->p_code ?></td>
                                  <td><?php echo $brow->batch_no ?></td>
                                  <td><?php echo $brow->s_no_qty ?></td>
                                  <td><?php echo $brow->mfd_date ?></td>
                                  <td><?php echo $brow->exp_date ?></td>
                                </tr>    
                              <?php endforeach ?>
                            </tbody>
                          </table>
                          <?php else: ?>No batch info found! or no batch is created yet! 
                        <?php endif ?>  
                      <?php endforeach?>
                      <!-- Ends Batch Search -->

                      <!-- Starts Container Search -->
                      <?php foreach($binfo->result() as $brow): ?>
                        <?php $cinfo = $this->db->select('ctid,pid, ucc, batchno, serialno, alias')
                                    ->from('seedcontainer')->where(array('pid'=>$brow->pid, 'cid'=>$comid, 'batchno'=>$brow->id))
                                    ->get(); ?>
                        <?php $ccount = $cinfo->num_rows(); ?>
                        <?php if($ccount != '0'):?>
                          <h3 class="mb-3 mt-3">Container Details</h3>
                          <table class="table table-striped table-bordered nowrap" style="width:100%;">
                            <thead class="bg-primary">
                              <tr>
                                <th>#</th>
                                <th>UCC</th>
                                <th>Batch No.</th>
                                <th>UCC Alias</th>                                
                                <th>Primary Alias Code</th> 
                              </tr>
                            </thead>  
                            <tbody>
                              <?php $i = 1; ?>
                              <?php foreach($cinfo->result() as $crow): ?>
                                <?php $vendor_code = get_settings('vendor_code');
                                $ucc_identifier = get_settings('ucc_identifier');
                                $serial_no =  $this->ccm->get_container_serial_no($crow->ctid);
                                $sno = implode(",",$serial_no);?>
                                <tr>
                                  <td><?php echo $i++ ?></td>
                                  <td><?php echo $crow->ucc ?></td>
                                  <td><?php echo $crow->batchno ?></td>
                                  <td><?php echo $ucc_identifier.$vendor_code.$crow->alias ?></td>
                                  <td><?php echo $sno ?></td>
                                </tr>    
                              <?php endforeach ?>
                            </tbody>
                          </table>
                          <?php else: ?>No container info found! or no container is created yet! 
                        <?php endif ?>  
                      <?php endforeach?>
                      <!-- Ends Batch Search -->
                    <?php endif ?> <!-- search by upc  -->
                    <!-- /.UPC Search -->

                    <!-- UCC Search -->
                    <?php if($srchcat==="ucc"): ?>
                    <?php endif ?> 
                    <!-- /.UCC Search -->

                    <!-- primary alias Search -->
                    <?php if($srchcat==="palias"): ?>
                      <?php $len = strlen($srchterm); $sterm="0"; ?>
                      <?php if($len==="7"){
                        $sterm = $srchterm;
                      }else{
                        $sterm = substr($srchterm, 4);
                      }
                      ?>
                      <h3 class="text-center mb-5 text-sm navbar-green p-3 rounded">Searched for Primary Alias - <?php echo $srchterm ?></h3>
                      <?php $painfo = $this->db->select('sb.id, sb.c_id, sb.pid, sb.p_code, sb.batch_no, sb.s_no_qty, 
                              sb.mfd_date, sb.exp_date, sbs.alias')->from('seedbatch sb')
                              ->join('seedbatchserial sbs', 'sbs.batch_id=sb.id', 'left')
                              ->where(array('sbs.alias'=>$sterm))->get();?>
                        <?php $pacount = $painfo->num_rows(); ?>
                        <?php if($pacount != '0'): ?>
                          <h3>Batch Details
                            <?php $sbsinfo = $this->db->select('sbsid, cid')->from('seedbatchserial')->where(array('alias'=>$sterm, 'cid'=>$_SESSION['comid']))->get();?>
                            <?php $sbscount = $sbsinfo->num_rows(); ?>
                            <?php if($sbscount!=0):?>
                              <?php $sbsid=''; $cid=''; ?>
                              <?php foreach($sbsinfo->result() as $sbsrow){
                                $sbsid = $sbsrow->sbsid;
                                $cid = $sbsrow->cid;
                              }
                              ?>
                            <?php endif ?>  
                            <a class="btn btn-primary btn-sm float-right" href="serialqrcodeprint?id=<?php echo $sbsid ?>&cid=<?php echo $cid ?>" target="_blank"><i class="fa-solid fa-qrcode"></i> Generate / view full Label</a>                          
                          </h3>
                          <table class="table table-striped table-bordered nowrap rounded" style="width:100%;">
                            <thead class="bg-primary">
                              <tr>
                              <th>#</th>
                              <th>UPC</th>
                              <th>Batch Number</th>
                              <th>Qty</th> 
                              <th>Mfg. Date</th>
                              <th>Exp. Date</th>
                              </tr>
                            </thead>  
                            <tbody>
                              <?php $i = 1; ?>
                              <?php foreach($painfo->result() as $brow): ?>
                                <?php $vendor_code = get_settings('vendor_code');
                                $ucc_identifier = get_settings('ucc_identifier');?>
                                <tr>
                                  <td><?php echo $i++ ?></td>
                                  <td><?php echo $brow->p_code ?></td>
                                  <td><?php echo $brow->batch_no ?></td>
                                  <td><?php echo $brow->s_no_qty ?></td>
                                  <td><?php echo $brow->mfd_date ?></td>
                                  <td><?php echo $brow->exp_date ?></td>
                                </tr>    
                              <?php endforeach ?>
                            </tbody>
                          </table>
                          <?php foreach($painfo->result() as $brow): ?>
                            <?php $pinfo = $this->db->select('p_code, p_name, p_category, sub_category')
                            ->from('seedproduct')->where(array('id'=>$brow->pid, 'c_id'=>$brow->c_id))
                            ->get(); ?> 
                            <?php $pcount = $pinfo->num_rows(); ?>
                            <?php if($pcount!='0'):?>
                              <h3>Product Details</h3>
                              <table class="table table-striped table-bordered nowrap rounded" style="width:100%;">
                                <thead class="bg-primary">
                                  <tr>
                                    <th>#</th>
                                    <th>UPC</th>
                                    <th>Product Name</th> 
                                    <th>Category</th>
                                    <th>Sub Category</th>
                                  </tr>
                                </thead>  
                                <tbody>
                                  <?php $i = 1; ?>
                                  <?php foreach($pinfo->result() as $row): ?>
                                    <tr>
                                      <td><?php echo $i++ ?></td>
                                      <td><?php echo $row->p_code ?></td>
                                      <td><?php echo $row->p_name ?></td>
                                      <td><?php echo $row->p_category ?></td>
                                      <td><?php echo $row->sub_category ?></td>
                                    </tr>    
                                  <?php endforeach ?>
                                </tbody>
                              </table>
                              <?php else: ?>
                              <p>No product info found! or no product is created yet! </p>
                            <?php endif ?>
                          <?php endforeach ?>
                          <?php else: ?>
                            <p>No batch info found! or no batch is created yet! <?php echo $sterm ?></p>
                        <?php endif ?>
                    <?php endif ?> 
                    <!-- /.primary alias Search -->

                    <!-- secondary alias Search -->
                    <?php if($srchcat==="salias"): ?>
                      <?php $len = strlen($srchterm); $sterm="0"; ?>
                      <?php if($len==="7"){
                        $sterm = $srchterm;
                      }else{
                        $sterm = substr($srchterm, 4);
                      }
                      ?>
                      <h3 class="text-center mb-5 text-sm navbar-green p-3 rounded">Searched for secondary Alias - <?php echo $srchterm ?></h3>
                      <?php $painfo = $this->db->select('sb.id, sb.c_id, sb.pid, sb.p_code, sb.batch_no, sb.s_no_qty, 
                              sb.mfd_date, sb.exp_date, sc.alias')->from('seedbatch sb')
                              ->join('seedcontainer sc', 'sc.batchno=sb.id', 'left')
                              ->where(array('sc.alias'=>$sterm))->get();?>
                        <?php $pacount = $painfo->num_rows(); ?>
                        <?php if($pacount != '0'): ?>
                          <h3>Batch Details
                            <?php $sbsinfo = $this->db->select('ctid, cid')->from('seedcontainer')->where(array('alias'=>$sterm, 'cid'=>$_SESSION['comid']))->get();?>
                            <?php $sbscount = $sbsinfo->num_rows(); ?>
                            <?php if($sbscount!=0):?>
                              <?php $ctid=''; $cid=''; ?>
                              <?php foreach($sbsinfo->result() as $sbsrow){
                                $ctid = $sbsrow->ctid;
                                $cid = $sbsrow->cid;
                              }
                              ?>
                            <?php endif ?>  
                            <a class="btn btn-primary btn-sm float-right" href="containerqrcode?ctid=<?php echo $ctid ?>&cid=<?php echo $cid ?>" target="_blank"><i class="fa-solid fa-qrcode"></i> Generate / view full Label</a>                          
                          </h3>
                          <table class="table table-striped table-bordered nowrap rounded" style="width:100%;">
                            <thead class="bg-primary">
                              <tr>
                              <th>#</th>
                              <th>UPC</th>
                              <th>Batch Number</th>
                              <th>Qty</th> 
                              <th>Mfg. Date</th>
                              <th>Exp. Date</th>
                              </tr>
                            </thead>  
                            <tbody>
                              <?php $i = 1; ?>
                              <?php foreach($painfo->result() as $brow): ?>
                                <?php $vendor_code = get_settings('vendor_code');
                                $ucc_identifier = get_settings('ucc_identifier');?>
                                <tr>
                                  <td><?php echo $i++ ?></td>
                                  <td><?php echo $brow->p_code ?></td>
                                  <td><?php echo $brow->batch_no ?></td>
                                  <td><?php echo $brow->s_no_qty ?></td>
                                  <td><?php echo $brow->mfd_date ?></td>
                                  <td><?php echo $brow->exp_date ?></td>
                                </tr>    
                              <?php endforeach ?>
                            </tbody>
                          </table>
                          <?php foreach($painfo->result() as $brow): ?>
                            <?php $pinfo = $this->db->select('p_code, p_name, p_category, sub_category')
                            ->from('seedproduct')->where(array('id'=>$brow->pid, 'c_id'=>$brow->c_id))
                            ->get(); ?> 
                            <?php $pcount = $pinfo->num_rows(); ?>
                            <?php if($pcount!='0'):?>
                              <h3>Product Details</h3>
                              <table class="table table-striped table-bordered nowrap rounded" style="width:100%;">
                                <thead class="bg-primary">
                                  <tr>
                                    <th>#</th>
                                    <th>UPC</th>
                                    <th>Product Name</th> 
                                    <th>Category</th>
                                    <th>Sub Category</th>
                                  </tr>
                                </thead>  
                                <tbody>
                                  <?php $i = 1; ?>
                                  <?php foreach($pinfo->result() as $row): ?>
                                    <tr>
                                      <td><?php echo $i++ ?></td>
                                      <td><?php echo $row->p_code ?></td>
                                      <td><?php echo $row->p_name ?></td>
                                      <td><?php echo $row->p_category ?></td>
                                      <td><?php echo $row->sub_category ?></td>
                                    </tr>    
                                  <?php endforeach ?>
                                </tbody>
                              </table>
                              <?php else: ?>
                              <p>No product info found! or no product is created yet! </p>
                            <?php endif ?>
                          <?php endforeach ?>
                          <?php else: ?>
                            <p>No batch info found! or no batch is created yet! <?php echo $sterm ?></p>
                        <?php endif ?>
                    <?php endif ?> 
                    <!-- /.secondary alias Search -->

                    <!-- Product Name alias Search -->
                    <?php if($srchcat==="pname"): ?>
                    <?php endif ?> 
                    <!-- /.Product Name alias Search -->

                    <!-- Batch No alias Search -->
                    <?php if($srchcat==="bno"): ?>
                    <?php endif ?> 
                    <!-- /.Batch No alias Search -->
                  </div><!-- /.col-md-12 -->
                </div><!-- /.row -->
              </div><!-- /.card block -->
            </div><!-- /.card -->
          </div><!-- /.col-md-12 -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div><!-- /.content -->
  