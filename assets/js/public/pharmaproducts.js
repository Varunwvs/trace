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
                        console.log('hey');
                      html += '<p style="font-weight: bold;">' + data['Generic name of the drug'] + '</p>';
                    }
            
                    html += '</div>';
                    html += '<p style="color: green">Product Details</p>';
                    html += '<table class="table table-hover">';
            
                    $.each(data, function(key, value) {
                      html += '<tr><td><strong>' + key + '</strong></td><td>' + value + '</td></tr>';
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