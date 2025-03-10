
        $("#formdealer").on("submit", function(e) {
            e.preventDefault(); // Prevent default form submission
            
            $.ajax({
                url: "FarmerController/addDealer",
                type: "POST",
                data: $(this).serialize(), // Serialize form data
                dataType: "json",
                success: function(response) {
                    if (response.status == "success") {
                        Swal.fire({
                            icon: 'success',
                            title: 'Good Job!',
                            text: 'Dealer added successfully!',                  
                            showConfirmButton: false,
                            timer: 2000
                          }); 
                        $("#formdealer")[0].reset(); // Reset form
                    } else {
                        alert("Error: " + response.message);
                    }
                },
                error: function(xhr, status, error) {
                    alert("AJAX Error: " + error);
                }
            });
        });
    
