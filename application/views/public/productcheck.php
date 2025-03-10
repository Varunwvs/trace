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
.right-align {
    float: right;
}

</style>
<div class="container-fluid">
  <div class="row justify-content-center align-items-center vh-100">
    <div class="col-lg-10 bg-white m-0 p-5">
      <div class="row justify-content-between align-items-start">
        <div class="col-lg-auto">
          <div class="d-flex gap-2 align-items-center">
            <!-- <img src="https://cdn.builder.io/api/v1/image/assets/TEMP/e089262c27c2155bf0e91cb0d12878d629fde19251102da1d0f1b9ff2976b5f1?" class="img-fluid" alt="Logo"> -->
            <img src="<?= base_url( '/assets/pharma_images/Logo-PharmaQR.png') ?>" class="img-fluid" alt="Logo">
            <div class="bg-light rounded px-2 py-1">V2.0</div>
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
        
        <!-- Form column to be aligned to the right -->
        <div class="col-lg-6">
          <div class="p-3" >
            <form id="searchForm" method="post">
              <div class="row">
                <div class="col-sm-12 mb-3 form-group" id="product_div">
                  <label for="p_code" class="form-label">Product Code :</label>
                  <input class="form-control" type="text" name="p_code" id="p_code" required>
                </div>
              </div>     

              <div class="row mb-3 mt-3">
                   <div class="col-md-12 text-right">
                        <input type="submit" class="btn btn-primary btn-md" name="submit" id="prod_submit" value="Submit">
                    </div>                                
                </div> 
            </form>
          </div>

          <hr>

        </div>
        <div id="resultContainer" class="mt-3 col-lg-12">

          <!-- The result from AJAX call will be rendered here(for only product details) -->
        </div>


      </div>

     
    </div>

    <div class="row mt-5">
        <div class="col text-center">
          © 2024 | World Vision Softek
        </div>
      </div>

  </div>
</div>

<!-- jQuery -->
<script src="<?php echo base_url('assets/plugins/jquery/jquery.min.js')?>"></script>
<script>

$("#prod_submit").click(function(e){
    e.preventDefault();

    var p_code = $('#p_code').val();

        $.ajax({
            type: "POST",
            url: "<?= base_url('getProductData') ?>",
            data: {product_code: p_code},
            cache: false,  
            success: function(result){
               
              console.log(result);


              var data = JSON.parse(result);

              $('#resultContainer').show();

              var html = '';

              // Check if the data contains valid product details
              if(data == null){
                  html += '<div class="alert alert-danger">Product code is wrong or data is not present. Please try again.</div>';
              } else {

                
                html += '<div class="row">';
                  
                //Image
                    html += '<div class="col-lg-6">';
                    if (data['product_image']) {
                      // html += '<img src="' + data['product_image'] + '" class="img-fluid" alt="Product Image">';
                      html += '<img src="<?= base_url('/assets/pharma_images/') ?>' + data['product_image'] + '" class="img-fluid" alt="Product Image">';
                      console.log(data['product_image']);
                    } 
                    html += '</div>';
            
                 //table
                    html += '<div class="col-lg-6">';
                    html += '<div style="text-align: center;">';
                    html += '<h6 style="color: green">Product Qualification Successful</h6>';
            
                    if (data['Generic name of the drug']) {
                      html += '<p style="font-weight: bold;">' + data['Generic name of the drug'] + '</p>';
                    }
            
                    html += '</div>';
                    html += '<p style="color: green">Product Details</p>';
                    html += '<table class="table table-hover">';
            
                    $.each(data, function(key, value) {
                      if (key !== 'product_image') {
                            html += '<tr><td><strong>' + key + '</strong></td><td>' + value + '</td></tr>';
                        }
                      // html += '<tr><td><strong>' + key + '</strong></td><td>' + value + '</td></tr>';
                    });
            
                    html += '</table>';
                    html += '</div>';  
            
                    html += '</div>';  // end row
                  }
            
                  $('#resultContainer').html(html);
            
            },
            error: function(xhr, status, error){
                console.error("An error occurred: " + xhr.responseText);
            }
        });
    
});



</script>
