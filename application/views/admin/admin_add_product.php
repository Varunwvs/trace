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
                <div class="card-block tab-icon">
                    <div class="row"> 
                      <div class="col-12 text-sm">
                        <form id="formProduct" method="post" action="AdminController/addProduct">
                            <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="form-label">Company Name</label>
                                                    <input type="text" class="form-control" name="cname" id="cname" value="<?= $_SESSION['role']==='company' ? htmlentities(ucwords($_SESSION['comname'])) : ''?>" <?= $_SESSION['role']==='company' ? 'readonly' : '' ?> tabindex="<?= $_SESSION['role']==='company' ? '-1' : '' ?>">
                                                    <input type="hidden" name="cid" id="cid" value="<?php echo $_SESSION['comid'] ?>">
                                                    <input type="hidden" name="mfg_id" id="mfg_id" value="<?php echo $_SESSION['mfg_id'] ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="form-label">Marketed By/RC Holder</label>
                                                    <input type="text" class="form-control" name="marketed_by" id="marketed_by"  value="<?= $_SESSION['role']==='rcholder' ? htmlentities(ucwords($_SESSION['comname'])) : ''?>" <?= $_SESSION['role']==='rcholder' ? 'readonly' : '' ?> tabindex="<?= $_SESSION['role']==='rcholder' ? '-1' : '' ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="form-label">Product Category *</label>                                                    
                                                    <select class="form-control form-select select2" data-bs-placeholder="Select" name="p_category" id="p_category">
                                                        <option value="0|Choose one">Choose Category</option>
                                                        <?php foreach($itemCat as $row):?>
                                                            <option value="<?php echo $row->itemcategoryid.'|'.$row->itemcategoryname;?>"><?php echo ucwords($row->itemcategoryname);?></option>
                                                        <?php endforeach;?>                                  
                                                    </select>                                       
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="form-label">Sub Category *</label>                                                    
                                                    <select class="form-control form-select select2" data-bs-placeholder="Select" name="sub_category" id="sub_category">
                                                        <option value="0|Choose one">Choose Sub-Category</option>                                                        
                                                    </select>   
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="form-label">Unique Product Code
                                                        <span class="help-tip" data-bs-placement="top" data-bs-toggle="tooltip" title="Enter your GS1 GTIN as UPC. If you’ve not applied for GS1 GTIN, then only click on generate UPC.">
                                                        </span>
                                                    </label>
                                                    <div class="input-group">
                                                        <input type="number" class="form-control" placeholder="" id="upc" name="p_code" aria-describedby="button-addon1" readonly="true">
                                                        <button class="btn btn-warning" type="button" id="btnClick" data-bs-placement="top" data-bs-toggle="tooltip" title="Enter your GS1 GTIN as UPC. If you’ve not applied for GS1 GTIN, then only click on generate UPC.">Autogenerate</button>
                                                    </div>                                        
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="form-label">Product Name *</label>
                                                    <select class="form-control form-select select2" data-bs-placeholder="Select" name="p_name" id="p_name">
                                                        <option value="0|Choose one">Choose Product</option>                                                                                         
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label class="form-label">Product Class *</label>
                                                    <select class="form-control form-select select2" data-bs-placeholder="Select" name="pc_name" id="pc_name">
                                                        <option value="0|Choose once">Choose Class</option>      
                                                        <?php foreach($seedc as $row):?>
                                                            <option value="<?php echo $row->id.'|'.$row->scname;?>"><?php echo strtoupper($row->scname);?></option>
                                                        <?php endforeach;?>                                                                                    
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="form-label">Brand Name</label>
                                                    <input type="text" class="form-control" name="b_name" id="b_name"  placeholder="Brand Name">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="form-label">Unit of Measurement *</label>
                                                    <input type="hidden" class="form-control text-capitalize" name="uomid" id="uomid" readonly="true" tabindex="-1">
                                                    <input type="text" class="form-control text-capitalize" name="unit_w" id="unit_w" readonly="true" tabindex="-1" placeholder="Unit of Measurements">
                                                    <input type="hidden" class="form-control text-capitalize" name="uomw" id="uomw" readonly="true" tabindex="-1">                                                    
                                                </div>
                                            </div>
                                            <div class="col-md-4" id="uomdiv">
                                                <div class="form-group">
                                                    <label class="form-label">Net Content/Weight per Pack</label>
                                                    <input type="number" step="0.01" class="form-control" name="net_w" id="net_w"  placeholder="Net Content/Weight per Pack" readonly="true" tabindex="-1">
                                                </div>
                                            </div>                
                                        </div>
                            
                            <div class="row hidden">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="onlyprimary" id="onlyprimary" checked>
                                            <label class="form-check-label"><strong>Only Primary Packing? <i class="fa-solid fa-circle-info text-primary" data-bs-toggle="tooltip" title="Select if you print only primary labels for this product and there’s no secondary packing." style="cursor:pointer;"></i></strong></label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row hidden">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form-label">Product Link</label>
                                        <input type="text" class="form-control" name="prdlink"  placeholder="Product Link">
                                    </div>
                                </div>
                            </div>

                            <div class="row hidden" style="border-top:1px solid #e6e6e6; border-bottom:1px solid #e6e6e6">
                                <div class="col-md-12 p-2">
                                    <a id="greenlabel" style="cursor: pointer;font-weight: 700;"> 
                                        <i class="fas fa-plus"></i> Add Green Lablel Information <i class="fas fa-caret-down"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="row glabel mt-3 hidden">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">MRP (Incl.Tax):</label>
                                        <input type="number" class="form-control" name="mrp" id="mrp"  placeholder="MRP (Incl.Tax)">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">Germination (Min):</label>
                                        <input type="number" class="form-control" name="germination" id="germination"  placeholder="Germination (Min)">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">Physical Purity (Min):</label>
                                        <input type="number" class="form-control" name="phypurity" id="phypurity"  placeholder="Physical Purity (Min)">
                                    </div>
                                </div>
                            </div>

                            <div class="row glabel hidden">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">Moisture (Max):</label>
                                        <input type="number" class="form-control" name="moisture" id="moisture"  placeholder="Moisture (Max)">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">Inert Matter (Max): </label>
                                        <input type="number" class="form-control" name="inertmatter" id="inertmatter"  placeholder="Inert Matter (Max)">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">Other Crop Seed (Max):</label>
                                        <input type="number" class="form-control" name="othercrop" id="othercrop"  placeholder="Other Crop Seed (Max)">
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