$(document).ready(function(){
    //Data Table Function
    var dtlyProduct = $('#dtlyProduct').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": true,
        "responsive": true,
        "columnDefs": [{ targets: [0], className: 'dt-center valign dt-w3' },
                      { targets: [1], className: 'dt-left valign dt-w25' },
                      { targets: [2,3], className: 'dt-center valign dt-w25' },
                      {targets: [4], className: 'dt-center dt-w22 valign'}],
        dom: 'Bfrtip',
        "ajax": "MicroirrigationController/dtlyProduct",
        "order": [] 
    });//Datatable View
  
    
  });//end of doc ready function
  
  