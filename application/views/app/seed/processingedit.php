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


                  <form id="formEditProcessing" method="post" action="SeedController/editProcessing">
                            <div class="row">

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">Processed Final Lot No.</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="processed_lot_no" id="edit_processed_lot_no" readonly>
                                            <!-- <button class="btn btn-warning" type="button" id="generate_processed_lot_no" data-bs-placement="top" data-bs-toggle="tooltip" >Autogenerate</button> -->
                                        </div>  
                                        <input type="hidden" name="cid" id="cid" value="<?php echo $_SESSION['comid'] ?>"> 
                                        <input type="hidden" name="pid" id="pid" value="<?php echo $_GET['processing_id'] ?>"> 
                                    </div>
                                </div>

                                
                            
                            </div>

                            <div id="sourcing-dynamic-fields">
                            <div class="sourcing-row">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="form-label">Sourcing Lot No.</label>
                                            <select class="form-control sourcing-lot" name="sourcing_lot_id" id="edit_sourcing_lot_id" required readonly>
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
                                        <input type="text" class="form-control vendor_name" name="vendor_name" id="edit_vendor_id" readonly>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Raw Material Name</label>
                                        <input type="text" class="form-control raw_material" name="raw_material" id="edit_raw_material_id" readonly>
                                    </div>
                                </div>

                                <!-- Dynamic Processing Rows -->
                                <div class="processing-rows">
                                    <div class="row process-row">
                                        <div class="col-md-2">
                                            <label class="form-label">Process Name</label>
                                            <input type="text" class="form-control" name="process_name" id="edit_process_name" required>
                                        </div>
                                        <div class="col-md-2">
                                            <label class="form-label">Process Type</label>
                                            <select class="form-control" name="process_type" id="edit_process_type" required>
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
                                            <input type="number" class="form-control" name="process_qty" id="edit_process_qty" required>
                                        </div>
                                        <div class="col-md-2">
                                            <label class="form-label">Final Qty</label>
                                            <input type="text" class="form-control" name="final_qty" id="edit_final_qty" required>
                                        </div>
                                        <div class="col-md-2">
                                            <label class="form-label">Wastage</label>
                                            <input type="text" class="form-control" name="wastage" id="edit_wastage" required>
                                        </div>
                                        <div class="col-md-2">
                                            <label class="form-label">Unit</label>
                                            <select class="form-control" name="uom" id="edit_uom" required>
                                                <option value="">Select Unit</option>
                                                <?php foreach ($units as $unit): ?>
                                                    <option value="<?php echo $unit->uomid; ?>"><?php echo $unit->uomname; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                      
                                    </div>
                                </div>

                               
                            </div>
                        </div>

                       


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
