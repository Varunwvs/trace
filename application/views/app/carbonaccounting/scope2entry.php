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
                     
                    
                        <form id="formScope1" method="post" action="#" enctype="multipart/form-data">
                            <p><strong>Purchased Electricity:</strong></p>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">Energy Provider Name</label>
                                        <input type="text" name="energy_provider" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">Total Electricity Purchased (kWh)</label>
                                        <input type="number" name="total_electricity" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">Grid Emission Factor (kg CO₂e/kWh)</label>
                                        <input type="number" step="0.01" name="grid_emission_factor" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Purchased Steam, Heating, and Cooling -->
                            <p><strong>Purchased Steam, Heating, and Cooling:</strong></p>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">Type</label>
                                        <select name="steam_type" class="form-control">
                                            <option value="">Select</option>
                                            <option value="Steam">Steam</option>
                                            <option value="District Heating">District Heating</option>
                                            <option value="District Cooling">District Cooling</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">Energy Consumption (kWh, GJ, or MMBtu)</label>
                                        <input type="number" name="energy_consumption" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">Emission Factor (kg CO₂e/kWh)</label>
                                        <input type="number" step="0.01" name="steam_emission_factor" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Renewable Energy Usage -->
                            <p><strong>Renewable Energy Usage:</strong></p>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">Renewable Energy Purchased (kWh)</label>
                                        <input type="number" name="renewable_energy" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">Green Tariff Participation</label>
                                        <select name="green_tariff" class="form-control">
                                            <option value="">Select</option>
                                            <option value="Yes">Yes</option>
                                            <option value="No">No</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">Renewable Energy Certificates (RECs) Used</label>
                                        <input type="number" name="recs_used" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Evidence Upload -->
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">Evidence (Upload .PDF)</label>
                                        <input type="file" name="evidence" class="form-control" accept=".pdf">
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