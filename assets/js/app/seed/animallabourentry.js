$(document).ready(function() {
    $("#animalLabourForm").submit(function(e) {
        e.preventDefault(); // Prevent default form submission

        var formData = new FormData(this); 

        $.ajax({
            url: "LiveStockManagementController/addAnimalLabour", 
            type: "POST",
            data: formData,
            contentType: false,
            cache: false,
            processData: false,
            dataType : 'json',
            success: function(response) {
                if(response.success == true) {
                    $("#animalLabourForm")[0].reset();
                    Swal.fire({
                        icon: 'success',
                        title: 'Good Job!',
                        text: 'Data Added successfully!',                  
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