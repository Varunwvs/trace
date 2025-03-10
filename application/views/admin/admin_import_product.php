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
            <div class="card-block tab-icon">
                <div class="row"> 
                    <div class="col-12 text-sm">
                        <h2>Please fill in the information below</h2>
    	                <p>The first line in downloaded csv file should remain as it is. Please do not change the order of columns.
                            The correct column order is (Company Name, Marketed By,Category, Sub Category,Unique Product Code, Product Name,Brand Name,Measurement Unit of Weight,Net Content/Weight per Pack),MRP (Incl.Tax),Germination,Physical Purity,Moisture,Inert Matter,Other Crop Seed </p>
                        <a href="<?php echo base_url() ?>BulkImport/sample_csv" class="btn btn-info btn-sm pull-right"><i class="fa fa-download"></i> Download sample File</a>
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
<?php if($this->session->flashdata('error_message')){ ?>
    <div class="alert alert-danger text-center" >
        <?php echo $this->session->flashdata('error_message'); ?>
    </div>
<?php } ?>
<?php if($this->session->flashdata('success_message')){ ?>
    <div class="alert alert-success text-center" >
        <?php echo $this->session->flashdata('success_message'); ?>
    </div>
<?php } ?>
<div class="content">
    <div class="container-fluid">
        <div class="row">  
            <div class="col-lg-12">
                <div class="card">                
                    <div class="card-block tab-icon">
                        <div class="row"> 
                            <div class="col-12 text-sm">
                            <h4 class="page-title">Upload File</h4>    
                                <form action="<?php echo base_url(); ?>BulkImport/import" method="post" name="upload_excel" enctype="multipart/form-data">
                                    <input type="file" name="file" id="file" required="">
                                    <button type="submit" class="btn btn-primary" id="submit" name="import">Import</button>
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