$(document).ready(function(){
    var dtInput = $('#dtInput').DataTable({
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
            "url": "FarmerController/dtInput/",
            "type": "POST"
        },
  });

});

$(document).on('click', '.open-modal', function() {
    var id = $(this).data('id'); // Get the ID of the clicked item

    // Make an AJAX request to get the remaining data
    $.ajax({
        url: 'FarmerController/getInputDetails',  // Replace 'YourController' with the actual controller name
        type: 'POST',
        data: {id: id},  // Send the product ID to the server
        dataType: 'json',
        success: function(response) {
            if (response.status) {
                // Populate the modal with the response data
                $('#modalProduct').text(response.data.product);
                $('#modalBrand').text(response.data.brand);
                $('#modalCategory').text(response.data.category);
                $('#modalDescription').text(response.data.description);
                $('#modalUsageInstructions').text(response.data.usage_instructions);

                // Show the modal
                $('#viewModal').modal('show');
            } else {
                alert('Unable to fetch details.');
            }
        },
        error: function(xhr, status, error) {
            console.log(error);
            alert('An error occurred while fetching details.');
        }
    });
});









