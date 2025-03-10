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

                      <form id="animalFinanceForm" method="post" action="LiveStockManagementController/addAnimalFinance">
                 
                                <div class="row">
                                  <div class="col-md-4">
                                      <div class="form-group">
                                          <label class="form-label">Animal ID</label>
                                          <select class="form-control" name="animal_id" id="animal_id"  required>
                                              <option value="">Select Animal Id</option>
                                              <?php foreach ($animals as $row): ?>
                                                  <option value="<?= $row->id ?>"><?= $row->animal_id ?></option>
                                              <?php endforeach; ?>
                                          </select>
                                          <input type="hidden" name="cid" id="cid" value="<?php echo $_SESSION['comid'] ?>">            </div>
                                  </div>
                                  <div class="col-md-4">
                                      <div class="form-group">
                                          <label class="form-label">Livestock Sale Date</label>
                                          <input type="date" class="form-control" name="sale_date" required>
                                      </div>
                                  </div>
                                  <div class="col-md-4">
                                      <div class="form-group">
                                          <label class="form-label">Buyer Name</label>
                                          <input type="text" class="form-control" name="buyer_name" required>
                                      </div>
                                  </div>
                              </div>

                              <div class="row">
                                  <div class="col-md-4">
                                      <div class="form-group">
                                          <label class="form-label">Buyer Contact</label>
                                          <input type="text" class="form-control" name="buyer_contact" required>
                                      </div>
                                  </div>
                                  <div class="col-md-4">
                                      <div class="form-group">
                                          <label class="form-label">Sale Price</label>
                                          <input type="number" class="form-control" name="sale_price" required>
                                      </div>
                                  </div>
                                  <div class="col-md-4">
                                      <div class="form-group">
                                          <label class="form-label">Logistics Cost</label>
                                          <input type="number" class="form-control" name="logistics_cost">
                                      </div>
                                  </div>
                              </div>

                              <div class="row">
                                  <div class="col-md-4">
                                      <div class="form-group">
                                          <label class="form-label">Veterinary Expenses</label>
                                          <input type="number" class="form-control" name="vet_expenses">
                                      </div>
                                  </div>
                                  <div class="col-md-4">
                                      <div class="form-group">
                                          <label class="form-label">Profit/Loss</label>
                                          <input type="number" class="form-control" name="profit_loss">
                                      </div>
                                  </div>
                                  <div class="col-md-4">
                                      <div class="form-group">
                                          <label class="form-label">Milk & Meat Sales</label>
                                          <input type="number" class="form-control" name="milk_meat_sales">
                                      </div>
                                  </div>
                              </div>

                              <div class="row">
                                  <div class="col-md-4">
                                      <div class="form-group">
                                          <label class="form-label">Subsidies or Loans Received</label>
                                          <input type="number" class="form-control" name="subsidies_loans">
                                      </div>
                                  </div>
                              </div>
                                    <!-- Submit Button -->
                                    <div class="row">
                                        <div class="col-md-12 text-right">
                                        <input type="submit" class="btn btn-primary btn-lg" name="submit" id="submit" value="Submit" />
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
      <div id="loader"></div>
    </div>
    <!-- /.content -->