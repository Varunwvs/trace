$("#formaddlocation").submit(function(e) {
    e.preventDefault(); // Prevent default form submission

    $.ajax({
        url: "FarmerController/addlocation",
        type: "POST",
        data: $(this).serialize(), // Serialize form data
        dataType: "json",
        success: function(response) {
            if (response.status == "success") {
                Swal.fire({
                    icon: 'success',
                    title: 'Good Job!',
                    text: 'Location added successfully!',                  
                    showConfirmButton: false,
                    timer: 2000
                  }); 
                $("#formaddlocation")[0].reset(); 
            } else {
                alert("Error: " + response.message);
            }
        },
        error: function(xhr, status, error) {
            console.log(xhr.responseText);
            alert("Something went wrong. Please try again.");
        }
    });
});