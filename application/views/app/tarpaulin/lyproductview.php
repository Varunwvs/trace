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
                    <li class="breadcrumb-item"><a href="tpdashboard">Home</a></li>
                    <li class="breadcrumb-item active"><?php echo $title ?></li>
                    <?php else: ?>
                    <li class="breadcrumb-item"><a href="tpdashboard" tabindex="-1">Home</a></li>
                    <li class="breadcrumb-item"><?php echo $thisPageMain ?></li>
                    <li class="breadcrumb-item active"><?php echo $title ?></li>
                    <?php endif ?>              
                </ol>
            </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

<?php
    $id = $_GET['id'];
    $adminrole = $_SESSION['role'];
    $admin=substr($adminrole, 0, -6).'admin';
    $center=substr($adminrole, 0, -6).'center';
    if($_SESSION['role']!=$center){
      $cid = $_SESSION['comid'];
    }else{      
      $cinfo = $this->db->select('id as cid')->from('users')->where('role', $admin)->get();
      foreach($cinfo->result() as $crow){
          $cid = $crow->cid;
      }
      $cid = $cid;
    }
    $query = $this->db->select('id, c_id, name, applicationid, marketed_by, itemcategoryid, itemcategory, 
    subcategoryid, subcategory, p_code, itemid, p_name, b_name, unit_w, uomid, net_w, cml, cmlbis, licno, gsm, status, api_sent, 
    api_response, onlyprimary')->from('tarpaulinproduct')->where(array('id'=>$id, 'c_id'=>$cid))->get();
    $count = $query->num_rows(); 
?>
<!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">  
          <div class="col-lg-12">
            <?php if($count != 0): ?>
              <?php foreach($query->result() as $row): ?>
              <?php $api_sent = $row->api_sent; ?>
              <div class="card">    
                <div class="card-header bg-primary" id="dttable">
                    <h5 id="prddtls" style="cursor: pointer;"><?php echo ucwords($row->p_name) ?> <i class="fa-solid fa-caret-down"></i>
                        <?php if($row->onlyprimary==='1'):?>
                          <sup><small><span class="right badge badge-success">Primary</span></small></sup>
                         <?php else: ?>
                          <sup><small><span class="right badge badge-warning">Secondary</span></small></sup>
                        <?php endif ?>
                    </h5>           
                    <div class="card-header-right">
                      <?php if($row->api_sent!='1'): ?>
                        <a class="mr-3 text-white" role="button" href="tpproductedit?id=<?php echo $row->id ?>"><i class="fa-solid fa-edit"></i> Edit Product Info</a>                        
                      <?php endif ?>
                    </div> 
                </div>            
                  <div class="card-block tab-icon hidden">
                      <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <label class="form-label col-6 bg-sky p-2">Company Name</label>
                                    <label class="form-label col-6 p-2 text-primary"><?php echo strtoupper($row->name) ?></label>
                                </div>
                                <div class="row">
                                    <label class="form-label col-6 bg-sky p-2">MKT BY</label>
                                    <label class="form-label col-6 p-2 text-primary"><?php echo strtoupper($row->marketed_by) ?></label>
                                </div>
                                <div class="row">
                                    <label class="form-label col-6 bg-sky p-2">Category</label>
                                    <label class="form-label col-6 p-2 text-primary"><?php echo strtoupper($row->itemcategory) ?></label>
                                </div>
                                <div class="row">
                                    <label class="form-label col-6 bg-sky p-2">Sub Category</label>
                                    <label class="form-label col-6 p-2 text-primary"><?php echo strtoupper($row->subcategory) ?></label>
                                </div>
                                <div class="row">
                                    <label class="form-label col-6 bg-sky p-2">CM/L No.</label>
                                    <label class="form-label col-6 p-2 text-primary"><?php echo strtoupper($row->cml) ?></label>
                                </div>
                                <div class="row">
                                    <label class="form-label col-6 bg-sky p-2">CM L BIS Number</label>
                                    <label class="form-label col-6 p-2 text-primary"><?php echo strtoupper($row->cmlbis) ?></label>
                                </div>
                                <div class="row">
                                    <label class="form-label col-6 bg-sky p-2">License Number</label>
                                    <label class="form-label col-6 p-2 text-primary"><?php echo strtoupper($row->licno) ?></label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <label class="form-label col-6 bg-sky p-2">UPC</label>
                                    <label class="form-label col-6 p-2 text-primary"><?php echo $row->p_code ?></label>
                                </div>
                                <div class="row">
                                    <label class="form-label col-6 bg-sky p-2">Product Name</label>
                                    <label class="form-label col-6 p-2 text-primary"><?php echo strtoupper($row->p_name) ?></label>
                                </div>
                                <div class="row">
                                    <label class="form-label col-6 bg-sky p-2">Brand Name</label>
                                    <label class="form-label col-6 p-2 text-primary"><?php echo strtoupper($row->b_name) ?></label>
                                </div>
                                <div class="row">
                                    <label class="form-label col-6 bg-sky p-2">Measurement Unit of Weight *</label>
                                    <label class="form-label col-6 p-2 text-primary"><?php echo strtoupper($row->unit_w) ?></label>
                                </div>
                                <div class="row">
                                    <label class="form-label col-6 bg-sky p-2">Number of Pieces / Pack</label>
                                    <label class="form-label col-6 p-2 text-primary"><?php echo $row->net_w ?></label>
                                </div>
                                <div class="row">
                                    <label class="form-label col-6 bg-sky p-2">GSM</label>
                                    <label class="form-label col-6 p-2 text-primary"><?php echo strtoupper($row->gsm) ?></label>
                                </div>
                            </div>         
                        </div>       
                    </div>   
                  </div>
              </div>
              <?php endforeach; ?> <!-- end foreach -->
            <?php else: ?> No records found <?php endif; ?>  
          </div>
          <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">  
          <div class="col-lg-12">
            <?php if($count != 0): ?>
              <?php foreach($query->result() as $row): ?>
              <div class="card">    
                <div class="card-header bg-primary" id="dttable">
                    <h5>Batch Details</h5>  
                </div>            
                  <div class="card-block tab-icon">
                    <div class="row"> 
                      <div class="col-12 table-responsive text-sm">
                        <input type="hidden" name="pid" id="pid" value="<?php echo $row->id ?>">
                        <table id="dtlyBatch" class="table table-striped table-bordered nowrap" style="width:100%;">
                          <thead class="bg-green">
                            <tr>
                              <th width="3%" class="text-center">#</th>
                              <th>Batch Number</th>
                              <th>Qty</th>
                              <th class="text-center">Mfg. Date</th>
                              <th class="text-center">Exp. Date</th>
                              <th class="text-center">Action</th> 
                            </tr>
                          </thead>   
                          <tbody>
                            
                          </tbody>                         
                        </table>
                      </div>
                    </div>
                  </div>
              </div>
              <?php endforeach; ?> <!-- end foreach -->
            <?php else: ?> No records found <?php endif; ?>  
          </div>
          <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->