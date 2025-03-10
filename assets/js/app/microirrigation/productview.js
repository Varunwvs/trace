$(document).on('click','#prddtls',function(){
	$(".tab-icon").toggleClass("hidden");
});

$(document).ready(function(){
	var dtBatch = $('#dtBatch').DataTable({
	"processing": true,
	"serverSide": true,
	"ordering": true,
	"responsive": true,
	"columnDefs": [{ targets: [0], className: 'dt-center valign dt-w3' },
				{ targets: [1], className: 'dt-left valign dt-w35' },
				{ targets: [2], className: 'dt-center valign dt-w17' },
				{targets: [3], className: 'dt-center dt-w45 valign'}],
    dom: 'Bfrtip',
	buttons: [
		{extend:'copy', text:'<i class="fas fa-copy text-info"></i> Copy', titleAttr: 'Copy'}, 
		{extend:'csv', text:'<i class="fas fa-file-excel text-primary"></i> CSV <i class="fas fa-download text-dark"></i>', titleAttr:'csv'}, 
		{extend:'excel', text:'<i class="fas fa-file-excel text-primary"></i> Excel <i class="fas fa-download text-dark"></i>', titleAttr:'excel'}, 
		{extend:'pdf', text:'<i class="fas fa-file-pdf text-danger"></i> PDF <i class="fas fa-download text-dark"></i>', titleAttr:'pdf'}, 
		{extend:'print', text:'<i class="fas fa-print text warning"></i> Print', titleAttr:'print'}
	], 
	// Load data from an Ajax source
	ajax: {
		type: 'POST',
		url: 'MicroirrigationController/dtBatch',
		data: function(data) {
			data.pid = $('#pid').val();
		},
	},
	"order": []
  });
  
  //To Select the id of company to update
    $(document).on('click', '#update_print', function(e){ 
        var memberid = $(this).data('id');
        SwalUpdate(memberid);
        e.preventDefault();
    });
});//end doc ready function

//Update Swal popup
  function SwalUpdate(memberid){  
    Swal.fire({
      title: 'Are you sure?',
      text: "You want to change the print status!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, change the status!',
      showLoaderOnConfirm: true,
      preConfirm: function() {
         return new Promise(function(resolve) {                
            $.ajax({
            url: 'MicroirrigationController/updPrintstatus',
            type: 'POST',
               data: {member_id : memberid},
               dataType: 'json'
            })
            .done(function(response){
                Swal.fire(
                      'Status Updated',
                      response.messages,
                      'success'
                );
                $('#dtBatch').DataTable().ajax.reload();
            })
            .fail(function(){
             swal.fire('Oops...', 'Something went wrong !', 'error');
            });
         });
          },
       allowOutsideClick: false
    })  
   }