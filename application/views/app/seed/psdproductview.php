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
    subcategoryid, subcategory, p_code, itemid, p_name, b_name, unit_w, uomid, net_w, formulation, cibno, mlno, status, api_sent, 
    api_response, onlyprimary')->from('pesticideproduct')->where(array('id'=>$id, 'c_id'=>$cid))->get();
    $count = $query->num_rows(); 
?>
<!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">  
          <div class="col-lg-12">
            
              <div class="card">    
                <div class="card-header bg-primary" id="dttable">
                    <h5 id="prddtls" style="cursor: pointer;">Sunflower Seeds <i class="fa-solid fa-caret-down"></i>
                        <sup><small><span class="right badge badge-success">Primary</span></small></sup>
                    </h5>           
                    <!-- <div class="card-header-right">
                      <?php if($row->api_sent!='1'): ?>
                        <a class="mr-3 text-white" role="button" href="psproductedit?id=<?php echo $row->id ?>"><i class="fa-solid fa-edit"></i> Edit Product Info</a>                        
                      <?php endif ?>
                    </div> -->
                </div>            
                  <div class="card-block tab-icon hidden">
                      <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <label class="form-label col-6 bg-sky p-2">Company Name</label>
                                    <label class="form-label col-6 p-2 text-primary">Pstest</label>
                                </div>
                                <div class="row">
                                    <label class="form-label col-6 bg-sky p-2">MKT BY</label>
                                    <label class="form-label col-6 p-2 text-primary">Pstest</label>
                                </div>
                                <div class="row">
                                    <label class="form-label col-6 bg-sky p-2">Category</label>
                                    <label class="form-label col-6 p-2 text-primary">Sowing Seeds</label>
                                </div>
                                <div class="row">
                                    <label class="form-label col-6 bg-sky p-2">Sub Category</label>
                                    <label class="form-label col-6 p-2 text-primary">Truthfull Seeds</label>
                                </div>
                                <div class="row">
                                    <label class="form-label col-6 bg-sky p-2">Formulation</label>
                                    <label class="form-label col-6 p-2 text-primary"></label>
                                </div>
                                <div class="row">
                                    <label class="form-label col-6 bg-sky p-2">C.I.B & RC Reg. No.</label>
                                    <label class="form-label col-6 p-2 text-primary"></label>
                                </div>
                                <div class="row">
                                    <label class="form-label col-6 bg-sky p-2">Mfg. Licence No.</label>
                                    <label class="form-label col-6 p-2 text-primary"></label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <label class="form-label col-6 bg-sky p-2">UPC</label>
                                    <label class="form-label col-6 p-2 text-primary">SED001</label>
                                </div>
                                <div class="row">
                                    <label class="form-label col-6 bg-sky p-2">Product Name</label>
                                    <label class="form-label col-6 p-2 text-primary">Sunflower Seeds</label>
                                </div>
                                <div class="row">
                                    <label class="form-label col-6 bg-sky p-2">Brand Name</label>
                                    <label class="form-label col-6 p-2 text-primary"></label>
                                </div>
                                <div class="row">
                                    <label class="form-label col-6 bg-sky p-2">Unit of Weight</label>
                                    <label class="form-label col-6 p-2 text-primary">GM</label>
                                </div>
                                <div class="row">
                                    <label class="form-label col-6 bg-sky p-2">Net Content/Weight per Pack</label>
                                    <label class="form-label col-6 p-2 text-primary">100</label>
                                </div>
                            </div>      
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

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">  
          <div class="col-lg-12">
            
              <div class="card">    
                <div class="card-header bg-primary" id="dttable">
                    <h5>Batch Details</h5>                                
                    <div class="card-header-right">
                      <a class="mr-3 text-white" role="button" href="ppsbatchentry?id=1"><i class="fa-solid fa-plus"></i> Add New Batches</a>
                    </div>
                </div>            
                  <div class="card-block tab-icon">
                    <div class="row"> 
                      <div class="col-12 table-responsive text-sm">
                        <input type="hidden" name="pid" id="pid" value="">
                        <table id="dtPBatchs" class="table table-striped table-bordered nowrap" style="width:100%;">
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
                            <tr>
                              <td widtd="3%" class="text-center">1</td>
                              <td>sun001</td>
                              <td>5</td>
                              <td class="text-center">01-09-2023</td>
                              <td class="text-center">01-09-2028</td>
                              <td class="text-center"><ul class="list-inline">  
                <li class="list-inline-item"><a class="btn text-info btn-xs" role="button" href="psdbatchview?id=1" data-toggle="tooltip" title="View Batch Details"> <span class="fa fa-eye"></span></a></li>
                <li class="list-inline-item"><a class="btn text-info btn-xs '.$dis.'" role="button" href="psbatchedit?id=1"> <span class="fa fa-edit" data-toggle="tooltip" title="Edit Batch Info"></span></a></li></ul></td> 
                            </tr>
                          </tbody>                        
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