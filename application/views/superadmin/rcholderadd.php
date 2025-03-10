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
                        <form id="userForm" action="SuperAdminController/addRcholder" method="post">
                            <div class="row">
                                <div class="col-6">
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" name="cname" id="cname" placeholder="RC Holder Name">
                                        <div class="input-group-append">
                                        <div class="input-group-text bg-gray">
                                            <span class="fas fa-user"></span>
                                        </div>
                                        </div>
                                    </div>
                                    <div class="input-group mb-3">
                                        <select class="form-control text-grey" id="category" name="category">
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
                                        <input type="text" class="form-control" name="contact_person" id="contact_person" placeholder="Contact Person">
                                        <div class="input-group-append">
                                        <div class="input-group-text bg-gray">
                                            <span class="fas fa-user"></span>
                                        </div>
                                        </div>
                                    </div>
                                    <div class="input-group mb-3">
                                        <input type="email" class="form-control" name="email" id="email" placeholder="Email Id" data-bs-validate="Valid email is required: ex@abc.xyz">
                                        <div class="input-group-append">
                                        <div class="input-group-text bg-gray">
                                            <span class="fas fa-envelope"></span>
                                        </div>
                                        </div>
                                    </div>
                                    <div class="input-group mb-3">
                                        <input type="password" class="form-control" name="password" id="password" placeholder="Password">
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
                                        <input type="text" class="form-control" name="phone" id="phone" placeholder="Phone No.">
                                        <div class="input-group-append">
                                        <div class="input-group-text bg-gray">
                                            <span class="fas fa-phone"></span>
                                        </div>
                                        </div>
                                    </div>
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" name="gst" id="gst" placeholder="GST No.">
                                        <div class="input-group-append">
                                        <div class="input-group-text bg-gray">
                                            <span class="fas fa-file"></span>
                                        </div>
                                        </div>
                                    </div>
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" name="website" id="website" placeholder="website">
                                        <div class="input-group-append">
                                        <div class="input-group-text bg-gray">
                                            <span class="fas fa-globe"></span>
                                        </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="input-group mb-3">
                                        <select class="form-control text-grey" name="totalproduct" id="totalproduct">
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
                                        <input type="text" class="form-control" name="state" id="state" placeholder="state">
                                        <div class="input-group-append">
                                        <div class="input-group-text bg-gray">
                                            <span class="fas fa-bank"></span>
                                        </div>
                                        </div>
                                    </div>
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" name="city" id="city" placeholder="city">
                                        <div class="input-group-append">
                                        <div class="input-group-text bg-gray">
                                            <span class="fas fa-bank"></span>
                                        </div>
                                        </div>
                                    </div>
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" name="pincode" id="pincode" placeholder="pincode">
                                        <div class="input-group-append">
                                        <div class="input-group-text bg-gray">
                                            <span class="fas fa-map-marker"></span>
                                        </div>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <textarea class="form-control" name="address" id="address" cols="30" rows="10" style="height: 147px;" placeholder="Address"></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <!-- /.col -->
                                <div class="col-12 text-center mt-3">
                                    <input type="submit" class="btn btn-primary btn-md" name="submit" id="submit" value="Submit">                                
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