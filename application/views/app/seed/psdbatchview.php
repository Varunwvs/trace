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
                    <h5 class="text-uppercase" id="bname"></h5> 
                    <p class="m-0"><small>List of serial numbers</small></p>
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
                                <div class="col-6">
                                    <div class="btn-group1" style="position: absolute;top: 0;left: 10px;right: 0;bottom: 0;z-index: 1000;">
                                        <!-- <a href="psprimaryfullbatchqrcode?id=<?php echo $_GET['id'] ?>&cid=<?php echo $_SESSION['comid'] ?>" target="_blank" class="btn btn-info btn-xs" role="button" style="cursor:pointer;"><i class="fas fa-qrcode"></i> Full Qrcode</a>
                                        <a href="psprimaryfullsmallqrcode?id=<?php echo $_GET['id'] ?>&cid=<?php echo $_SESSION['comid'] ?>" target="_blank" style="cursor:pointer;"><button type="button" class="btn btn-warning btn-xs"><i class="fas fa-qrcode"></i> Small Qrcode</button></a>
                                        <a href="psbatchexport?id=<?php echo $_GET['id'] ?>&cid=<?php echo $_SESSION['comid'] ?>" style="cursor:pointer;"><button type="button" class="btn btn-primary btn-xs"><i class="fas fa-download text-dark"></i> Export</button></a> -->
                                        <?php $pub = $this->db->select('public_page')->from('users')->where('id', $_SESSION['comid'])->get(); 
                                          foreach($pub->result() as $prow){
                                            $public_page = $prow->public_page;
                                          }
                                          if($public_page === '1'){
                                            echo '<a class="" href="psdpublicpageqrcode?id= '.$_GET['id'].'&cid='.$_SESSION['comid'].'" target="_blank" style="cursor:pointer;"><button type="button" class="btn btn-success btn-xs"><i class="fas fa-qrcode"></i> Public QRCode</button></a>
                                            <a href="ppsbatchexport?id='.$_GET['id'].'&cid='.$_SESSION['comid'].'" style="cursor:pointer;"><button type="button" class="btn btn-primary btn-xs"><i class="fas fa-download text-dark"></i> Export</button></a>';
                                          }else{}
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <style>.btn-group{display:none;}</style>
                            <div class="row"> 
                              <div class="col-12 table-responsive text-sm">
                                <table id="dtPSerials" class="table table-striped table-bordered nowrap" style="width:100%;">
                                  <thead class="bg-nblue">
                                    <tr>
                                      <th>#</th>
                                      <th>Serial Numbers</th>  
                                      <th>Actions</th>
                                    </tr>
                                  </thead> 
                                  <tbody class="bg-nblue">
                                    <tr>
                                      <td>1</td>
                                      <td>2312001</td>  
                                      <td></td>
                                    </tr>
                                    <tr>
                                      <td>1</td>
                                      <td>2312002</td>  
                                      <td></td>
                                    </tr>
                                    <tr>
                                      <td>1</td>
                                      <td>2312003</td>  
                                      <td></td>
                                    </tr>
                                  </tbody> 
                                </table>
                              </div>
                            </div>
                        </div>
                        
                        <div class="tab-pane fade show" id="secondary">
                             <div class="row">
                                <div class="col-6">
                                    <div class="btn-group1" style="position: absolute;top: 0;left: 10px;right: 0;bottom: 0;z-index: 1000;">                                       
                                        <a href="pssecondaryfullqrcode?id=<?php echo $_GET['id'] ?>&cid=<?php echo $_SESSION['comid'] ?>" target="_blank" style="cursor:pointer;"><button type="button" class="btn btn-warning btn-xs"><i class="fas fa-qrcode"></i> Small Container Qrcode</button></a>
                                        <a href="containerexport?id=<?php echo $_GET['id'] ?>&cid=<?php echo $_SESSION['comid'] ?>" style="cursor:pointer;"><button type="button" class="btn btn-primary btn-xs"><i class="fas fa-download text-dark"></i> Export</button></a>
                                        <a class="hidden" href="batchgreenqrcode?id=<?php echo $_GET['id'] ?>&cid=<?php echo $_SESSION['comid'] ?>" target="_blank" style="cursor:pointer;"><button type="button" class="btn btn-success btn-xs"><i class="fas fa-qrcode"></i> Green Label Qrcode</button></a>
                                    </div>
                                </div>
                            </div>
                            <div class="row"> 
                              <div class="col-12 table-responsive text-sm">
                                <table id="dtPContainers" class="table table-striped table-bordered nowrap" style="width:100%;">
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