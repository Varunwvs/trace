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
                  <li class="breadcrumb-item"><a href="tpdashboard">Home</a></li>
                  <li class="breadcrumb-item active"><?php echo $title ?></li>
                <?php else: ?>
                  <li class="breadcrumb-item"><a href="tpdashboard" tabindex="-1">Home</a></li>
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
                    <h5>List of Serial Nos.</h5> 
                    <input type="hidden" name="bid" id="bid" value="<?php echo $_GET['id'] ?>">
                </div>
                <div class="card-block tab-icon">
                    <ul class="nav nav-tabs" id="myTab">
                        <li class="nav-item">
                            <a href="#primary" class="nav-link active" data-bs-toggle="tab">Primary</a>
                        </li>
                        <li class="nav-item hidden">
                            <a href="#secondary" class="nav-link" data-bs-toggle="tab">Secondary</a>
                        </li>
                    </ul>
                    <div class="tab-content mt-5">
                        <div class="tab-pane fade show active" id="primary">                            
                            <div class="row"> 
                              <div class="col-12 table-responsive text-sm">
                                <table id="dtlySerial" class="table table-striped table-bordered nowrap" style="width:100%;">
                                  <thead class="bg-nblue">
                                    <tr>
                                      <th>#</th>
                                      <th>Serial Numbers</th> 
                                      <th>Alias</th> 
                                    </tr>
                                  </thead>                            
                                </table>
                              </div>
                            </div>
                        </div>
                        
                        <div class="tab-pane fade show hidden" id="secondary">                             
                            <div class="row"> 
                              <div class="col-12 table-responsive text-sm">
                                <table id="" class="table table-striped table-bordered nowrap" style="width:100%;">
                                  <thead class="bg-nblue">
                                    <tr>
                                      <th>#</th>
                                      <th>Container Code</th> 
                                      <th>UCC Alias</th> 
                                      <th>Primary Alias Code</th>
                                      <th>Actions</th>
                                    </tr>
                                  </thead>                            
                                </table>
                              </div>
                            </div>
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