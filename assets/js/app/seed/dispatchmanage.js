$(document).ready(function(){
    var dtDispatch = $('#dtDispatch').DataTable({
      "processing": true,
      "serverSide": true,
      "ordering": true,
      "responsive": true,
      "columnDefs": [{ targets: [0], className: 'dt-center valign dt-w3' },
                      { targets: [1], className: 'dt-center valign dt-w20' },
                      { targets: [2,3,4,5], className: 'dt-center valign dt-w20' }],
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
            "url": "FarmerController/dtDispatch/",
            "type": "POST"
        },
  });

});


$(document).on('click', '.open-modal', function() {
  var dispatchId = $(this).data('id');

  $.ajax({
      url: 'FarmerController/fetch_dispatch_data',
      type: 'POST',
      data: { id: dispatchId },
      dataType: 'json',
      success: function(response) {
          if (response.status === 'success') {
              $('#order_no').text(response.data.order_no);
              $('#dispatch_no').text(response.data.dispatch_no);
              $('#batch_no').text(response.data.batch_no);
              $('#crop_id').text(response.data.crop_name);
              $('#qty_shipped').text(response.data.qty_shipped);
              $('#vehicle_no').text(response.data.vehicle_no);

              // Show files if they exist
              $('#image_section').html(response.data.images 
                  ? `<a href="uploads/dispatch_files/${response.data.images}" target="_blank" class="btn btn-sm btn-primary">View Image</a>` 
                  : 'No Data');

              $('#certificate_section').html(response.data.certificate 
                  ? `<a href="uploads/dispatch_files/${response.data.certificate}" target="_blank" class="btn btn-sm btn-primary">View Certificate</a>` 
                  : 'No Data');

              $('#other_files_section').html(response.data.other_files 
                  ? `<a href="uploads/dispatch_files/${response.data.other_files}" target="_blank" class="btn btn-sm btn-primary">View File</a>` 
                  : 'No Data');

              // Show modal
              $('#dispatchModal').modal('show');
          } else {
              alert('Data not found.');
          }
      }
  });
});




