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

                      <form id="animalDairyForm" method="post" action="LiveStockManagementController/addAnimalDairy">
                 

                                    <div class="row">
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
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="form-label">Daily Milk Yield (Liters)</label>
                                                <input type="number" step="0.1" class="form-control" name="milk_yield" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="form-label">Lactation(Active/Inactive)</label>
                                                <select class="form-control" name="lactation_period" id="lactation_period"  required>
                                                        <option value="">Select </option>
                                                        <option value="active">Active</option>
                                                        <option value="inactive">Inactive</option>
                                                    </select>
                                                <!-- <input type="text" class="form-control" name="lactation_period"> -->
                                            </div>
                                        </div>
                                        <!-- <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="form-label">Milking Time</label>
                                                <select class="form-control" name="milking_time">
                                                    <option value="">Select</option>
                                                    <option value="Morning">Morning</option>
                                                    <option value="Evening">Evening</option>
                                                </select>
                                            </div>
                                        </div> -->
                                    </div>

                                    <!-- <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="form-label">Fat %</label>
                                                <input type="number" step="0.1" class="form-control" name="fat_percentage" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="form-label">SNF %</label>
                                                <input type="number" step="0.1" class="form-control" name="snf_percentage" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="form-label">Contamination</label>
                                                <input type="text" class="form-control" name="contamination">
                                            </div>
                                        </div>
                                    </div> -->

                                    <div class="row">
                                        
                                        <!-- <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="form-label">Milk Sales & Revenue</label>
                                                <input type="text" class="form-control" name="milk_sales_revenue">
                                            </div>
                                        </div> -->
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="form-label">Storage & Distribution Details</label>
                                                <textarea class="form-control" name="storage_distribution" id="storage_distribution"></textarea>
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