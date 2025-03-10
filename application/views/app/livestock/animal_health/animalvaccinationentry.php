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

                      <form id="animalVaccinationForm" method="post" action="LiveStockManagementController/addAnimalVaccination">
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

                                    <!-- Health Status -->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="form-label">Health Status</label>
                                            <select class="form-control" name="health_status">
                                            <option value="">Select Status</option>
                                                <option value="Healthy">Healthy</option>
                                                <option value="Sick">Sick</option>
                                                <option value="Injured">Injured</option>
                                                <option value="Recovering">Recovering</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Vaccination -->
                                     <!-- <p><strong>Vaccination Record:</strong></p> -->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="form-label">Vaccination Type</label>
                                            <input type="text" class="form-control" name="vaccination_type">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="form-label">Vaccination Date</label>
                                            <input type="date" class="form-control" name="vaccination_date">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="form-label">Next Vaccination Due Date</label>
                                            <input type="date" class="form-control" name="next_vaccination_due">
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