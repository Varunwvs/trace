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
                      <form id="formFarmingActivity" method="post" action="FarmerController/addFarmingActivity">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-label">Farmer</label>
                                        <select class="form-control" name="farmer_id" id="farmer_id">
                                            <option value="">Select Farmer</option>
                                            <?php foreach ($farmers as $farmer): ?>
                                                <option value="<?= $farmer->id ?>"><?= $farmer->full_name ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-label">Plot Division</label>
                                        <select class="form-control" name="plot_division_id" id="plot_division_id">
                                            <option value="">Select Plot Division</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-label">Crops</label>
                                        <select class="form-control" name="crop_id" id="crop_id">
                                        <option value="">Select Crop</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <a class="mt-4 btn btn-sm btn-primary" target="_blank" href="#" id="crop_schedule_link">No Schedule Available</a>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Farming Activity Section (Dynamic Rows) -->
                            <h4 class="form-label">Farming Activities</h4>
                                <div id="farmingActivityRows">
                                    <div class="row farmingActivityRow">
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label class="form-label">Select Date</label>
                                                <input type="date" class="form-control" name="activity_date[]" id="activity_date">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label class="form-label">Activities</label>
                                                <select class="form-control" name="activity[]" id="activity">
                                                    <option value="">Select</option>
                                                    <option value="sowing">Sowing</option>
                                                    <option value="spraying">Spraying Insecticides</option>
                                                    <option value="fertilizer">Fertilizer</option>
                                                    <option value="inm">INM</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label class="form-label">Brand</label>
                                                <select class="form-control" name="brand[]" id="brand[]">
                                                    <option value="">Select Brand</option>
                                                    <?php foreach ($farminginputs as $inputs): ?>
                                                        <option value="<?= $inputs->brand ?>"><?= $inputs->brand ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label class="form-label">Product</label>
                                                <select class="form-control" name="product[]" id="product[]">
                                                    <option value="">Select product</option>
                                                    <?php foreach ($farminginputs as $inputs): ?>
                                                        <option value="<?= $inputs->product ?>"><?= $inputs->product ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                 <label class="form-label">Purpose</label>
                                                <!--<select class="form-control" name="purpose[]" id="purpose">
                                                    <option value="">Select</option>
                                                    <option value="pestcontrol">Pest Control</option>
                                                    <option value="plantgrowth">Plant Growth</option>
                                                    <option value="soilenrichment">Soil Enrichment</option>
                                                    <option value="other">Others</option>
                                                </select> -->

                                                <textarea class="form-control" name="purpose[]" id="purpose"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row farmingActivityRow">
                                        
                                        <!-- <div class="col-md-4">
                                            <button type="button" class="btn btn-danger removeBtn mt-4">Remove</button>
                                        </div> -->
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12 text-left">
                                        <button type="button" id="addMore" class="btn btn-success mt-4">Add More</button>
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
    var inputsData = <?php echo json_encode($farminginputs); ?>;
</script>

