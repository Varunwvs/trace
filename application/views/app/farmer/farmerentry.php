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
                        <form id="formFarmerProfile" method="post" action="FarmerController/addFarmer" enctype="multipart/form-data" >
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">Full Name</label>
                                    <input type="text" class="form-control" name="full_name" id="full_name">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">Contact No.</label>
                                    <input type="number" class="form-control" name="contact_no" id="contact_no">
                                </div>
                            </div>     
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control" name="email" id="email">
                                </div>
                            </div>  
                        </div>
                        <div class="row">   
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">Latitude</label>
                                    <input type="text" class="form-control" name="latitude" id="latitude">
                                </div>
                            </div>    
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">Longitude</label>
                                    <input type="text" class="form-control" name="longitude" id="longitude">
                                </div>
                            </div>  
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">Plot Area (in acres)</label>
                                    <input type="text" class="form-control" name="plot_area" id="plot_area">
                                </div>
                            </div>
                        </div>
                        <div class="row">   
                        <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">Farmer Registration Id</label>
                                    <input type="text" class="form-control" name="registration_id" id="registration_id">
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
                            <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">Farmer File</label>
                                        <input type="file" class="form-control" name="farmer_files" id="farmer_files" accept=".pdf" >
                                    </div>
                                </div>  
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">Upload Document</label>
                                        <input type="file" class="form-control" name="" id="" accept=".pdf" >
                                    </div>
                                </div>  
                        </div>
                       
                        
                        <div class="row">
                            <div class="col-md-12">
                                <h4 class="form-label">Plot Division</h4>
                                <div id="plotDivisionContainer">
                                    <!-- Default Fields -->
                                    <div class="row plot-division">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="form-label">Name</label>
                                                <input type="text" class="form-control" name="plot_name[]" placeholder="Enter plot name">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="form-label">Area (in acres)</label>
                                                <input type="text" class="form-control" name="division_area[]" placeholder="Enter area in acres">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                          <div class="form-group">
                                              <label class="form-label">Crops</label>
                                              <select class="form-control" name="crop_id[]" >
                                                  <option value="">Select Crop</option>
                                                  <?php foreach ($crops as $crop): ?>
                                                      <option value="<?= $crop->id ?>"><?= $crop->crop_name ?></option>
                                                  <?php endforeach; ?>
                                              </select>
                                          </div>
                                      </div>
                                        <!-- <div class="col-md-4 d-flex align-items-center">
                                            <button type="button" class="btn btn-danger removePlotDivision">Remove</button>
                                        </div> -->
                                    </div>
                                </div>
                                <button type="button" class="btn btn-primary mt-3" id="addMorePlotDivision">Add More</button>
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