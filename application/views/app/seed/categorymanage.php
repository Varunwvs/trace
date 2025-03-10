
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
                    <h5>Categories</h5>            
                    <div class="card-header-right">
                        <?php $adminrole = $_SESSION['role']; ?>
                        <?php $center=substr($adminrole, 0, -6).'center';?>
                        <?php
                           
                            echo '<a class="mr-3 text-white" role="button" href="categoryentry"><i class="fa-solid fa-plus"></i> Add Category</a>';
                               
                                                      
                        ?>                      
                    </div>
                </div>
                <div class="card-block tab-icon">
                    <div class="row"> 
                      <div class="col-12 table-responsive text-sm">
                        <table id="dtCategory" class="table table-striped table-bordered nowrap" style="width:100%;">
                          <thead class="bg-nblue">
                            <tr>
                               <th>#</th>
                               <th>Type</th>
                               <th>Category</th>
                               <th>Code</th>
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


    </div>
    <!-- /.content -->

            <!-- Modal -->
<div class="modal fade" id="subCategoryModal" tabindex="-1" role="dialog" aria-labelledby="subCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="subCategoryModalLabel">Subcategories List</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Subcategory Name</th>
                            <th>Subcategory Code</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="subcategoryList">
                        <!-- Data will be loaded dynamically -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>





    