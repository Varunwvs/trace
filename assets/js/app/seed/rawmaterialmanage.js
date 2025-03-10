$(document).ready(function(){
    var dtRawMaterial = $('#dtRawMaterial').DataTable({
      "processing": true,
      "serverSide": true,
      "ordering": true,
      "responsive": true,
      "columnDefs": [{ targets: [0], className: 'dt-center valign dt-w3' },
                      { targets: [1], className: 'dt-center valign dt-w20' },
                      { targets: [2,3], className: 'dt-center valign dt-w20' }],
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
            "url": "SeedController/dtRawMaterial/",
            "type": "POST"
        },
  });

});

$(document).on('click', '#delete_rawmaterial', function(e) {
  e.preventDefault(); // Prevent default action

  var r_id = $(this).data('id'); // Get vendor ID from data-id attribute

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
              url: "SeedController/deleteRawMaterial",  
              type: "POST",
              data: { id: r_id },
              dataType: "json",
              success: function(response) {
                  if (response.success) {
                      Swal.fire({
                          icon: 'success',
                          title: 'Deleted!',
                          text: 'Raw Material has been deleted.',
                          showConfirmButton: false,
                          timer: 3000
                      });

                      // Refresh the vendor table (if using DataTables)
                      $('#dtRawMaterial').DataTable().ajax.reload();
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










