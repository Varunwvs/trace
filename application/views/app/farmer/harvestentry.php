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
                                    <label class="form-label">Packhouse Name</label>
                                    <input type="text" class="form-control" name="full_name" id="full_name">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">Date</label>
                                    <input type="date" class="form-control" name="date" id="date">
                                </div>
                            </div>     
                            <div class="col-md-4">
                                <div class="form-group">
                                  <label class="form-label">Farmer Name</label>
                                  <select class="form-control" name="farmer_id" id="farmer_id">
                                            <option value="">Select Farmer</option>
                                            <?php foreach ($farmers as $farmer): ?>
                                                <option value="<?= $farmer->id ?>"><?= $farmer->full_name ?></option>
                                            <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>  
                        </div>
                        <div class="row">   
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">Contact No.</label>
                                    <input type="text" class="form-control" name="contact_no" id="contact_no" readonly>
                                </div>
                            </div>  
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">Farm Location</label>
                                    <input type="text" class="form-control" name="latitude" id="latitude">
                                </div>
                            </div>    
                           
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">Plot No.</label>
                                    <select class="form-control" name="plot_id" id="plot_id">
                                        <option value="">Select Plot</option>
                                        <!-- Options will be dynamically populated -->
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">   
                        <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">Variety</label>
                                    <input type="text" class="form-control" name="registration_id" id="registration_id">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">Govt Reg. No.</label>
                                    <input type="text" class="form-control" name="registration_id" id="registration_id">
                                </div>
                            </div>   
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">EU MRL Status</label>
                                    <select name="status" id="status" class="form-control">
                                        <option value="">Select Status</option>
                                        <option value="">Pass</option>
                                        <option value="">Fail</option>
                                    </select>
                                </div>
                            </div>  
                        </div>

                        <div class="row">   
                        <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">Date & Time Of Harvest</label>
                                    <input type="datetime-local" class="form-control" name="registration_id" id="registration_id">
                                </div>
                            </div>
                          
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">Berry Size</label>
                                    <input type="text" class="form-control" name="registration_id" id="registration_id">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">Empty Crates Available For Harvesting</label>
                                    <input type="text" class="form-control" name="registration_id" id="registration_id">
                                </div>
                            </div>
                        </div>

                        <div class="row">   
                        
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">Filled Crates Uploaded In Vehicle</label>
                                    <input type="text" class="form-control" name="registration_id" id="registration_id">
                                </div>
                            </div>   
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">Harvested Rows</label>
                                    <input type="text" class="form-control" name="registration_id" id="registration_id">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">Rows Yet To Be Harvested</label>
                                    <input type="text" class="form-control" name="registration_id" id="registration_id">
                                </div>
                            </div>
                        </div>

                        <div class="row">   
                           
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">Remarks</label>
                                    <textarea name="" id="" class="form-control"></textarea>
                                </div>
                            </div>   
                           
                        </div>

                        <div class="rows-container">
                            <div class="row form-row" id="row-1">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">Harvester Name</label>
                                        <input type="text" class="form-control" name="harvester_name[]" id="harvester_name_1">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">Code</label>
                                        <input type="text" class="form-control" name="code[]" id="code_1">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <button class="btn btn-sm btn-success add-row mt-4">Add More</button>
                                    </div>
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
   