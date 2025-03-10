$(document).ready(function(){
    var dteiProfile = $('#dteiProfile').DataTable({
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
            "url": "FarmerController/dteiProfile/",
            "type": "POST"
        },
  });

});

$(document).on('click', '.open-modal', function() {
    var id = $(this).data('id'); // Get the id of the clicked item

    // Make an AJAX request to get the profile details
    $.ajax({
        url: 'FarmerController/geteiProfileDetails',  // Replace with your controller method
        type: 'POST',
        data: {id: id},  // Send the profile ID to the server
        dataType: 'json',
        success: function(response) {
            if (response.status) {
                // Populate the modal with the response data
                $('#modalFullName').text(response.data.full_name);
                $('#modalContactNo').text(response.data.contact_no);
                $('#modalEmail').text(response.data.email);
                $('#modalUserType').text(response.data.user_type);
                $('#modalCompanyName').text(response.data.company_name);
                $('#modalWebsite').text(response.data.website);
                $('#modalLicenseNo').text(response.data.license_no);
                $('#modalRegisterNo').text(response.data.register_no);
                $('#modalNotes').text(response.data.notes);
                $('#modalAddress').text(response.data.address);

                // Show the modal
                $('#viewModal').modal('show');
            } else {
                alert('Unable to fetch profile details.');
            }
        },
        error: function(xhr, status, error) {
            console.log(error);
            alert('An error occurred while fetching the profile details.');
        }
    });
});
