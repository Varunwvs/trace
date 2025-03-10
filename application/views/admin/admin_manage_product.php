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
                <div class="card-header bg-primary" id="dttable">
                    <h5>List of Product</h5>            
                    <div class="card-header-right">
                        <?php if($_SESSION['comcat'] === '1'): ?>
                            <a class="mr-3 text-white" role="button" href="admin_add_product"><i class="fa-solid fa-plus"></i> Add New Product</a>
                        <?php elseif ($_SESSION['comcat'] === '3'):?>
                            <a class="mr-3 text-white" role="button" href="admin_add_product_mi"><i class="fa-solid fa-plus"></i> Add New Product</a>
                        <?php else : ?>
                            <a class="mr-3 text-white" role="button" href="admin_add_product"><i class="fa-solid fa-plus"></i> Add New Product</a>
                        <?php endif ?>
                    </div>
                </div>
                <div class="card-block tab-icon">
                    <div class="row"> 
                      <div class="col-12 table-responsive text-sm">
                        <table id="dtProduct" class="table table-striped table-bordered nowrap" style="width:100%;">
                          <thead class="bg-nblue">
                            <tr>
                              <th>#</th>
                              <th>Product Name</th>                          
                              <th>UPC</th>
                              <th>Category</th>
                              <th>Actions</th>
                            </tr>
                          </thead>                            
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

    <!-- View company modal -->
    <div class="modal fade" id="viewModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
          <div class="modal-header bg-green shadow-sm mb-2">
            <h1 class="modal-title fs-5" id="exampleModalLabel"><i class="nav-icon fa-solid fa-boxes-packing"></i> Product Details</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>          
          <div class="modal-body">            
            <div class="row">
              <div class="col-6">
                <div class="row">
                  <div class="col-md-6 bg-sky shadow p-1">
                    <h5 class="text-sm fw-bold">Company Name:</h5>
                  </div>
                  <div class="col-md-6 bg-light p-1 rounded">
                    <h5 class="text-capitalize text-sm fw-bold" id="cname"></h5>
                  </div>
                </div>
                
                <div class="row">
                  <div class="col-md-6 bg-sky shadow p-1">
                    <h5 class="text-sm fw-bold">Marketed By/RC Holder:</h5>
                  </div>
                  <div class="col-md-6 bg-light p-1 rounded">
                    <h5 class="text-sm fw-bold" class="text-capitalize" id="mktby"></h5>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6 bg-sky shadow p-1">
                    <h5 class="text-sm fw-bold">Product Category:</h5>
                  </div>
                  <div class="col-md-6 bg-light p-1 rounded">
                    <h5 class="text-sm fw-bold" id="prdcat"></h5>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6 bg-sky shadow p-1">
                    <h5 class="text-sm fw-bold">Sub Category:</h5>
                  </div>
                  <div class="col-md-6 bg-light p-1 rounded">
                    <h5 class="text-sm fw-bold" id="subcat"></h5>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6 bg-sky shadow p-1">
                    <h5 class="text-sm fw-bold">Only Primary Packing?:</h5>
                  </div>
                  <div class="col-md-6 bg-light p-1 rounded">
                    <h5 class="text-sm fw-bold" id="isprimary"></h5>
                  </div>
                </div>
              </div>
              <div class="col-6">                          
                <div class="row">
                  <div class="col-md-6 bg-sky shadow p-1">
                    <h5 class="text-sm fw-bold">Unique Product Code:</h5>
                  </div>
                  <div class="col-md-6 bg-light p-1 rounded">
                    <h5 class="text-sm fw-bold" id="upc"></h5>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6 bg-sky shadow p-1">
                    <h5 class="text-sm fw-bold">Product Name:</h5>
                  </div>
                  <div class="col-md-6 bg-light p-1 rounded">
                    <h5 class="text-sm fw-bold" id="prdname"></h5>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6 bg-sky shadow p-1">
                    <h5 class="text-sm fw-bold">Brand Name:</h5>
                  </div>
                  <div class="col-md-6 bg-light p-1 rounded">
                    <h5 class="text-sm fw-bold" class="text-capitalize" id="brdname"></h5>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6 bg-sky shadow p-1">
                    <h5 class="text-sm fw-bold">Measurement Unit of Weight:</h5>
                  </div>
                  <div class="col-md-6 bg-light p-1 rounded">
                    <h5 class="text-sm fw-bold" class="text-capitalize" id="muw"></h5>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6 bg-sky shadow p-1">
                    <h5 class="text-sm fw-bold">Net Content/Weight per Pack:</h5>
                  </div>
                  <div class="col-md-6 bg-light p-1 rounded">
                    <h5 class="text-sm fw-bold" id="ncw"></h5>
                  </div>
                </div>
              </div>
            </div>            
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>              
          </div>          
        </div>
      </div>
    </div>