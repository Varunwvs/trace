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
                        <form id="formaddlocation"  >
                        <div class="row">
                           
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="locationName" class="form-label">Location</label>
                                    <input type="text" id="locationName" name="location" class="form-control" required>
                                    <input type="hidden" name="cid" id="cid" value="<?php echo $_SESSION['comid'] ?>">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="state" class="form-label">Address</label>
                                    <input type="text" id="address" name="address" class="form-control" required>
                                </div>
                            </div>
                           
                               
                        </div>
                        <div class="row mt-3">
                            <h5>In addition to electricity, does your location use any of the other following utilities?</h5>
                        </div>

                        <div class="row  mt-3">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <input type="checkbox" id="natural_gas">
                                    <label for="natural_gas">
                                        <strong>This location also uses natural gas</strong>
                                    </label><br>
                                    <small>
                                        Natural gas is a common fuel type used in many buildings around the world for heating.
                                    </small>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <input type="checkbox" id="heat_steam">
                                    <label for="heat_steam">
                                        <strong>This location also uses heat & steam</strong>
                                    </label><br>
                                    <small>
                                        Heat & steam bought from a third-party supplier and delivered to your location, typically via district heating or heated water. 
                                        While less common globally than onsite natural gas, it is widely used in certain regions.
                                    </small>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <input type="checkbox" id="purchased_cooling">
                                    <label for="purchased_cooling">
                                        <strong>This location also uses purchased cooling</strong>
                                    </label><br>
                                    <small>
                                        Purchased cooling is rarely used (< 2% of locations). It involves buying chilled water for cooling and is NOT the same as traditional air conditioning, 
                                        which relies on purchased electricity and refrigerants.
                                    </small>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                           
                           <div class="col-md-4">
                               <div class="form-group">
                                    <label for="locationName" class="form-label">What is the gross area of this location? (in sq ft)</label>
                                    <input type="text" id="locationName" name="location" class="form-control" >
                               </div>
                           </div>
                           <div class="col-md-4">
                               <div class="form-group">
                                    <label for="locationName" class="form-label">What is the locations primary use? </label>
                                    <select name="" id="" class="form-control">
                                        <option value="">Select</option>
                                        <option value="">Banking & Financial services</option>
                                        <option value="">Education</option>
                                        <option value="">Entertainment & public assembly</option>
                                        <option value="">Food sales</option>
                                        <option value="">Food service</option>
                                        <option value="">Healthcare</option>
                                        <option value="">Lodging</option>
                                        <option value="">Manufacture & industrial</option>
                                    </select>
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