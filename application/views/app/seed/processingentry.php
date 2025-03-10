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
     <?php 
     $sourcing_reference_no='';
     $sourcing_reference_no=$_GET['lot_reference_no'] ; ?>
<div class="content">
      <div class="container-fluid">
        <div class="row">  
          <div class="col-lg-12">
            <div class="card">                
                <div class="card-block tab-icon">
                    <div class="row"> 
                      <div class="col-12 text-sm">

                      <!-- <form id="formProcessing" method="post" action="SeedController/addProcessing">
                      <div class="row">
                          <div class="col-md-4">
                              <div class="form-group">
                                  <label class="form-label">Sourcing Lot No.</label>
                                  <select class="form-control" name="sourcing_lot_id" id="sourcing_lot_id">
                                      <option value="">Select Sourcing Lot No.</option>
                                      <?php foreach ($reference_no as $no): ?>
                                        <option value="<?php echo $no->lot_reference_no; ?>" 
                                                            <?php echo ($sourcing_reference_no == $no->lot_reference_no) ? 'selected' : ''; ?>>
                                                            <?php echo $no->lot_reference_no; ?>
                                                        </option>
                                          
                                      <?php endforeach; ?>
                                  </select>
                              </div>
                          </div>
                          <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">Processed Final Lot No.</label>
                                        <input type="number" class="form-control" name="processed_lot_no" id="processed_lot_no">
                                    </div>
                                </div>   
                      </div>
                      <div id="dynamic-fields">
                     

                      </div>
                      <div class="row">
                          <div class="col-md-12 text-right">
                              <input type="submit" class="btn btn-primary" name="submit" id="submit" value="Submit" />
                          </div>
                      </div>
                  </form> -->


                  <form id="formProcessing" method="post" action="SeedController/addProcessing">
    <div class="row">

        <div class="col-md-4">
            <div class="form-group">
                <label class="form-label">Processed Final Lot No.</label>
                <div class="input-group">
                     
                    <?php if(!empty( $_GET['p_lot'])){ ?>
                        <!-- to add more sourcing data for same processed lot no -->
                        <input type="text" class="form-control" name="processed_lot_no" id="processed_lot_no" value="<?php echo $_GET['p_lot']?>" readonly>
                 <?php  } else { ?>
                    <input type="text" class="form-control" name="processed_lot_no" id="processed_lot_no" readonly>
                    <button class="btn btn-warning" type="button" id="generate_processed_lot_no" data-bs-placement="top" data-bs-toggle="tooltip" >Autogenerate</button>
                    <?php  }  ?>
                </div>  
                <input type="hidden" name="cid" id="cid" value="<?php echo $_SESSION['comid'] ?>"> 
            </div>
        </div>

        
      
    </div>

    <div id="sourcing-dynamic-fields">
    <div class="sourcing-row">
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label class="form-label">Sourcing Lot No.</label>
                    <select class="form-control sourcing-lot" name="sourcing_lot_id[]" required>
                        <option value="">Select Sourcing Lot No.</option>
                        <?php foreach ($reference_no as $no): ?>
                            <option value="<?php echo $no->lot_reference_no; ?>">
                                <?php echo $no->lot_reference_no; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <label class="form-label">Vendor Name</label>
                <input type="text" class="form-control vendor_name" name="vendor_name[]" readonly>
                <input type="hidden" class="vendor_id" name="vendor_id[]">
            </div>
            <div class="col-md-4">
                <label class="form-label">Raw Material Name</label>
                <input type="text" class="form-control raw_material" name="raw_material[]" readonly>
                <input type="hidden" class="raw_material_id" name="raw_material_id[]">
            </div>
        </div>

        <!-- Dynamic Processing Rows -->
        <div class="processing-rows">
            <div class="row process-row">
                <div class="col-md-2">
                    <label class="form-label">Process Name</label>
                    <input type="text" class="form-control" name="process_name[][]" required>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Process Type</label>
                    <select class="form-control" name="process_type[][]" required>
                        <option value="0">Select process type</option>
                        <option value="cleaning">Cleaning</option>
                        <option value="sorting">Sorting</option>
                        <option value="grading">Grading</option>
                        <option value="coating">Coating</option>
                        <option value="packing">Packing</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Process Qty</label>
                    <input type="number" class="form-control" name="process_qty[][]" required>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Final Qty</label>
                    <input type="number" class="form-control" name="final_qty[][]" required>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Wastage</label>
                    <input type="number" class="form-control" name="wastage[][]" required>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Unit</label>
                    <select class="form-control" name="uom[][]" required>
                        <option value="">Select Unit</option>
                        <?php foreach ($units as $unit): ?>
                            <option value="<?php echo $unit->uomid; ?>"><?php echo $unit->uomname; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-2 mt-2">
                    <button type="button" class="btn btn-danger remove-process">Remove</button>
                </div>
            </div>
        </div>

        <button type="button" class="btn btn-success add-process mt-3">Add More Processing</button>
        <button type="button" class="btn btn-danger remove-sourcing mt-3">Remove Sourcing</button>
    </div>
</div>

<button type="button" class="btn btn-info mt-3" id="add-more-sourcing">Add More Sourcing Data</button>


    <div class="row mt-3">
        <div class="col-md-12 text-right">
            <input type="submit" class="btn btn-primary btn-lg" name="submit"  id="submit" value="Submit">
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
    var unitsData = <?php echo json_encode($units); ?>;
    var sourcingData = <?php echo json_encode($reference_no); ?>;
</script>
