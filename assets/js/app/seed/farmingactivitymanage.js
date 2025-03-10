$(document).ready(function(){
    var dtFarmingActivity = $('#dtFarmingActivity').DataTable({
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
            "url": "FarmerController/dtFarmingActivity/",
            "type": "POST"
        },
  });

});


$(document).on('click', '.view-details', function (e) {
    e.preventDefault();
  
    // Get the ID from the data attribute
    var id = $(this).data('id');
  
    // Make an AJAX request to fetch details
    $.ajax({
        url: 'FarmerController/getFarmingActivityDetails', // Replace with your controller method
        type: 'POST',
        data: { id: id },
        dataType: 'json',
        success: function (response) {
            console.log(response);
            if (response.status && response.data.length > 0) {
                // Initialize HTML content
                var htmlContent = `
                    <p><strong>Farmer Name:</strong> ${response.data[0].farmer_name}</p>
                    <p><strong>Plot Name:</strong> ${response.data[0].plot_name}</p>
                    <p><strong>Plot Name:</strong> ${response.data[0].crop_name}</p>
                            
                `;
  
                // Loop through the data array to populate the table
                response.data.forEach(function (item) {
                    let formattedDate = new Date(item.activity_date).toLocaleDateString('en-GB');
                    htmlContent += `
                       <p><strong>- ${item.activity.toUpperCase()} - ${formattedDate}</strong>
                        <p>Brand: ${item.brand}</p>
                        <p>Product: ${item.product}</p>
                        <p>Purpose: ${item.purpose}</p>
                        
                    `;
                });
  
                // Close the table and add the content
                htmlContent += `
                        </tbody>
                    </table>
                `;
  
                // Add the content to the modal
                $('#modalContent').html(htmlContent);
            } else {
                $('#modalContent').html('<p>No details found.</p>');
            }
  
            // Show the modal
            $('#detailsModal').modal('show');
        },
        error: function () {
            $('#modalContent').html('<p>Error fetching details.</p>');
            $('#detailsModal').modal('show');
        }
    });
  });










// $(document).on('click', '.view-details', function (e) {
//   e.preventDefault();

//   // Get the ID from the data attribute
//   var id = $(this).data('id');

//   // Make an AJAX request to fetch details
//   $.ajax({
//       url: 'FarmerController/getFarmingActivityDetails', // Replace with your controller method
//       type: 'POST',
//       data: { id: id },
//       dataType: 'json',
//       success: function (response) {
//           console.log(response);
//           if (response.status && response.data.length > 0) {
//               // Initialize HTML content
//               var htmlContent = `
//                   <p><strong>Farmer Name:</strong> ${response.data[0].farmer_name}</p>
//                   <p><strong>Plot Name:</strong> ${response.data[0].plot_name}</p>
//                   <p><strong>Plot Name:</strong> ${response.data[0].crop_name}</p>
//                   <table class="table table-bordered">
//                       <thead>
//                           <tr>
//                               <th>Activity</th>
//                               <th>Activity Date</th>
//                               <th>Brand</th>
//                               <th>Product</th>
//                               <th>Purpose</th>
//                           </tr>
//                       </thead>
//                       <tbody>
//               `;

//               // Loop through the data array to populate the table
//               response.data.forEach(function (item) {
//                   htmlContent += `
//                       <tr>
//                           <td>${item.activity}</td>
//                           <td>${item.activity_date}</td>
//                           <td>${item.brand}</td>
//                           <td>${item.product}</td>
//                           <td>${item.purpose}</td>
//                       </tr>
//                   `;
//               });

//               // Close the table and add the content
//               htmlContent += `
//                       </tbody>
//                   </table>
//               `;

//               // Add the content to the modal
//               $('#modalContent').html(htmlContent);
//           } else {
//               $('#modalContent').html('<p>No details found.</p>');
//           }

//           // Show the modal
//           $('#detailsModal').modal('show');
//       },
//       error: function () {
//           $('#modalContent').html('<p>Error fetching details.</p>');
//           $('#detailsModal').modal('show');
//       }
//   });
// });





