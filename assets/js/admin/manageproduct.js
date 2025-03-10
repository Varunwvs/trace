$(document).ready(function(){
    //Data Table Function
    var dtProduct = $('#dtProduct').DataTable({
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
        "ajax": "AdminController/dtProduct",
        "order": [] 
    });//Datatable View

    //To Select the id of product to delete
    $(document).on('click', '#admin_delete_product', function(e){ 
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
            url: 'AdminController/delProduct',
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
                $('#dtProduct').DataTable().ajax.reload();
            })
            .fail(function(){
                swal.fire('Oops...', 'Something went wrong !', 'error');
            });
            });
            },
        allowOutsideClick: false
    })  
}

//Increase total count
function viewMember(id = null) {
    if(id) {   
      $.ajax({
        url: 'AdminController/getPrdinfo',
        type: 'post',
        data: {member_id : id},
        dataType: 'json',
        success:function(response) {
          $('#cname').html(response.name);
          $('#mktby').html(response.marketed_by);
          $('#prdcat').html(response.p_category);
          $('#subcat').html(response.sub_category);
          if(response.onlyprimary==='1'){
            $('#isprimary').html('Primary');
          }else {
            $('#isprimary').html('Secondary');
          }          
          $('#upc').html(response.p_code);
          $('#prdname').html(response.p_name);
          $('#brdname').html(response.b_name);
          $('#muw').html(response.unit_w);  
          $('#ncw').html(response.net_w);       
        }
      });
    } else{
      alert("Error : Refresh the page again");
    }
  }
  
  