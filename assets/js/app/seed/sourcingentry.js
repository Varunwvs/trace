$(document).ready(function() {
    var spinner = $('#loader');
    //Submit Form Using Ajax
    $(document).on('click','#submit',function(e){
        let bid = $('#pid').val();
      // remove the error 
      $("#batch_no").css({"border-color": "gray"});
      $(".text-danger").remove();
      // submit form
      $("#formSourcing").unbind('submit').bind('submit', function() {
        spinner.show();
        $(".text-danger").remove();
        var form = $(this);
        // validation
       
          //submi the form to server
          $.ajax({
            url : 'SeedController/addSourcing',
            type : 'POST',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            dataType : 'json',
            success:function(response) {
  
              if(response.success == true) {
                spinner.hide();
                // $("#formSourcing")[0].reset();
                Swal.fire({
                    icon: 'success',
                    title: 'Good Job!',
                    text: 'Sourcing added successfully!',                  
                    showConfirmButton: false,
                    timer: 5000
                  }); 
                  window.location.href = "sourcingmanage";
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
                }  // /else
            } // success  
          }); // ajax subit         
       
        return false;
      }); // /submit form for create member
    }); // /add modal
  });
$(function () {
    $('#mfgdate').datetimepicker({
        format: 'DD-MM-YYYY',
        todayHighlight: true
    }); 
    
    $('#expdate').datetimepicker({
        format: 'DD-MM-YYYY',
        todayHighlight: true
    }); 
});

let rowCount = 1; // Initialize row count

// Add event listener for the document to handle "Add More" and "Remove" buttons
document.addEventListener('click', function (e) {
    // Handle "Add More" button click
    if (e.target && e.target.classList.contains('add-more')) {
        rowCount++;
        const container = document.getElementById('sourcingContainer');

        // Clone the first row
        const firstRow = document.querySelector('.sourcing-row');
        const newRow = firstRow.cloneNode(true);

        // Reset the input fields and update IDs
        newRow.querySelectorAll('input, select').forEach((element) => {
            element.value = ''; // Clear the value
            if (element.id) {
                element.id = element.id.replace(/\d+$/, rowCount); // Update ID with new count
            }
        });

        // Show "Remove" button and hide "Add More" button for the cloned row
        newRow.querySelector('.add-more').classList.add('d-none');
        newRow.querySelector('.remove-row').classList.remove('d-none');

        // Append the new row
        container.appendChild(newRow);
    }

    // Handle "Remove" button click
    if (e.target && e.target.classList.contains('remove-row')) {
        const row = e.target.closest('.sourcing-row');
        row.remove();
    }
});

// Ensure the "Remove" button is hidden for the first row on page load
document.addEventListener('DOMContentLoaded', () => {
    const firstRowRemoveButton = document.querySelector('.sourcing-row .remove-row');
    if (firstRowRemoveButton) {
        firstRowRemoveButton.classList.add('d-none');
    }
});

$(document).on('click', '#btnClick', function() {
  $.ajax({
      url: 'SeedController/generateLotReference', // Update with your controller function
      type: 'POST',
      dataType: 'json',
      success: function(response) {
          if (response.success) {
              $('#lot_reference_no').val(response.lot_reference_no);
          } else {
              alert(response.message);
          }
      },
      error: function() {
          alert('Error generating Lot Reference Number');
      }
  });
});


