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

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Info boxes -->
        <div class="row">
          <div class="col-lg-12">
            <div class="card">  
                <div class="card-header bg-primary" id="dttable">
                    <h5>Converting QR Code to A4 page format</h5>  
                </div>
                <div class="card-block tab-icon">
                    <div class="row mb-2"> 
                      <div class="col-12 table-responsive text-sm">
                        <h5>Follow the steps below to convert the QR code into A4 sizes</h5>
                      </div>
                    </div>
                    <div class="row">
                        <div class="col-5 col-sm-3">
                            <div class="nav flex-column nav-tabs h-100" id="vert-tabs-tab" role="tablist" aria-orientation="vertical">
                            <a class="nav-link active" id="vert-tabs-step1-tab" data-toggle="pill" href="#vert-tabs-step1" role="tab" aria-controls="vert-tabs-step1" aria-selected="true">Step 1 - Open Adobe Acrobat Reader</a>
                            <a class="nav-link" id="vert-tabs-step2-tab" data-toggle="pill" href="#vert-tabs-step2" role="tab" aria-controls="vert-tabs-step2" aria-selected="false">Step 2 - Open file for changes</a>
                            <a class="nav-link" id="vert-tabs-step3-tab" data-toggle="pill" href="#vert-tabs-step3" role="tab" aria-controls="vert-tabs-step3" aria-selected="false">Step 3 - Select the file</a>
                            <a class="nav-link" id="vert-tabs-step4-tab" data-toggle="pill" href="#vert-tabs-step4" role="tab" aria-controls="vert-tabs-step4" aria-selected="false">Step 4 - Select Print command</a>
                            <a class="nav-link" id="vert-tabs-step5-tab" data-toggle="pill" href="#vert-tabs-step5" role="tab" aria-controls="vert-tabs-step5" aria-selected="false">Step 5 - Make the changes in the print</a>
                            <a class="nav-link" id="vert-tabs-step6-tab" data-toggle="pill" href="#vert-tabs-step6" role="tab" aria-controls="vert-tabs-step6" aria-selected="false">Watch Video</a>
                            </div>
                        </div>
                        <div class="col-7 col-sm-9">
                            <div class="tab-content" id="vert-tabs-tabContent">
                                <div class="tab-pane text-left fade show active" id="vert-tabs-step1" role="tabpanel" aria-labelledby="vert-tabs-step1-tab">
                                    <div class="col-lg-12">
                                        <img src="assets/images/step-1.jpg" alt="" style="width:100%;">
                                    </div>                                   
                                </div>
                                <div class="tab-pane fade" id="vert-tabs-step2" role="tabpanel" aria-labelledby="vert-tabs-step2-tab">
                                    <div class="col-lg-12">
                                        <img src="assets/images/step-2.jpg" alt="" style="width:100%;">
                                    </div>  
                                </div>
                                <div class="tab-pane fade" id="vert-tabs-step3" role="tabpanel" aria-labelledby="vert-tabs-step3-tab">
                                    <div class="col-lg-12">
                                        <img src="assets/images/step-3.jpg" alt="" style="width:100%;">
                                    </div>   
                                </div>
                                <div class="tab-pane fade" id="vert-tabs-step4" role="tabpanel" aria-labelledby="vert-tabs-step4-tab">
                                    <div class="col-lg-12">
                                        <img src="assets/images/step-4.jpg" alt="" style="width:100%;">
                                    </div>    
                                </div>
                                <div class="tab-pane fade" id="vert-tabs-step5" role="tabpanel" aria-labelledby="vert-tabs-step5-tab">
                                    <div class="col-lg-12">
                                        <img src="assets/images/step-5.jpg" alt="" style="width:100%;">
                                    </div>   
                                </div>
                                <div class="tab-pane fade" id="vert-tabs-step6" role="tabpanel" aria-labelledby="vert-tabs-step6-tab">
                                    Video tutorial will be added soon...
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
          </div>          
        </div>
        <!-- /.row -->
      </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->