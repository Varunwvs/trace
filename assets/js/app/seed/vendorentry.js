$(document).ready(function() {
    var spinner = $('#loader');
    //Submit Form Using Ajax
    $(document).on('click','#submit',function(e){
        let bid = $('#pid').val();
      // remove the error 
      $("#batch_no").css({"border-color": "gray"});
      $(".text-danger").remove();
      // submit form
      $("#formVendor").unbind('submit').bind('submit', function() {
        spinner.show();
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
                spinner.hide();
                $("#formVendor")[0].reset();
                Swal.fire({
                    icon: 'success',
                    title: 'Good Job!',
                    text: 'Vendor added successfully!',                  
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
    }); // /add modal
  });
$(function () {
    $('#mfgdate').datetimepicker({
        format: 'DD-MM-YYYY',
        todayHighlight: true
    }); 
    
    $('#expdate').datetimepicker({
        format: 'DD-MM-YYYY',
        todayHighlight: true
    }); 
});