$(document).ready(function(){
    var dtFarmer = $('#dtFarmer').DataTable({
      "processing": true,
      "serverSide": true,
      "ordering": true,
      "responsive": true,
      "columnDefs": [{ targets: [0], className: 'dt-center valign dt-w3' },
                      { targets: [1], className: 'dt-center valign dt-w20' },
                      { targets: [2,3,4], className: 'dt-center valign dt-w20' }],
      dom: 'Bfrtip',
        buttons: [
            {extend:'copy', text:'<i class="fas fa-copy text-info"></i> Copy', titleAttr: 'Copy'}, 
            {extend:'csv', text:'<i class="fas fa-file-excel text-primary"></i> CSV <i class="fas fa-download text-dark"></i>', titleAttr:'csv'}, 
            {extend:'excel', text:'<i class="fas fa-file-excel text-primary"></i> Excel <i class="fas fa-download text-dark"></i>', titleAttr:'excel'}, 
            {extend:'pdf', text:'<i class="fas fa-file-pdf text-danger"></i> PDF <i class="fas fa-download text-dark"></i>', titleAttr:'pdf'}, 
            {extend:'print', text:'<i class="fas fa-print text warning"></i> Print', titleAttr:'print'}
        ], 
      "order": [],
        // Load data from an Ajax source
        "ajax": {
            "url": "FarmerController/dtFarmer/",
            "type": "POST"
        },
  });

});

$(document).on('click', '.open-modal', function (e) {
  e.preventDefault();

  // Get the ID from the data attribute
  var id = $(this).data('id');

  // Make an AJAX request to fetch details
  $.ajax({
      url: 'FarmerController/getFarmerPlotDetails', // Controller method to fetch details
      type: 'POST',
      data: { id: id },
      dataType: 'json',
      success: function (response) {
        console.log(response);
          if (response.status) {
              // Extract unique details
              const fullName = response.data[0].full_name;
              const plotArea = response.data[0].plot_area;
              const latitude = response.data[0].latitude;
              const longitude = response.data[0].longitude;
              const registration_id = response.data[0].registration_id || "";
              const file = response.data[0].farmer_files;

              // Prepare HTML for unique details
              let modalContent = `
                  <p><strong>Full Name:</strong> ${fullName}</p>
                  <p><strong>Plot Area:</strong> ${plotArea}  acre</p>
                  <p><strong>Latitude:</strong> ${latitude}</p>
                  <p><strong>Longitude:</strong> ${longitude}</p>
                  <p><strong>Farmer Registration Id:</strong> ${registration_id}</p>
              `;
              if (file) {
                modalContent += `<p><strong>File:</strong> <a target="_blank" href="uploads/farmer_files/${file}">View File</a></p>`;
            } else {
                modalContent += `<p><strong>File:</strong> No data available</p>`;
            }

              // Add repetitive fields (plot_division_area and plot_name)
              modalContent += `<p><strong>Plot Division:</strong></p><ul>`;
              response.data.forEach(plot => {
                  modalContent += `
                      <li>
                          <strong>Plot Name:</strong> ${plot.plot_name}, 
                          <strong>Division Area:</strong> ${plot.plot_division_area},
                          <strong>Crop:</strong> ${plot.crop_name}
                      </li>`;
              });
              modalContent += `</ul>`;

              // Populate modal content
              $('#modalContent').html(modalContent);
          } else {
              $('#modalContent').html(`<p>${response.message}</p>`);
          }

          // Show the modal
          $('#detailsModal').modal('show');
      },
      error: function () {
          $('#modalContent').html('<p>Error fetching details. Please try again later.</p>');
          $('#detailsModal').modal('show');
      }
  });
});





