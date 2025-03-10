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
                    <li class="breadcrumb-item"><a href="psdashboard">Home</a></li>
                    <li class="breadcrumb-item active"><?php echo $title ?></li>
                    <?php else: ?>
                    <li class="breadcrumb-item"><a href="psdashboard" tabindex="-1">Home</a></li>
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
                        <form id="formProduct" method="post" action="PesticideController/editProduct">
                            <div class="row mb-3 mt-1">
                                <p style="background: #d1d1d13b;padding: 9px;border-radius: 5px;">Fields mark with asterix (*) are required fileds.</p>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">Company Name *</label>
                                        <input type="text" class="form-control" name="edit_cname" id="edit_cname" value="<?= $_SESSION['role']==='company' ? htmlentities(ucwords($_SESSION['comname'])) : ''?>" <?= $_SESSION['role']==='company' ? 'readonly' : '' ?> tabindex="<?= $_SESSION['role']==='company' ? '-1' : '' ?>">
                                        <input type="hidden" name="edit_cid" id="edit_cid" value="<?php echo $_SESSION['comid'] ?>">
                                        <input type="hidden" name="edit_appid" id="edit_appid" value="fl">
                                        <input type="hidden" name="edit_pid" id="edit_pid" value="<?php echo $_GET['id'] ?>">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">Marketed By/RC Holder *</label>
                                        <input type="text" class="form-control" name="edit_marketed_by" id="edit_marketed_by"  value="<?= $_SESSION['role']==='rcholder' ? htmlentities(ucwords($_SESSION['comname'])) : ''?>" <?= $_SESSION['role']==='rcholder' ? 'readonly' : '' ?> tabindex="<?= $_SESSION['role']==='rcholder' ? '-1' : '' ?>">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">Product Category *</label>                                                    
                                        <select class="form-control form-select select2" data-bs-placeholder="Select" name="edit_p_category" id="edit_p_category">
                                            <option value="0|Choose one">Choose Category</option>
                                            <?php foreach($itemCat as $row):?>
                                                <option value="<?php echo $row->itemcategoryid.'|'.$row->itemcategoryname;?>"><?php echo ucwords($row->itemcategoryname);?></option>
                                            <?php endforeach;?>                                  
                                        </select>                                       
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">Sub Category *</label>                                                    
                                        <select class="form-control form-select select2" data-bs-placeholder="Select" name="edit_sub_category" id="edit_sub_category">
                                            <option value="0|Choose one">Choose Sub-Category</option>
                                            
                                        </select>   
                                    </div>
                                </div>
                                <div class="col-md-4">                                                
                                    <div class="form-group">
                                        <label class="form-label">Unique Product Code *
                                            <span class="help-tip" data-bs-placement="top" data-bs-toggle="tooltip" title="Enter your GS1 GTIN as UPC. If you’ve not applied for GS1 GTIN, then only click on generate UPC.">
                                            </span>
                                        </label>
                                        <div class="input-group">
                                            <input type="number" class="form-control" placeholder="" id="edit_upc" name="edit_p_code" aria-describedby="button-addon1" readonly="true" tabindex="-1">                                            
                                        </div>                                        
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">Product Name *</label>
                                        <select class="form-control form-select select2" data-bs-placeholder="Select" name="edit_p_name" id="edit_p_name">
                                            <!--<option value="0|Choose one">Choose Product</option>                                                                                         -->
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">Brand Name *</label>
                                        <input type="text" class="form-control" name="edit_b_name" id="edit_b_name" placeholder="Brand Name">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">Measurement Unit of Weight *</label>
                                        <select class="form-control form-select select2" data-bs-placeholder="Select" name="edit_unit_w" id="edit_unit_w" readonly="true" tabindex="-1">
                                            <option value="0|Choose one">Choose one</option>  
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">Net Content/Weight per Pack *</label>
                                        <input type="number" step="0.01" class="form-control" name="edit_net_w" id="edit_net_w"  placeholder="Net Content/Weight per Pack" readonly="true" tabindex="-1">
                                    </div>
                                </div>                
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">Formulation</label>
                                        <input type="text" class="form-control" name="edit_formulation" id="edit_formulation">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">C.I.B & RC Reg. No.</label>
                                        <input type="text" class="form-control" name="edit_cibno" id="edit_cibno">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">Mfg. Licence No.</label>
                                        <input type="text" class="form-control" name="edit_mlno" id="edit_mlno">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="edit_onlyprimary" id="edit_onlyprimary">
                                            <label class="form-check-label" ><strong>Only Primary Packing? <i class="fa-solid fa-circle-info text-primary" data-bs-toggle="tooltip" title="Select if you print only primary labels for this product and there’s no secondary packing." style="cursor:pointer;"></i></strong></label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3 mt-3">
                                <div class="col-md-12 text-right">
                                <input type="submit" class="btn btn-primary btn-md" name="submit" id="submit" value="Submit">
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
    </div>
    <!-- /.content -->