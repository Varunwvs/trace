$(document).ready(function() {
    let id = $('#vid').val();
    
    if(id){
        $.ajax({
            url: 'SeedController/getVendorInfo',
            type: 'post',
            data: {vendor_id: id},
            dataType: 'json',
            success: function (response) {
                if (!response.error) {
                    $("#edit_vendor_name").val(response.vendor_name);
                    $("#edit_gst_no").val(response.gst_no);
                    $("#edit_address").val(response.address);
                    $("#edit_contact_person").val(response.contact_person);
                    $("#edit_contact_no").val(response.contact_no);
                    $("#edit_bank_name").val(response.bank_name);
                    $("#edit_bank_branch").val(response.bank_branch);
                    $("#edit_account_no").val(response.account_no);
                    $("#edit_ifsc_code").val(response.ifsc_code);
                } else {
                    alert(response.error);
                }
            },
            error: function () {
                alert("Error fetching vendor details.");
            }
        });//ajax ends
    }else{
      alert("Error : Refresh the page again");
    }
      
});

$(document).on('click','#submit',function(e){
  
  $("#formVendorEdit").unbind('submit').bind('submit', function() {
    $(".text-danger").remove();
    var form = $(this);
    // validation
   
      //submi the form to server
      $.ajax({
        url : form.attr('action'),
        type : form.attr('method'),
        data : form.serialize(),
        dataType : 'json',
        success:function(response) {

          if(response.success == true) {
            $("#formVendorEdit")[0].reset();
            Swal.fire({
                icon: 'success',
                title: 'Good Job!',
                text: 'Vendor Updated successfully!',                  
                showConfirmButton: false,
                timer: 5000
              }); 
              window.location.href = "vendormanage";
          } else {
              Swal.fire({
              icon: 'error',
              title: 'Ooops...',
              text: response.messages,
              showConfirmButton: false,
              timer: 5000,
              showClass: {popup: 'animate__animated animate__fadeInDown'},
              hideClass: {popup: 'animate__animated animate__fadeOutUp'}
            })
            }  // /else
        } // success  
      }); // ajax subit         
   
    return false;
  }); // /submit form for create member
});