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
                        <div class="row">
                        <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">Equipment Id</label>
                                    <input type="text" class="form-control" name="contact_no" id="contact_no">
                                </div>
                            </div>  
                           
                           
                        </div>

                        <div class="row mt-3">
                            <h5>Please select the following that apply. You can always update these later.</h5>
                        </div>

                        <div class="row  mt-3">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <input type="checkbox" id="natural_gas">
                                    <label for="natural_gas">
                                        <strong>This equipment consumes fuel</strong>
                                    </label><br>
                                    <small>
                                    Select this if your equipment runs on fuel (gasoline, diesel, etc). To avoid double counting, if you’ve already accounted for natural gas usage at the facility level, there’s no need to add natural gas boilers as equipment here.
                                    </small>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <input type="checkbox" id="heat_steam">
                                    <label for="heat_steam">
                                        <strong>This  equipment uses refrigerants</strong>
                                    </label><br>
                                    <small>
                                    Select this if your company purchases refrigerants used by equipment owned by your organization including mobile air conditioning, chillers, retail food refrigeration, refrigerated transport, etc.
                                    </small>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <input type="checkbox" id="purchased_cooling">
                                    <label for="purchased_cooling">
                                        <strong>This equipment uses industrial gases</strong>
                                    </label><br>
                                    <small>
                                    Select this if your company purchases industrial gases, such as carbon dioxide, methane, nitrous oxide, sulfur hexafluoride, and nitrogen trifluoride, used in manufacturing, testing, or laboratory applications.
                                    </small>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">    
                            <!-- this dropdown updates as per the above checkbox selection so we need master data -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">Equipment Type</label>
                                    <Select class="form-control">
                                      <option value="">Select</option>
                                      <option value="">Chillers </option>
                                      <option value="">Refrigerations</option>
                                      <option value="">Mobile air conditioning  </option>
                                      <option value="">Stand alone commercial applications</option>
                                      <option value="">Fixed fire suppresion equipment </option>
                                      <option value="">Boiler </option>
                                      <option value="">Burner </option>
                                      <option value="">Dryer </option>
                                      <option value="">Oven </option>
                                      <option value="">Generator </option>
                                      <option value="">Heater </option>
                                    </Select>
                                </div>
                            </div>  
                            <div class="col-md-4">
                                <div class="form-group">
                                    <!-- location entered in location section -->
                                    <label class="form-label">Where is this Equipment located?</label>
                                    <Select class="form-control">
                                    <option value="">Select</option>
                                    </Select>
                                                                          
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