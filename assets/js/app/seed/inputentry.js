
    $(document).ready(function() {
        $('#formFarmerInput').on('submit', function(event) {
            event.preventDefault();  // Prevent the form from submitting the traditional way

            // Create a FormData object to handle the form data
            var formData = new FormData(this);

            // Perform AJAX request
            $.ajax({
                url: 'FarmerController/addFarmerInput',  // The URL for the controller method
                type: 'POST',
                data: formData,
                contentType: false,  // Let jQuery set content type for FormData
                processData: false,  // Don't process the data, since it's FormData
                dataType: 'json',
                success: function(response) {
                    if (response.status) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Good Job!',
                            text: 'Farmer Inputs added successfully!',                  
                            showConfirmButton: false,
                            timer: 5000
                          }); 
                          window.location.href = "inputmanage";
                    } else {
                        // Handle error: Show validation or other errors
                        alert(response.message);
                    }
                },
                error: function(xhr, status, error) {
                    // Handle AJAX error
                    alert('An error occurred. Please try again.');
                }
            });
        });
    });
