
$(document).ready(function(){
    let id = $('#bid').val();
    
    if(id){
      $.ajax({
        url: 'MicroirrigationController/getBatchinfo',
        type: 'post',
        data: {member_id : id},
        dataType: 'json',
        success:function(response) {
          var formattedDatetime = moment(response.batch_no).format('DD/MM/YYYY HH:mm:ss');
          $('#bname').html(formattedDatetime);        
        }//success ends
      });//ajax ends
    }else{
      alert("Error : Refresh the page again");
    }

//Batch primary serial datatable 
	var dtSerial = $('#dtSerial').DataTable({
	"processing": true,
	"serverSide": true,
	"ordering": true,
	"responsive": true,
	"columnDefs": [{ targets: [0], className: 'dt-center valign dt-w3' },
				{ targets: [1, 2], className: 'dt-left valign dt-w40' },
				{targets: [3], className: 'dt-center dt-w17 valign'}],
    dom: 'Bfrtip',
	// Load data from an Ajax source
	ajax: {
		type: 'POST',
		url: 'MicroirrigationController/dtSerial',
		data: function(data) {
			data.bid = $('#bid').val();
		},
	},
	"order": []
  });

  // //Batch primary serial datatable 
	// var dtContainer = $('#dtContainer').DataTable({
  //       "processing": true,
  //       "serverSide": true,
  //       "ordering": true,
  //       "responsive": true,
  //       "columnDefs": [{ targets: [0], className: 'dt-center valign dt-w3' },
  //                   { targets: [1, 2], className: 'dt-left valign dt-w20' },
  //                   { targets: [3], className: 'dt-left valign dt-w40' },
  //                   {targets: [4], className: 'dt-center dt-w17 valign'}],
  //       dom: 'Bfrtip',
  //       // Load data from an Ajax source
  //       ajax: {
  //           type: 'POST',
  //           url: 'MicroirrigationController/dtContainer',
  //           data: function(data) {
  //               data.bid = $('#bid').val();
  //           },
  //       },
  //       "order": []
  //   });
});//end doc ready function

$(document).ready(function(){
  //Data Table Function
  //console.log('Hi');
  var dtContainer = $('#dtContainer').DataTable({
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
            url: 'MicroirrigationController/dtContainer',
            data: function(data) {
                data.bid = $('#bid').val()
            },
        },
      "order": [] 
  });
});