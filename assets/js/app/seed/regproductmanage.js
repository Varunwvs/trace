$(document).ready(function(){
    var dtRegProduct = $('#dtRegProduct').DataTable({
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
            "url": "FarmerController/dtRegProduct/",
            "type": "POST"
        },
  });

});

$(document).on('click', '.open-modal', function (e) {
    e.preventDefault();

    // Get the ID from the data attribute
    var id = $(this).data('id');

    // Make an AJAX request to fetch the details
    $.ajax({
        url: 'FarmerController/getRegProductDetails',
        type: "POST",
        data: { id: id },
        dataType: "json",
        success: function (response) {
            if (response.status) {
                // Populate the modal with the retrieved data
                var content = `
                    <p><strong>Name:</strong> ${response.data.name}</p>
                    <p><strong>Mobile:</strong> ${response.data.mobile}</p>
                    <p><strong>Email:</strong> ${response.data.email}</p>
                    <p><strong>Location:</strong> ${response.data.location}</p>
                    <p><strong>Product Purchased:</strong> ${response.data.product_purchased}</p>
                    <p><strong>Batch Number:</strong> ${response.data.batch_no}</p>
                    <p><strong>Purchase Source:</strong> ${response.data.purchase_source}</p>
                `;
                $('#modalContent').html(content);

                // Show the modal
                $('#detailsModal').modal('show');
            } else {
                alert('Error: ' + response.message);
            }
        },
        error: function () {
            alert('Failed to fetch product details.');
        }
    });
});









