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
                                    <label class="form-label">Vehicle</label>
                                    <Select class="form-control">
                                      <option value="">Select</option>
                                      <option value="">Semi-Trailer Trucks</option>
                                      <option value="">Box Trucks</option>
                                      <option value="">Flatbed Trucks</option>
                                      <option value="">Refrigerated Trucks</option>
                                      <option value="">Tanker Trucks</option>
                                      <option value="">Heavy Hauler Trucks</option>
                                    </Select>
                                </div>
                            </div>     
                        </div>
                        <div class="row">   
                             
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">License No.</label>
                                    <input type="text" class="form-control" name="longitude" id="longitude">
                                </div>
                            </div>  
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">License Expiry Date</label>
                                    <input type="text" class="form-control" name="longitude" id="longitude">
                                </div>
                            </div> 
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">RTO</label>
                                    <input type="text" class="form-control" name="latitude" id="latitude">
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