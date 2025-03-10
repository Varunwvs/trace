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
    <div class="row">  
      <div class="col-lg-12">
        <div class="card">                
          <div class="card-block tab-icon">
            <div class="row"> 
              <div class="col-12 text-sm">                
                <form id="userForm" action="SuperAdminController/updCompany" method="post">
                    <div class="row editModal">
                        <div class="col-6">
                            <div class="input-group mb-3">
                            <input type="hidden" class="form-control" name="edit_cid" id="edit_cid" value="<?php echo $_GET['id'] ?>">    
                            <input type="text" class="form-control" name="edit_cname" id="edit_cname">
                                <div class="input-group-append">
                                <div class="input-group-text bg-gray">
                                    <span class="fas fa-user"></span>
                                </div>
                                </div>
                            </div>
                            <div class="input-group mb-3">
                                <select class="form-control text-grey" id="edit_category" name="edit_category">
                                <option value="0">Select Business Category</option>
                                <?php foreach($category as $rows):?>
                                    <option value="<?php echo $rows->id;?>"><?php echo ucwords($rows->name);?></option>
                                <?php endforeach;?>
                                </select>
                                <div class="input-group-append">
                                <div class="input-group-text bg-gray">
                                    <span class="fas fa-boxes"></span>
                                </div>
                                </div>
                            </div>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" name="edit_contact_person" id="edit_contact_person">
                                <div class="input-group-append">
                                <div class="input-group-text bg-gray">
                                    <span class="fas fa-user"></span>
                                </div>
                                </div>
                            </div>
                            <div class="input-group mb-3">
                                <input type="email" class="form-control" name="edit_email" id="edit_email" data-bs-validate="Valid email is required: ex@abc.xyz">
                                <div class="input-group-append">
                                <div class="input-group-text bg-gray">
                                    <span class="fas fa-envelope"></span>
                                </div>
                                </div>
                            </div>
                            <div class="input-group mb-3">
                                <input type="password" class="form-control" name="edit_password" id="edit_password">
                                <span style="position: absolute;right: 45px;transform: translate(0,-50%);top: 50%;cursor: pointer;z-index: 1000;">
                                    <i class="fa fa-eye toggle-password text-grey" id="eye">
                                    </i>
                                </span>
                                <div class="input-group-append">
                                <div class="input-group-text bg-gray">
                                    <span class="fas fa-lock"></span>
                                </div>
                                </div>
                            </div>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" name="edit_phone" id="edit_phone">
                                <div class="input-group-append">
                                <div class="input-group-text bg-gray">
                                    <span class="fas fa-phone"></span>
                                </div>
                                </div>
                            </div>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" name="edit_gst" id="edit_gst">
                                <div class="input-group-append">
                                <div class="input-group-text bg-gray">
                                    <span class="fas fa-file"></span>
                                </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="input-group mb-3">
                                <select class="form-control text-grey" name="edit_totalproduct" id="edit_totalproduct">
                                <option value="0">Select Total Products</option>
                                <option value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                                </select>
                                <div class="input-group-append">
                                <div class="input-group-text bg-gray">
                                    <span class="fas fa-box"></span>
                                </div>
                                </div>
                            </div>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" name="edit_website" id="edit_website">
                                <div class="input-group-append">
                                <div class="input-group-text bg-gray">
                                    <span class="fas fa-globe"></span>
                                </div>
                                </div>
                            </div>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" name="edit_state" id="edit_state">
                                <div class="input-group-append">
                                <div class="input-group-text bg-gray">
                                    <span class="fas fa-bank"></span>
                                </div>
                                </div>
                            </div>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" name="edit_city" id="edit_city">
                                <div class="input-group-append">
                                <div class="input-group-text bg-gray">
                                    <span class="fas fa-bank"></span>
                                </div>
                                </div>
                            </div>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" name="edit_pincode" id="edit_pincode">
                                <div class="input-group-append">
                                <div class="input-group-text bg-gray">
                                    <span class="fas fa-map-marker"></span>
                                </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <textarea class="form-control" name="edit_address" id="edit_address" cols="30" rows="10" style="height: 94px;"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                    <!-- /.col -->
                    <div class="col-12 text-center mt-3">
                        <input type="submit" class="btn btn-primary btn-md" name="submit" id="submit" value="Update Info">                          
                    </div>
                    <!-- /.col -->
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