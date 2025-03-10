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

                          <h4>Upstream Emissions (Before the company)</h4> 
                          <hr>
                            <p><strong>Purchased Goods & Services:</strong></p>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">Product/Material Name</label>
                                        <input type="text" class="form-control" name="product_name">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">Quantity Procured</label>
                                        <input type="number" class="form-control" name="quantity_procured">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">Supplier Name</label>
                                        <input type="text" class="form-control" name="supplier_name">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">Emission Factor (kg CO₂e/unit)</label>
                                        <input type="number" class="form-control" name="emission_factor">
                                    </div>
                                </div>
                            </div>

                            <!-- Business Travel -->
                            <p><strong>Business Travel:</strong></p>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">Travel Mode</label>
                                        <select class="form-control" name="travel_mode">
                                            <option value="Flight">Flight</option>
                                            <option value="Train">Train</option>
                                            <option value="Car Rental">Car Rental</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">Distance Traveled (km/miles)</label>
                                        <input type="number" class="form-control" name="distance_traveled">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">Class of Travel</label>
                                        <select class="form-control" name="class_of_travel">
                                            <option value="Economy">Economy</option>
                                            <option value="Business">Business</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">CO₂e Emissions</label>
                                        <input type="number" class="form-control" name="co2_emissions">
                                    </div>
                                </div>
                            </div>

                            <!-- Employee Commuting -->
                            <p><strong>Employee Commuting:</strong></p>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">Mode of Transport</label>
                                        <input type="text" class="form-control" name="mode_of_transport">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">Distance Traveled Per Day (km)</label>
                                        <input type="number" class="form-control" name="distance_per_day">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">Work-from-Home Ratio (%)</label>
                                        <input type="number" class="form-control" name="work_from_home_ratio">
                                    </div>
                                </div>
                            </div>

                            <p><strong>Fuel & Energy-Related Activities (Not Included in Scope 1 or 2):</strong></p>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">Fuel Type Used in Supply Chain</label>
                                        <input type="text" class="form-control" name="fuel_type_supply_chain">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">Energy Purchased (kWh)</label>
                                        <input type="number" class="form-control" name="energy_purchased">
                                    </div>
                                </div>
                            </div>
                            <br>
                            <hr>
                            <h4>Downstream Emissions (After the company)</h4>
                            <hr>
                             <p><strong>Transportation & Distribution of Sold Products:</strong></p>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">Mode of Transport (Truck, Ship, Air, Rail)</label>
                                        <input type="text" class="form-control" name="transport_mode">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">Distance Covered (km)</label>
                                        <input type="number" class="form-control" name="distance_covered">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">Fuel Consumption (Liters)</label>
                                        <input type="number" class="form-control" name="fuel_consumption">
                                    </div>
                                </div>
                            </div>
                            <p><strong>Product Use & Disposal:</strong></p>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">Expected Lifetime Emissions (CO₂e)</label>
                                        <input type="number" class="form-control" name="lifetime_emissions">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">Recycling/End-of-Life Disposal Method</label>
                                        <input type="text" class="form-control" name="recycling_method">
                                    </div>
                                </div>
                            </div>
                            <p><strong>Franchises, Investments & Leased Assets:</strong> </p>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">Type of Investment (Equity, Loan, etc.)</label>
                                        <input type="text" class="form-control" name="investment_type">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">Financial Value & CO₂ Impact</label>
                                        <input type="number" class="form-control" name="financial_value">
                                    </div>
                                </div>
                            </div>


                            <!-- Evidence Upload -->
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">Evidence (Upload .PDF)</label>
                                        <input type="file" class="form-control">
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