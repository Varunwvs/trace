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
                        <form id="formFarmerLabour" method="post" action="#" enctype="multipart/form-data" >
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">Full Name*</label>
                                    <input type="text" class="form-control" name="full_name" id="full_name">
                                    <input type="hidden" name="cid" id="cid" value="<?php echo $_SESSION['comid'] ?>">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">DOB</label>
                                    <input type="date" class="form-control" name="dob" id="dob">
                                </div>
                            </div>     
                            <div class="col-md-4">
                                <div class="form-group">
                                <label class="form-label">Contact No.*</label>
                                <input type="number" class="form-control" name="contact_no" id="contact_no">
                                </div>
                            </div>  
                        </div>
                        <div class="row">   
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">Emergency Contact No.</label>
                                    <input type="number" class="form-control" name="emergency_contact" id="emergency_contact">
                                </div>
                            </div>  
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">Govt Id</label>
                                    <input type="file" class="form-control" name="file" id="file" accept=".pdf">
                                </div>
                            </div>    
                           
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">Blood Group</label>
                                    <input type="text" class="form-control" name="blood_grp" id="blood_grp">
                                </div>
                            </div>
                        </div>
                        <div class="row">   
                        <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">Daily Wages</label>
                                    <input type="number" class="form-control" name="daily_wage" id="daily_wage">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">Skills</label>
                                    <textarea class="form-control" name="skills" id="skills"></textarea>
                                </div>
                            </div>   
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">Address</label>
                                    <textarea class="form-control" name="address" id="address"></textarea>
                                </div>
                            </div>   
                            
                        </div>

                        <div class="row"> 
                          <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">Notes</label>
                                    <textarea class="form-control" name="notes" id="notes"></textarea>
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
   