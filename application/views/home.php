<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap');
  *{
    font-family:inter;
  }
  .card{
    box-shadow:none !important;
  }
  ul.notice li {
    padding: 0.875rem 2rem 0.475rem 0rem;
    text-align: justify;
    border-bottom: 1px solid #adacac;
  }
  input[type="email"], input[type="password"], .input-group-text {
    border: none;
  }
  .carousel-control-next, .carousel-control-prev {
    top: 60px !important;
    width: 8% !important;
}
</style>
<div class="container-fluid">
  <div class="row justify-content-center align-items-center vh-100">
    <div class="col-lg-10 bg-white m-0 p-5">
      <div class="row justify-content-between align-items-start">
        <div class="col-lg-auto">
          <div class="d-flex gap-2 align-items-center">
            <!--<img src="https://cdn.builder.io/api/v1/image/assets/TEMP/e089262c27c2155bf0e91cb0d12878d629fde19251102da1d0f1b9ff2976b5f1?" class="img-fluid" alt="Logo">-->
                <img src="<?php echo base_url('assets/images/trace-logo.png') ?>" class="img-fluid" alt="Logo">
            <div class="bg-light rounded px-2 py-1">V1.0</div>
          </div>
        </div>
        <div class="col-lg-auto hidden">
          <div class="d-flex gap-2 align-items-center">
            <img src="https://cdn.builder.io/api/v1/image/assets/TEMP/3dff9645f6718e64c653f2dc56e4108578f3d3f07338eb60f64aefb943c591cf?" class="img-fluid" alt="See Documentation">
            <div class="text-center">See Documentation</div>
          </div>
        </div>
      </div>

      <div class="row mt-5">
        <div class="col-lg-8">
          <div class="card pr-2">
            <div class="card-header hidden">
              <h2 class="card-title fw-bold"><i class="text-green fa-solid fa-list pr-2"></i> Product Highlights</h2>
            </div>
            <div class="card-body">   
              <div id="carouselExampleSlidesOnly" class="carousel slide carousel-fade" data-bs-ride="carousel">
                <div class="carousel-inner">
                  <div class="carousel-item active">
                    <img src="assets/images/trace-slide-1.png" class="d-block w-100" alt="...">
                  </div>
                  <div class="carousel-item">
                    <img src="assets/images/trace-slide-2.png" class="d-block w-100" alt="...">
                  </div>
                  <div class="carousel-item">
                    <img src="assets/images/trace-slide-3.png" class="d-block w-100" alt="...">
                  </div>
                  <!-- <div class="carousel-item">
                    <img src="assets/images/Slide-4.png" class="d-block w-100" alt="...">
                  </div> -->
                </div>
              </div>   
              <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleSlidesOnly" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
              </button>
              <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleSlidesOnly" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
              </button>
            </div>
          </div>
          <div class="card mt-4">
            <div class="card-header">
              <h2 class="card-title fw-bold"><i class="text-green fa-solid fa-bell pr-2"></i> Notifications</h2>
            </div>
            <div class="card-body">
              <ul class="notice">
                <!--<li>Kisaan QR V2.0 is Live - <span class="text-primary">See What’s New?</span></li>-->
                <li>Kindly renew your KisaanQR subscription for FY2024-25 to proceed with Account activation and QR code generation. 
                Ignore if already done.</li>
              </ul>
            </div>
          </div>
        </div>

        <div class="col-lg-4 rounded p-3" style="background-color: #e9e9e9 !important;">
          <div class="card" style="background:transparent;">
            <div class="card-body">
              <h3 class="fw-bold text-center">Welcome to Scalion Trace</h3>
              <p class="login-box-msg text-center">Login to your account</p>
              <p id="message" class="text-xs text-left text-danger"></p>
              <form id="loginForm" method="post">
                <div class="input-group mb-3">
                  <div class="input-group-append">
                    <div class="input-group-text bg-white">
                      <span class="fas fa-envelope text-grey"></span>
                    </div>
                  </div>
                  <input type="email" class="form-control" name="username" id="username" placeholder="Email" data-bs-validate="Valid email is required: ex@abc.xyz">
                  
                </div>

                <div id="passwordSection">
                  <div class="input-group mb-3" >
                    <div class="input-group-append">
                      <div class="input-group-text bg-white">
                        <span class="fas fa-key text-grey"></span>
                      </div>
                    </div>
                    <input type="password" class="form-control" name="password" id="password" placeholder="Password">
                    <span style="position: absolute;right: 10px;transform: translate(0,-50%);top: 50%;cursor: pointer;z-index: 1000;">
                        <i class="fa fa-eye toggle-password text-grey" id="eye"></i>   
                    </span>    

                  </div> 
                  <!-- <div class="col-12 text-center ">
                    <button type="button" id="verifyPassword" class="btn btn-success fw-bold mt-2 text-center">LOGIN</button>
                  </div> -->

                </div>

                <div class="row mb-3">
                  <!-- /.col -->
                  <div class="col-12 text-center ">
                    <button type="submit" name="submit" id="submit" class="btn btn-primary fw-bold btn-block">LOGIN</button>
                  </div>
                  <!-- /.col -->
                </div>

                <!-- <div id="otpSection" class="row mb-3" style="display: none;">
                    <input type="text" class="form-control" name="otp" id="otp" placeholder="Enter OTP" required>
                    <button type="button" id="verifyOtp" class="btn btn-primary btn-block fw-bold mt-2">Submit OTP</button>
                </div> -->
              </form> 
              <p class="mb-3 text-center">
                Forgot your password ? <a class="text-primary" target="_blank" href="https://wa.me/919901577087/">Reset</a>
              </p>
              <p class="mb-0 text-center">
                Not Registered Yet ? <a href="signup" class="text-center text-primary">Register Now</a>
              </p>


            </div>
          </div>          
        </div>
        <div class="col-lg-4">&nbsp;</div>
      </div>

      <div class="mt-5">
        <!-- Add your content here -->
      </div>

      
      

     
    </div>

    <div style="background-image: url(assets/images/Footer-background-green.png);">
          <div class="row mt-2 p-5 text-green" >
              <div class="col-md-4 mt-3">
                <!-- Logo and Social Media Links -->
                <div>
                <img src="<?php echo base_url('assets/images/Scalion - Logo - White.png') ?>" width="200px" height="50px" class="img-fluid mb-3" alt="Logo">
                <div>
                    <a href="https://www.linkedin.com/company/scalioncommerce/" target="_blank" 
                        style="background: blue; color: white; padding: 10px; border-radius: 50%; width: 40px; height: 40px; 
                              display: inline-flex; align-items: center; justify-content: center; text-decoration: none; margin-right: 10px;">
                        <i class="fab fa-linkedin fa-lg"></i>
                    </a>

                    <a href="https://www.instagram.com/scalion_commerce/#" target="_blank" 
                        style="background: blue; color: white; padding: 10px; border-radius: 50%; width: 40px; height: 40px; 
                              display: inline-flex; align-items: center; justify-content: center; text-decoration: none;">
                        <i class="fab fa-instagram fa-lg"></i>
                    </a>
                </div>

                </div>
              </div>
              <div class="col-md-4 mt-3">
                <!-- Quick Links -->
                <div>
                  <h5>PLATFORM</h5>
                  <ul class="list-unstyled" >
                    <li><a style="color: white; " href="https://scalion.com/" target="_blank">Scalion</a></li>
                    <li><a style="color: white; " href="<?php echo base_url() ?>" target="_blank">Trace</a></li>
                  </ul>
                </div>
              </div>

              <div class="col-md-4 mt-3">
                <!-- Contact Info -->
                <div>
                <h5>GET IN TOUCH</h5>

                    <h6 style="color: white; display: flex; align-items: center;">
                        <span style="background: blue; color: white; padding: 6px; border-radius: 50%; width: 30px; height: 30px; display: flex; align-items: center; justify-content: center; font-size: 14px; margin-right: 10px;">
                            <i class="fas fa-map-marker-alt"></i>
                        </span>
                        Office Address
                    </h6>
                    <p>
                        <a style="color: white;" href="https://maps.app.goo.gl/JpwcJkAUVpDbaJia9" target="_blank">
                            #120, 2nd Floor, Amba Complex, Dr. Rajkumar Road, Rajajinagar, Bengaluru, Karnataka – 560010
                        </a>
                    </p>

                    <h6 style="color: white; display: flex; align-items: center;">
                        <span style="background: blue; color: white; padding: 6px; border-radius: 50%; width: 30px; height: 30px; display: flex; align-items: center; justify-content: center; font-size: 14px; margin-right: 10px;">
                            <i class="fas fa-phone"></i>
                        </span>
                        Mobile
                    </h6>
                    <p>
                        <a style="color: white;" href="tel:+917760807087">+91-7760807087</a>
                    </p>

                    <h6 style="color: white; display: flex; align-items: center;">
                        <span style="background: blue; color: white; padding: 6px; border-radius: 50%; width: 30px; height: 30px; display: flex; align-items: center; justify-content: center; font-size: 14px; margin-right: 10px;">
                            <i class="fas fa-envelope"></i>
                        </span>
                        Email
                    </h6>
                    <p>
                        <a style="color: white;" href="mailto:shree@scalion.com">shree@scalion.com</a>
                    </p>

                </div>
              </div>
            </div>

            <div class="row text-white" >
              <div class="col text-center">
              ©️2025 Scalion Commerce Pvt. Ltd.
              </div>
            </div>
      </div>

   

    


  </div>

  


  


