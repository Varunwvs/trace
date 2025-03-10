
$(document).ready(function(){
    let id = $('#bid').val();
    
    if(id){
      $.ajax({
        url: 'TarpaulinController/getBatchinfo',
        type: 'post',
        data: {member_id : id},
        dataType: 'json',
        success:function(response) {
          $('#bname').html(response.batch_no);        
        }//success ends
      });//ajax ends
    }else{
      alert("Error : Refresh the page again");
    }

//Batch primary serial datatable 
	var dtPSerial = $('#dtPSerial').DataTable({
	"processing": true,
	"serverSide": true,
	"ordering": true,
	"responsive": true,
	"columnDefs": [{ targets: [0], className: 'dt-center valign dt-w3' },
				{ targets: [1], className: 'dt-left valign dt-w80' },
				{targets: [2], className: 'dt-center dt-w17 valign'}],
    dom: 'Bfrtip',
	// Load data from an Ajax source
	ajax: {
		type: 'POST',
		url: 'TarpaulinController/dtPSerial',
		data: function(data) {
			data.bid = $('#bid').val();
		},
	},
	"order": []
  });
});//end doc ready function

$(document).ready(function(){
  //Data Table Function
  //console.log('Hi');
  var dtPContainer = $('#dtPContainer').DataTable({
      "paging": true,
       "lengthChange": true,
       "searching": true,
       "ordering": true,
       "info": true,
       "autoWidth": true,
       "responsive": true,
      "columnDefs": [{ targets: [0], className: 'dt-center valign dt-w3' },
                    { targets: [1,2], className: 'text-wrap dt-left valign dt-w20' },
                    { targets: [3], className: 'text-wrap word-wrap dt-left valign dt-w47' },
                    { targets: [4], className: 'dt-left valign dt-w20' }],
      dom: 'Bfrtip',
      
      ajax: {
            type: 'POST',
            url: 'TarpaulinController/dtPContainer',
            data: function(data) {
                data.bid = $('#bid').val()
            },
        },
      "order": [] 
  });
});