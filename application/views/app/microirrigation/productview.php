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
                    <li class="breadcrumb-item"><a href="midashboard">Home</a></li>
                    <li class="breadcrumb-item active"><?php echo $title ?></li>
                    <?php else: ?>
                    <li class="breadcrumb-item"><a href="midashboard" tabindex="-1">Home</a></li>
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
    subcategoryid, subcategory, p_code, itemid, p_name, b_name, unit_w, uomid, net_w, cml, cmlbis, licno, status, api_sent, 
    api_response, onlyprimary')->from('microirrigationproduct')->where(array('id'=>$id, 'c_id'=>$cid))->get();
    $count = $query->num_rows(); 
?>
<!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">  
          <div class="col-lg-12">
            <?php if($count != 0): ?>
              <?php foreach($query->result() as $row): ?>
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
                        <a class="mr-3 text-white" role="button" href="miproductedit?id=<?php echo $row->id ?>"><i class="fa-solid fa-edit"></i> Edit Product Info</a>                        
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
                                    <label class="form-label col-6 bg-sky p-2">CML</label>
                                    <label class="form-label col-6 p-2 text-primary"><?php echo strtoupper($row->cml) ?></label>
                                </div>
                                <div class="row">
                                    <label class="form-label col-6 bg-sky p-2">CM L BIS No.</label>
                                    <label class="form-label col-6 p-2 text-primary"><?php echo strtoupper($row->cmlbis) ?></label>
                                </div>
                                <div class="row hidden">
                                    <label class="form-label col-6 bg-sky p-2">Licence No.</label>
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
                                <?php if($row->net_w !='' || $row->net_w!='0'): ?>
                                <div class="row">
                                    <label class="form-label col-6 bg-sky p-2">Length per bundle</label>
                                    <label class="form-label col-6 p-2 text-primary"><?php echo $row->net_w ?></label>
                                </div>
                                <?php else: ?>
                                <?php endif ?>
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
                    <div class="card-header-right">
                        <?php $adminrole = $_SESSION['role']; ?>
                        <?php $center=substr($adminrole, 0, -6).'center';?>
                        <?php $admin=substr($adminrole, 0, -6).'admin';?>
                        <?php
                            $result = $this->db->select('qr_quantity')->from('users')->where('role', $admin)->get(); 
                            foreach($result->result() as $qrow){
                                $qr_quantity = $qrow->qr_quantity;
                            }
                            if($_SESSION['role']===$center){
                            $pdcount = $this->db->select('count(*) as pcount')->from('microirrigationbatchserial')
                            ->where( array('cid'=>$_SESSION['comid']) )->get();
                                foreach($pdcount->result() as $pcrow){
                                    $pcount = $pcrow->pcount;
                                }
                                if($pcount===$qr_quantity){
                                    echo '<a class="text-white" href="https://wa.me/918762807087/"><i class="fa-regular fa-circle-up"></i> Please upgrade plan</a>';
                                }else{
                                    if($row->api_sent !=1){
                                        echo '<p class="text-warning">Please send the product details using API to agriculture department then create the batches</p>';
                                    }else{
                                        echo '<a class="mr-3 text-white" role="button" href="mibatchentry?id='.$row->id.'&upc='.$row->p_code.'&nw='.$row->net_w.'"><i class="fa-solid fa-plus"></i> Add New Batches</a>';
                                    }
                                }
                            }else{
                                if($pcount===$_SESSION['comtotqr']){
                                    echo '<a class="text-white" href="https://wa.me/918762807087/"><i class="fa-regular fa-circle-up"></i> Please upgrade plan</a>';
                                }else{
                                    if($row->api_sent !=1){
                                        echo '<p class="text-warning">Please send the product details using API to agriculture department then create the batches</p>';
                                    }else{
                                        echo '<a class="mr-3 text-white" role="button" href="mibatchentry?id='.$row->id.'&upc='.$row->p_code.'&nw='.$row->net_w.'"><i class="fa-solid fa-plus"></i> Add New Batches</a>';
                                    }
                                }
                            } 
                        ?>
                    </div>
                </div>            
                  <div class="card-block tab-icon">
                    <div class="row"> 
                      <div class="col-12 table-responsive text-sm">
                        <input type="hidden" name="pid" id="pid" value="<?php echo $row->id ?>">
                        <table id="dtBatch" class="table table-striped table-bordered nowrap" style="width:100%;">
                          <thead class="bg-green">
                            <tr>
                              <th width="3%" class="text-center">#</th>
                              <th>Serials Created On</th>
                              <th>Serial Qty.</th>
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