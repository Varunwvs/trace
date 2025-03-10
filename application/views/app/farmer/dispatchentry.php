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
                      <form id="formdispatch" >
                          <div class="row">
                              <div class="col-md-4">
                                  <div class="form-group">
                                      <label class="form-label">Order No.</label>
                                      <select class="form-control" name="order_no" id="order_no">
                                          <option value="">Select Order No.</option>
                                          <?php foreach ($orders as $order): ?>
                                                      <option value="<?= $order->id ?>"><?= $order->order_no ?></option>
                                                  <?php endforeach; ?>
                                      </select>
                                  </div>
                              </div>
                              <div class="col-md-4">
                                  <div class="form-group">
                                      <label class="form-label">Dispatch No</label>
                                      <input type="text" class="form-control" name="dispatch_no" id="dispatch_no">
                                  </div>
                              </div>
                              <div class="col-md-4">
                                  <div class="form-group">
                                      <label class="form-label">Batch No</label>
                                      <input type="text" class="form-control" name="batch_no" id="batch_no">
                                  </div>
                              </div>
                          </div>
                          <div class="row">
                              <div class="col-md-4">
                                  <div class="form-group">
                                      <label class="form-label">Crop</label>
                                      <select class="form-control" name="crop_id" >
                                                  <option value="">Select Crop</option>
                                                  <?php foreach ($crops as $crop): ?>
                                                      <option value="<?= $crop->id ?>"><?= $crop->crop_name ?></option>
                                                  <?php endforeach; ?>
                                          </select>
                                  </div>
                              </div>
                              <div class="col-md-4">
                                  <div class="form-group">
                                      <label class="form-label">Qty Shipped</label>
                                      <input type="text" class="form-control" name="qty_shipped" id="qty_shipped">
                                  </div>
                              </div>
                              <div class="col-md-4">
                                  <div class="form-group">
                                      <label class="form-label">Vehicle No.</label>
                                      <input type="text" class="form-control" name="vehicle_no" id="vehicle_no">
                                  </div>
                              </div>
                          </div>
                          <div class="row">
                              <div class="col-md-4">
                                  <div class="form-group">
                                      <label class="form-label">Product Images</label>
                                      <input type="file" class="form-control" name="imagePath" id="imagePath" accept="image/*">
                                  </div>
                              </div>
                              <div class="col-md-4">
                                  <div class="form-group">
                                      <label class="form-label">Reports/Certificates</label>
                                      <input type="file" class="form-control" name="certificate" id="certificate" accept=".pdf">
                                  </div>
                              </div>
                              <div class="col-md-4">
                                  <div class="form-group">
                                      <label class="form-label">File Uploads</label>
                                      <input type="file" class="form-control" name="other_file" id="other_file" accept=".pdf">
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