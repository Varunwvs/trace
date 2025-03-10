    <!-- Content Wrapper. Contains page content -->
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
                    <li class="breadcrumb-item"><a href="admin_dashboard">Home</a></li>
                    <li class="breadcrumb-item active"><?php echo $title ?></li>
                    <?php else: ?>
                    <li class="breadcrumb-item"><a href="admin_dashboard" tabindex="-1">Home</a></li>
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
                <div class="card-header bg-primary" id="dttable">
                    <h5>List of Center</h5>            
                    <div class="card-header-right">
                      <a class="mr-3 text-white" role="button" href="admin_add_center"><i class="fa-solid fa-plus"></i> Add New Center</a>
                    </div>
                </div>
                <div class="card-block tab-icon">
                    <div class="row"> 
                      <div class="col-12 table-responsive text-sm">
                        <table id="dtCenter" class="table table-striped table-bordered nowrap" style="width:100%;">
                          <thead class="bg-nblue">
                            <tr>
                              <th>#</th>
                              <th>Center Name</th> 
                              <th>contact Person</th>
                              <th>Email</th>
                              <th>contact No.</th>
                              <th>Status</th>
                              <th>Actions</th>
                            </tr>
                          </thead>                            
                        </table>
                      </div>
                    </div>
                </div>
            </div>
          </div>
          <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->

    <!-- View company modal -->
    <div class="modal fade" id="viewModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
          <div class="modal-header bg-green shadow-sm mb-2">
            <h1 class="modal-title fs-5" id="exampleModalLabel"><i class="nav-icon fa-solid fa-street-view"></i> Center Details</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>          
          <div class="modal-body">            
            <div class="row">
              <div class="col-7">
                <div class="row">
                  <div class="col-md-5 bg-sky shadow p-1">
                    <h5>Center Name:</h5>
                  </div>
                  <div class="col-md-7 bg-light p-1 rounded">
                    <h5 class="text-capitalize" id="cname"></h5>
                  </div>
                </div>
                
                <div class="row">
                  <div class="col-md-5 bg-sky shadow p-1">
                    <h5>Contact Person:</h5>
                  </div>
                  <div class="col-md-7 bg-light p-1 rounded">
                    <h5 class="text-capitalize" id="cper"></h5>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-5 bg-sky shadow p-1">
                    <h5>Email Id:</h5>
                  </div>
                  <div class="col-md-7 bg-light p-1 rounded">
                    <h5 id="cemail"></h5>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-5 bg-sky shadow p-1">
                    <h5>Password:</h5>
                  </div>
                  <div class="col-md-7 bg-light p-1 rounded">
                    <h5 id="cpass"></h5>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-5 bg-sky shadow p-1">
                    <h5>Phone No.:</h5>
                  </div>
                  <div class="col-md-7 bg-light p-1 rounded">
                    <h5 id="cphone"></h5>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-5 bg-sky shadow p-1">
                    <h5>GST No.:</h5>
                  </div>
                  <div class="col-md-7 bg-light p-1 rounded">
                    <h5 class="text-uppercase" id="cgst"></h5>
                  </div>
                </div>
              </div>
              <div class="col-5">                          
                <div class="row hidden">
                  <div class="col-md-5 bg-sky shadow p-1">
                    <h5>Total Product:</h5>
                  </div>
                  <div class="col-md-7 bg-light p-1 rounded">
                    <h5 id="totprd"></h5>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-5 bg-sky shadow p-1">
                    <h5>Website:</h5>
                  </div>
                  <div class="col-md-7 bg-light p-1 rounded">
                    <h5 id="website"></h5>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-5 bg-sky shadow p-1">
                    <h5>State:</h5>
                  </div>
                  <div class="col-md-7 bg-light p-1 rounded">
                    <h5 class="text-capitalize" id="state"></h5>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-5 bg-sky shadow p-1">
                    <h5>City:</h5>
                  </div>
                  <div class="col-md-7 bg-light p-1 rounded">
                    <h5 class="text-capitalize" id="city"></h5>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-5 bg-sky shadow p-1">
                    <h5>Pincode:</h5>
                  </div>
                  <div class="col-md-7 bg-light p-1 rounded">
                    <h5 id="pin"></h5>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-5 bg-sky shadow p-1">
                    <h5>Address:</h5>
                  </div>
                  <div class="col-md-7 bg-light p-1 rounded">
                    <h5 class="text-capitalize" id="address"></h5>
                  </div>
                </div>
              </div>
            </div>            
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>              
          </div>          
        </div>
      </div>
    </div>