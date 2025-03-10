$(document).ready(function() {
    let id = $('#rid').val();
    
    if(id){
        $.ajax({
            url: 'SeedController/getRawMaterialInfo',
            type: 'post',
            data: {r_id: id},
            dataType: 'json',
            success: function (response) {
                if (!response.error) {
                    $("#edit_category").val(response.category_id).trigger('change');
                    $("#edit_raw_material").val(response.raw_material_name);
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
  
    $("#formRawMaterialEdit").unbind('submit').bind('submit', function() {
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
  // console.log(response.success);
            if(response.success == true) {
              $("#formRawMaterialEdit")[0].reset();
              Swal.fire({
                  icon: 'success',
                  title: 'Good Job!',
                  text: 'Raw material Updated successfully!',                  
                  showConfirmButton: false,
                  timer: 5000
                }); 
                window.location.href = "rawmaterialmanage";
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