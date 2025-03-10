$(document).ready(function(){
    var dtProcessing = $('#dtProcessing').DataTable({
      "processing": true,
      "serverSide": true,
      "ordering": true,
      "responsive": true,
      "columnDefs": [{ targets: [0], className: 'dt-center valign dt-w3' },
                      { targets: [1,2], className: 'dt-center valign dt-w20' },
                      { targets: [3], className: 'dt-center valign dt-w25' },
                      {targets: [4], className: 'dt-center dt-w17 valign'}],
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
            "url": "SeedController/dtProcessing/",
            "type": "POST"
        },
  });
    
    $(document).on('click', '.sendApiDataBtn', function() {
        // alert('button clicked');
      var productId = $(this).data('id');
    //   console.log(productId);
      // Make AJAX request to send API data
      $.ajax({
          url: 'ApiController/sprd_api_post',
          type: 'POST',
          data: { productId: productId },
          success: function(response){
            $('#dtProduct').DataTable().ajax.reload();
          },
          error: function(xhr, status, error){
              alert('Error occurred while sending API data');
              console.error(error);
          }
      });
   });

});

$(document).on('click', '.open-modal', function (e) {
  e.preventDefault();
  let processedLotNo = $(this).data('processed-lot-no');
  // console.log(processedLotNo);
  
  $.ajax({
      url: 'SeedController/getProcessingDetails',
      type: 'POST',
      data: { processed_lot_no: processedLotNo },
      datatype: 'JSON',
      success: function (response) {

          // Parse the JSON response
          let data = JSON.parse(response);

          if (data.length > 0) {
            $('#vendor_name').text(data[0].vendor_name);
            // $('#raw_material_name').text(data[0].raw_material_name);
            // $('#processed_lot_no').text(data[0].processed_lot_no || '');
        }

          let htmlContent = '<table class="table table-bordered table-responsive"><thead><tr>' +
              '<th>Source Lot No.</th><th>Vendor</th><th>Raw Material</th><th>Process Name</th><th>Process Type</th>' +
              '<th>Process Qty</th><th>Final Qty</th>' +
              '<th>Wastage</th><th>UOM</th><th>Actions</th>' +
              '</tr></thead><tbody>';
          
          data.forEach(row => {
              htmlContent += '<tr>' +
                  `<td>${row.sourcing_lot_id}</td>` +
                  `<td>${row.vendor_name}</td>` +
                  `<td>${row.raw_material_name}</td>` +
                  `<td>${row.process_name}</td>` +
                  `<td>${row.process_type}</td>` +
                  `<td>${row.process_qty}</td>` +
                  `<td>${row.final_qty}</td>` +
                  `<td>${row.wastage}</td>` +
                  `<td>${row.uomname}</td>` +
                  `<td>
                        <button class="btn btn-primary btn-sm edit-btn" data-processing-id="${row.processing_id}"><i class="fa fa-edit"></i></button>
                        <button class="btn btn-danger btn-sm delete-btn" data-processing-id="${row.processing_id}"><i class="fa fa-trash"></i></button>
                    </td>`+
                  '</tr>';
          });
          htmlContent += '</tbody></table>';
          
          $('#modalContent').html(htmlContent);
          $('#detailsModal').modal('show');
      },
      error: function () {
          $('#modalContent').html('<p class="text-danger">Failed to load data. Please try again.</p>');
          $('#detailsModal').modal('show');
      }
  });
});

$(document).on('click', '.edit-btn', function () {
  let processingId = $(this).data('processing-id');
  
  // Redirect to a new page for editing the data
  window.location.href = `processingedit?processing_id=${processingId}`;
});


// delete for inner process data
$(document).on('click', '.delete-btn', function () {
  let processingId = $(this).data('processing-id');
  
  Swal.fire({
    title: "Are you sure?",
    text: "You won’t be able to revert this!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#d33",
    cancelButtonColor: "#3085d6",
    confirmButtonText: "Yes, delete it!"
}).then((result) => {
    if (result.isConfirmed) {
        // AJAX request to delete vendor
        $.ajax({
            url: "SeedController/deleteProcessData",  
            type: "POST",
            data: { id: processingId },
            dataType: "json",
            success: function(response) {
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Deleted!',
                        text: 'Process data has been deleted.',
                        showConfirmButton: false,
                        timer: 3000
                    });

                    // Refresh the vendor table (if using DataTables)
                    $('#dtProcessing').DataTable().ajax.reload();
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: response.message
                    });
                }
            },
            error: function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops!',
                    text: 'Something went wrong. Please try again.'
                });
            }
        });
    }
});
});

//Delete for processing lot 
$(document).on('click', '#delete_processing', function(e) {
  e.preventDefault(); // Prevent default action

  var processed_lot = $(this).data('id'); // Get vendor ID from data-id attribute

  Swal.fire({
      title: "Are you sure?",
      text: "You won’t be able to revert this!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#d33",
      cancelButtonColor: "#3085d6",
      confirmButtonText: "Yes, delete it!"
  }).then((result) => {
      if (result.isConfirmed) {
          // AJAX request to delete vendor
          $.ajax({
              url: "SeedController/deleteProcessing",  
              type: "POST",
              data: { processed_lot: processed_lot },
              dataType: "json",
              success: function(response) {
                  if (response.success) {
                      Swal.fire({
                          icon: 'success',
                          title: 'Deleted!',
                          text: 'Processing has been deleted.',
                          showConfirmButton: false,
                          timer: 3000
                      });

                      // Refresh the vendor table (if using DataTables)
                      $('#dtProcessing').DataTable().ajax.reload();
                  } else {
                      Swal.fire({
                          icon: 'error',
                          title: 'Error!',
                          text: response.message
                      });
                  }
              },
              error: function() {
                  Swal.fire({
                      icon: 'error',
                      title: 'Oops!',
                      text: 'Something went wrong. Please try again.'
                  });
              }
          });
      }
  });
});