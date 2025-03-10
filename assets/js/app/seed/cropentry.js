$(document).ready(function () {
    $('#formCrop').on('submit', function (e) {
        e.preventDefault(); // Prevent default form submission

        var formData = new FormData(this); // Create FormData object for file upload

        $.ajax({
            url: $(this).attr('action'),
            method: $(this).attr('method'),
            data: formData,
            contentType: false, // Important for file upload
            processData: false, // Important for file upload
            success: function (response) {
                var res = JSON.parse(response);
                if (res.status) {
                    // alert(res.message); // Success message
                    $('#formCrop')[0].reset(); // Reset form fields
                    Swal.fire({
                        icon: 'success',
                        title: 'Good Job!',
                        text: 'Crop added successfully!',                  
                        showConfirmButton: false,
                        timer: 5000
                      }); 
                      window.location.href = "cropmanage";
                } else {
                    alert(res.message); // Error message
                }
            },
            error: function () {
                alert('An error occurred while submitting the form.');
            },
        });
    });
});
