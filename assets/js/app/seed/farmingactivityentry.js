$(document).ready(function() {
    $('#farmer_id').change(function() {
        var farmer_id = $(this).val();
        
        if (farmer_id) {
            $.ajax({
                url: 'FarmerController/get_plot_division',
                type: 'POST',
                data: { farmer_id: farmer_id },
                dataType: 'json',
                success: function(response) {
                    if (response.status) {
                        var plotNameDropdown = $('#plot_division_id');
                        plotNameDropdown.empty(); // Clear previous options
                        plotNameDropdown.append('<option value="">Select Plot Division</option>');
                        
                        $.each(response.data, function(index, item) {
                            plotNameDropdown.append('<option value="' + item.id + '">' + item.plot_name + '</option>');
                        });
                    } else {
                        alert(response.message);
                    }
                },
                error: function() {
                    alert('Error fetching data.');
                }
            });
        } else {
            // Clear the dropdown if no farmer is selected
            $('#plot_division_id').empty().append('<option value="">Select Plot Division</option>');
        }
    });

    $('#plot_division_id').change(function() {
        var plotDivisionId = $(this).val(); // Get selected Plot Division ID
        
        if (plotDivisionId) {
            $.ajax({
                url: 'FarmerController/getCropByPlotDivision', 
                method: 'POST',
                data: { plot_division_id: plotDivisionId },
                dataType: 'json',
                success: function(response) {
                    if (response.status) {
                        // Clear previous options
                        $('#crop_id').empty();
                        
                        // Add default option
                        $('#crop_id').append('<option value="">Select Crop</option>');
                        
                        // Populate crop options based on response data
                        $.each(response.crops, function(index, crop) {
                            $('#crop_id').append('<option value="' + crop.id + '">' + crop.crop_name + '</option>');
                        });
                    } else {
                        $('#crop_id').empty();
                        $('#crop_id').append('<option value="">No crops available</option>');
                    }
                },
                error: function() {
                    alert('An error occurred while fetching crops.');
                }
            });
        } else {
            // Clear crop dropdown if no plot division is selected
            $('#crop_id').empty();
            $('#crop_id').append('<option value="">Select Crop</option>');
        }
    });


    $('#crop_id').change(function() {
        var crop_id = $(this).val();  // Get the selected crop ID
        
        // Check if a crop is selected
        if (crop_id != '') {
            $.ajax({
                url: 'FarmerController/getCropSchedule', // URL to the controller method
                method: 'POST',
                data: { crop_id: crop_id },
                dataType: 'json',
                success: function(response) {
                    if (response.status == true) {
                        // Update the link with the crop schedule URL
                        var fileName = response.file_name;
                        $('#crop_schedule_link').attr('href', "uploads/crop_schedule/" + fileName);
                        $('#crop_schedule_link').text(fileName ? 'View Schedule' : 'No Schedule Available');
                    } else {
                        $('#crop_schedule_link').attr('href', '#');
                        $('#crop_schedule_link').text('No Schedule Available');
                    }
                },
                error: function() {
                    alert('Error occurred while fetching the crop schedule.');
                }
            });
        } else {
            $('#crop_schedule_link').attr('href', '#');
            $('#crop_schedule_link').text('No Schedule Available');
        }
    });

    // Add new row
   // Add new row when "Add More" button is clicked
document.getElementById('addMore').addEventListener('click', function () {
    // Get the container for farming activity rows
    var farmingActivityRows = document.getElementById('farmingActivityRows');
    
    // Create a new row
    var newRow = document.createElement('div');
    newRow.classList.add('row', 'farmingActivityRow');

    var inputBrandOptions = inputsData.map(inputs => 
        `
        <option value="${inputs.brand}">${inputs.brand}</option>`
    ).join('');

    var inputProductOptions = inputsData.map(inputs => 
        `
        <option value="${inputs.product}">${inputs.product}</option>`
    ).join('');
    
    // Add the fields for the new row
    newRow.innerHTML = `
        <div class="col-md-2">
            <div class="form-group">
                <label class="form-label">Select Date</label>
                <input type="date" class="form-control" name="activity_date[]" id="activity_date">
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <label class="form-label">Activities</label>
                <select class="form-control" name="activity[]" id="activity">
                    <option value="">Select</option>
                    <option value="sowing">Sowing</option>
                    <option value="spraying">Spraying Insecticides</option>
                    <option value="fertilizer">Fertilizer</option>
                    <option value="inm">INM</option>
                </select>
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <label class="form-label">Brand</label>
                <select class="form-control" name="brand[]" id="brand">
                            <option value="">Select Brand</option>
                                ${inputBrandOptions}
                            </select>
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <label class="form-label">Product</label>
                  <select class="form-control" name="product[]" id="product">
                            <option value="">Select Product</option>
                                ${inputProductOptions}
                            </select>
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <label class="form-label">Purpose</label>
                <textarea class="form-control" name="purpose[]" id="purpose"></textarea>
            </div>
        </div>
        <div class="col-md-2">
            <button type="button" class="btn btn-danger removeBtn mt-4">Remove</button>
        </div>
    `;

    // Append the new row to the container
    farmingActivityRows.appendChild(newRow);
});

// Remove the row when "Remove" button is clicked
document.getElementById('farmingActivityRows').addEventListener('click', function (event) {
    if (event.target.classList.contains('removeBtn')) {
        // Remove the parent row of the clicked button
        event.target.closest('.farmingActivityRow').remove();
    }
});

$('#formFarmingActivity').submit(function(e) {
    e.preventDefault();  // Prevent the default form submission

    // Prepare form data to be sent via AJAX
    var formData = $(this).serialize();  // Serializes the form data into a query string

    // Perform the AJAX request
    $.ajax({
        url: $(this).attr('action'),
        method: $(this).attr('method'),
        data: formData,
        dataType: 'json',  // Expecting a JSON response
        success: function(response) {
            if (response.status === 'success') {
                // Handle success (you can display a success message, clear the form, etc.)
                // alert('Farming activity has been added successfully!');
                $('#formFarmingActivity')[0].reset();  // Reset the form
                $('#farmingActivityRows').empty();  // Clear the dynamically added rows
                Swal.fire({
                    icon: 'success',
                    title: 'Good Job!',
                    text: 'Farmer Activity added successfully!',                  
                    showConfirmButton: false,
                    timer: 5000
                  }); 
                  window.location.href = "farmingactivitymanage";
            } else {
                // Handle error (you can display an error message here)
                alert('Error: ' + response.message);
            }
        },
        error: function(xhr, status, error) {
            // Handle any errors with the AJAX request itself
            alert('An error occurred while submitting the form. Please try again.');
        }
    });
});



});
