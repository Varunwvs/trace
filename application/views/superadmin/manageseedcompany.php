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
                  <li class="breadcrumb-item"><a href="super_admin_dashboard">Home</a></li>
                  <li class="breadcrumb-item active"><?php echo $title ?></li>
                <?php else: ?>
                  <li class="breadcrumb-item"><a href="super_admin_dashboard" tabindex="-1">Home</a></li>
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
        <div class="row mb-5">
          <!-- product count -->
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
              <span class="info-box-icon bg-success elevation-1"><i class="fa-solid fa-boxes-packing"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Products</span>
                <span class="info-box-number">
                    <?php
                        $com = $this->db->select('id')->from('users')
                              ->where(array('role'=>'company', 'category'=>'1'))
                              ->get();
                              
                        foreach($com->result() as $cm){
                          $cid[]=$cm->id;
                          $pcinfo = $this->db->select('count(*) as pcount')->from('seedproduct')->where_in('c_id', $cid)->get();
                          foreach($pcinfo->result() as $pc){
                              $pcount = $pc->pcount;
                          }
                        }                    
                        if($pcount != 0){
                            echo $pcount;
                        }else{
                            echo '0';
                        }
                    ?>
                </span>                
              </div>
              <!-- /.info-box-content -->
            </div>
          </div>
          <!-- Batch count -->
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
              <span class="info-box-icon bg-info elevation-1"><i class="fa-solid fa-boxes-packing"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Batch</span>
                <span class="info-box-number">
                    <?php
                        $bcinfo = $this->db->select('count(*) as bcount')->from('seedbatch')->where_in('c_id', $cid)->get();
                        foreach($bcinfo->result() as $bc){
                            $bcount = $bc->bcount;
                        }
                        if($bcount != 0){
                            echo $bcount;
                        }else{
                            echo '0';
                        }
                    ?>
                </span>                
              </div>
              <!-- /.info-box-content -->
            </div>
          </div>
          <!-- Primary count -->
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
              <span class="info-box-icon bg-purple elevation-1"><i class="fa-solid fa-qrcode"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Primary Serials</span>
                <span class="info-box-number">
                    <?php
                        $pscinfo = $this->db->select('count(*) as pscount')->from('seedbatchserial')->where_in('cid', $cid)->get();
                        foreach($pscinfo->result() as $psc){
                            $pscount = $psc->pscount;
                        }
                        if($pscount != 0){
                            echo $pscount;
                        }else{
                            echo '0';
                        }
                    ?>
                </span>                
              </div>
              <!-- /.info-box-content -->
            </div>
          </div>
          <!-- Secondary count -->
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
              <span class="info-box-icon bg-warning elevation-1"><i class="fa-solid fa-qrcode"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Secondary Serials</span>
                <span class="info-box-number">
                    <?php
                        $sccinfo = $this->db->select('count(*) as sscount')->from('seedcontainer')->where_in('cid', $cid)->get();
                        foreach($sccinfo->result() as $psc){
                            $sscount = $psc->sscount;
                        }
                        if($sscount != 0){
                            echo $sscount;
                        }else{
                            echo '0';
                        }
                    ?>
                </span>                
              </div>
              <!-- /.info-box-content -->
            </div>
          </div>
        </div>
        <div class="row">  
          <div class="col-lg-12">
            <div class="card">
                <div class="card-header bg-primary" id="dttable">
                    <h5>List of Companies</h5>            
                    <div class="card-header-right">
                      <a class="mr-3 text-white" role="button" href="companyadd"><i class="fa-solid fa-plus"></i> Add New Company</a>
                    </div>
                </div>
                <div class="card-block tab-icon">
                    <div class="row"> 
                      <div class="col-12 table-responsive text-sm">
                        <table id="dtCompany" class="table table-striped table-bordered nowrap" style="width:100%;">
                          <thead class="bg-nblue">
                            <tr>
                              <th>#</th>
                              <th>Company Name</th> 
                              <th>Address</th>
                              <th>Details</th>
                              <th>Category</th>                              
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

    <!-- increase the total count -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header bg-green">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Increase total count</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <form id="editComForm" method="post" action="SuperAdminController/incTotalcount">
            <div class="modal-body">            
              <div class="row editCom">
                <div class="col-12">
                  <div class="form-group mb-3">
                    <label for="totalcount" class="">Total Product Count</label>
                    <select class="form-control" name="totalcount" id="totalcount">
                      <option value="0">Select total count</option>
                      <option value="10">10</option>
                      <option value="25">25</option>
                      <option value="50">50</option>
                      <option value="100">100</option>
                    </select>                    
                  </div>
                </div>
              </div>            
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <input type="submit" name="submit" id="submit" class="btn btn-primary" value="Save changes">
            </div>
          </form>
        </div>
      </div>
    </div>
    
    <!-- increase the qr quantity -->
    <div class="modal fade" id="editQr" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header bg-green">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Increase total count</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <form id="editQrForm" method="post" action="SuperAdminController/incQrQuantity">
            <div class="modal-body">            
              <div class="row editQr">
                <div class="col-12">
                  <div class="form-group mb-3">
                    <label for="totalcount" class="">Qr Quantity</label>
                    <input type="text" class="form-control" name="qrquantity" id="qrquantity">                  
                  </div>
                </div>
              </div>            
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <input type="submit" name="submit" id="submit" class="btn btn-primary" value="Save changes">
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- View company modal -->
    <div class="modal fade" id="viewModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
          <div class="modal-header bg-green">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Company Details</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>          
          <div class="modal-body">            
            <div class="row">
              <div class="col-7">
                <div class="row">
                  <div class="col-md-5 bg-sky">
                    <h5>Company Name:</h5>
                  </div>
                  <div class="col-md-7">
                    <h5 class="text-capitalize" id="cname"></h5>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-5 bg-sky">
                    <h5>Business Category:</h5>
                  </div>
                  <div class="col-md-7">
                    <h5 class="text-capitalize" id="bcat"></h5>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-5 bg-sky">
                    <h5>Contact Person:</h5>
                  </div>
                  <div class="col-md-7">
                    <h5 class="text-capitalize" id="cper"></h5>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-5 bg-sky">
                    <h5>Email Id:</h5>
                  </div>
                  <div class="col-md-7">
                    <h5 id="cemail"></h5>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-5 bg-sky">
                    <h5>Password:</h5>
                  </div>
                  <div class="col-md-7">
                    <h5 id="cpass"></h5>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-5 bg-sky">
                    <h5>Phone No.:</h5>
                  </div>
                  <div class="col-md-7">
                    <h5 id="cphone"></h5>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-5 bg-sky">
                    <h5>GST No.:</h5>
                  </div>
                  <div class="col-md-7">
                    <h5 class="text-uppercase" id="cgst"></h5>
                  </div>
                </div>
              </div>
              <div class="col-5">                          
                <div class="row">
                  <div class="col-md-5 bg-sky">
                    <h5>Total Product:</h5>
                  </div>
                  <div class="col-md-7">
                    <h5 id="totprd"></h5>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-5 bg-sky">
                    <h5>Website.:</h5>
                  </div>
                  <div class="col-md-7">
                    <h5 id="website"></h5>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-5 bg-sky">
                    <h5>State:</h5>
                  </div>
                  <div class="col-md-7">
                    <h5 class="text-capitalize" id="state"></h5>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-5 bg-sky">
                    <h5>City:</h5>
                  </div>
                  <div class="col-md-7">
                    <h5 class="text-capitalize" id="city"></h5>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-5 bg-sky">
                    <h5>Pincode:</h5>
                  </div>
                  <div class="col-md-7">
                    <h5 id="pin"></h5>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-5 bg-sky">
                    <h5>Address:</h5>
                  </div>
                  <div class="col-md-7">
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
    
    <!-- View company modal -->
    <div class="modal fade" id="viewinfoModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
          <div class="modal-header bg-green">
            <h1 class="modal-title fs-5" id="comname"></h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>          
          <div class="modal-body">            
            <div class="row">
              <div class="col-12">
                <div class="row">
                  <div class="col-md-6 bg-sky">
                    <h5>Product:</h5>
                  </div>
                  <div class="col-md-6">
                    <h5 class="text-capitalize" id="prdcount"></h5>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6 bg-sky">
                    <h5>Batch:</h5>
                  </div>
                  <div class="col-md-6">
                    <h5 class="text-capitalize" id="bthcount"></h5>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6 bg-sky">
                    <h5>Primary QRCodes:</h5>
                  </div>
                  <div class="col-md-6">
                    <h5 class="text-capitalize" id="pqrcount"></h5>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6 bg-sky">
                    <h5>Secondary QRCodes:</h5>
                  </div>
                  <div class="col-md-6">
                    <h5 id="sqrcount"></h5>
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