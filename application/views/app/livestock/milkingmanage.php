
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
                    <h5>Animal Dairy Details</h5>            
                    <div class="card-header-right">
                        <?php $adminrole = $_SESSION['role']; ?>
                        <?php $center=substr($adminrole, 0, -6).'center';?>
                        <?php
                           
                            // echo '<a class="mr-3 text-white" role="button" href="animaldairyentry"><i class="fa-solid fa-plus"></i> Add New Data</a>';
                                                               
                        ?>                      
                    </div>
                </div>
                <div class="card-block tab-icon">

                <div class="row"><h4>Fetch Data</h4></div>
                <form id="filterForm"  class="mb-3">
                    <div class="row">
                        <div class="col-md-3">
                            <label>Date</label>
                            <input type="date" name="date" id="date" class="form-control" required>
                        </div>
                        <div class="col-md-3">
                            <label>Slot</label><br>
                            <input type="checkbox" name="slot" id="morning" value="morning"> Morning
                            <input type="checkbox" name="slot" id="evening" value="evening"> Evening
                        </div>
                        <div class="col-md-3">
                            <button type="button" id="loadData" class="btn btn-primary mt-4">Load Data</button>
                        </div>
                    </div>
                </form>
                <hr>
                <!-- <div class="row text-center mt-2"><h3>ADD Milking Data</h3></div> -->
                <div class="card-header bg-primary text-center mt-2" >
                    <h4>ADD MILKING DATA</h4>            
                   
                </div>
                
                    <div class="row "> 
                      <div class="col-12 table-responsive text-sm">
                      <form id="milkingForm">

                      <div class="row mb-3">
                            <div class="col-md-3">
                                <label>Date</label>
                                <input type="date"  name="date" id="fdate" class="form-control" required>
                            </div>
                            <div class="col-md-3">
                                <label>Slot</label><br>
                                <input type="checkbox" name="slot" id="fmorning" value="morning"> Morning
                                <input type="checkbox" name="slot" id="fevening" value="evening"> Evening
                            </div>  
                        </div>

                      <input type="hidden" name="cid" id="cid" value="<?php echo $_SESSION['comid'] ?>">
                        <table id="dtAnimalDairy" class="table table-striped table-bordered nowrap" style="width:100%;">
                          <thead class="bg-nblue">
                            <tr>
                               <th>#</th>
                               <th>Animal Id</th>
                               <th>Milk Yield(lt)</th>
                               <th>SNF(%)</th>
                               <th>Fat(%)</th>
                               <th>Contamination</th>
                            </tr>
                          </thead>  
                          <tbody id="milkingDataBody">
                                <?php foreach ($animals as $index => $animal): ?>
                                    <tr>
                                        <td><?= $index + 1; ?></td>
                                        <td><?= $animal['animal_id']; ?>
                                        <input type="hidden" name="milking[<?= $animal['id']; ?>][animal_id]" value="<?= $animal['id']; ?>" class="form-control"></td>
                                        <td><input type="number" name="milking[<?= $animal['id']; ?>][milk_yield]" class="form-control"></td>
                                        <td><input type="text" name="milking[<?= $animal['id']; ?>][snf]" class="form-control"></td>
                                        <td><input type="text" name="milking[<?= $animal['id']; ?>][fat]" class="form-control"></td>
                                        <td><input type="text" name="milking[<?= $animal['id']; ?>][contamination]" class="form-control"></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>                          
                        </table>
                        <button type="submit" class="btn btn-success">Save Data</button>
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




    