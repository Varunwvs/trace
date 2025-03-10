$(document).ready(function() {
    //Submit Form Using Ajax
    $(document).on('click','#submit',function(e){
      // remove the error 
      $("#edit_batch_no").css({"border-color": "gray"});
      $(".text-danger").remove();
      // submit form
      $("#formBatch").unbind('submit').bind('submit', function() {
        $(".text-danger").remove();
        var form = $(this);
        // validation
        var edit_batch_no = $("#edit_batch_no").val();
        if(edit_batch_no == "") {
          $("#edit_batch_no").css({"border-color": "red"});
        } else {
          $("#edit_batch_no").css({"border-color": "gray"});       
        }
  
        if(edit_batch_no) {
          //submi the form to server
          $.ajax({
            url : form.attr('action'),
            type : form.attr('method'),
            data : form.serialize(),
            dataType : 'json',
            success:function(response) {
  
              // remove the error 
              $("#edit_batch_no").css({"border-color": "gray"});
  
              if(response.success == true) {
                Swal.fire({
                    icon: 'success',
                    title: 'Good Job!',
                    text: 'Batch info updated successfully!',                  
                    showConfirmButton: false,
                    timer: 5000
                  }); 
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
        } /// if
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