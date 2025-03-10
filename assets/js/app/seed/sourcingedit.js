$(document).ready(function() {
    let id = $('#sid').val();
    
    if(id){
        $.ajax({
            url: 'SeedController/getSourcingInfo',
            type: 'post',
            data: {id: id},
            dataType: 'json',
            success: function (response) {
                if (!response.error) {
                    $("#edit_product_id").val(response.product_id).trigger('change');
                    $("#edit_lot_reference_no").val(response.lot_reference_no);
                    $("#edit_vendor_id").val(response.vendor_id).trigger('change');
                    $("#edit_raw_material_id").val(response.raw_material_id).trigger('change');
                    $("#edit_qty").val(response.qty);
                    $("#edit_uom").val(response.uom_id).trigger('change');
                    $("#edit_date_of_sourcing").val(response.date_of_sourcing);
                    $("#edit_file").val(response.grn_file);

                    if (response.grn_file) {
                      let filePath = `uploads/grn_files/${response.grn_file}`;
                      $(".pcontent").html(
                          `<a style="color: #29875a !important; text-decoration: none !important;" href="${filePath}" target="_blank"><span class="fa fa-eye"></span> View File</a>`
                      );
                  } else {
                      $(".pcontent").html('<p class="text-muted">No file uploaded</p>');
                  }
                
                } else {
                    alert(response.error);
                }
            },
            error: function () {
                alert("Error fetching sourcing details.");
            }
        });//ajax ends
    }else{
      alert("Error : Refresh the page again");
    }
      
});

$(document).on('click','#submit',function(e){
  
  $("#formEditSourcing").unbind('submit').bind('submit', function() {
    $(".text-danger").remove();
    var form = $(this);
    // validation
   
      //submi the form to server
      $.ajax({
        url : 'SeedController/editSourcing',
        type : 'POST',
        data: new FormData(this),
        contentType: false,
        cache: false,
        processData: false,
        dataType : 'json',
        success:function(response) {

          if(response.success == true) {
            $("#formEditSourcing")[0].reset();
            Swal.fire({
                icon: 'success',
                title: 'Good Job!',
                text: 'Sourcing Updated successfully!',                  
                showConfirmButton: false,
                timer: 5000
              }); 
              window.location.href = "sourcingmanage";
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