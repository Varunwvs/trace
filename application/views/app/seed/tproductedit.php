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

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">  
          <div class="col-lg-12">
            <div class="card">                
                <div class="card-block tab-icon">
                    <div class="row"> 
                      <div class="col-12 text-sm">                        
                        <form id="formProduct" method="post" action="SeedController/teditProduct"  enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="">
                                        <label class="form-label">Company Name</label>
                                        <input type="text" class="form-control" name="edit_cname" id="edit_cname" value="<?= $_SESSION['role']==='company' ? htmlentities(ucwords($_SESSION['comname'])) : ''?>" <?= $_SESSION['role']==='company' ? 'readonly' : '' ?> tabindex="<?= $_SESSION['role']==='company' ? '-1' : '' ?>">
                                        <input type="hidden" name="edit_cid" id="edit_cid" value="<?php echo $_SESSION['comid'] ?>">
                                        <input type="hidden" name="edit_pid" id="edit_pid" value="<?php echo $_GET['id'] ?>">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="">
                                        <label class="form-label">Marketed By/RC Holder</label>
                                        <input type="text" class="form-control" id="edit_marketed_by" name="edit_marketed_by" value="<?= $_SESSION['role']==='rcholder' ? htmlentities(ucwords($_SESSION['comname'])) : ''?>" <?= $_SESSION['role']==='rcholder' ? 'readonly' : '' ?> tabindex="<?= $_SESSION['role']==='rcholder' ? '-1' : '' ?>">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-label">Unique Product Code</label>
                                        <div class="input-group">
                                            <input type="number" class="form-control" placeholder="" id="edit_upc" name="edit_p_code" readonly="true">                                            
                                        </div>                                        
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-label">Registration No</label>
                                        <input type="text" class="form-control" name="edit_registration_no" id="edit_registration_no"  placeholder="">
                                    </div>
                                </div>  
                              
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-label">Product Category</label>
                                        <select class="form-control form-select select2" data-bs-placeholder="Select" name="edit_p_category" id="edit_p_category">
                                            <option value="0|Choose one">Choose Category</option>
                                            <?php foreach($itemCat as $row):?>
                                                <option value="<?php echo $row->id.'|'.$row->name;?>"><?php echo ucwords($row->name);?></option>
                                            <?php endforeach;?>                                  
                                        </select>                                     
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-label">Sub Category</label>
                                        <select class="form-control form-select select2" data-bs-placeholder="Select" name="edit_sub_category" id="edit_sub_category">
                                                        <option value="0|Choose one">Choose Sub-Category</option>                                                        
                                                    </select>   
                                    </div>
                                </div>
                              
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-label">Product Name</label>
                                        <input type="text" class="form-control" id="edit_p_name" name="edit_p_name">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-label">Brand Name</label>
                                        <input type="text" class="form-control" id="edit_b_name" name="edit_b_name">
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                              
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-label">Measurement Unit of Weight</label>
                                        <select class="form-control form-select select2" data-bs-placeholder="Select" id="edit_unit_w" name="edit_unit_w">                                    
                                            <option value="0|Choose one">Choose one</option>
                                            <?php foreach($uomid as $urow):?>
                                                <option value="<?php echo $urow->uomid.'|'.$urow->uomname;?>"><?php echo ucwords($urow->uomname);?></option>
                                            <?php endforeach ?> 
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-label">Net Content/Weight per Pack</label>
                                        <input type="number" step="0.01" class="form-control" id="edit_net_w" name="edit_net_w">
                                    </div>
                                </div>   
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-label">Product Leaflet</label>
                                        <input type="text" class="form-control" name="edit_prd_leaflet" id="edit_prd_leaflet" placeholder="Add link here">
                                    </div>
                                </div>       
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-label">Product Video</label>
                                        <input type="text" class="form-control" name="edit_prd_video" id="edit_prd_video" placeholder="Add link here">
                                                
                                    </div>
                                </div>      
                            </div>

                            <div class="row mb-3">

                               

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-label">Usage Instructions</label>
                                        <textarea class="form-control" name="edit_usage_instructions" id="edit_usage_instructions"></textarea>
                                    </div>
                                </div>  

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-label">Description:</label>
                                        <textarea class="form-control" name="edit_prod_description" id="edit_prod_description" placeholder=""></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="edit_onlyprimary" id="edit_onlyprimary">
                                            <label class="form-check-label"><strong>Only Primary Packing? <i class="fa-solid fa-circle-info text-primary" data-bs-toggle="tooltip" title="Select if you print only primary labels for this product and there’s no secondary packing." style="cursor:pointer;"></i></strong></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row hidden">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form-label">Product Link</label>
                                        <input type="text" class="form-control" name="edit_prdlink">
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
                                        <input type="checkbox" id="edit_show_gitag" name="edit_gi_checkbox" style="margin-right: 10px;"> Show GI Tag Information
                                    </label>
                                </div>

                                <div class="col-md-3 p-2">
                                    <label>
                                        <input type="checkbox" id="edit_show_fssai" name="edit_fssai_checkbox" style="margin-right: 10px;"> Show FSSAI Information
                                    </label>
                                </div>

                                <div class="col-md-3 p-2">
                                    <label>
                                        <input type="checkbox" id="edit_show_usfda" name="edit_usfda_checkbox" style="margin-right: 10px;"> Show US FDA Information
                                    </label>
                                </div>
                            </div>


                            <div class="row" style="border-top:1px solid #e6e6e6; border-bottom:1px solid #e6e6e6">
                                <div class="col-md-12 p-2">
                                    <a id="greenlabel" style="cursor: pointer;font-weight: 700;"> 
                                        <i class="fas fa-plus"></i> Add Green Lablel Information <i class="fas fa-caret-down"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="row glabel mt-3">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-label">MRP (Incl.Tax):</label>
                                        <input type="number" class="form-control" name="edit_mrp" id="edit_mrp">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="form-label">Pure Seed (Min):</label>
                                                    <input type="number" class="form-control" name="edit_phypurity" id="edit_phypurity"  placeholder="">
                                                </div>
                                            </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-label">Germination (Min):</label>
                                        <input type="number" class="form-control" name="edit_germination" id="edit_germination">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-label">Gen. Purity (Min):</label>
                                        <input type="number" class="form-control" name="edit_genpur" id="edit_genpur"  placeholder="">
                                    </div>
                                </div>
                               
                            </div>

                            <div class="row glabel">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-label">Moisture (Max):</label>
                                        <input type="number" class="form-control" name="edit_moisture" id="edit_moisture">
                                    </div>
                                </div>
                                
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-label">Inert Matter (Max): </label>
                                        <input type="number" class="form-control" name="edit_inertmatter" id="edit_inertmatter">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-label">Other Crop Seed (Max):</label>
                                        <input type="number" class="form-control" name="edit_othercrop" id="edit_othercrop">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-label">Weed Seed (Max):</label>
                                        <input type="number" class="form-control" name="edit_weedseed" id="edit_weedseed"  placeholder="">
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
                                                    <input type="text" class="form-control" name="edit_blkind" id="edit_blkind"  placeholder="">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="form-label">Variety:</label>
                                                    <input type="text" class="form-control" name="edit_blvariety" id="edit_blvariety"  placeholder="">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="form-label">Class Of Seed:</label>
                                                    <input type="text" class="form-control" name="edit_blseedclass" id="edit_blseedclass"  placeholder="">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="form-label">Upload Signature:</label>
                                                    <input type="file" class="form-control" name="edit_blsign" id="edit_blsign"  placeholder="" accept="image/*">
                                                    <input type="hidden" class="form-control" name="blsign" id="blsign" >
                                          
                                                <div class="blsign-pcontent">
                                                        <!-- The file link will be dynamically updated here -->
                                                    </div>
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
                                                        <input type="text" class="form-control" name="edit_gi_geographical_area" id="edit_gi_geographical_area" placeholder="">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="form-label">Sourcing Geo Latitude:</label>
                                                        <input type="text" class="form-control" name="edit_gi_latitude" id="edit_gi_latitude" placeholder="">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="form-label">Sourcing Geo Longitude:</label>
                                                        <input type="text" class="form-control" name="edit_gi_longitude" id="edit_gi_longitude" placeholder="">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="form-label">Indication of Source/Origin Country:</label>
                                                        <input type="text" class="form-control" name="edit_gi_origin_country" id="edit_gi_origin_country" placeholder="">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="form-label">Source Information:</label>
                                                        <input type="file" class="form-control" name="edit_gi_source_info" id="edit_gi_source_info" accept=".pdf">
                                                        <input type="hidden" class="form-control" name="gi_source_info" id="gi_source_info" >
                                          
                                                    <div class="gi_source_info-pcontent">
                                                            <!-- The file link will be dynamically updated here -->
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="form-label">Authorities/Compliance Certificate:</label>
                                                        <input type="file" class="form-control" name="edit_gi_authorities_certificate" id="edit_gi_authorities_certificate" accept=".pdf">
                                                        <input type="hidden" class="form-control" name="gi_authorities_certificate" id="gi_authorities_certificate" >
                                          
                                                        <div class="gi_authorities_certificate-pcontent">
                                                        <!-- The file link will be dynamically updated here -->
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="form-label">Product Packed Date:</label>
                                                        <div class="input-group date" id="gi_packed_date" data-target-input="nearest">
                                                            <input type="text" class="form-control datetimepicker-input" name="edit_gi_packed_date" id="gi_packed_date" data-target="#gi_packed_date">
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
                                                            <input type="text" class="form-control datetimepicker-input" name="edit_gi_expire_date" id="gi_expire_date" data-target="#gi_expire_date">
                                                            <div class="input-group-append" data-target="#gi_expire_date" data-toggle="datetimepicker">
                                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="form-label">FSSAI License No:</label>
                                                        <input type="text" class="form-control" name="edit_gi_fssai_license_no" id="edit_gi_fssai_license_no">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="form-label">Description:</label>
                                                        <textarea class="form-control" name="edit_gi_description" id="edit_gi_description" placeholder=""></textarea>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="form-label">Product Specifications Difference:</label>
                                                        <textarea class="form-control" name="edit_gi_product_specifications" id="edit_gi_product_specifications" placeholder=""></textarea>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="form-label">Processing Facility Info:</label>
                                                        <textarea class="form-control" name="edit_gi_processing_facility" id="edit_gi_processing_facility" placeholder=""></textarea>
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
                                                        <input type="text" class="form-control" name="edit_fs_license_no" id="edit_fs_license_no">
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="form-label">Ingredients:</label>
                                                        <input type="file" class="form-control" name="edit_fs_ingredients" id="edit_fs_ingredients" accept=".pdf">
                                                        <input type="hidden" class="form-control" name="fs_ingredients" id="fs_ingredients" >
                                          
                                                        <div class="fs_ingredients-pcontent">
                                                        <!-- The file link will be dynamically updated here -->
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="form-label">Nutritional Info:</label>
                                                        <input type="file" class="form-control" name="edit_fs_nutri_info" id="edit_fs_nutri_info" accept=".pdf">
                                                        <input type="hidden" class="form-control" name="fs_nutri_info" id="fs_nutri_info" >
                                          
                                                        <div class="fs_nutri_info-pcontent">
                                                        <!-- The file link will be dynamically updated here -->
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="form-label">Allergens:</label>
                                                        <input type="text" class="form-control" name="edit_fs_allergens" id="edit_fs_allergens">
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="form-label">Allergen Warning:</label>
                                                        <input type="text" class="form-control" name="edit_fs_allergen_warning" id="edit_fs_allergen_warning">
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
                                                        <input type="text" class="form-control" name="edit_us_fda_no" id="edit_us_fda_no">
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="form-label">Ingredients:</label>
                                                        <input type="file" class="form-control" name="edit_us_ingredients" id="edit_us_ingredients" accept=".pdf">
                                                        <input type="hidden" class="form-control" name="us_ingredients" id="us_ingredients" >
                                          
                                                        <div class="us_ingredients-pcontent">
                                                        <!-- The file link will be dynamically updated here -->
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="form-label">Nutritional Info:</label>
                                                        <input type="file" class="form-control" name="edit_us_nutri_info" id="edit_us_nutri_info" accept=".pdf">
                                                        <input type="hidden" class="form-control" name="us_nutri_info" id="us_nutri_info" >
                                          
                                                        <div class="us_nutri_info-pcontent">
                                                        <!-- The file link will be dynamically updated here -->
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="form-label">Allergens:</label>
                                                        <input type="text" class="form-control" name="edit_us_allergens" id="edit_us_allergens">
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="form-label">Allergen Warning:</label>
                                                        <input type="text" class="form-control" name="edit_us_allergen_warning" id="edit_us_allergen_warning">
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="form-label">Storage Instructions:</label>
                                                        <textarea class="form-control" name="edit_us_storage_info" id="edit_us_storage_info" placeholder=""></textarea>
                                                    </div>
                                                </div>
                                                
                                                
                                            </div>
                                            

                            <div class="row mb-3">
                                <div class="col-md-12 text-right">
                                    <input type="submit" class="btn btn-primary btn-md" name="submit" id="submit" value="submit">
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