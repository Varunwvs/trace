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
    <style type="text/css">
        #loader {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            width: 100%;
            background: rgba(0,0,0,0.75) url(<?php echo base_url('assets/images/loading2.gif')?>) no-repeat center center;
            z-index: 10000;
        }
    </style>
    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">  
                <div class="col-lg-12">
                    <div class="card">                
                        <div class="card-block tab-icon">
                            <div class="row"> 
                                <div class="col-12 text-sm">
                                    <form id="formProduct" method="post" action="PesticideController/addPProduct">
                                        <div class="row mb-3 mt-1">
                                            <p style="background: #d1d1d13b;padding: 9px;border-radius: 5px;">Fields mark with asterix (*) are required fileds.</p>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="form-label">Company Name *</label>
                                                    <input type="text" class="form-control" name="cname" id="cname" value="<?= $_SESSION['role']==='company' ? htmlentities(ucwords($_SESSION['comname'])) : ''?>" <?= $_SESSION['role']==='company' ? 'readonly' : '' ?> tabindex="<?= $_SESSION['role']==='company' ? '-1' : '' ?>">
                                                    <input type="hidden" name="cid" id="cid" value="<?php echo $_SESSION['comid'] ?>">
                                                    <input type="hidden" name="appid" id="appid" value="PS">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="form-label">Marketed By/RC Holder *</label>
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
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="form-label">Sub Category *</label>                                                    
                                                    <select class="form-control form-select select2" data-bs-placeholder="Select" name="sub_category" id="sub_category">
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
                                                        <input type="number" class="form-control" placeholder="" id="upc" name="p_code" aria-describedby="button-addon1" readonly="true" tabindex="-1">
                                                        <button class="btn btn-warning" type="button" id="btnClick" data-bs-placement="top" data-bs-toggle="tooltip" title="Enter your GS1 GTIN as UPC. If you’ve not applied for GS1 GTIN, then only click on generate UPC.">Autogenerate</button>
                                                    </div>                                        
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="form-label">Product Name *</label>
                                                    <select class="form-control form-select select2" data-bs-placeholder="Select" name="p_name" id="p_name">
                                                        <option value="0|Choose one">Choose Product</option>                                                                                         
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="form-label">Brand Name *</label>
                                                    <input type="text" class="form-control" name="b_name" id="b_name" placeholder="Brand Name">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="form-label">Measurement Unit of Weight *</label>
                                                    <input type="hidden" class="form-control text-capitalize" name="uomid" id="uomid" readonly="true" tabindex="-1">
                                                    <input type="text" class="form-control text-capitalize" name="unit_w" id="unit_w" readonly="true" tabindex="-1">
                                                    <input type="hidden" class="form-control text-capitalize" name="uomw" id="uomw" readonly="true" tabindex="-1">
                                                    <!-- <select class="form-control form-select select2" data-bs-placeholder="Select" name="unit_w" id="unit_w" readonly="true" tabindex="-1">
                                                        <option value="0|Choose one">Choose one</option>  
                                                    </select> -->
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="form-label">Net Content/Weight per Pack *</label>
                                                    <!-- <input type="number" step="0.01" class="form-control" name="net_w" id="net_w"  placeholder="Net Content/Weight per Pack" readonly="true" tabindex="-1"> -->
                                                    <select class="form-control form-select select2" data-bs-placeholder="Select" name="net_w" id="net_w">
                                                        
                                                    </select>
                                                </div>
                                            </div>                
                                        </div>
                                        
                                         <div class="row mb-3">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="form-label">Formulation</label>
                                                    <input type="text" class="form-control" name="formulation" id="formulation" placeholder="Formulation">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="form-label">C.I.B & RC Reg. No.</label>
                                                    <input type="text" class="form-control" name="cibno" id="cibno" placeholder="C.I.B & RC Reg. No.">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="form-label">Mfg. Licence No.</label>
                                                    <input type="text" class="form-control" name="mlno" id="mlno" placeholder="Mfg. Licence No.">
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-md-12">
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

                                        <div class="row" style="border-top:1px solid #e6e6e6; border-bottom:1px solid #e6e6e6">
                                            <div class="col-md-12 p-2">
                                                <a id="greenlabel" style="cursor: pointer;font-weight: 700;"> 
                                                    <i class="fas fa-plus"></i> Add Additional Information <i class="fas fa-caret-down"></i>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="row glabel mt-3 hidden">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="form-label">Chemical Composition:</label>
                                                    <textarea class="form-control" name="chemcom" id="chemcom" cols="30" rows="5"></textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="form-label">Antidote Statement:</label>
                                                    <textarea class="form-control" name="antst" id="antst" cols="30" rows="5"></textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="form-label">Direction of Use:</label>
                                                    <textarea class="form-control" name="dou" id="dou" cols="30" rows="5"></textarea>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row glabel hidden">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="form-label">Recommendations:</label>
                                                    <textarea class="form-control" name="recom" id="recom" cols="30" rows="5"></textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="form-label">Warning Statement: </label>
                                                    <textarea class="form-control" name="warst" id="warst" cols="30" rows="5"></textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="form-label">Precautions:</label>
                                                    <textarea class="form-control" name="prec" id="prec" cols="30" rows="5"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row glabel hidden">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="form-label">Standard Instructions:</label>
                                                    <textarea class="form-control" name="stdins" id="stdins" cols="30" rows="5"></textarea>
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
        <div id="loader"></div>
    </div>
    <!-- /.content -->