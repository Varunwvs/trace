
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
                    <h5>Animals List</h5>            
                    <div class="card-header-right">
                        <?php $adminrole = $_SESSION['role']; ?>
                        <?php $center=substr($adminrole, 0, -6).'center';?>
                        <?php
                           
                            echo '<a class="mr-3 text-white" role="button" href="animalregistrationentry"><i class="fa-solid fa-plus"></i> Add New Animal</a>';
                                                               
                        ?>                      
                    </div>
                </div>
                <div class="card-block tab-icon">
                    <div class="row"> 
                      <div class="col-12 table-responsive text-sm">
                        <table id="dtAnimalRegister" class="table table-striped table-bordered nowrap" style="width:100%;">
                          <thead class="bg-nblue">
                            <tr>
                               <th>#</th>
                               <th>Animal Id</th>
                               <th>Breed</th>
                               <th>DOB</th>
                               <th>Gender</th>
                               <th>Action</th>
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


    <!-- Bootstrap Modal -->
<div class="modal fade" id="animalModal" tabindex="-1" role="dialog" aria-labelledby="animalModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="animalModalLabel">Animal Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

            </div>
            <div class="modal-body">
                <table class="table table-bordered">
                    <tbody>
                        <tr><th>Animal ID</th><td id="modal_animal_id"></td></tr>
                        <tr><th>Species</th><td id="modal_species"></td></tr>
                        <tr><th>Breed</th><td id="modal_breed"></td></tr>
                        <tr><th>Date of Birth</th><td id="modal_dob"></td></tr>
                        <tr><th>Gender</th><td id="modal_gender"></td></tr>
                        <tr><th>Parent Details</th><td id="modal_parent_details"></td></tr>
                        <tr><th>Ear Tag</th><td id="modal_ear_tag"></td></tr>
                        <tr><th>Farm Location</th><td id="modal_farm_location"></td></tr>
                        <tr><th>Owner</th><td id="modal_owner"></td></tr>
                        <tr>
                            <th>Animal Photo</th>
                            <td>
                                <img id="modal_photo" src="" alt="No Image" style="max-width: 200px; display: none;">
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

    