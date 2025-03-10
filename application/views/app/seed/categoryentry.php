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
                        <form id="formCategory" method="post" action="SeedController/addCategory">

                        <div class="row">
                          <label class="form-label">Category Type</label>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-3">
                                <label><input type="checkbox" name="category_type[]" value="Raw Material"> Raw Material</label>
                            </div>
                        </div>
                        <div class="row">
                          <div class="col-md-3">
                                <label><input type="checkbox" name="category_type[]" value="Product"> Product</label>
                            </div>
                            <input type="hidden" name="cid" id="cid" value="<?php echo $_SESSION['comid'] ?>">
                        </div>
                           
                        

                        <div class="row mt-3">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">Name</label>
                                    <input type="text" class="form-control" name="name" id="name">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">Code</label>
                                    <input type="text" class="form-control" name="code" id="code">
                                </div>
                            </div>     

                            <div class="col-md-4">
                                <div class="form-group"> 
                                    <label class="form-label">Parent Category</label>
                                    <select class="form-control" name="parent_category" id="parent_category">
                                        <option value="">Select Category</option>
                                        <?php foreach ($categories as $category): ?>
                                                  <option value="<?php echo $category->id; ?>"><?php echo $category->name; ?></option>
                                              <?php endforeach; ?>
                                    </select>
                                    <span><small>Select parent category to add a sub category</small></span>
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