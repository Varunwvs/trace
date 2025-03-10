let rowCounter = 1;

document.addEventListener("click", function (e) {
    if (e.target.classList.contains("add-row")) {
        e.preventDefault();
        rowCounter++;

        const newRow = `
            <div class="row form-row" id="row-${rowCounter}">
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="form-label">Harvester Name</label>
                        <input type="text" class="form-control" name="harvester_name[]" id="harvester_name_${rowCounter}">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="form-label">Code</label>
                        <input type="text" class="form-control" name="code[]" id="code_${rowCounter}">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <button class="btn btn-sm btn-success add-row mt-4">Add More</button>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <button class="btn btn-sm btn-danger remove-row mt-4">Remove</button>
                    </div>
                </div>
            </div>
        `;

        // Append new row
        document.querySelector(".rows-container").insertAdjacentHTML("beforeend", newRow);

        // Show the "Remove" button in the previous row
        const lastRow = document.getElementById(`row-${rowCounter - 1}`);
        lastRow.querySelector(".remove-row").style.display = "inline-block";
    }

    if (e.target.classList.contains("remove-row")) {
        e.preventDefault();

        const currentRow = e.target.closest(".form-row");
        currentRow.remove();
    }
});


    $(document).ready(function () {
        $('#farmer_id').on('change', function () {
            const farmerId = $(this).val();
            if (farmerId) {
                $.ajax({
                    url: 'FarmerController/get_farmer_and_plot_details',
                    type: 'POST',
                    data: { farmer_id: farmerId },
                    dataType: 'json',
                    success: function (response) {
                        console.log(response.farmer.contact_no)
                        if (response.farmer) {
                            $('#contact_no').val(response.farmer.contact_no);
                        } else {
                            $('#contact_no').val('');
                        }

                        if (response.plots) {
                            const plotDropdown = $('#plot_id');
                            plotDropdown.empty(); // Clear existing options
                            plotDropdown.append('<option value="">Select Plot</option>');
                            response.plots.forEach(plot => {
                                plotDropdown.append(
                                    `<option value="${plot.id}">${plot.plot_name}</option>`
                                );
                            });
                        } else {
                            $('#plot_id').html('<option value="">No plots available</option>');
                        }
                    },
                    error: function () {
                        alert('Failed to fetch farmer details. Please try again.');
                    }
                });
            } else {
                $('#contact_no').val('');
                $('#plot_id').html('<option value="">Select Plot</option>');
            }
        });
    });
