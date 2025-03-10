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
	// Load data from an Ajax source
	ajax: {
		type: 'POST',
		url: 'PesticideController/dtBatch',
		data: function(data) {
			data.pid = $('#pid').val();
		},
	},
	"order": []
  });
});//end doc ready function