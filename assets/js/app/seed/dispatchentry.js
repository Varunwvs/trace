$(document).ready(function () {
    $('#formdispatch').on('submit', function (e) {
        e.preventDefault(); // Prevent form submission

        var formData = new FormData(this); // Create FormData object to handle file uploads

        $.ajax({
            url: "FarmerController/add_dispatchdata", // Change this to your controller method
            type: "POST",
            data: formData,
            contentType: false, // Do not set content type, required for FormData
            processData: false, // Prevent jQuery from processing data
            dataType: "json",
            success: function (response) {
                console.log('hye');
                if (response.status == "success") {
                    console.log('hye');
                    Swal.fire({
                        icon: 'success',
                        title: 'Good Job!',
                        text: 'Data added successfully!',                  
                        showConfirmButton: false,
                        timer: 5000
                      }); 
                    $('#formdispatch')[0].reset();
                } else {
                    alert("Error: " + response.message);
                }
            },
            error: function () {
                alert("Failed to submit data.");
            }
        });
    });
});