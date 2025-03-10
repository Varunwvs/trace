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
                        <form id="formVendor" method="post" action="SeedController/addVendor">
                          <div class="row">
                            <!-- <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">Product</label>
                                    <select class="form-control" name="product_id" id="product_id">
                                        <option value="">Select Product</option>
                                        <?php foreach ($products as $product): ?>
                                            <option value="<?php echo $product->id; ?>"><?php echo $product->p_name; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>   -->
                            <div class="col-md-4">
                                <div class="form-group">
                                <input type="hidden" name="cid" id="cid" value="<?php echo $_SESSION['comid'] ?>">
                                    <label class="form-label">Vendor Name*</label>
                                    <input type="text" class="form-control" name="vendor_name" id="vendor_name">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">GST No.*</label>
                                    <input type="text" class="form-control" name="gst_no" id="gst_no">
                                </div>
                            </div>    
                            <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">Contact No.*</label>
                                        <input type="number" class="form-control" name="contact_no" id="contact_no">
                                    </div>
                                </div> 
                                          
                          </div>
                          
                          <div class="row">   
                           
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">Contact Person*</label>
                                        <input type="text" class="form-control" name="contact_person" id="contact_person">
                                    </div>
                                </div>
                                     
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">Address*</label>
                                        <textarea class="form-control" name="address" id="address"></textarea>
                                    </div>
                                </div>                                                            
                          </div>

                          <!-- New Bank Details Section -->
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">Bank Name</label>
                                    <input type="text" class="form-control" name="bank_name" id="bank_name">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">Bank Branch</label>
                                    <input type="text" class="form-control" name="bank_branch" id="bank_branch">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">Account No.</label>
                                    <input type="text" class="form-control" name="account_no" id="account_no">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">IFSC Code</label>
                                    <input type="text" class="form-control" name="ifsc_code" id="ifsc_code">
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