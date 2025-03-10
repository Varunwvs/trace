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
                  <li class="breadcrumb-item"><a href="midashboard">Home</a></li>
                  <li class="breadcrumb-item active"><?php echo $title ?></li>
                <?php else: ?>
                  <li class="breadcrumb-item"><a href="midashboard" tabindex="-1">Home</a></li>
                  <li class="breadcrumb-item"><?php echo $thisPageMain ?></li>
                  <li class="breadcrumb-item active"><?php echo $title ?></li>
                <?php endif ?>              
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- error message -->
    <?php if($this->session->flashdata('error_message')){ ?>
        <div class="alert alert-danger text-center" >
            <?php echo $this->session->flashdata('error_message'); ?>
        </div>
    <?php } ?>

    <!-- success message -->
    <?php if($this->session->flashdata('success_message')){ ?>
        <div class="alert alert-success text-center" >
            <?php echo $this->session->flashdata('success_message'); ?>
        </div>
    <?php } ?>
                
<div class="container-fluid">
    <div class="card <?php echo $_SESSION['role']==='jaincenter' ? 'hidden' : '' ?>" >
        <div class="card-block tab-icon"> 
            <h3>Products</h3>
            <form action="<?php echo base_url(); ?>mikkisaanapi_post" method="post" name="upload_excel" enctype="multipart/form-data">
            <!--<form action="<?php echo base_url(); ?>" method="post" name="upload_excel" enctype="multipart/form-data">-->
                <!-- <input type="file" name="file" id="file" required=""> -->
                <div class="row">
                    <div class="col-md-12">
                        <label class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" name="example-checkbox1" value="option1" required>
                                <span class="custom-control-label">I have verified that all the details are correct and its good to send these details to <b>Karnataka - Krishi Information Service and Networking </b></span>
                        </label><br/>
                        <button type="submit" class="btn btn-primary" id="submit" name="import">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card <?php echo $_SESSION['role']==='jainadmin' ? 'hidden' : '' ?>">
        <div class="card-block tab-icon"> 
            <h3>Primary Label</h3>
            <form action="<?php echo base_url(); ?>mikkisaanapi_batch_post" method="post" name="upload_excel" enctype="multipart/form-data">
            <!--<form action="<?php echo base_url(); ?>" method="post" name="upload_excel" enctype="multipart/form-data">-->
            <!-- <input type="file" name="file" id="file" required=""> -->
                <div class="row">
                    <div class="col-md-12">
                        <label class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" name="example-checkbox1" value="option1" required>
                                <span class="custom-control-label">I have verified that all the details are correct and its good to send these details to <b>Karnataka - Krishi Information Service and Networking </b></span>
                        </label><br/>
                        <button type="submit" class="btn btn-primary" id="submit" name="import">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card hidden" >
        <div class="card-block tab-icon"> 
            <h3>Containers</h3>
            <form action="<?php echo base_url(); ?>save_secondary_container_detail" method="post" name="upload_excel" enctype="multipart/form-data">
            <!--<form action="<?php echo base_url(); ?>" method="post" name="upload_excel" enctype="multipart/form-data">-->

            <!-- <input type="file" name="file" id="file" required=""> -->
                <div class="row ">
                    <div class="col-md-12">
                        <label class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" name="example-checkbox1" value="option1" required>
                                <span class="custom-control-label">I have verified that all the details are correct and its good to send these details to <b>Karnataka - Krishi Information Service and Networking </b></span>
                        </label><br/>
                        <button type="submit" class="btn btn-primary" id="submit" name="import">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div> 
</div>