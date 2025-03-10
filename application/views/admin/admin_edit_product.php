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
                        <form id="formProduct" method="post" action="AdminController/editProduct">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="">
                                        <label class="form-label">Company Name</label>
                                        <input type="text" class="form-control" name="edit_cname" id="edit_cname">
                                        <input type="hidden" name="edit_pid" id="edit_pid" value="<?php echo $_GET['id'] ?>">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="">
                                        <label class="form-label">Marketed By/RC Holder</label>
                                        <input type="text" class="form-control" id="edit_marketed_by" name="edit_marketed_by">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">Product Category</label>
                                        <input type="text" class="form-control" id="edit_p_category" name="edit_p_category">                                        
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">Sub Category</label>
                                        <input type="text" class="form-control" id="edit_sub_category" name="edit_sub_category">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">Unique Product Code</label>
                                        <div class="input-group">
                                            <input type="number" class="form-control" placeholder="" id="edit_upc" name="edit_p_code" readonly="true">                                            
                                        </div>                                        
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">Product Name</label>
                                        <input type="text" class="form-control" id="edit_p_name" name="edit_p_name">
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">Brand Name</label>
                                        <input type="text" class="form-control" id="edit_b_name" name="edit_b_name">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">Measurement Unit of Weight</label>
                                        <select class="form-control form-select select2" data-bs-placeholder="Select" id="edit_unit_w" name="edit_unit_w">                                    
                                            <option value="0|Choose one">Choose one</option>
                                            <?php foreach($uomid as $urow):?>
                                                <option value="<?php echo $urow->uomid.'|'.$urow->slug;?>"><?php echo ucwords($urow->uomname);?></option>
                                            <?php endforeach ?> 
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">Net Content/Weight per Pack</label>
                                        <input type="number" step="0.01" class="form-control" id="edit_net_w" name="edit_net_w">
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
                                        <input type="number" class="form-control" name="edit_mrp" id="edit_mrp">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">Germination (Min):</label>
                                        <input type="number" class="form-control" name="edit_germination" id="edit_germination">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">Physical Purity (Min):</label>
                                        <input type="number" class="form-control" name="edit_phypurity" id="edit_phypurity">
                                    </div>
                                </div>
                            </div>

                            <div class="row glabel hidden">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">Moisture (Max):</label>
                                        <input type="number" class="form-control" name="edit_moisture" id="edit_moisture">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">Inert Matter (Max): </label>
                                        <input type="number" class="form-control" name="edit_inertmatter" id="edit_inertmatter">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">Other Crop Seed (Max):</label>
                                        <input type="number" class="form-control" name="edit_othercrop" id="edit_othercrop">
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