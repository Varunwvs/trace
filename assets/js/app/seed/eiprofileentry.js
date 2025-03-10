$(document).ready(function() {
    // Handle form submission
    $('#formeiProfileUser').on('submit', function(e) {
        e.preventDefault(); // Prevent the form from submitting normally
        
      
        var password = $('#password').val();
        
        //  must be alphanumeric with at least 8 characters and one special character
        var passwordPattern = /^(?=.*[a-zA-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
        
        // Clear any previous error message
        $('#password-error').remove();

        // Check if the password matches the pattern
        if (!passwordPattern.test(password)) {
            // Show the error message below the password input
            $('#password').after('<div id="password-error" class="text-danger">Password should be 8 digit alpha numeric(abcd123@).</div>');
            return; // Stop the form submission
        }

        // Serialize form data
        var formData = $(this).serialize();
        
        // AJAX request to submit the form
        $.ajax({
            url: 'FarmerController/addeiProfileUser',  // Controller method to handle the form submission
            type: 'POST',
            data: formData,  // Send serialized form data
            dataType: 'json',  // Expect a JSON response
            success: function(response) {
                if (response.status) {
                    // alert('Form submitted successfully!');
                    $('#formeiProfileUser')[0].reset(); // Reset the form fields
                    Swal.fire({
                        icon: 'success',
                        title: 'Good Job!',
                        text: 'User added successfully!',                  
                        showConfirmButton: false,
                        timer: 5000
                      }); 
                      window.location.href = "eiprofilemanage";
                } else {
                    // On failure, show an error message
                    alert('Form submission failed: ' + response.message);
                }
            },
            error: function(xhr, status, error) {
                console.error(error);
                alert('An error occurred while submitting the form.');
            }
        });
    });
});

$(document).on('click', '.toggle-password', function() {
    $(this).toggleClass("fa-eye fa-eye-slash");
    var input = $("#password");
    input.attr('type') === 'password' ? input.attr('type','text') : input.attr('type','password')
  });