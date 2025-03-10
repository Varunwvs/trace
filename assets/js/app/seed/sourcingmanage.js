$(document).ready(function(){
    var dtSourcing = $('#dtSourcing').DataTable({
      "processing": true,
      "serverSide": true,
      "ordering": true,
      "responsive": true,
      "columnDefs": [{ targets: [0], className: 'dt-center valign dt-w3' },
                      { targets: [1], className: 'dt-center valign dt-w20' },
                      { targets: [2,3,4,5], className: 'dt-center valign dt-w20' },
                      {targets: [6], className: 'dt-center dt-w17 valign'}],
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
            "url": "SeedController/dtSourcing/",
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

$(document).on('click', '.open-modal', function(e) {
  e.preventDefault();
  var id = $(this).data('id'); // Get the ID from the data attribute
console.log(id)
  // Fetch data via AJAX
  $.ajax({
      url: 'SeedController/getSourcingDetails', 
      type: 'POST',
      data: { id: id },
      dataType: 'json',
      success: function(response) {
        console.log(response)
          if (response) {
              // Populate the modal with the fetched data
              $('#modalLotReferenceNo').text(response.lot_reference_no);
              $('#modalVendorName').text(response.vendor_name);
              $('#modalProductName').text(response.product_name);
              $('#modalRawMaterialName').text(response.raw_material_name);
              $('#modalQty').text(response.qty);
              $('#modalUOMName').text(response.uomname);
              $('#modalDateOfSourcing').text(response.date_of_sourcing);

              // Show the modal
              $('#sourcingModal').modal('show');
          } else {
              alert('No data found.');
          }
      },
      error: function() {
          alert('Failed to fetch data.');
      }
  });
});


$(document).on('click', '#delete_sourcing', function(e) {
  e.preventDefault(); // Prevent default action

  var id = $(this).data('id'); // Get vendor ID from data-id attribute

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
              url: "SeedController/deleteSourcing",  
              type: "POST",
              data: { id: id },
              dataType: "json",
              success: function(response) {
                  if (response.success) {
                      Swal.fire({
                          icon: 'success',
                          title: 'Deleted!',
                          text: 'Sourcing has been deleted.',
                          showConfirmButton: false,
                          timer: 3000
                      });

                      // Refresh the vendor table (if using DataTables)
                      $('#dtSourcing').DataTable().ajax.reload();
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
