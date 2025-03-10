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

                      <form id="animalInventoryForm" method="post" action="LiveStockManagementController/addAnimalInventory">
                 
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
                                        <label class="form-label">Stock of Feed & Supplements</label>
                                        <input type="text" class="form-control" name="stock_feed_supplements" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">Medication & Vaccine Inventory</label>
                                        <input type="text" class="form-control" name="medication_vaccine" required>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">Equipment & Machinery</label>
                                        <textarea class="form-control" name="equipment_machinery" required></textarea>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">Fencing & Shelter Details</label>
                                        <textarea class="form-control" name="fencing_shelter" required></textarea>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">Farm Labor Details</label>
                                        <textarea class="form-control" name="farm_labor" required></textarea>
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