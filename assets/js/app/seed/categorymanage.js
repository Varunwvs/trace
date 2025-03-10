$(document).ready(function(){
    var dtCategory = $('#dtCategory').DataTable({
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
            "url": "SeedController/dtCategory/",
            "type": "POST"
        },
  });




});



$(document).on('click', '.open-modal', function(e) {
  e.preventDefault();
  
  var categoryId = $(this).data('id');
// console.log(categoryId);
    $.ajax({
        url: "SeedController/getSubcategories",
        type: "POST",
        data: { category_id: categoryId },
        dataType: "json",
        success: function(response) {
          console.log(response);
            var html = '';
            $('#subCategoryModal').modal('show');
            if (response.length > 0) {
                $.each(response, function(index, subcategory) {
                    html += '<tr>';
                    html += '<td>' + subcategory.sub_name + '</td>';
                    html += '<td>' + subcategory.sub_code + '</td>';
                    html += '<td>';
                    html += '<button class="btn btn-warning btn-sm edit-subcategory" data-id="' + subcategory.id + '"><i class="fa fa-edit"></i></button> ';
                    html += '<button class="btn btn-danger btn-sm delete-subcategory" data-id="' + subcategory.id + '"><i class="fa fa-trash"></i></button>';
                    html += '</td>';
                    html += '</tr>';
                });
            } else {
                html = '<tr><td colspan="3" class="text-center">No subcategories found</td></tr>';
            }

            $('#subcategoryList').html(html);
        }
    });
});



$(document).on('click', '.edit-subcategory', function() {
    var subcategoryId = $(this).data('id');

    window.location.href = "subcategoryedit?scid=" + subcategoryId;

});




$(document).on('click', '.delete-subcategory', function(e) {
  e.preventDefault(); // Prevent default action

  var subcategoryId = $(this).data('id'); // Get vendor ID from data-id attribute

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
              url: "SeedController/deleteSubcategory",  // Update with your correct delete API URL
              type: "POST",
              data: { id: subcategoryId },
              dataType: "json",
              success: function(response) {
                  if (response.success) {
                      Swal.fire({
                          icon: 'success',
                          title: 'Deleted!',
                          text: 'Sub-Category has been deleted.',
                          showConfirmButton: false,
                          timer: 3000
                      });

                      location.reload();
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


$(document).on('click', '#delete_category', function(e) {
  e.preventDefault(); // Prevent default action

  var categoryId = $(this).data('id'); // Get vendor ID from data-id attribute

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
              url: "SeedController/deleteCategory",  // Update with your correct delete API URL
              type: "POST",
              data: { id: categoryId },
              dataType: "json",
              success: function(response) {
                  if (response.success) {
                      Swal.fire({
                          icon: 'success',
                          title: 'Deleted!',
                          text: 'Category has been deleted.',
                          showConfirmButton: false,
                          timer: 3000
                      });

                      // Refresh the vendor table (if using DataTables)
                      $('#dtCategory').DataTable().ajax.reload();
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
