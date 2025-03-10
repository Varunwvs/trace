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
                <form id="userForm" action="SuperAdminController/genCClientReport" target="_blank" method="post">
                    <div class="row ">
                        <div class="col-12">
                            <h3 class="mt-2">For Current Financial Year 2024-2025</h3>
                            <div class="input-group">
                                <label class="form-control col-md-3 bg-gray" for="client_id">Select Category</label>
                                <select class="form-control col-md-3" name="client_id" id="client_id" aria-label="Recipient's username with two button addons">
                                    
                                    <?php foreach($category as $rows):?>
                                        <option value="<?php echo $rows->id;?>"><?php echo ucwords($rows->name);?></option>
                                    <?php endforeach;?>
                                </select>
                                <input type="submit" class="btn btn-outline-danger" name="submitpdf" id="submitpdf" value="Download PDF">
                                <input type="submit" class="btn btn-outline-primary" name="submitexl" id="submitexl" value="Download Excel">
                            </div>                                                       
                        </div>
                    </div>
                </form> 
                <form id="userForm" action="SuperAdminController/genClientReport" target="_blank" method="post">
                    <div class="row mt-5">
                        <div class="col-12">
                            <h3 class="mt-2">For Last Financial Year 2023-2024</h3>
                            <div class="input-group">
                                <label class="form-control col-md-3 bg-gray" for="client_id">Select Category</label>
                                <select class="form-control col-md-3" name="client_id" id="client_id" aria-label="Recipient's username with two button addons">
                                    
                                    <?php foreach($category as $rows):?>
                                        <option value="<?php echo $rows->id;?>"><?php echo ucwords($rows->name);?></option>
                                    <?php endforeach;?>
                                </select>
                                <input type="submit" class="btn btn-outline-danger" name="submitpdf" id="submitpdf" value="Download PDF">
                                <input type="submit" class="btn btn-outline-primary" name="submitexl" id="submitexl" value="Download Excel">
                            </div>                                                       
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
</div>
<!-- /.content -->