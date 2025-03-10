$(document).on('click','#prddtls',function(){
	$(".tab-icon").toggleClass("hidden");
});
$(document).ready(function(){
//Data Table Function
  var dtBatch = $('#dtBatch').DataTable({
   "paging": true,
   "lengthChange": true,
   "searching": true,
   "ordering": true,
   "info": true,
   "autoWidth": true,
   "responsive": true,
   "columnDefs": [{ targets: [0], className: 'dt-center valign dt-w3' },
                 { targets: [1], className: 'dt-left valign dt-w25' },
                 {targets: [2,3,4,5], className: 'dt-center dt-w18 valign'}],
   dom: 'Bfrtip',
     buttons: [
         {extend:'copy', text:'<i class="fas fa-copy text-info"></i> Copy', titleAttr: 'Copy'}, 
         {extend:'csv', text:'<i class="fas fa-file-excel text-primary"></i> CSV <i class="fas fa-download text-dark"></i>', titleAttr:'csv'}, 
         {extend:'excel', text:'<i class="fas fa-file-excel text-primary"></i> Excel <i class="fas fa-download text-dark"></i>', titleAttr:'excel'}, 
         {extend:'pdf', text:'<i class="fas fa-file-pdf text-danger"></i> PDF <i class="fas fa-download text-dark"></i>', titleAttr:'pdf'}, 
         {extend:'print', text:'<i class="fas fa-print text warning"></i> Print', titleAttr:'print'}
     ],
     ajax: {
      type: 'POST',
      url: 'SeedController/dtBatch',
      data: function(data) {
          data.pid = $('#pid').val()
      },
  },
   "order": [] 
});//Datatable View

$(document).on('click', '.sendApiBatchBtn', function() {
  var batchId = $(this).data('id');
  console.log(batchId);
  // Make AJAX request to send API data
  $.ajax({
      url: 'ApiController/sbtch_api_post',
      type: 'POST',
      data: { batchId: batchId },
      success: function(response){
        $('#dtBatch').DataTable().ajax.reload();
      },
      error: function(xhr, status, error){
          alert('Error occurred while sending API data');
          console.error(error);
      }
  });
});

//To Select the id of member to delete
$(document).on('click', '#delete_batch', function(e){ 
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
          url: 'SeedController/delBatch',
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
            //   $('#dtBatch').DataTable().ajax.reload();
            location.reload();
          })
          .fail(function(){
           swal.fire('Oops...', 'Something went wrong !', 'error');
          });
       });
        },
     allowOutsideClick: false
  })  
 }