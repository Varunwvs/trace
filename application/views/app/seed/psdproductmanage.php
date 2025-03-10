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
                    <h5>List of Products</h5>            
                    <div class="card-header-right">
                        <a class="mr-3 text-white" role="button" href="psdproductentry"><i class="fa-solid fa-plus"></i> Add New Private Product</a>                     
                    </div>
                </div>
                <div class="card-block tab-icon">
                    <div class="row"> 
                      <div class="col-12 table-responsive text-sm">
                        <table id="dtPProducts" class="table table-striped table-bordered nowrap" style="width:100%;">
                          <thead class="bg-nblue">
                            <tr>
                              <th>#</th>
                              <th>Product Name</th>                          
                              <th>UPC</th>
                              <th>Category</th>
                              <th>Actions</th>
                            </tr>
                          </thead> 
                          <tbody>
                            <tr>
                              <td>1</td>
                              <td>Sunflower Seeds</td>                          
                              <td>SED001</td>
                              <td>Truthfull Seeds</td>
                              <td><ul class="list-inline">  
                <li class="list-inline-item"><a class="btn text-info btn-xs" role="button" href="psdproductview?id=1"> <span class="fa fa-eye"></span></a></li>
                <li class="list-inline-item"><a class="btn text-info btn-xs '.$dis.' hidden" role="button" href="psdproductedit?id=1"> <span class="fa fa-edit"></span></a></li>                
            </ul></td>
                            </tr>
                          </tbody> 
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