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
            <img src="https://cdn.builder.io/api/v1/image/assets/TEMP/e089262c27c2155bf0e91cb0d12878d629fde19251102da1d0f1b9ff2976b5f1?" class="img-fluid" alt="Logo">
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
        <div class="col-lg-3 rounded p-2" style="background-color: #e9e9e9 !important;">
          <div class="card" style="background:transparent;">
            <div class="card-body">
              <div class="col-lg-12 mt-3">
                <div class="list-group">
                  <button class="list-group-item list-group-item-action" id="product_detail"> - Product Detail</button>
                  <button class="list-group-item list-group-item-action mt-3" id="primary_detail"> - Primary Detail</button>
                </div>
              </div>  
            </div>
          </div>          
        </div>
        
        <!-- Empty space column to add space between the left card and the form -->
        <div class="col-lg-2">&nbsp;</div>

        <!-- Form column to be aligned to the right -->
        <div class="col-lg-6">
          <div class="p-3" >
            <form id="searchForm" method="post">
              <div class="row">
                <div class="col-sm-6 mb-3 form-group" id="product_div">
                  <label for="p_code" class="form-label">Product Code :</label>
                  <input class="form-control" type="text" name="p_code" id="p_code" required>
                </div>
              </div>     
              <div class="row" id="primary_div">
                <div class="col-sm-6 mb-3 form-group">
                  <label for="category" class="form-label">Category :</label>
                  <select class="form-control form-select" name="category" id="category" required>
                    <option value="" disabled selected>Select Category</option>
                    <option value="Seeds">Seeds</option>
                    <option value="Fertilizer">Fertilizer</option>
                    <option value="Pesticide">Pesticide</option>
                    <option value="Tarpaulin">Tarpaulin</option>
                    <option value="Micro Irrigation">Micro Irrigation</option>
                  </select>
                </div>
                <div class="col-sm-6 mb-3 form-group">
                  <label for="alias_no" class="form-label">Alias No. :</label>
                  <input class="form-control" type="text" name="alias_no" id="alias_no" required>
                  <small>*Please enter your vendor code with alias no(Eg. 10xxxxxxxx)*</small>
                </div>
              </div>  
              <input type="hidden" name="detail_type" id="detail_type" value="">

              <div class="row mb-3 mt-3">
                   <div class="col-md-12 text-right">
                        <input type="submit" class="btn btn-primary btn-md" name="submit" id="submit" value="Submit">
                    </div>                                
                </div> 
            </form>
          </div>

          <hr>

          <div id="errorContainer" class="mt-3">
            <!-- Only for errors -->
          </div>

          <div id="resultContainer" class="mt-3">
              <!-- The result from AJAX call will be rendered here(for only product details) -->
          </div>

        </div>


        <div class="row" id="primaryDetailContainer">
              <!-- The result from AJAX call will be rendered here(for alias details with product details) -->
              <div class="col-md-6 mb-3">
            <div id="aliasDetailsTable"></div> 
          </div>

          <div class="col-md-6 mb-3">
            <div id="productDetailsTable"></div>
          </div>
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

$(document).ready(function(){
  $('#primary_div').hide().find('input, select').prop('required', false); 
  $('#product_div').show().find('input').prop('required', true);
$('#detail_type').val('product_detail');
})

$("#product_detail").click(function (e) { 
    e.preventDefault();
    $('#primary_div').hide().find('input, select').prop('required', false); 
    $('#product_div').show().find('input').prop('required', true);
$('#detail_type').val('product_detail');
    
});

$("#primary_detail").click(function (e) { 
    e.preventDefault();
    
    $('#product_div').hide().find('input').prop('required', false); 
    $('#primary_div').show().find('input, select').prop('required', true); 
    $('#detail_type').val('primary_detail');
});

$('#category').change(function(){
        var selectedCategory = $(this).val();
        // console.log(selectedCategory);
        if (selectedCategory == "Micro Irrigation") {
            $('#detail_type').val('primary_detailMi');
        } else {
            $('#detail_type').val('primary_detail');
        }
});

