
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
                <div class="card-header bg-primary" id="dttable">
                    <h5>Dispatch List</h5>            
                    <div class="card-header-right">
                        <?php $adminrole = $_SESSION['role']; ?>
                        <?php $center=substr($adminrole, 0, -6).'center';?>
                        <?php
                           
                            echo '<a class="mr-3 text-white" role="button" href="dispatchentry"><i class="fa-solid fa-plus"></i> Add New Dispatch</a>';
                                                               
                        ?>                      
                    </div>
                </div>
                <div class="card-block tab-icon">
                    <div class="row"> 
                      <div class="col-12 table-responsive text-sm">
                        <table id="dtDispatch" class="table table-striped table-bordered nowrap" style="width:100%;">
                          <thead class="bg-nblue">
                            <tr>
                               <th>#</th>
                               <th>Order No.</th>
                               <th>Batch No.</th>
                               <!-- <th>Produce Details</th> -->
                               <th>Dispatch No.</th>
                               <th>Quantity Shipped</th>
                               <th>Action</th>
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

      <!-- Modal -->
<div class="modal fade" id="dispatchModal" tabindex="-1" aria-labelledby="dispatchModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="dispatchModalLabel">Dispatch Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered">
                    <tr><th>Order No</th><td id="order_no"></td></tr>
                    <tr><th>Dispatch No</th><td id="dispatch_no"></td></tr>
                    <tr><th>Batch No</th><td id="batch_no"></td></tr>
                    <tr><th>Crop ID</th><td id="crop_id"></td></tr>
                    <tr><th>Quantity Shipped</th><td id="qty_shipped"></td></tr>
                    <tr><th>Vehicle No</th><td id="vehicle_no"></td></tr>
                    <tr><th>Image</th><td id="image_section"></td></tr>
                    <tr><th>Certificate</th><td id="certificate_section"></td></tr>
                    <tr><th>Other Files</th><td id="other_files_section"></td></tr>
                </table>
            </div>
        </div>
    </div>
</div>

    </div>
    <!-- /.content -->
    