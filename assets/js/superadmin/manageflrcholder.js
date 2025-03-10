$(document).ready(function(){
    //Data Table Function
    var dtFlrcholder = $('#dtFlrcholder').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": true,
        "responsive": true,
        "columnDefs": [{ targets: [0], className: 'dt-center valign dt-w3' },
                      { targets: [1], className: 'dt-left valign dt-w22' },
                      { targets: [2], className: 'dt-left text-wrap valign dt-w22' },
                      { targets: [3], className: 'dt-left text-wrap valign dt-w16' },
                      { targets: [4,5], className: 'dt-center valign dt-w10' },
                      {targets: [6], className: 'dt-center dt-w17 valign'}],
        dom: 'Bfrtip',
          buttons: [
              {extend:'copy', text:'<i class="fas fa-copy text-info"></i> Copy', titleAttr: 'Copy'}, 
              {extend:'csv', text:'<i class="fas fa-file-excel text-primary"></i> CSV <i class="fas fa-download text-dark"></i>', titleAttr:'csv'}, 
              {extend:'excel', text:'<i class="fas fa-file-excel text-primary"></i> Excel <i class="fas fa-download text-dark"></i>', titleAttr:'excel'}, 
              {extend:'pdf', text:'<i class="fas fa-file-pdf text-danger"></i> PDF <i class="fas fa-download text-dark"></i>', titleAttr:'pdf'}, 
              {extend:'print', text:'<i class="fas fa-print text warning"></i> Print', titleAttr:'print'}
          ],
        "ajax": "SuperAdminController/dtFlrcholder",
        "order": [] 
    });//Datatable View
    
    //To Select the id of company to update
    $(document).on('click', '#update_rcstatus', function(e){ 
        var memberid = $(this).data('id');
        SwalUpdate(memberid);
        e.preventDefault();
    });

    //To Select the id of company to update
    $(document).on('click', '#update_rcrole', function(e){ 
      var memberid = $(this).data('id');
      SwalRole(memberid);
      e.preventDefault();
   });

    //To Select the id of company to delete
    $(document).on('click', '#delete_rcholder', function(e){ 
      var memberid = $(this).data('id');
      SwalDelete(memberid);
      e.preventDefault();
    });
  });//end of doc ready function
  
  //Update Swal popup
  function SwalUpdate(memberid){  
    Swal.fire({
      title: 'Are you sure?',
      text: "You want to change the status!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, change the status!',
      showLoaderOnConfirm: true,
      preConfirm: function() {
         return new Promise(function(resolve) {                
            $.ajax({
            url: 'SuperAdminController/updRcstatus',
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
                $('#dtFlrcholder').DataTable().ajax.reload();
            })
            .fail(function(){
             swal.fire('Oops...', 'Something went wrong !', 'error');
            });
         });
          },
       allowOutsideClick: false
    })  
   }

   //Update Swal popup
   function SwalRole(memberid){  
      Swal.fire({
      title: 'Are you sure?',
      text: "You want to change the role!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, change the role!',
      showLoaderOnConfirm: true,
      preConfirm: function() {
         return new Promise(function(resolve) {                
            $.ajax({
            url: 'SuperAdminController/updRcrole',
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
                  $('#dtFlrcholder').DataTable().ajax.reload();
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
   function editMember(id = null) {
      if(id) {
      // remove the error 
      $(".form-group").removeClass('has-error').removeClass('has-success');
      $(".text-danger").remove();
      // remove the id
      $("#member_id").remove();
      // fetch the member data
      $.ajax({
         url: 'SuperAdminController/getrcTotalCount',
            type: 'post',
            data: {member_id : id},
            dataType: 'json',
            success:function(response) {
            $('#rctotalcount').val(response.totalproduct);
            $(".editModal").append('<input type="hidden" name="member_id" id="member_id" value="'+response.id+'"/>');
            $("#editRcForm").unbind('submit').bind('submit', function() {
            $(".text-danger").remove();
            var form = $(this);
            // validation
            var rctotalcount = $("#rctotalcount").val();
   
            if(rctotalcount === "0") {
                  $("#rctotalcount").closest('.form-group').addClass('has-error');
                  $("#rctotalcount").after('<p class="text-danger">Please select product count!</p>');
            } else {
                  $("#rctotalcount").closest('.form-group').removeClass('has-error');
                  $("#rctotalcount").closest('.form-group').addClass('has-success');                   
            }
            if(rctotalcount) {
               $.ajax({
                  url: form.attr('action'),
                  type: form.attr('method'),
                  data: form.serialize(),
                  dataType: 'json',
                  success:function(response) {
                  if(response.success == true) {
                     $(function() {
                        const Toast = Swal.mixin({
                        toast: true,
                        position: 'top',
                        target:"#editRcForm",
                        showConfirmButton: false,
                        timer: 3000
                        });
                        Toast.fire({
                        icon: 'success',
                        title: 'Total count increased successfully!'
                        });
                     });
                     // $('#dtFlrcholder').DataTable().ajax.reload();
                  } else {
                     $(function() {
                        const Toast = Swal.mixin({
                        toast: true,
                        position: 'top',
                        target:"#editRcForm",
                        showConfirmButton: false,
                        timer: 3000
                        });
                        Toast.fire({
                        icon: 'error',
                        title: 'Ooops! Something went wrong.'
                        });
                     });
                  }
                  } // /success
               }); // /ajax
            }
            return false;
            });
         }
      });
      } else{
      alert("Error : Refresh the page again");
      }
   }
   
      //Increase total count
function editQrcode(id = null) {
   if(id) {
     // remove the error 
     $(".form-group").removeClass('has-error').removeClass('has-success');
     $(".text-danger").remove();
     // remove the id
     $("#member_id").remove();
     // fetch the member data
     $.ajax({
       url: 'SuperAdminController/getrcQrqty',
         type: 'post',
         data: {member_id : id},
         dataType: 'json',
         success:function(response) {
           $('#qrquantity').val(response.qr_quantity);
           $(".editQr").append('<input type="hidden" name="member_id" id="member_id" value="'+response.id+'"/>');
           $("#editQrForm").unbind('submit').bind('submit', function() {
           $(".text-danger").remove();
           var form = $(this);
           // validation
           var qrquantity = $("#qrquantity").val();
 
           if(qrquantity === "0") {
               $("#qrquantity").closest('.form-group').addClass('has-error');
               $("#qrquantity").after('<p class="text-danger">Please enter qr quantity!</p>');
           } else {
               $("#qrquantity").closest('.form-group').removeClass('has-error');
               $("#qrquantity").closest('.form-group').addClass('has-success');                   
           }
           if(qrquantity) {
             $.ajax({
               url: form.attr('action'),
               type: form.attr('method'),
               data: form.serialize(),
               dataType: 'json',
               success:function(response) {
                 if(response.success == true) {
                   $(function() {
                     const Toast = Swal.mixin({
                       toast: true,
                       position: 'top',
                       target:"#editQrForm",
                       showConfirmButton: false,
                       timer: 3000
                     });
                     Toast.fire({
                       icon: 'success',
                       title: 'QR Quantity updated successfully'
                     });
                   });
                   $('#dtFlrcholder').DataTable().ajax.reload();
                 } else {
                   $(function() {
                     const Toast = Swal.mixin({
                       toast: true,
                       position: 'top',
                       target:"#editQrForm",
                       showConfirmButton: false,
                       timer: 3000
                     });
                     Toast.fire({
                       icon: 'error',
                       title: 'Ooops! Something went wrong.'
                     });
                   });
                 }
               } // /success
             }); // /ajax
           }
           return false;
         });
       }
     });
   } else{
     alert("Error : Refresh the page again");
   }
 }

   //Increase total count
   function viewMember(id = null) {
      if(id) {   
      $.ajax({
         url: 'SuperAdminController/getRcinfo',
         type: 'post',
         data: {member_id : id},
         dataType: 'json',
         success:function(response) {
            $('#cname').html(response.name);
            $('#bcat').html(response.catname);
            $('#cper').html(response.contact_person);
            $('#cemail').html(response.email);
            $('#cpass').html(response.password);
            $('#cphone').html(response.contact);
            $('#cgst').html(response.gst);
            $('#totprd').html(response.totalproduct);
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
            url: 'SuperAdminController/delRcholder',
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
                $('#dtFlrcholder').DataTable().ajax.reload();
            })
            .fail(function(){
             swal.fire('Oops...', 'Something went wrong !', 'error');
            });
         });
          },
       allowOutsideClick: false
    })  
   }