$("#searchForm").click(function(e){
    e.preventDefault();

    if(!this.checkValidity()){
        this.reportValidity();
        return; 
    }

    var detail_type = $('#detail_type').val();
    var p_code = $('#p_code').val();
    var alias_no = $('#alias_no').val();

// console.log(detail_type);
// console.log(p_code);
// console.log(alias_no);


        $.ajax({
            type: "POST",
            url: "<?= base_url('getApiData') ?>",
            data: {product_code: p_code,alias_no: alias_no, type: detail_type},
            cache: false,  
            success: function(result){
               
              try{
              // console.log(result);
              var data=JSON.parse(result);

              if(detail_type=='product_detail'){

                var product_details = JSON.parse(data['product_details']);
                var uom_details = JSON.parse(data['uom_details']);

                var uomMap = {};
                uom_details.forEach(function(uom) {
                    uomMap[uom.UomID] = uom.UomName;
                });

                // Check if UomID exists in product_details and replace it with UomName
                if (product_details.UomID && uomMap[product_details.UomID]) {
                    product_details.UomID = uomMap[product_details.UomID];
                }

               
                // console.log(product_details);
                // console.log(uom_details);

                $('#primaryDetailContainer').hide();
                $('#errorContainer').hide();
                $('#resultContainer').show();

                var keysToRemove = ['ManufacturerID', 'ItemCategoryID', 'SubCategoryID','ItemID','SeedClassID'];

                keysToRemove.forEach(function(key) {
                    delete product_details[key];
                });

                var html ='';

                if(product_details['ProductCode']==null){
                   html +='<div class="alert alert-danger">Product code is wrong or data is not with the department. Please try again.</div>';
                }

                html +='Product Details';
                html += '<table class="table table-bordered">';
                html += '<tr><th>Field</th><th>Value</th></tr>';
                $.each(product_details, function(key, value) {
                    html += '<tr><td>' + key + '</td><td>' + value + '</td></tr>';
                });
                html += '</table>';

                $('#resultContainer').html(html);

              }else{

                $('#primaryDetailContainer').show();
                $('#resultContainer').hide();

                //Alias table
                var alias_details=JSON.parse(data['alias_details']);
              
                
                var aliasTableHTML ='Alias Details';
                aliasTableHTML += '<table class="table table-bordered">';
                aliasTableHTML += '<tr><th>Field</th><th>Value</th></tr>';
                $.each(alias_details, function(key, value) {
                  aliasTableHTML += '<tr><td>' + key + '</td><td>' + value + '</td></tr>';
                });
                aliasTableHTML += '</table>';

                $('#aliasDetailsTable').html(aliasTableHTML);

                //Product details table
                var product_details = JSON.parse(data['product_details']);


                var uom_details = JSON.parse(data['uom_details']);

                var uomMap = {};
                uom_details.forEach(function(uom) {
                    uomMap[uom.UomID] = uom.UomName;
                });

                // Check if UomID exists in product_details and replace it with UomName
                if (product_details.UomID && uomMap[product_details.UomID]) {
                    product_details.UomID = uomMap[product_details.UomID];
                }


                var keysToRemove = ['ManufacturerID', 'ItemCategoryID', 'SubCategoryID','ItemID','SeedClassID'];

                keysToRemove.forEach(function(key) {
                    delete product_details[key];
                });

                var productTableHTML = 'Product Details';
                productTableHTML += '<table class="table table-bordered">';
                productTableHTML += '<tr><th>Field</th><th>Value</th></tr>';
                $.each(product_details, function(key, value) {
                  productTableHTML += '<tr><td>' + key + '</td><td>' + value + '</td></tr>';
                });
                productTableHTML += '</table>';

                $('#productDetailsTable').html(productTableHTML);
                
              }
            }catch(error){
              // console.error("Failed to parse JSON: " + error.message);
              var error_html = '<div class="alert alert-danger">Please try again with correct vendor code or alias no.</div>';
            }
            

              $('#errorContainer').html(error_html);
            },
            error: function(xhr, status, error){
                console.error("An error occurred: " + xhr.responseText);
            }
        });
    
});



</script>
