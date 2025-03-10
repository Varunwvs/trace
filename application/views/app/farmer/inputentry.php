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
                        <form id="formFarmerInput" method="post" action="FarmerController/addFarmerInput" >
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">Product</label>
                                    <input type="text" class="form-control" name="product" id="product">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">Category</label>
                                    <select class="form-control" name="category" >
                                        <option value="">Select Category</option>
                                        <?php foreach ($categories as $category): ?>
                                            <option value="<?= $category->id ?>"><?= $category->name ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>     
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">Description</label>
                                    <textarea class="form-control" name="description" id="description"></textarea>
                                </div>
                            </div>  
                        </div>
                        <div class="row">   
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">Brand/Company</label>
                                    <input type="text" class="form-control" name="brand" id="brand">
                                </div>
                            </div>    
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">Usage Instructions</label>
                                    <textarea class="form-control" name="usage_instructions" id="usage_instructions"></textarea>
                                </div>
                            </div>  
                           
                        </div>
                      
                       
                       
                          <div class="row">
                            <div class="col-md-12 text-right">
                              <input type="submit" class="btn btn-primary btn-lg" name="submit" id="submit" value="Submit" />
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
    