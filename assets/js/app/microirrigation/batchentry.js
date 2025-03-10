$(document).ready(function() {
  $(document).on('click','#submit',function(e){
    var spinner = $('#loader');
    $(".form-group").removeClass('has-error').removeClass('has-success');
    $(".text-danger").remove();
    $("#formBatch").unbind('submit').bind('submit', function() {
        spinner.show();
        $(".text-danger").remove();
        var form = $(this);
        var bid = $("#pid").val();
        var s_no = $("#s_no").val();
        
        if(s_no == "") {
            $("#s_no").closest('.form-group').addClass('has-error');
            $("#s_no").after('<p class="text-danger error-text">Serial number is required!</p>');
        } else {
            $("#s_no").closest('.form-group').removeClass('has-error');
            $("#s_no").closest('.form-group').addClass('has-success');                   
        }
        
        if(s_no) {
            $.ajax({
                url : form.attr('action'),
                type : form.attr('method'),
                data : form.serialize(),
                dataType : 'json',
                success:function(response) {
                    // remove the error 
                    $(".form-group").removeClass('has-error').removeClass('has-success');      
                    if(response.success == true) {
                      spinner.hide();
                      // reset the form
                      $("#formBatch")[0].reset();
                      Swal.fire({
                        icon: 'success',
                        title: 'Good Job!',
                        text: 'Batch added successfully!',                  
                        showConfirmButton: false,
                        timer: 5000
                      });     
                      window.location.href = "miproductview?id="+bid;
                    } else {
                        spinner.hide();
                      Swal.fire({
                        icon: 'error',
                        title: 'Ooops...',
                        text: response.messages,
                        showConfirmButton: false,
                        timer: 5000,
                        showClass: {popup: 'animate__animated animate__fadeInDown'},
                        hideClass: {popup: 'animate__animated animate__fadeOutUp'}
                      });
                    }  // /else
                } // success  
              }); // ajax subit
        }
        return false;
    }); // /submit form for create member
  }); // /add modal
});//end doc ready function
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