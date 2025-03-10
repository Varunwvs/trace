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
                        <form id="formdealer" >
                        <div class="row">
                           
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="companyName" class="form-label">Company Name</label>
                                    <input type="text" id="companyName" name="company_name" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="gstin" class="form-label">GSTIN</label>
                                    <input type="text" id="gstin" name="gstin" class="form-control" required>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                <label for="pan" class="form-label">PAN</label>
                                <input type="text" id="pan" name="pan" class="form-control" required>
                                </div>
                            </div> 
                               
                        </div>


                        <div class="row">   
                          
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="distributionLocations" class="form-label">Distribution Location</label>
                                    <!-- this should be multiple -->
                                    <select id="distributionLocations" name="distribution_location" class="form-select" required>
                                        <option value="">Select</option>
                                        <?php foreach ($locations as $location): ?>
                                              <option value="<?= $location->id ?>"><?= $location->location_name ?></option>
                                        <?php endforeach; ?>  
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="contactPerson" class="form-label">Contact Person</label>
                                    <input type="text" id="contactPerson" name="contact_person" class="form-control" required>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="mobile" class="form-label">Mobile</label>
                                    <input type="tel" id="mobile" name="mobile" class="form-control" pattern="[0-9]{10}" required>
                                </div>
                            </div> 
                            
                        </div>

                        <div class="row">  
                          
                             
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" id="email" name="email" class="form-control" required>
                                </div>
                            </div>    
                            <div class="col-md-4">
                                <div class="form-group">
                                <label for="distributorStatus" class="form-label">Distributor Status</label>
                                    <select id="distributorStatus" name="distributor_status" class="form-select" required>
                                        <option value="">Select</option>
                                        <option value="Franchisee">Franchisee</option>
                                        <option value="Dealer">Dealer</option>
                                        <option value="Stockist">Stockist</option>
                                        <option value="C&F">C&F</option>
                                        <option value="Company Owned">Company Owned</option>
                                    </select>
                                </div>
                            </div> 

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="address" class="form-label">Address</label>
                                    <textarea id="address" name="address" class="form-control" rows="3" required></textarea>
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