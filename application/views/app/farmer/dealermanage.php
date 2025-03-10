
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
                    <h5>Dealers List</h5>            
                    <div class="card-header-right">
                        <?php $adminrole = $_SESSION['role']; ?>
                        <?php $center=substr($adminrole, 0, -6).'center';?>
                        <?php
                           
                            echo '<a class="mr-3 text-white" role="button" href="dealerentry"><i class="fa-solid fa-plus"></i> Add New Dealer</a>';
                                                               
                        ?>                      
                    </div>
                </div>
                <div class="card-block tab-icon">
                    <div class="row"> 
                      <div class="col-12 table-responsive text-sm">
                        <table id="dtDealer" class="table table-striped table-bordered nowrap" style="width:100%;">
                          <thead class="bg-nblue">
                            <tr>
                            <th>#</th>
                               <th>Company Name</th>
                               <th>Contact Person</th>
                               <th>Mobile</th>
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

    <!-- Dealer Details Modal -->
    <div id="dealerModal" class="modal fade" tabindex="-1" aria-labelledby="dealerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Dealer Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered">
                    <tr><th>Company Name</th><td id="company_name"></td></tr>
                    <tr><th>GSTIN</th><td id="gstin"></td></tr>
                    <tr><th>PAN</th><td id="pan"></td></tr>
                    <tr><th>Distribution Location</th><td id="distribution_location"></td></tr>
                    <tr><th>Contact Person</th><td id="contact_person"></td></tr>
                    <tr><th>Mobile</th><td id="mobile"></td></tr>
                    <tr><th>Email</th><td id="email"></td></tr>
                    <tr><th>Distributor Status</th><td id="distributor_status"></td></tr>
                    <tr><th>Address</th><td id="address"></td></tr>
                </table>
            </div>
        </div>
    </div>
</div>



    </div>
    <!-- /.content -->




    