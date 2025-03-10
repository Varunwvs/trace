$(document).ready(function(){
    //Data Table Function
    var dtCenter = $('#dtCenter').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": true,
        "responsive": true,
        "columnDefs": [{ targets: [0], className: 'dt-center valign dt-w3' },
                      { targets: [1], className: 'dt-left valign dt-w19' },
                      { targets: [2], className: 'dt-left text-wrap valign dt-w17' },
                      { targets: [3,4,5], className: 'dt-center valign dt-w15' },
                      {targets: [6], className: 'dt-center dt-w17 valign'}],
        dom: 'Bfrtip',
          buttons: [
              {extend:'copy', text:'<i class="fas fa-copy text-info"></i> Copy', titleAttr: 'Copy'}, 
              {extend:'csv', text:'<i class="fas fa-file-excel text-primary"></i> CSV <i class="fas fa-download text-dark"></i>', titleAttr:'csv'}, 
              {extend:'excel', text:'<i class="fas fa-file-excel text-primary"></i> Excel <i class="fas fa-download text-dark"></i>', titleAttr:'excel'}, 
              {extend:'pdf', text:'<i class="fas fa-file-pdf text-danger"></i> PDF <i class="fas fa-download text-dark"></i>', titleAttr:'pdf'}, 
              {extend:'print', text:'<i class="fas fa-print text warning"></i> Print', titleAttr:'print'}
          ],
        "ajax": "AdminController/dtCenter",
        "order": [] 
    });//Datatable View

    //To Select the id of company to delete
    $(document).on('click', '#admin_delete_center', function(e){ 
        var memberid = $(this).data('id');
        SwalDelete(memberid);
        e.preventDefault();
    });

});//end doc ready function


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
        url: 'AdminController/delCenter',
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
            $('#dtCenter').DataTable().ajax.reload();
        })
        .fail(function(){
            swal.fire('Oops...', 'Something went wrong !', 'error');
        });
        });
        },
    allowOutsideClick: false
})  
}

//View Center
function viewCenter(id = null) {
    if(id) {   
      $.ajax({
        url: 'AdminController/getCntinfo',
        type: 'post',
        data: {member_id : id},
        dataType: 'json',
        success:function(response) {
          $('#cname').html(response.name);
          $('#cper').html(response.contact_person);
          $('#cemail').html(response.email);
          $('#cpass').html(response.password);
          $('#cphone').html(response.contact);
          $('#cgst').html(response.gst);
          $('#website').html(response.website);  
          $('#state').html(response.state);
          $('#city').html(response.city);  
          $('#pin').html(response.pincode);
          $('#address').html(response.address);        
        }
      });
    } else{
      alert("Error : Refresh the page again");
    }
  }