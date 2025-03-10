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

                      <form id="formSourcing" method="post" action="SeedController/addSourcing"  enctype="multipart/form-data">
                      <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">Product*</label>
                                    <select class="form-control" name="product_id" id="product_id">
                                        <option value="">Select Product</option>
                                        <?php foreach ($products as $product): ?>
                                            <option value="<?php echo $product->id; ?>"><?php echo $product->p_name; ?></option>
                                        <?php endforeach; ?>
                                    </select>

                                    <input type="hidden" name="cid" id="cid" value="<?php echo $_SESSION['comid'] ?>">
                                </div>
                            </div> 
                            <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">Source Lot Reference Number*</label>
                                        
                                        <div class="input-group">
                                            <input type="number" class="form-control" placeholder="" id="lot_reference_no" name="lot_reference_no" aria-describedby="button-addon1" readonly="true">
                                            <button class="btn btn-warning" type="button" id="btnClick" data-bs-placement="top" data-bs-toggle="tooltip">Autogenerate</button>
                                        </div>                                        
                                    </div>
                                </div>   
                          </div>
                         
                          <div id="sourcingContainer">
                              <!-- Initial Row -->
                              <div class="row sourcing-row">
                                  <div class="col-md-2">
                                      <div class="form-group">
                                          <label class="form-label">Vendor Name*</label>
                                          <select class="form-control" name="vendor_id[]" id="vendor_id_1">
                                              <option value="">Select Vendor</option>
                                              <?php foreach ($vendors as $vendor): ?>
                                                  <option value="<?php echo $vendor->id; ?>"><?php echo $vendor->vendor_name; ?></option>
                                              <?php endforeach; ?>
                                          </select>
                                      </div>
                                  </div>
                                  <div class="col-md-2">
                                      <div class="form-group">
                                          <label class="form-label">Raw Material Name*</label>
                                          <select class="form-control" name="raw_material_id[]" id="raw_material_id_1">
                                              <option value="">Select Raw Material</option>
                                              <?php foreach ($materials as $material): ?>
                                                  <option value="<?php echo $material->id; ?>"><?php echo $material->raw_material_name; ?></option>
                                              <?php endforeach; ?>
                                          </select>
                                      </div>
                                  </div>
                                  <div class="col-md-2">
                                      <div class="form-group">
                                          <label class="form-label">Quantity*</label>
                                          <input type="number" class="form-control" name="qty[]" id="qty_1">
                                      </div>
                                  </div>
                                  <div class="col-md-2">
                                      <div class="form-group">
                                          <label class="form-label">Unit Of Measurements*</label>
                                          <select class="form-control" name="uom[]" id="uom_1">
                                              <option value="">Select Unit</option>
                                              <?php foreach ($units as $unit): ?>
                                                  <option value="<?php echo $unit->uomid; ?>"><?php echo $unit->uomname; ?></option>
                                              <?php endforeach; ?>
                                          </select>
                                      </div>
                                  </div>
                                  <div class="col-md-2">
                                      <div class="form-group">
                                          <label class="form-label">Date Of Sourcing*</label>
                                          <input type="date" class="form-control" name="date_of_sourcing[]" id="date_of_sourcing_1">
                                      </div>
                                  </div>
                                  <div class="col-md-2">
                                      <div class="form-group">
                                          <label class="form-label">GRN File Upload</label>
                                          <input type="file" class="form-control" name="file" id="file" placeholder="Upload GRN File">
                                      </div>
                                  </div>
                                  <div class="col-md-2 mt-4">
                                      <!--<button type="button" class="btn btn-success btn-sm add-more">Add More</button>-->
                                      <button type="button" class="btn btn-danger btn-sm remove-row">Remove</button>
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