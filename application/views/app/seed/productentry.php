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
                                    <form id="formProduct" enctype="multipart/form-data">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="form-label">Manufacturing Company Name</label>
                                                    <input type="text" class="form-control" name="cname" id="cname" value="<?= $_SESSION['role']==='company' ? htmlentities(ucwords($_SESSION['comname'])) : ''?>" <?= $_SESSION['role']==='company' ? 'readonly' : '' ?> tabindex="<?= $_SESSION['role']==='company' ? '-1' : '' ?>">
                                                    <input type="hidden" name="cid" id="cid" value="<?php echo $_SESSION['comid'] ?>">
                                                    <input type="hidden" name="mfg_id" id="mfg_id" value="<?php echo $_SESSION['mfg_id'] ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="form-label">Marketed By/RC Holder</label>
                                                    <input type="text" class="form-control" name="marketed_by" id="marketed_by"  value="<?= $_SESSION['role']==='rcholder' ? htmlentities(ucwords($_SESSION['comname'])) : ''?>" <?= $_SESSION['role']==='rcholder' ? 'readonly' : '' ?> tabindex="<?= $_SESSION['role']==='rcholder' ? '-1' : '' ?>">
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-3">
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
                                                    <label class="form-label">Registration No</label>
                                                    <input type="text" class="form-control" name="registration_no" id="registration_no"  placeholder="">
                                                </div>
                                            </div>  
                                        </div>

                                        <div class="row mb-3">
                                            
                                            <div class="col-md-3">
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
                                            
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="form-label">Sub Category *</label>                                                    
                                                    <select class="form-control form-select select2" data-bs-placeholder="Select" name="sub_category" id="sub_category">
                                                        <option value="0|Choose one">Choose Sub-Category</option>                                                        
                                                    </select>   
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
                                            <div class="col-md-3">
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
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="form-label">Brand Name</label>
                                                    <input type="text" class="form-control" name="b_name" id="b_name"  placeholder="">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="form-label">Unit of Measurement *</label>
                                                    <input type="hidden" class="form-control text-capitalize" name="uomid" id="uomid" readonly="true" tabindex="-1">
                                                    <input type="text" class="form-control text-capitalize" name="unit_w" id="unit_w" readonly="true" tabindex="-1" placeholder="">
                                                    <input type="hidden" class="form-control text-capitalize" name="uomw" id="uomw" readonly="true" tabindex="-1">                                                    
                                                </div>
                                            </div>
                                            <div class="col-md-3" id="uomdiv">
                                                <div class="form-group">
                                                    <label class="form-label">Net Content/Weight per Pack</label>
                                                    <input type="number" step="0.01" class="form-control" name="net_w" id="net_w"  placeholder="" readonly="true" tabindex="-1">
                                                </div>
                                            </div> 
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="form-label">Product Leaflet</label>
                                                    <input type="text" class="form-control" name="prd_leaflet" id="prd_leaflet" placeholder="Add link here">
                                                </div>
                                            </div>
                                                         
                                        </div>

                                        <div class="row mb-3">

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="form-label">Product Video</label>
                                                    <input type="text" class="form-control" name="prd_video" id="prd_video" placeholder="Add link here">
                                                   
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="form-label">Usage Instructions</label>
                                                    <textarea class="form-control" name="usage_instructions" id="usage_instructions"></textarea>
                                                </div>
                                            </div>  

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="form-label">Description:</label>
                                                    <textarea class="form-control" name="prod_description" id="prod_description" placeholder=""></textarea>
                                                </div>
                                            </div>
                                        </div>
                                       
                                        
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="onlyprimary" id="onlyprimary" checked>
                                                        <label class="form-check-label" ><strong>Only Primary Packing? <i class="fa-solid fa-circle-info text-primary" data-bs-toggle="tooltip" title="Select if you print only primary labels for this product and there’s no secondary packing." style="cursor:pointer;"></i></strong></label>
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

                                        

                                        <div class="row mt-3 mb-3">
                                            <div class="col-md-3 p-2">
                                                <label>
                                                    <input type="checkbox" id="" name="" style="margin-right: 10px;"> Show Green Choice Information
                                                </label>
                                            </div>
                                            <div class="col-md-3 p-2">
                                                <label>
                                                    <input type="checkbox" id="show_gitag" name="gi_checkbox" style="margin-right: 10px;"> Show GI Tag Information
                                                </label>
                                            </div>

                                            <div class="col-md-3 p-2">
                                                <label>
                                                    <input type="checkbox" id="show_fssai" name="fssai_checkbox" style="margin-right: 10px;"> Show FSSAI Information
                                                </label>
                                            </div>

                                            <div class="col-md-3 p-2">
                                                <label>
                                                    <input type="checkbox" id="show_usfda" name="usfda_checkbox" style="margin-right: 10px;"> Show US FDA Information
                                                </label>
                                            </div>
                                        </div>

                                        <div class="row" style="border-top:1px solid #e6e6e6; border-bottom:1px solid #e6e6e6">
                                            <div class="col-md-12 p-2">
                                                <a id="greenlabel" style="cursor: pointer;font-weight: 700;"> 
                                                    <i class="fas fa-plus"></i> Green Label Information <i class="fas fa-caret-down"></i>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="row glabel mt-3 hidden" s>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="form-label">MRP (Incl.Tax):</label>
                                                    <input type="number" class="form-control" name="mrp" id="mrp"  placeholder="">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="form-label">Pure Seed (Min):</label>
                                                    <input type="number" class="form-control" name="phypurity" id="phypurity"  placeholder="">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="form-label">Germination (Min):</label>
                                                    <input type="number" class="form-control" name="germination" id="germination"  placeholder="">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="form-label">Gen. Purity (Min):</label>
                                                    <input type="number" class="form-control" name="genpur" id="genpur"  placeholder="">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row glabel hidden">
                                            
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="form-label">Moisture (Max):</label>
                                                    <input type="number" class="form-control" name="moisture" id="moisture"  placeholder="">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="form-label">Inert Matter (Max): </label>
                                                    <input type="number" class="form-control" name="inertmatter" id="inertmatter"  placeholder="">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="form-label">Other Crop Seed (Max):</label>
                                                    <input type="number" class="form-control" name="othercrop" id="othercrop"  placeholder="">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="form-label">Weed Seed (Max):</label>
                                                    <input type="number" class="form-control" name="weedseed" id="weedseed"  placeholder="">
                                                </div>
                                            </div>
                                        </div>
                                      
                                        <div class="row mt-3 mb-3" style="border-top:1px solid #e6e6e6; border-bottom:1px solid #e6e6e6">
                                            <div class="col-md-12 p-2">
                                                <a id="bluelabel" style="cursor: pointer;font-weight: 700;"> 
                                                    <i class="fas fa-plus"></i> Blue Label Information <i class="fas fa-caret-down"></i>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="row blabel hidden">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="form-label">Kind:</label>
                                                    <input type="text" class="form-control" name="blkind" id="blkind"  placeholder="">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="form-label">Variety:</label>
                                                    <input type="text" class="form-control" name="blvariety" id="blvariety"  placeholder="">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="form-label">Class Of Seed:</label>
                                                    <input type="text" class="form-control" name="blseedclass" id="blseedclass"  placeholder="">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="form-label">Upload Signature:</label>
                                                    <input type="file" class="form-control" name="blsign" id="blsign"  placeholder="" accept="image/*">
                                                </div>
                                            </div>  
                                        </div>
                                       

                                        <!-- GI Tag Section -->
                                            
                                            <div class="row mt-3 mb-3 gitag_toggle_row hidden" style="border-top:1px solid #e6e6e6; border-bottom:1px solid #e6e6e6">
                                                <div class="col-md-12 p-2">
                                                    <a id="gitag_toggle" style="cursor: pointer; font-weight: 700;">
                                                        <i class="fas fa-plus"></i> GI Tag Information <i class="fas fa-caret-down"></i>
                                                    </a>
                                                </div>
                                            </div>

                                            <div class="row gitag_content hidden">
                                               
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="form-label">Geographical Area:</label>
                                                        <input type="text" class="form-control" name="gi_geographical_area" id="gi_geographical_area" placeholder="">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="form-label">Sourcing Geo Latitude:</label>
                                                        <input type="text" class="form-control" name="gi_latitude" id="gi_latitude" placeholder="">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="form-label">Sourcing Geo Longitude:</label>
                                                        <input type="text" class="form-control" name="gi_longitude" id="gi_longitude" placeholder="">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="form-label">Indication of Source/Origin Country:</label>
                                                        <input type="text" class="form-control" name="gi_origin_country" id="gi_origin_country" placeholder="">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="form-label">Source Information:</label>
                                                        <input type="file" class="form-control" name="gi_source_info" id="gi_source_info" accept=".pdf">
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="form-label">Authorities/Compliance Certificate:</label>
                                                        <input type="file" class="form-control" name="gi_authorities_certificate" id="gi_authorities_certificate" accept=".pdf">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="form-label">Product Packed Date:</label>
                                                        <div class="input-group date" id="gi_packed_date" data-target-input="nearest">
                                                            <input type="text" class="form-control datetimepicker-input" name="gi_packed_date" id="gi_packed_date" data-target="#gi_packed_date">
                                                            <div class="input-group-append" data-target="#gi_packed_date" data-toggle="datetimepicker">
                                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="form-label">Product Expire Date:</label>
                                                        <div class="input-group date" id="gi_expire_date" data-target-input="nearest">
                                                            <input type="text" class="form-control datetimepicker-input" name="gi_expire_date" id="gi_expire_date" data-target="#gi_expire_date">
                                                            <div class="input-group-append" data-target="#gi_expire_date" data-toggle="datetimepicker">
                                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="form-label">FSSAI License No:</label>
                                                        <input type="text" class="form-control" name="gi_fssai_license_no" id="gi_fssai_license_no">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="form-label">Description:</label>
                                                        <textarea class="form-control" name="gi_description" id="gi_description" placeholder=""></textarea>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="form-label">Product Specifications Difference:</label>
                                                        <textarea class="form-control" name="gi_product_specifications" id="gi_product_specifications" placeholder=""></textarea>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="form-label">Processing Facility Info:</label>
                                                        <textarea class="form-control" name="gi_processing_facility" id="gi_processing_facility" placeholder=""></textarea>
                                                    </div>
                                                </div>
                                                
                                            </div>

                                        <!-- FSSAI Section -->
                                            
                                            <div class="row mt-3 mb-3 fssai_toggle_row hidden" style="border-top:1px solid #e6e6e6; border-bottom:1px solid #e6e6e6">
                                                <div class="col-md-12 p-2">
                                                    <a id="fssai_toggle" style="cursor: pointer; font-weight: 700;">
                                                        <i class="fas fa-plus"></i> FSSAI Information <i class="fas fa-caret-down"></i>
                                                    </a>
                                                </div>
                                            </div>

                                            <div class="row fssai_content hidden">

                                            <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="form-label">FSSAI License No:</label>
                                                        <input type="text" class="form-control" name="fs_license_no" id="fs_license_no">
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="form-label">Ingredients:</label>
                                                        <input type="file" class="form-control" name="fs_ingredients" id="fs_ingredients" accept=".pdf">
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="form-label">Nutritional Info:</label>
                                                        <input type="file" class="form-control" name="fs_nutri_info" id="fs_nutri_info" accept=".pdf">
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="form-label">Allergens:</label>
                                                        <input type="text" class="form-control" name="fs_allergens" id="fs_allergens">
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="form-label">Allergen Warning:</label>
                                                        <input type="text" class="form-control" name="fs_allergen_warning" id="fs_allergen_warning">
                                                    </div>
                                                </div>
                                               
                                                
                                                
                                            </div>

                                            

                                        <!-- US FDA Section -->
                                            
                                            <div class="row mt-3 mb-3 usfda_toggle_row hidden" style="border-top:1px solid #e6e6e6; border-bottom:1px solid #e6e6e6">
                                                <div class="col-md-12 p-2">
                                                    <a id="usfda_toggle" style="cursor: pointer; font-weight: 700;">
                                                        <i class="fas fa-plus"></i> US FDA Information <i class="fas fa-caret-down"></i>
                                                    </a>
                                                </div>
                                            </div>

                                            <div class="row usfda_content hidden">
                                            <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="form-label">FDA Approval No:</label>
                                                        <input type="text" class="form-control" name="us_fda_no" id="fs_license_no">
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="form-label">Ingredients:</label>
                                                        <input type="file" class="form-control" name="us_ingredients" id="us_ingredients" accept=".pdf">
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="form-label">Nutritional Info:</label>
                                                        <input type="file" class="form-control" name="us_nutri_info" id="us_nutri_info" accept=".pdf">
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="form-label">Allergens:</label>
                                                        <input type="text" class="form-control" name="us_allergens" id="us_allergens">
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="form-label">Allergen Warning:</label>
                                                        <input type="text" class="form-control" name="us_allergen_warning" id="us_allergen_warning">
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="form-label">Storage Instructions:</label>
                                                        <textarea class="form-control" name="us_storage_info" id="us_storage_info" placeholder=""></textarea>
                                                    </div>
                                                </div>
                                                
                                                
                                            </div>
                                            


                                        
                                        <div class="row mb-3 mt-3">
                                            <div class="col-md-12 text-right">
                                            <input type="submit" class="btn btn-primary btn-md" name="submitprd" id="submitprd" value="Submit">
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