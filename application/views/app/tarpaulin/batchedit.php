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

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">  
          <div class="col-lg-12">
            <div class="card">                
                <div class="card-block tab-icon">
                    <div class="row"> 
                      <div class="col-12 text-sm">                        
                        <form id="formBatch" method="post" action="TarpaulinController/editBatch">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">Batch number</label>
                                        <input type="text" class="form-control" name="edit_batch_no" id="edit_batch_no"> 
                                        <input type="hidden" class="form-control" name="edit_bid" id="edit_bid" value="<?php echo $_GET['id'] ?>">  
                                    </div>
                                </div> 
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Mfg Date</label>
                                        <div class="input-group date" id="mfgdate" data-target-input="nearest">
                                            <input type="text" class="form-control datetimepicker-input" name="edit_mfg_date" id="edit_mfg_date" data-target="#mfgdate">
                                            <div class="input-group-append" data-target="#mfgdate" data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Exp Date</label>
                                        <div class="input-group date" id="expdate" data-target-input="nearest">
                                            <input type="text" class="form-control datetimepicker-input" name="edit_exp_date" id="edit_exp_date" data-target="#expdate">
                                            <div class="input-group-append" data-target="#expdate" data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                            </div>
                                        </div>
                                    </div>
                                <!-- /.form-group -->                              
                                </div>                  
                            </div>
                            <div class="row">
                                <div class="col-md-12 text-center">
                                <input type="submit" class="btn btn-primary btn-lg" name="submit" id="submit" value="Save Changes" />
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
    </div>
    <!-- /.content -->