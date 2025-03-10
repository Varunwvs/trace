$(document).ready(function() {
    var spinner = $('#loader');
    //Submit Form Using Ajax
    $(document).on('click','#submit',function(e){
        let bid = $('#pid').val();
      // remove the error 
      $("#batch_no").css({"border-color": "gray"});
      $(".text-danger").remove();
      // submit form
      $("#formRawMaterials").unbind('submit').bind('submit', function() {
        spinner.show();
        $(".text-danger").remove();
        var form = $(this);
        // validation
       
          //submi the form to server
          $.ajax({
            url : form.attr('action'),
            type : form.attr('method'),
            data : form.serialize(),
            dataType : 'json',
            success:function(response) {
  
              if(response.success == true) {
                spinner.hide();
                $("#formRawMaterials")[0].reset();
                Swal.fire({
                    icon: 'success',
                    title: 'Good Job!',
                    text: 'Raw Materials added successfully!',                  
                    showConfirmButton: false,
                    timer: 5000
                  }); 
                  window.location.href = "rawmaterialentry";
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



let rawMaterialCount = 1; // Initialize raw material count 

// Function to add a new raw material input field
document.getElementById('addMaterial').addEventListener('click', function() {
    rawMaterialCount++;
    const container = document.getElementById('rawMaterialsContainer');

    // Create a new row div
    const newRow = document.createElement('div');
    newRow.classList.add('row', 'raw-material-row');

    // Create a new column div inside the row
    const newField = document.createElement('div');
    newField.classList.add('col-md-6', 'raw-material-item');
    newField.innerHTML = `
        <div class="form-group">
            <label class="form-label">Raw Material Name</label>
            <div class="d-flex">
                <input type="text" class="form-control" name="raw_materials[]" id="raw_materials_${rawMaterialCount}">
                <button type="button" class="btn btn-danger btn-sm ml-2 removeMaterial">Remove</button>
            </div>
        </div>
    `;

    // Append the new column to the row
    newRow.appendChild(newField);

    // Append the new row to the container
    container.appendChild(newRow);

    // Add event listener for the remove button
    newField.querySelector('.removeMaterial').addEventListener('click', function() {
        container.removeChild(newRow);
    });
});
