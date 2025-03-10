$(document).ready(function(){
    var dtVendor = $('#dtVendor').DataTable({
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
            "url": "SeedController/dtVendor/",
            "type": "POST"
        },
  });

});

$(document).on('click', '#delete_vendor', function(e) {
  e.preventDefault(); // Prevent default action

  var vendorId = $(this).data('id'); // Get vendor ID from data-id attribute

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
              url: "SeedController/deleteVendor",  // Update with your correct delete API URL
              type: "POST",
              data: { id: vendorId },
              dataType: "json",
              success: function(response) {
                  if (response.success) {
                      Swal.fire({
                          icon: 'success',
                          title: 'Deleted!',
                          text: 'Vendor has been deleted.',
                          showConfirmButton: false,
                          timer: 3000
                      });

                      // Refresh the vendor table (if using DataTables)
                      $('#dtVendor').DataTable().ajax.reload();
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


$(document).on('click', '.open-modal', function(e) {
  e.preventDefault();
  
  var vendorId = $(this).data('id'); // Get vendor ID
  
  $.ajax({
      url: "SeedController/getVendorDetails", // Update with the correct backend URL
      type: "POST",
      data: { id: vendorId },
      dataType: "json",
      success: function(response) {
          if (response.success) {
              // Populate modal fields with vendor details
              $("#vendor_name").text(response.data.vendor_name);
              $("#gst_no").text(response.data.gst_no);
              $("#address").text(response.data.address);
              $("#contact_person").text(response.data.contact_person);
              $("#contact_no").text(response.data.contact_no);
              $("#bank_name").text(response.data.bank_name);
              $("#bank_branch").text(response.data.bank_branch);
              $("#account_no").text(response.data.account_no);
              $("#ifsc_code").text(response.data.ifsc_code);
              
              // Show modal
              $("#vendorModal").modal('show');
          } else {
              Swal.fire({
                  icon: 'error',
                  title: 'Oops!',
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
});








