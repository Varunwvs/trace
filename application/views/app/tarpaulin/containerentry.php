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
                  <li class="breadcrumb-item"><a href="tpdashboard">Home</a></li>
                  <li class="breadcrumb-item active"><?php echo $title ?></li>
                <?php else: ?>
                  <li class="breadcrumb-item"><a href="tpdashboard" tabindex="-1">Home</a></li>
                  <li class="breadcrumb-item"><?php echo $thisPageMain ?></li>
                  <li class="breadcrumb-item active"><?php echo $title ?></li>
                <?php endif ?>              
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <?php
    $id = $_GET['id'];
    $binfo = $this->db->select('sb.*,sp.id as pid,sp.p_name,sp.net_w,sp.unit_w,sp.p_code')
            ->from('tarpaulinbatch sb')
            ->join('tarpaulinproduct sp','sp.id = sb.pid')
            ->where(array('sb.id'=> $id))->get();
    $count = $binfo->num_rows();

?>
<style type="text/css">
  #loader {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    width: 100%;
    background: rgba(0,0,0,0.75) url(<?php echo base_url('assets/images/loading2.gif')?>) no-repeat center center;
    z-index: 10000;
  }
</style>
<!-- Main content -->
    <div class="content">
      <div class="container-fluid">
    <?php if($count != 0): ?>  
        <div class="row">  
          <div class="col-lg-12">
            <div class="card">                
                <div class="card-block tab-icon">
                    <div class="row"> 
                      <div class="col-12 text-sm">
                        <form id="formContainer" method="post" action="TarpaulinController/addContainer">
                  <?php foreach($binfo->result() as $row): ?>     
                        <div class="row">
                          <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Product Name</label>
                                    <input type="text" class="form-control" name="p_name" id="p_name" placeholder="Batch Quantity" value="<?php echo strtoupper($row->p_name) ?>" readonly>
                                    <input type="hidden" class="form-control" name="bid" id="bid" value="<?php echo $row->pid ?>" readonly>
                                </div>
                            </div>     
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Net Content/Weight per Pack</label>
                        <?php $net_content = $row->net_w.''.ucfirst($row->unit_w); ?>            
                                    <input type="text" class="form-control" name="net_w" id="net_w" placeholder="Batch Quantity" value="<?php echo $net_content ?>" readonly>
                                </div>
                            </div>     
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="hidden" class="form-control" name="pid" id="pid" placeholder="Batch Quantity" value="<?php echo $row->pid ?>">
                                </div>
                            </div>     
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="hidden" class="form-control" name="bid" id="bid" placeholder="Batch Quantity" value="<?php echo $row->id ?>">
                                </div>
                            </div>    
                          </div><!-- End row -->
                    <?php endforeach; ?> 
                          <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">UPC </label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="" id="upc" name="upc" aria-describedby="button-addon1" autocomplete="off" value="<?php echo $row->p_code ?>" readonly>
                                    </div>                                    
                                </div>
                            </div>  
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Batch Number </label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="" id="batchno" name="batchno" aria-describedby="button-addon1" autocomplete="off" value="<?php echo $row->batch_no ?>" readonly>
                                    </div>                                    
                                </div>
                            </div>  
                        </div>
                        <div class="row">    
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Batch Quantity</label>
                                    <input type="text" class="form-control" name="s_no_qty" id="s_no_qty" placeholder="Batch Quantity" value="<?php echo $row->s_no_qty ?>" readonly>
                                </div>
                            </div>     
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Total Bags / Container</label>
                                    <input type="number" class="form-control" name="ctotal" id="ctotal" placeholder="Total No of quantity" required="">
                                </div>
                            </div> 
                                 
                          </div>
                          <div class="row">
                            <div class="col-md-12 text-right">
                              <input type="submit" class="btn btn-primary btn-lg" name="submit" id="submit" value="Submit" />
                            </div>
                          </div>
                        </form>
                      </div>
                    </div>
                </div>
            </div>
          </div>
          <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->
        <?php else: ?> No records found <?php endif; ?>  
      </div><!-- /.container-fluid -->
      <div id="loader"></div>
    </div>
    <!-- /.content -->