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
                        <!-- <form id="formScope1" method="post" action="#" enctype="multipart/form-data">
                          <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">Bill Date</label>
                                   <input type="date" class="form-control">
                                </div>
                            </div>   
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">Facility</label>
                                    <select name="" id="" class="form-control">
                                    <option value="0">Select Facility</option>
                                    </select>
                                </div>    
                            </div>  
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">Fuel Type</label>
                                        <select name="" id="" class="form-control">
                                        <option value="0">Select Fuel type</option>
                                    </select>
                                </div>              
                            </div>
                          </div>

                          <div class="row">   
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">Use Type</label>
                                    <input type="text" class="form-control">
                                    </div>
                                </div>    
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">Fuel Consumed</label>
                                    <input type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">Unit</label>
                                    <input type="text" class="form-control">
                                    </div>
                                </div>
                            
                            </div>   

                            <div class="row">                    
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">Amount Paid</label>
                                    <input type="text" class="form-control">
                                    </div>
                                </div>    
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">Currency</label>
                                    <input type="text" class="form-control">
                                    </div>
                                </div>         
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">Heat Content of Fuel Per Unit(kWh/lt, kWh/tonnes)</label>
                                    <input type="text" class="form-control">
                                    </div>
                                </div>                                                   
                          </div>

                          <div class="row">                    
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">Carbon Content of the FUel Per Unit</label>
                                   <input type="text" class="form-control">
                                </div>
                            </div>    
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">Emission Factor(kf CO2e of CO2 per unit)</label>
                                   <input type="text" class="form-control">
                                </div>
                            </div>         
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">Evidence(Upload .PDF)</label>
                                   <input type="file" class="form-control">
                                </div>
                            </div>                                                   
                          </div>
                          
                          
                          <div class="row">
                            <div class="col-md-12 text-right">
                              <input type="submit" class="btn btn-primary btn-lg" name="submit" id="submit" value="Submit" />
                            </div>
                          </div>
                        </form> -->
                     
                    
                        <form id="formScope1" method="post" action="#" enctype="multipart/form-data">
                        <p><strong>Fuel Consumption (Stationary & Mobile):</strong></p>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Fuel Type</label>
                                    <select name="fuel_type" class="form-control">
                                        <option value="">Select</option>
                                        <option value="Diesel">Diesel</option>
                                        <option value="Petrol">Petrol</option>
                                        <option value="Natural Gas">Natural Gas</option>
                                        <option value="LPG">LPG</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Quantity Consumed</label>
                                    <input type="number" name="fuel_quantity" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>CO₂ Emissions (kg/metric tons)</label>
                                    <input type="number" name="co2_emissions" class="form-control" required>
                                </div>
                            </div>
                        </div>

                        <!-- On-Site Energy Generation -->
                        <p><strong>On-Site Energy Generation:</strong></p>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Type</label>
                                    <select name="energy_type" class="form-control">
                                        <option value="">Select</option>
                                        <option value="Solar">Solar</option>
                                        <option value="Wind">Wind</option>
                                        <option value="Biomass">Biomass</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Energy Produced (kWh)</label>
                                    <input type="number" name="energy_produced" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Associated Emissions (kg CO₂e)</label>
                                    <input type="number" name="associated_emissions" class="form-control">
                                </div>
                            </div>
                        </div>

                        <!-- Company-Owned Vehicles -->
                        <p><strong>Company-Owned Vehicles (Fleet Emissions):</strong></p>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Vehicle Type</label>
                                    <input type="text" name="vehicle_type" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Fuel Type</label>
                                    <select name="vehicle_fuel_type" class="form-control">
                                        <option value="">Select</option>
                                        <option value="Petrol">Petrol</option>
                                        <option value="Diesel">Diesel</option>
                                        <option value="CNG">CNG</option>
                                        <option value="EV">EV</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Distance Traveled (km/miles)</label>
                                    <input type="number" name="distance_traveled" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Fuel Consumption (Liters/Gallons)</label>
                                    <input type="number" name="distance_traveled" class="form-control">
                                </div>
                            </div>
                        </div>

                        <!-- Industrial Processes Emissions -->
                        <p><strong>Industrial Processes Emissions:</strong></p>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Process Type</label>
                                    <input type="text" name="process_type" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>GHG Emissions (Metric Tons CO₂e)</label>
                                    <input type="number" name="process_emissions" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Evidence (Upload .PDF)</label>
                                    <input type="file" name="process_evidence" class="form-control" accept=".pdf">
                                </div>
                            </div>
                        </div>

                        <!-- Refrigerants & HVAC Systems -->
                        <p><strong>Refrigerants & HVAC Systems:</strong></p>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Refrigerant Type</label>
                                    <input type="text" name="refrigerant_type" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Leak Rate (%)</label>
                                    <input type="number" step="0.1" name="leak_rate" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>GHG Emissions (Metric Tons CO₂e)</label>
                                    <input type="number" name="refrigerant_emissions" class="form-control">
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