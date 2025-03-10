
<style>
    /* Style for the popup */
    .popup {
      display: none;
      position: fixed;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      background-color: white;
      padding: 20px;
      border: 1px solid #ccc;
      z-index: 1000;
    }

    /* Style for the overlay background */
    .overlay {
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.7);
      z-index: 900;
    }

    /* Style for the close button */
    .close {
      position: absolute;
      top: 10px;
      right: 10px;
      cursor: pointer;
    }
    .logo-img{
        margin-bottom: 0rem;
        padding-bottom: 0rem;
        border-bottom: none;
    }
    @media screen and (max-width: 767px){
        .company-box .card h5 {
            font-size: 1.375rem;
            font-weight: 500;
            color: #3e99c1;
        }
        .logo-img {
            margin-bottom: 1rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #888686;
        }
        .mmb{
            border-bottom: 1px solid #888888;
            margin-bottom: 1rem;
        }
    }
  </style>

<div class="company-box" style="height:100vh;">
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-header text-center text-white p-4" style="background: #74A731;">
        <h1>KisaanQR Information System(KQRIS)</h1>
    </div>
    <div class="card-body mt-3 mb-3">
        <div class="col-12">
            <div class="row"> 
                <!--<div class="col-lg-12 col-sm-12 pl-5 pr-5 logo-img">-->
                <!--    <div class="row text-center">-->
                <!--        <div class="col-sm-12">-->
                <!--            <img src="<?php echo base_url();?>/uploads/logo.png" alt="company logo">-->
                <!--        </div>-->
                <!--    </div>-->
                <!--</div>-->
                <!--<div class="col-lg-12 col-sm-12 pl-5 pr-5 mt-3">-->
                <!--    <div class="row">-->
                <!--        <div class="col-sm-6 mmb">-->
                <!--            <h5>NAME OF THE MANUFACTURER</h5>-->
                <!--            <p></p>-->
                <!--            <p></p>-->
                <!--        </div>-->
                <!--    </div>-->
                <!--</div>-->
                <div class="col-lg-12 col-sm-12 pl-5 pr-5 mt-5">
                    <div class="row">
                        <div class="col-sm-6 mmb">
                            <h5>PRODUCT NAME</h5>
                            <p>Sunflower Seeds</p>
                        </div>
                        <div class="col-sm-6 mmb">
                            <h5>U.I.D(Unique ID No.)</h5>
                            <p>SED001</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 col-sm-12 pl-5 pr-5">
                    <div class="row">
                        <div class="col-sm-6 mmb">
                            <h5>PRODUCT ID</h5>
                            <p>2312001</p>
                        </div>
                        <div class="col-sm-6 mmb">
                            <h5>BATCH NUMBER</h5>
                            <p>01</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 col-sm-12 pl-5 pr-5">
                    <div class="row">
                        <div class="col-sm-6 mmb">
                            <h5>MFG. Date</h5>
                            <p>01-09-2023</p>
                        </div>
                        <div class="col-sm-6 mmb">
                            <h5>EXPIRY DATE</h5>
                            <p>01-09-2028</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 col-sm-12 pl-5 pr-5">
                    <div class="row">
                        <div class="col-sm-6 mmb">
                            <h5>MANUFACTURED BY</h5>
                            <p>Pstest</p>
                        </div>
                        <div class="col-sm-6 mmb">
                            <h5>MARKETED BY</h5>
                            <p>Pstest</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 col-sm-12 pl-5 pr-5">
                    <div class="row">
                        <div class="col-sm-6 mmb">
                            <h5>Pure Seed (Min):</h5>
                            <p>98</p>
                        </div>
                        <div class="col-sm-6 mmb">
                            <h5>Germination (Min):</h5>
                            <p>70</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 col-sm-12 pl-5 pr-5">
                    <div class="row">
                        <div class="col-sm-6 mmb">
                            <h5>Gen. Purity (Min):</h5>
                            <p>98</p>
                        </div>
                        <div class="col-sm-6 mmb">
                            <h5>Moisture (Max):</h5>
                            <p>12</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 col-sm-12 pl-5 pr-5">
                    <div class="row">
                        <div class="col-sm-6 mmb">
                            <h5>Inert Matter (Max):</h5>
                            <p>2</p>
                        </div>
                        <div class="col-sm-6 mmb">
                            <h5>Other Crop Seed (Max):</h5>
                            <p>1</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 col-sm-12 pl-5 pr-5">
                    <div class="row">
                        <div class="col-sm-6 mmb">
                            <h5>Weed Seed (Max):</h5>
                            <p>1</p>
                        </div>
                        <div class="col-sm-6 mmb">
                            <h5>CUSTOMER CARE CONTACT DETAILS</h5>
                            <p><i class="fas fa-mobile"></i> : 8789324125</p>
                            <p><i class="fas fa-envelope"></i> : pstest@gmail.com</p>
                            <p><i class="fas fa-map-pin"></i> : BSK 3rd stage, Bangalore, Karnataka-560031</p>
                        </div>
                    </div>
                </div>
                
                
            </div>
        </div>
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
</div>
<!-- /.company-box -->  
<div class="overlay" id="overlay"></div>
  <div class="popup" id="popup">
    <span class="close" onclick="closePopup()">&times;</span>
    
    
</div>
<script>
    // Function to open the popup
    function openPopup() {
      document.getElementById('overlay').style.display = 'block';
      document.getElementById('popup').style.display = 'block';
    }

    // Function to close the popup
    function closePopup() {
      document.getElementById('overlay').style.display = 'none';
      document.getElementById('popup').style.display = 'none';
    }

    // Attach click event to the link
    document.getElementById('openPopup').addEventListener('click', openPopup);
  </script>