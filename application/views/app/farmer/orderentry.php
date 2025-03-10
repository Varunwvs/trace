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
                        <form id="formCrop" method="post" action="#">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label class="form-label">Customer</label>
                                    <select class="form-control" name="customer_id" id="customer_id">
                                        <option value="">Select Customer</option>
                                        <?php foreach ($customers as $customer): ?>
                                            <option value="<?= $customer->id ?>"><?= $customer->company_name ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">Tags</label>
                                    <input class="form-control" type="text" name="tags" id="tags">
                                </div>
                            </div>     
                           
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">Bill To</label>
                                    <textarea class="form-control" name="bill_to" id="bill_to"></textarea>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">Ship To</label>
                                    <textarea class="form-control" name="ship_to" id="ship_to"></textarea>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="form-label">Currency</label>
                                    <select class="form-control" name="customer_id" id="customer_id">
                                        <option value="">Select Currency</option>
                                        <?php foreach ($currencies as $currency): ?>
                                            <option value="<?= $currency->id ?>"><?= $currency->name ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>  
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="form-label">Sales Agent</label>
                                    <input class="form-control" type="text" name="sales_agent" id="sales_agent">
                                </div>
                            </div>   
                           
                        </div>

                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label class="form-label">Order Number</label>
                                    <input class="form-control" type="text" name="order_no" id="order_no" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">Admin Notes</label>
                                    <textarea class="form-control" name="admin_notes" id="admin_notes"></textarea>
                                </div>
                            </div>     
                           
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">Order Date</label>
                                    <input class="form-control" type="date" name="order_date" id="order_date" value="<?php echo date('Y-m-d'); ?>">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">Delivery Date</label>
                                    <input class="form-control" type="date" name="delivery_date" id="delivery_date">
                                </div>
                            </div>     
                           
                        </div>

                        <hr>

                        <div class="row mt-3">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <input class="form-control" type="file" name="order_date" id="order_date" >
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <input class="form-control" type="file" name="delivery_date" id="delivery_date">
                                </div>
                            </div>    
                            <div class="col-md-4">
                                <div class="form-group">
                                    <input class="form-control" type="file" name="delivery_date" id="delivery_date">
                                </div>
                            </div>   
                           
                        </div>

                       

                        <hr>
                    <!-- Invoice cart row -->
                    <div class="row">
                      <div class="col-md-4 m-3">                       
                        <div class="form-group">
                            <h4>Invoice</h4>
                         <!-- <label class="form-label">Batch No.</label> -->
                         <!-- <input class="form-control" type="text" name="batch_no" id="batch_no"> -->
                        </div>
                      </div>
                      <div class="col-md-8 offset-md-8"></div>
                      <div class="col-md-12 table-responsive">
                        <table id="dtInvoice" class="table table-striped nowrap" style="width:100%;">
                          <thead class="bg-light">
                            <tr>
                              <th>Batch No</th>
                              <th>Product Name</th>                          
                              <th>Serial Nos Range</th>
                              <th>Qty</th>
                              <th>UOM</th>
                              <th>Price</th> 
                              <th>Amount</th>
                                
                              <th><i class="fa-solid fa-gear"></i></th>
                            </tr>
                            
                          </thead> 
                          <tbody class="details">
                            <tr>
                                <td>
                                     <input class="form-control" type="text"  name="batch_no" id="batch_no">
                                </td>
                                <td>
                                     <input class="form-control" type="text"  name="product_name" id="product_name">
                                </td>
                                <td>
                                  <div style="display: flex; gap: 2px;">
                                    <input class="form-control" type="text" name="serial_no_from" id="serial_no_from" placeholder="From">
                                    <input class="form-control" type="text" name="serial_no_to" id="serial_no_to" placeholder="To">
                                  </div>
                                </td>
                                <td>
                                     <input class="form-control" type="text"  name="qty" id="qty">
                                </td>
                                <td>
                                    <select class="form-control" name="uom" id="uom">
                                        <option value="">Select Unit</option>
                                        <?php foreach ($units as $unit): ?>
                                            <option value="<?= $unit->uomid ?>"><?= $unit->uomname ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </td>
                                <td>
                                     <input class="form-control" type="text"  name="price" id="price">
                                </td>
                                <td>
                                     <input class="form-control" type="text"  name="amount" id="amount" readonly>
                                </td>
                                <td>
                                <button type="button" title="Add More Orders" class="btn btn-primary" id="addmoreorder">+</button>
                                </td>

                            </tr>
                             
                          </tbody>
                        </table>
                        <hr />
                      </div>
                      
                      <div class="col-md-3 offset-md-9">
                        <div class="form-group row">
                          <label for="subtotal" class="col-form-label col-md-7">Sub Total</label>
                          <input type="text" class="form-control form-control-sm col-md-5" name="subtotal" id="subtotal" value="0.00" readonly="true" tabindex="-1">
                        </div>
                       
                      </div>
                    </div>

                       
                          <div class="row">
                            <div class="col-md-12 text-right">
                              <input type="submit" class="btn btn-primary btn-lg" name="submit" id="submit" value="Submit" />
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
    <script>
    var unitsData = <?php echo json_encode($units); ?>;
</script>