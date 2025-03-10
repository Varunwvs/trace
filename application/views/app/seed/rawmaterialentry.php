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
                        <form id="formRawMaterials" method="post" action="SeedController/addRawMaterials">

                        <div class="row">
                        <div class="col-md-4">
                              <div class="form-group">
                                  <label class="form-label">Category</label>
                                  <select class="form-control" name="category" id="category">
                                        <option value="">Select Category</option>
                                        <?php foreach ($categories as $category): ?>
                                                  <option value="<?php echo $category->id; ?>"><?php echo $category->name; ?></option>
                                              <?php endforeach; ?>
                                  </select>
                                  <input type="hidden" name="cid" id="cid" value="<?php echo $_SESSION['comid'] ?>">
                                  </div>            
                            </div>
                        </div>

                          <div class="row" id="rawMaterialsContainer">

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Raw Material Name</label>
                                    <input type="text" class="form-control" name="raw_materials[]" id="raw_materials_1">
                                </div>
                            </div>
                                            
                          </div>

                          <div class="row">
                            <div class="col-md-12 text-left">
                            <button type="button" class="btn btn-success" id="addMaterial">Add More</button>
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