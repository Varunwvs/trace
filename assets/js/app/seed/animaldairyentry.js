$(document).ready(function() {
    $("#animalDairyForm").submit(function(e) {
        e.preventDefault(); // Prevent default form submission

        $.ajax({
            url: "LiveStockManagementController/addAnimalDairy",
            type: "POST",
            data: $(this).serialize(),
            dataType: "json",
            success: function(response) {
                if(response.success == true) {
                    $("#animalDairyForm")[0].reset();
                    Swal.fire({
                        icon: 'success',
                        title: 'Good Job!',
                        text: 'Animal Dairy Data Added successfully!',                  
                        showConfirmButton: false,
                        timer: 5000
                      }); 

                  } else {
                      Swal.fire({
                      icon: 'error',
                      title: 'Ooops...',
                      text: response.messages,
                      showConfirmButton: false,
                      timer: 5000,
                      showClass: {popup: 'animate__animated animate__fadeInDown'},
                      hideClass: {popup: 'animate__animated animate__fadeOutUp'}
                    })
                    } 
            },
            error: function(xhr, status, error) {
                alert("Error: " + xhr.responseText);
            }
        });
    });
});