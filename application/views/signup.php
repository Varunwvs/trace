<div class="register-box">
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-header text-center">
        <!-- <img src="assets/images/logo.png" alt="Kisaan Logo"> -->
        <img src="assets/images/trace-logo.png" alt="Trace Logo">
    </div>
    <div class="card-body">      
      <div class="col-12 col-sm-12">
        <ul class="nav nav-tabs" id="myTab">
            <li class="nav-item">
                <a href="#company" class="nav-link active" data-bs-toggle="tab">Company Sign Up</a>
            </li>
            <li class="nav-item">
                <a href="#rcholder" class="nav-link" data-bs-toggle="tab">RC Holder Sign Up</a>
            </li>
        </ul>
        <div class="tab-content mt-3">
          <!-- Company start -->
          <div class="tab-pane fade show active" id="company">
            <form class="needs-validation" id="companyForm" action="HomeController/comregister" method="post">
              <div class="row">
                <div class="col-xs-12 col-md-6 col-lg-6">
                  <div class="input-group mb-3">
                    <input type="text" class="form-control" name="cname" id="cname" placeholder="Company Name">
                    <div class="input-group-append">
                      <div class="input-group-text bg-green">
                        <span class="fa-regular fa-building"></span>
                      </div>
                    </div>
                  </div>
                  <div class="input-group mb-3">
                    <select class="form-control text-grey" id="category" name="category">
                      <option value="0">Select Business Category</option>
                      <?php foreach($category as $row):?>
                        <option value="<?php echo $row->id;?>"><?php echo ucwords($row->name);?></option>
                      <?php endforeach;?>
                    </select>
                    <div class="input-group-append">
                      <div class="input-group-text bg-green">
                        <span class="fa-solid fa-sitemap"></span>
                      </div>
                    </div>
                  </div>
                  <div class="input-group mb-3">
                    <input type="text" class="form-control" name="contact_person" id="contact_person" placeholder="Name of the Representative">
                    <div class="input-group-append">
                      <div class="input-group-text bg-green">
                        <span class="fas fa-user"></span>
                      </div>
                    </div>
                  </div>
                  <div class="input-group mb-3">
                    <input type="email" class="form-control" name="email" id="email" placeholder="Email" data-bs-validate="Valid email is required: ex@abc.xyz">
                    <div class="input-group-append">
                      <div class="input-group-text bg-green">
                        <span class="fas fa-envelope"></span>
                      </div>
                    </div>
                  </div>
                  <div class="input-group mb-3 hidden">
                    <input type="password" class="form-control" name="password" id="password" placeholder="Password">
                    <div class="input-group-append">
                      <div class="input-group-text bg-green">
                        <span class="fas fa-lock"></span>
                      </div>
                    </div>
                  </div>
                  <div class="input-group mb-3">
                    <input type="tel" class="form-control" name="phone" id="phone" placeholder="Mobile Number" pattern="[0-9]{10}">
                    <div class="input-group-append">
                      <div class="input-group-text bg-green">
                        <span class="fas fa-phone"></span>
                      </div>
                    </div>
                  </div>
                  <div class="input-group mb-3">
                    <input type="text" class="form-control" name="gst" id="gst" placeholder="GST Number">
                    <div class="input-group-append">
                      <div class="input-group-text bg-green">
                        <span class="fas fa-file"></span>
                      </div>
                    </div>
                  </div>
                  <div class="input-group mb-3">
                    <input type="text" class="form-control" name="website" id="website" placeholder="Website">
                    <div class="input-group-append">
                      <div class="input-group-text bg-green">
                        <span class="fas fa-globe"></span>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-xs-12 col-md-6 col-lg-6">
                  <div class="input-group mb-3 hidden">
                    <input type="text" class="form-control" name="totalproduct" id="totalproduct" value="10" readonly="true" tabindex="-1">
                    <div class="input-group-append">
                      <div class="input-group-text bg-green">
                        <span class="fas fa-box"></span>
                      </div>
                    </div>
                  </div>
                  <!-- <div class="input-group mb-3">
                     <select class="form-control col-12 text-grey" name="qr_quantity" id="qr_quantity">
                         <option value="0">QR Quantity</option>
                         <option value="200000">< 200,000</option>
                         <option value="500000">< 500,000</option>
                         <option value="1000000">< 10,00,000</option>
                     </select>
                    <div class="input-group-append" data-toggle="tooltip" 
                    data-placement="top" title="Choose slab based on number of units / QR labels quantity supplied to Dept-of-Agriculture" style="cursor: pointer;">
                      <div class="input-group-text bg-green">
                        <span class="fa-solid fa-circle-info" data-toggle="tooltip" data-placement="top" title="Choose slab based on number of units / QR labels quantity supplied to Dept-of-Agriculture"></span>
                      </div>
                    </div>
                  </div> -->
                  <div class="input-group mb-3">
                    <input type="text" class="form-control" name="state" id="state" placeholder="State">
                    <div class="input-group-append">
                      <div class="input-group-text bg-green">
                        <span class="fa-solid fa-location-dot"></span>
                      </div>
                    </div>
                  </div>
                  <div class="input-group mb-3">
                    <input type="text" class="form-control" name="city" id="city" placeholder="City">
                    <div class="input-group-append">
                      <div class="input-group-text bg-green">
                        <span class="fa-solid fa-location-dot"></span>
                      </div>
                    </div>
                  </div>
                  <div class="input-group mb-3">
                    <input type="text" class="form-control" name="pincode" id="pincode" placeholder="PIN Code">
                    <div class="input-group-append">
                      <div class="input-group-text bg-green">
                        <span class="fa-solid fa-location-dot"></span>
                      </div>
                    </div>
                  </div>
                  <div class="mb-3">
                      <textarea class="form-control" name="address" id="address" cols="30" rows="10" style="height: 146px;" placeholder="Address"></textarea>
                  </div>
                </div>
              </div>

              <div class="row mb-3">
                <!-- /.col -->
                <div class="col-12">
                  <button type="submit" name="submit" id="companysubmit" class="btn btn-primary btn-block">Sign Up</button>
                </div>
                <!-- /.col -->
              </div>
            </form> 
          </div>
          <!-- Company ends -->
          <!-- rc holder start -->
          <div class="tab-pane fade" id="rcholder">
            <form class="needs-validation" id="rcholderForm" action="HomeController/rcregister" method="post">
              <div class="row">
                <div class="col-xs-12 col-md-6 col-lg-6">
                  <div class="input-group mb-3">
                    <input type="text" class="form-control" name="rcname" id="rcname" placeholder="RC Holder Name">
                    <div class="input-group-append">
                      <div class="input-group-text bg-green">
                        <span class="fa-regular fa-building"></span>
                      </div>
                    </div>
                  </div>
                  <div class="input-group mb-3">
                    <select class="form-control text-grey" id="rccategory" name="rccategory">
                      <option value="0">Select Business Category</option>
                      <?php foreach($rccategory as $row):?>
                        <option value="<?php echo $row->id;?>"><?php echo ucwords($row->name);?></option>
                      <?php endforeach;?>
                    </select>
                    <div class="input-group-append">
                      <div class="input-group-text bg-green">
                        <span class="fa-solid fa-sitemap"></span>
                      </div>
                    </div>
                  </div>
                  <div class="input-group mb-3">
                    <input type="text" class="form-control" name="rccontact_person" id="rccontact_person" placeholder="Name of the Representative">
                    <div class="input-group-append">
                      <div class="input-group-text bg-green">
                        <span class="fas fa-user"></span>
                      </div>
                    </div>
                  </div>
                  <div class="input-group mb-3">
                    <input type="email" class="form-control" name="rcemail" id="rcemail" placeholder="Email" data-bs-validate="Valid email is required: ex@abc.xyz">
                    <div class="input-group-append">
                      <div class="input-group-text bg-green">
                        <span class="fas fa-envelope"></span>
                      </div>
                    </div>
                  </div>
                  <div class="input-group mb-3 hidden">
                    <input type="password" class="form-control" name="rcpassword" id="rcpassword" placeholder="Password">
                    <div class="input-group-append">
                      <div class="input-group-text bg-green">
                        <span class="fas fa-lock"></span>
                      </div>
                    </div>
                  </div>
                  <div class="input-group mb-3">
                    <input type="tel" class="form-control" name="rcphone" id="rcphone" placeholder="Mobile Number" pattern="[0-9]{10}">
                    <div class="input-group-append">
                      <div class="input-group-text bg-green">
                        <span class="fas fa-phone"></span>
                      </div>
                    </div>
                  </div>
                  <div class="input-group mb-3">
                    <input type="text" class="form-control" name="rcgst" id="rcgst" pattern="^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}$" placeholder="GST Number">
                    <div class="input-group-append">
                      <div class="input-group-text bg-green">
                        <span class="fas fa-file"></span>
                      </div>
                    </div>
                  </div>
                  <div class="input-group mb-3">
                    <input type="text" class="form-control" name="rcwebsite" id="rcwebsite" placeholder="Website">
                    <div class="input-group-append">
                      <div class="input-group-text bg-green">
                        <span class="fas fa-globe"></span>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-xs-12 col-md-6 col-lg-6">
                  <div class="input-group mb-3 hidden">
                      <input type="text" class="form-control" name="rctotalproduct" id="rctotalproduct" value="10" readonly="true" tabindex="-1">
                      <div class="input-group-append">
                        <div class="input-group-text bg-green">
                          <span class="fas fa-box"></span>
                        </div>
                      </div>
                  </div>
                  <!-- <div class="input-group mb-3">
                     <select class="form-control col-12" name="rcqr_quantity" id="rcqr_quantity" placeholder="Qr Quantity">
                         <option value="0">QR Quantity</option>
                         <option value="200000">< 200,000</option>
                         <option value="500000">< 500,000</option>
                         <option value="1000000">< 10,00,000</option>
                     </select>
                    <div class="input-group-append" data-toggle="tooltip" 
                    data-placement="top" title="Choose slab based on number of units / QR labels quantity supplied to Dept-of-Agriculture" style="cursor: pointer;">
                      <div class="input-group-text bg-green">
                        <span class="fa-solid fa-circle-info" data-toggle="tooltip" data-placement="top" title="Choose slab based on number of units / QR labels quantity supplied to Dept-of-Agriculture"></span>
                      </div>
                    </div>
                  </div> -->
                  <div class="input-group mb-3">
                      <input type="text" class="form-control" name="rcstate" id="rcstate" placeholder="State">
                      <div class="input-group-append">
                        <div class="input-group-text bg-green">
                          <span class="fa-solid fa-location-dot"></span>
                        </div>
                      </div>
                  </div>
                  <div class="input-group mb-3">
                      <input type="text" class="form-control" name="rccity" id="rccity" placeholder="City">
                      <div class="input-group-append">
                        <div class="input-group-text bg-green">
                          <span class="fa-solid fa-location-dot"></span>
                        </div>
                      </div>
                  </div>
                  <div class="input-group mb-3">
                      <input type="text" class="form-control" name="rcpincode" id="rcpincode" placeholder="PIN Code">
                      <div class="input-group-append">
                        <div class="input-group-text bg-green">
                          <span class="fa-solid fa-location-dot"></span>
                        </div>
                      </div>
                  </div>
                  <div class="mb-3">
                      <textarea class="form-control" name="rcaddress" id="rcaddress" cols="30" rows="10" style="height: 146px;" placeholder="Address"></textarea>
                  </div>
                </div>
              </div>

              <div class="row mb-3">
                <!-- /.col -->
                <div class="col-12">
                  <button type="submit" name="submit" id="rcholdersubmit" class="btn btn-primary btn-block">Sign Up</button>
                </div>
                <!-- /.col -->
              </div>
            </form> 
          </div>
          <!-- rc holder ends -->
        </div>               
      </div>           
      <p class="mb-0 text-center">
        Already have account? <a href="home" class="text-center">Login</a>
      </p>
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
</div>

