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

                      <form id="animalFeedingForm" method="post" action="LiveStockManagementController/addAnimalFeeding">
                
                                  
                                        <div class="row">
                                            <!-- Animal ID -->
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="form-label">Animal ID</label>
                                                    <select class="form-control" name="animal_id" id="animal_id"  required>
                                                        <option value="">Select Animal Id</option>
                                                        <?php foreach ($animals as $row): ?>
                                                            <option value="<?= $row->id ?>"><?= $row->animal_id ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                    <input type="hidden" name="cid" id="cid" value="<?php echo $_SESSION['comid'] ?>">
                                                </div>
                                            </div>

                                            <!-- Daily Feed Intake -->
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="form-label">Daily Feed Intake (Kg/Liters)</label>
                                                    <input type="number" step="0.01" class="form-control" name="feed_intake" required>
                                                </div>
                                            </div>

                                            <!-- Feed Type -->
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="form-label">Feed Type</label>
                                                    <select class="form-control" name="feed_type" required>
                                                    <option value="">Select Type</option>
                                                        <option value="Hay">Hay</option>
                                                        <option value="Silage">Silage</option>
                                                        <option value="Concentrates">Concentrates</option>
                                                        <option value="Supplements">Supplements</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <!-- Feeding Schedule -->
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="form-label">Feeding Schedule</label>
                                                    <select class="form-control" name="feeding_schedule" required>
                                                    <option value="">Select Schedule</option>
                                                        <option value="Morning">Morning</option>
                                                        <option value="Afternoon">Afternoon</option>
                                                        <option value="Evening">Evening</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <!-- Water Intake Monitoring -->
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="form-label">Water Intake (Liters)</label>
                                                    <input type="number" step="0.01" class="form-control" name="water_intake" required>
                                                </div>
                                            </div>

                                            <!-- Weight Tracking -->
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="form-label">Weight Tracking</label>
                                                    <select class="form-control" name="weight_tracking" required>
                                                    <option value="">Select </option>
                                                        <option value="Weekly">Weekly</option>
                                                        <option value="Monthly">Monthly</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <!-- Special Dietary Needs -->
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="form-label">Special Dietary Needs</label>
                                                    <textarea class="form-control" name="special_diet" rows="3"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    <!-- Submit Button -->
                                    <div class="row">
                                        <div class="col-md-12 text-right">
                                        <input type="submit" class="btn btn-primary btn-lg" name="submit" id="submit" value="Submit" />
                                        </div>
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