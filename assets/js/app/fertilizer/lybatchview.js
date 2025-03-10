$(document).ready(function(){
    // var bid = $('#bid').val();
    //Data Table Function
      var dtlySerial = $('#dtlySerial').DataTable({
       "paging": true,
       "lengthChange": true,
       "searching": true,
       "ordering": true,
       "info": true,
       "autoWidth": true,
       "responsive": true,
       "columnDefs": [{ targets: [0], className: 'dt-center valign dt-w3' },
                     { targets: [1], className: 'dt-left valign dt-w38' },
                     {targets: [2], className: 'dt-center dt-w21 valign'}],
       dom: 'Bfrtip',
               
        ajax: {
            type: 'POST',
            url: 'FertilizerController/dtlySerial',
            data: function(data) {
                data.bid = $('#bid').val()
            },
        },
       "order": [] 
    });//Datatable View
    
});//end of doc ready function
    
    
     
     