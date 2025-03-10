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
    
     <?php  $processed_no = '';
    $processed_no= $_GET['processed_lot_no']; ?>
    
<div class="content">
      <div class="container-fluid">
        <div class="row">  
          <div class="col-lg-12">
            <div class="card">                
                <div class="card-block tab-icon">
                    <div class="row"> 
                      <div class="col-12 text-sm">
                        <form id="formBatch" method="post" action="SeedController/addBatch" enctype="multipart/form-data">
                          <div class="row">
                          <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Processed Final Lot no.</label>
                                    <select class="form-control" name="processed_lot_no" id="processed_lot_no">
                                              <option value="">Select Processed Lot No.</option>
                                              <?php foreach ($processed_lot_no as $process): ?>
                                                  <!-- <option value="<?php echo $process->processed_lot_no; ?>"><?php echo $process->processed_lot_no; ?></option> -->

                                                  <option value="<?php echo $process->processed_lot_no; ?>" 
                                                            <?php echo ($processed_no == $process->processed_lot_no) ? 'selected' : ''; ?>>
                                                            <?php echo $process->processed_lot_no; ?>
                                                        </option>
                                              <?php endforeach; ?>
                                          </select>
                                </div>
                            </div>   
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Batch number</label>
                                    <input type="text" class="form-control" name="batch_no" id="batch_no" maxlength = '25'> 
                                    <input type="hidden" class="form-control" name="pid" id="pid" value="<?php echo $_GET['id'] ?>">                                 
                                    <input type="hidden" class="form-control" name="upc" id="upc" value="<?php echo $_GET['upc'] ?>">
                                    <span><small><strong>Note:</strong> Batch No should be less than <strong>25 characters</strong>, if it is more than 25 characters <strong>RSK / K-KISAN portal will not accept the api submission.</strong></small></span>
                                </div>
                            </div>  
                                    
                          </div>
                          <div class="row">   
                          <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Serial Number(Qty)</label>
                                    <!-- <input type="number" class="form-control" name="s_no" id="s_no"> -->
                                    <select class="form-control" name="s_no" id="s_no" required>
                                        <option value="0">Select No.</option>
                                        <option value="10">10</option>
                                        <option value="20">20</option>
                                        <option value="30">30</option>
                                        <option value="40">40</option>
                                        <option value="50">50</option>
                                    </select>
                                    <span><small><strong>Note:</strong> 50 units limit in demo app will be removed for users who have subscribed.</small></span>
                                </div>
                            </div>      
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
                            </div>      
                            <div class="row">                    
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
                            <div class="col-md-6">
                                      <div class="form-group">
                                          <label class="form-label">Lab Certification / QC Upload</label>
                                          <input type="file" class="form-control" name="file" id="file" placeholder="Upload Lab Certification / QC upload" accept=".pdf,image/jpeg,image/jpg,image/png">
                                      </div>
                                  </div>                                                             
                          </div>
                          
                           <?php if($_SESSION['comid']==='218'): ?>
                            <div class="row mt-3 mb-3" style="border-top:1px solid #e6e6e6; border-bottom:1px solid #e6e6e6">
                                <div class="col-md-12 p-2">
                                    <a id="bluelabel" style="cursor: pointer;font-weight: 700;"> 
                                        <i class="fas fa-plus"></i> Add Blue Label Information <i class="fas fa-caret-down"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="row blabel hidden">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">Certificate No:</label>
                                        <input type="text" class="form-control" name="certno" id="certno"  placeholder="Certificate No">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                  <div class="form-group">
                                    <label>Date of issue</label>
                                    <div class="input-group date" id="issuedate" data-target-input="nearest">
                                        <input type="text" class="form-control datetimepicker-input" name="issue_date" id="issue_date" data-target="#issuedate">
                                        <div class="input-group-append" data-target="#issuedate" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                  </div>
                                </div>
                                <div class="col-md-4">
                                <div class="form-group">
                                    <label>Date of Test</label>
                                    <div class="input-group date" id="testdate" data-target-input="nearest">
                                        <input type="text" class="form-control datetimepicker-input" name="test_date" id="test_date" data-target="#testdate">
                                        <div class="input-group-append" data-target="#testdate" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                  </div>
                                </div> 
                            </div>
                            <div class="row blabel hidden">
                              
                                <div class="col-md-4">
                                <div class="form-group">
                                    <label>Certificate Valid upto</label>
                                    <div class="input-group date" id="validdate" data-target-input="nearest">
                                        <input type="text" class="form-control datetimepicker-input" name="valid_date" id="valid_date" data-target="#validdate">
                                        <div class="input-group-append" data-target="#validdate" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                  </div>
                                </div>                                         
                            </div>

                            <?php endif ?>
                          
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