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
                  <li class="breadcrumb-item"><a href="psdashboard">Home</a></li>
                  <li class="breadcrumb-item active"><?php echo $title ?></li>
                <?php else: ?>
                  <li class="breadcrumb-item"><a href="psdashboard" tabindex="-1">Home</a></li>
                  <li class="breadcrumb-item"><?php echo $thisPageMain ?></li>
                  <li class="breadcrumb-item active"><?php echo $title ?></li>
                <?php endif ?>              
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
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
        <div class="row">  
          <div class="col-lg-12">
            <div class="card">                
                <div class="card-block tab-icon">
                    <div class="row"> 
                      <div class="col-12 text-sm">
                        <form id="formBatch" method="post" action="PesticideController/addPBatch">
                          <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Batch number</label>
                                    <input type="text" class="form-control" name="batch_no" id="batch_no"> 
                                    <input type="hidden" class="form-control" name="pid" id="pid" value="<?php echo $_GET['id'] ?>">                                 
                                    <input type="hidden" class="form-control" name="upc" id="upc" value="<?php echo $_GET['upc'] ?>">
                                    <span><small><strong>Note:</strong> Batch No should be less than <strong>25 characters</strong>, if it is more than 25 characters <strong>RSK / K-KISAN portal will not accept the api submission.</strong></small></span>
                                </div>
                            </div>  
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Serial Number(Qty)</label>
                                    <input type="number" class="form-control" name="s_no" id="s_no">
                                </div>
                            </div>                
                          </div>
                          <div class="row">   
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Mfg Date</label>
                                    <div class="input-group date" id="mfgdate" data-target-input="nearest">
                                        <input type="text" class="form-control datetimepicker-input" name="mfg_date" id="mfg_date" data-target="#mfgdate">
                                        <div class="input-group-append" data-target="#mfgdate" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>                         
                            <div class="col-md-6">
                            <div class="form-group">
                                <label>Exp Date</label>
                                <div class="input-group date" id="expdate" data-target-input="nearest">
                                    <input type="text" class="form-control datetimepicker-input" name="exp_date" id="exp_date" data-target="#expdate">
                                    <div class="input-group-append" data-target="#expdate" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>
                            </div>
                              <!-- /.form-group -->                              
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
      </div><!-- /.container-fluid -->
      <div id="loader"></div>
    </div>
    <!-- /.content -->