<!-- jQuery -->
<script src="<?php echo base_url('assets/plugins/jquery/jquery.min.js')?>"></script>
<script>
  $(document).ready(function() {
  //Submit Form Using Ajax
  $("#companysubmit").on('click', function(e) {
    // remove the error 
    $("#cname").css({"border-color": "gray"});
    $(".text-danger").remove();
    // submit form
    $("#companyForm").unbind('submit').bind('submit', function() {
      $(".text-danger").remove();
      var form = $(this);
      // validation
      var cname = $("#cname").val();
      if(cname == "") {
        $("#cname").css({"border-color": "red"});
      } else {
        $("#cname").css({"border-color": "gray"});       
      }

      if(cname) {
        //submi the form to server
        $.ajax({
          url : form.attr('action'),
          type : form.attr('method'),
          data : form.serialize(),
          dataType : 'json',
          success:function(response) {

            // remove the error 
            $("#cname").css({"border-color": "gray"});

            if(response.success == true) {
              $("#companyForm")[0].reset();
              Swal.fire({
                icon: 'success',
                title: 'Good Job!',
                text: 'Company Added Successfully! For more info contact us!',
                showConfirmButton: false,
                timer: 5000
              }) 
              setTimeout(function () {
                document.location.href='home';
              }, 5000);
            } else {
                Swal.fire({
                icon: 'error',
                title: 'Ooops...',
                text: response.messages,
                showConfirmButton: false,
                timer: 5000,
                showClass: {popup: 'animate__animated animate__fadeInDown'},
                hideClass: {popup: 'animate__animated animate__fadeOutUp'}
              })
              }  // /else
          } // success  
        }); // ajax subit         
      } /// if
      return false;
    }); // /submit form for create member
  }); // /add company

  //Submit Form Using Ajax
  $("#rcholdersubmit").on('click', function(e) {
    // remove the error 
    $("#rcname").css({"border-color": "gray"});
    $(".text-danger").remove();
    // submit form
    $("#rcholderForm").unbind('submit').bind('submit', function() {
      $(".text-danger").remove();
      var form = $(this);
      // validation
      var rcname = $("#rcname").val();
      if(rcname == "") {
        $("#rcname").css({"border-color": "red"});
      } else {
        $("#rcname").css({"border-color": "gray"});       
      }

      if(rcname) {
        //submi the form to server
        $.ajax({
          url : form.attr('action'),
          type : form.attr('method'),
          data : form.serialize(),
          dataType : 'json',
          success:function(response) {

            // remove the error 
            $("#rcname").css({"border-color": "gray"});

            if(response.success == true) {
              $("#rcholderForm")[0].reset();
              Swal.fire({
                icon: 'success',
                title: 'Good Job!',
                text: 'RC Holder Added Successfully! For more info contact us!',                
                showConfirmButton: false,
                timer: 5000
              }) 
              setTimeout(function () {
                document.location.href='home';
              }, 5000);
            } else {
                Swal.fire({
                icon: 'error',
                title: 'Ooops...',
                text: response.messages,
                showConfirmButton: false,
                timer: 5000,
                showClass: {popup: 'animate__animated animate__fadeInDown'},
                hideClass: {popup: 'animate__animated animate__fadeOutUp'}
              })
              }  // /else
          } // success  
        }); // ajax subit         
      } /// if
      return false;
    }); // /submit form for create member
  }); // /add company
});



</script>