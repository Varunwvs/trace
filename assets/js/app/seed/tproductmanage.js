$(document).ready(function(){
    var tdtProduct = $('#tdtProduct').DataTable({
      "processing": true,
      "serverSide": true,
      "ordering": true,
      "responsive": true,
      "columnDefs": [{ targets: [0], className: 'dt-center valign dt-w3' },
                      { targets: [1], className: 'dt-center valign dt-w25' },
                      { targets: [2,3], className: 'dt-center valign dt-w25' },
                      {targets: [4], className: 'dt-center dt-w22 valign'}],
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
            "url": "SeedController/tdtProduct/",
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
  
    //To Select the id of member to delete
    $(document).on('click', '#delete_product', function(e){ 
      var memberid = $(this).data('id');
      SwalDelete(memberid);
      e.preventDefault();
    });
  });//end of doc ready function
  
  //Delete Swal popup
  function SwalDelete(memberid){  
    Swal.fire({
      title: 'Are you sure?',
      text: "You won't be able to revert this!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, delete it!',
      showLoaderOnConfirm: true,
      preConfirm: function() {
         return new Promise(function(resolve) {                
            $.ajax({
            url: 'SeedController/tdelProduct',
            type: 'POST',
               data: {member_id : memberid},
               dataType: 'json'
            })
            .done(function(response){
                Swal.fire(
                      'Deleted!',
                      response.messages,
                      'success'
                );
                $('#tdtProduct').DataTable().ajax.reload();
            })
            .fail(function(){
             swal.fire('Oops...', 'Something went wrong !', 'error');
            });
         });
          },
       allowOutsideClick: false
    })  
   }