</div>


<!-- jQuery -->
<script src="<?php echo base_url('assets/plugins/jquery/jquery.min.js')?>"></script>
<script>
  $(document).on('click', '.toggle-password', function() {
    $(this).toggleClass("fa-eye fa-eye-slash");
    var input = $("#password");
    input.attr('type') === 'password' ? input.attr('type','text') : input.attr('type','password')
  });
  $(document).ready(function(){      
    $("#submit").click(function(){  
      var user_name = $("#username").val();  
      var password = $("#password").val();  
      // Returns error message when submitted without req fields.  
      if(user_name==''|| password==''){  
        $("#message").html("- Please Enter valid User Name & Password!"); 
        $("input").css({"border-color": "red"});
      } else{  
          // AJAX Code To Submit Form.  
          $.ajax({  
            type: "POST",  
            url:  "<?php echo base_url(); ?>" + "HomeController/check_login",  
            data: {name: user_name, pwd: password},  
            cache: false,  
            success: function(result){  
              if(result!=0){  
                // On success redirect.  
                window.location.replace(result);  
                $("input").css({"border-color": "none"});
              } else{
                  $("#message").html("- Ooops! either user name or password is incorrect."); 
                  $("input").css({"border-color": "red"});
              }           
            }  
          });  
        }  
      return false;  
      
//to check username(email)
  /*     var user_name = $("#username").val();  

      if(user_name==''){  
        $("#message").html("- Please Enter valid User Name"); 
        $("input").css({"border-color": "red"});
      } else{ 

      $.ajax({  
            type: "POST",  
            url:  "<?php echo base_url(); ?>" + "HomeController/check_login",  
            data: {name: user_name},  
            cache: false,  
            success: function(result){  
              console.log(result);
              if(result==0){  
                $("#message").html("- Ooops! username is invalid or not correct."); 
                $("input").css({"border-color": "red"});
              } else if(result=='success'){
                    alert('OTP sent successfully! Please check your email.');
                    $('#otpSection').show();
                    $('#submit').hide(); 
                    $('#username').attr('readonly');
              }else if(result=='failed'){
                $("#message").html("Please check is email valid? Contact admin."); 
                $("input").css({"border-color": "red"});
              }else if(result=='test_emails'){
                    $('#passwordSection').show();
                    $('#submit').hide(); 
              }else if(result!=0){
                // On success redirect.  
                window.location.replace(result);  
                $("input").css({"border-color": "none"});
              }
              else{
                alert('Failed to send OTP! Please try to login again.');
              }           
            }  
          });  

        }
        return false; */

    });  

//to verify OTP    
    $('#verifyOtp').on('click', function() {
        var user_name = $("#username").val();  
        var otp = $('#otp').val();

        if(otp == '') {
            alert('Please enter the OTP.');
            return;
        }

    $.ajax({
            url:"<?php echo base_url(); ?>" + "HomeController/verify_login_otp",  
            type: 'POST',
            data: { otp: otp, name:user_name },
            success: function(result){  
              console.log(result);
              if(result=='otp_invalid'){  
                $("#message").html("- Invalid OTP. Please try again."); 
              }else if(result=='timeUp'){
                $("#message").html("- OTP Expired - Please try again"); 
                $("input").css({"border-color": "red"});
              }else if(result!=0){
                // On success redirect.  
                window.location.replace(result);  
                $("input").css({"border-color": "none"});

              } else{
                  $("#message").html("- Ooops! Something went wrong. Please try again"); 
                  $("input").css({"border-color": "red"});
              }     
           
            } 
        });
      });

// for password - test emails
      $('#verifyPassword').on('click', function() {
       var user_name = $("#username").val();  
      var password = $("#password").val();  
      // Returns error message when submitted without req fields.  
      if(user_name==''|| password==''){  
        $("#message").html("- Please Enter valid User Name & Password!"); 
        $("input").css({"border-color": "red"});
      } else{  
          // AJAX Code To Submit Form.  
          $.ajax({  
            type: "POST",  
            url:  "<?php echo base_url(); ?>" + "HomeController/check_password_login",  
            data: {name: user_name, pwd: password},  
            cache: false,  
            success: function(result){  
              if(result!=0){  
                // On success redirect.  
                window.location.replace(result);  
                $("input").css({"border-color": "none"});
              } else{
                  $("#message").html("- Ooops! either user name or password is incorrect."); 
                  $("input").css({"border-color": "red"});
              }           
            }  
          });  
        }  
      return false;  

      });


  });  
</script>