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
                  <li class="breadcrumb-item"><a href="fldashboard">Home</a></li>
                  <li class="breadcrumb-item active"><?php echo $title ?></li>
                <?php else: ?>
                  <li class="breadcrumb-item"><a href="fldashboard" tabindex="-1">Home</a></li>
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
                        <?php $adminrole = $_SESSION['role']; ?>
                        <?php $center=substr($adminrole, 0, -6).'center';?>
                        <?php $admin=substr($adminrole, 0, -6).'admin';?>
                        <?php
                            $result = $this->db->select('qr_quantity')->from('users')->where('role', $admin)->get(); 
                            foreach($result->result() as $qrow){
                                $qr_quantity = $qrow->qr_quantity;
                            }
                            if($_SESSION['role']===$center){
                            $pdcount = $this->db->select('count(*) as pcount')->from('fertilizerbatchserial')
                            ->where( array('cid'=> $_SESSION['comid']) )->get();
                                foreach($pdcount->result() as $pcrow){
                                    $pcount = $pcrow->pcount;
                                }
                                if($pcount===$qr_quantity){
                                    echo '<a class="text-white" href="https://wa.me/918762807087/"><i class="fa-regular fa-circle-up"></i> Please upgrade plan</a>';
                                }else{
                                    echo '<a class="mr-3 text-white" role="button" href="flproductentry"><i class="fa-solid fa-plus"></i> Add New Product</a>';
                                }
                            }else{
                                if($pcount===$_SESSION['comtotqr']){
                                    echo '<a class="text-white" href="https://wa.me/918762807087/"><i class="fa-regular fa-circle-up"></i> Please upgrade plan</a>';
                                }else{
                                    echo '<a class="mr-3 text-white" role="button" href="flproductentry"><i class="fa-solid fa-plus"></i> Add New Product</a>';
                                }
                            } 
                        ?> 
                    </div>
                </div>
                <div class="card-block tab-icon">
                    <div class="row"> 
                      <div class="col-12 table-responsive text-sm">
                        <table id="dtProduct" class="table table-striped table-bordered nowrap" style="width:100%;">
                          <thead class="bg-nblue">
                            <tr>
                              <th>#</th>
                              <th>Product Name</th>                          
                              <th>UPC</th>
                              <th>Category</th>
                              <th>Actions</th>
                            </tr>
                          </thead>                            
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