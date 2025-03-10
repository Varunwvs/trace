$(document).ready(function () {
    $('#addMorePlotDivision').click(function () {

        var cropOptions = cropsData.map(crop => 
            `
            <option value="${crop.id}">${crop.crop_name}</option>`
        ).join('');

        const html = `
            <div class="row plot-division">
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="form-label">Name</label>
                        <input type="text" class="form-control" name="plot_name[]" placeholder="Enter plot name">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="form-label">Area (in acres)</label>
                        <input type="text" class="form-control" name="division_area[]" placeholder="Enter area in acres">
                    </div>
                </div>
                 <div class="col-md-3">
                    <div class="form-group">
                        <label class="form-label">Crops</label>
                         <select class="form-control" name="crop_id[]" required>
                            <option value="">Select Crop</option>
                                ${cropOptions}
                            </select>
                    </div>
                </div>
                <div class="col-md-3 d-flex align-items-center">
                    <button type="button" class="btn btn-danger removePlotDivision">Remove</button>
                </div>
            </div>`;
        $('#plotDivisionContainer').append(html);
    });

    $(document).on('click', '.removePlotDivision', function () {
        $(this).closest('.plot-division').remove();
    });

    $('#formFarmerProfile').submit(function (e) {
        e.preventDefault(); // Prevent default form submission

        let formData = new FormData(this);

        $.ajax({
            url: $(this).attr('action'),
            method: $(this).attr('method'),
            data: formData,
            contentType: false, // Important for file upload
            processData: false, // Important for file upload
            dataType: 'json',
            success: function (response) {
                if (response.status) {
                    // alert(response.message);
                    $('#formFarmerProfile')[0].reset();
                    $('#plotDivisionContainer').html('');
                    Swal.fire({
                        icon: 'success',
                        title: 'Good Job!',
                        text: 'Farmer added successfully!',                  
                        showConfirmButton: false,
                        timer: 5000
                      }); 
                      window.location.href = "farmermanage";
                } else {
                    alert('Error: ' + response.message);
                }
            },
            error: function () {
                alert('An unexpected error occurred. Please try again.');
            }
        });
    });
});
