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
                        <form id="formeiProfileUser" method="post" action="FarmerController/addeiProfileUser" >
                        <div class="row">
                           
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">Company Name</label>
                                    <input type="text" class="form-control" name="company_name" id="company_name">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">Contact Person</label>
                                    <input type="text" class="form-control" name="full_name" id="full_name">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">Contact No.</label>
                                    <input type="number" class="form-control" name="contact_no" id="contact_no">
                                </div>
                            </div>     
                             
                        </div>
                        <div class="row">  
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control" name="email" id="email">
                                </div>
                            </div>  
                            <div class="col-md-4">
                                <div class="form-group position-relative">
                                    <label class="form-label">Password</label>
                                    <div class="input-group">
                                        <input type="password" class="form-control" name="password" id="password">
                                        <span class="input-group-text" id="eye-toggle" style="cursor: pointer;">
                                            <i class="fa fa-eye-slash toggle-password text-grey" id="eye"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
  
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">Website</label>
                                    <input type="text" class="form-control" name="website" id="website">
                                </div>
                            </div>  
                            
                        </div>
                        <div class="row">   
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">License No.</label>
                                    <input type="text" class="form-control" name="license_no" id="license_no">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">Registration No.</label>
                                    <input type="text" class="form-control" name="register_no" id="register_no">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">Tax Id</label>
                                    <input type="text" class="form-control" name="tax_id" id="tax_id">
                                </div>
                            </div>
                            
                            
                        </div>

                        <div class="row">  
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">User Type</label>
                                    <select class="form-control" name="user_type" id="user_type">
                                                    <option value="">Select</option>
                                                    <option value="export">Export</option>
                                                    <option value="import">Import</option>
                                                    <option value="both">Both(Export-Import)</option>
                                                    <option value="intermediary">Intermediary</option>
                                                    <option value="customer">Customer</option>
                                                </select>
                                </div>
                            </div> 
                            
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">Address</label>
                                    <textarea class="form-control" name="address" id="address"></textarea>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">Notes</label>
                                    <textarea class="form-control" name="notes" id="notes"></textarea>
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
    <script>
    var cropsData = <?php echo json_encode($crops); ?>;
</script>