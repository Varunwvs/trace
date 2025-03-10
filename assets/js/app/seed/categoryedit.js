   
$(document).ready(function() {
   let categoryId = $('#catid').val();

    if(categoryId){
        $.ajax({
            url: "SeedController/getCategoryDetails",
            type: "POST",
            data: { id: categoryId },
            dataType: "json",
            success: function (response) {
                if (response.success) {
                    var data = response.data; 
    
                    // Set form values
                    $('#edit_name').val(data.name);
                    $('#edit_code').val(data.code);

                    $('#edit_category_type').prop('checked', false);
                
                    // Check the checkboxes based on the response
                    if (data.category_type && data.category_type.includes("Raw Material")) {
                        $('#edit_category_type[value="Raw Material"]').prop('checked', true);
                    }
    
                    if (data.category_type && data.category_type.includes("Product")) {
                        $('#edit_category_type[value="Product"]').prop('checked', true);
                    }
             
                        // Editing a category (hide)
                    $('#edit_parent_category').val('').closest('.form-group').hide();

                    //to hide field used for subcategory
                    $('#edit_parent_category_name').val('').closest('.form-group').hide();

                    
                  
                } else {
                    alert('Error: Unable to fetch category details.');
                }
            
            }
        });
    }else{
         // for subcategory**********
    let subcategoryId = $('#s_catid').val();

    $.ajax({
            url: "SeedController/getSubCategoryDetails",
            type: "POST",
            data: { id: subcategoryId },
            dataType: "json",
            success: function (response) {

                if (response.success) {
                    var data = response.data; 
      
                    // Set form values
                    $('#edit_name').val(data.sub_name);
                        $('#edit_code').val(data.sub_code);

                        $('#edit_category_type').prop('checked', false); // Uncheck the checkbox if necessary
                        $('#edit_category_type').closest('.form-group').hide();

                        // Set readonly fields for subcategory details
                        $('#edit_parent_category_id').val(data.category_id);
                        $('#edit_parent_category_name').val(data.name);

                        // Hide the parent category field (if needed)
                        $('#edit_parent_category').val('').closest('.form-group').hide();
                  
                } else {
                    alert('Error: Unable to fetch category details.');
                }
            
            }
        });
    }


  


    

});


$('#formeditCategory').on('submit', function(e) {
    e.preventDefault();

    // Get form data
    var formData = new FormData(this);

    // Check if scid is not empty
    var url = ($('#s_catid').val()) ? 'SeedController/editSubCategory' : 'SeedController/editCategory';

    // Send the data via AJAX
    $.ajax({
        url: url,  // Endpoint for editing category
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json',
        success: function(response) {
            if(response.success == true) {
                $("#formeditCategory")[0].reset();
                Swal.fire({
                    icon: 'success',
                    title: 'Good Job!',
                    text: 'Category Updated successfully!',                  
                    showConfirmButton: false,
                    timer: 5000
                  }); 
                  window.location.href = "categorymanage";
              } else {
                  Swal.fire({
                  icon: 'error',
                  title: 'Ooops...',
                  text: response.message,
                  showConfirmButton: false,
                  timer: 5000,
                  showClass: {popup: 'animate__animated animate__fadeInDown'},
                  hideClass: {popup: 'animate__animated animate__fadeOutUp'}
                })
                }
        },
        error: function(xhr, status, error) {
            alert('Something went wrong, please try again.');
        }
    });
});
