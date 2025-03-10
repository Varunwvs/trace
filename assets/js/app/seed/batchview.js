$(document).ready(function(){
    // var bid = $('#bid').val();
    //Data Table Function
      var dtSerial = $('#dtSerial').DataTable({
       "paging": true,
       "lengthChange": true,
       "searching": true,
       "ordering": true,
       "info": true,
       "autoWidth": true,
       "responsive": true,
       "columnDefs": [{ targets: [0], className: 'dt-center valign dt-w3' },
                     { targets: [1,2], className: 'dt-left valign dt-w38' },
                     {targets: [3], className: 'dt-center dt-w21 valign'}],
       dom: 'Bfrtip',
               
        ajax: {
            type: 'POST',
            url: 'SeedController/dtSerial',
            data: function(data) {
                data.bid = $('#bid').val()
            },
        },
       "order": [] 
    });//Datatable View
    //To Select the id of member to delete
    $(document).on('click', '#delete_serial', function(e){ 
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
              url: 'SeedController/delSerial',
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
                  $('#dtSerial').DataTable().ajax.reload();                
              })
              .fail(function(){
               swal.fire('Oops...', 'Something went wrong !', 'error');
              });
           });
            },
         allowOutsideClick: false
      })  
     }
     
     //$(document).on('click', '#secondary', function(e){
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
            url: 'SeedController/dtContainer',
            data: function(data) {
                data.bid = $('#bid').val()
            },
        },
      "order": [] 
  });
});