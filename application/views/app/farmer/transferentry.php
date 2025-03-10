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
                        <form id="formFarmerProfile" method="post" action="#" enctype="multipart/form-data" >
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="date" class="form-label">Transfer Date</label>
                                        <input type="date" class="form-control" id="date" name="date" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="from_warehouse" class="form-label">From Warehouse</label>
                                        <select class="form-control" id="from_warehouse" name="from_warehouse">
                                            <option>Select warehouse</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="to_warehouse" class="form-label">To Warehouse</label>
                                         <select class="form-control" id="to_warehouse" name="to_warehouse">
                                            <option>Select warehouse</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row ">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="reference_number" class="form-label">Reference Number</label>
                                        <input type="text" class="form-control" id="reference_number" name="reference_number">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="select_items" class="form-label">Select Items / Products</label>
                                        <input type="text" class="form-control" id="select_items" name="select_items" placeholder="Scan QR / Input range of IDs">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="file_upload" class="form-label">File Upload</label>
                                        <input type="file" class="form-control" id="file_upload" name="file_upload">
                                    </div>
                                </div>
                            </div>
                            <div class="row ">
                               
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="issued_by" class="form-label">Issued by</label>
                                        <select class="form-control" id="issued_by" name="issued_by">
                                            <option>Select User</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="dispatched_through" class="form-label">Dispatched through</label>
                                        <select class="form-control" id="dispatched_through" name="dispatched_through">
                                            <option>Select Vehicle</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="notes" class="form-label">Notes</label>
                                        <textarea class="form-control" id="notes" name="notes" rows="2"></textarea>
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
      </div><!-- /.container-fluid -->
      <div id="loader"></div>
    </div>
    <!-- /.content -->
   