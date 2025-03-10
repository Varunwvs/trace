$(document).ready(function() {
    
    $(document).on('click','#bluelabel',function(){
      $(".blabel").toggleClass("hidden");
    });

    
    var spinner = $('#loader');
    //Submit Form Using Ajax
    $(document).on('click','#submit',function(e){
        let bid = $('#pid').val();
      // remove the error 
      $("#batch_no").css({"border-color": "gray"});
      $(".text-danger").remove();
      // submit form
      $("#formBatch").unbind('submit').bind('submit', function() {
        spinner.show();
        $(".text-danger").remove();
        var form = $(this);
        // validation
        var batch_no = $("#batch_no").val();
        if(batch_no == "") {
          $("#batch_no").css({"border-color": "red"});
        } else {
          $("#batch_no").css({"border-color": "gray"});       
        }
  
        if(batch_no) {
          //submi the form to server
          $.ajax({
            url : 'SeedController/addBatch',
            type : 'POST',
            data : new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            dataType : 'json',
            success:function(response) {
  
              // remove the error 
              $("#batch_no").css({"border-color": "gray"});
  
              if(response.success == true) {
                spinner.hide();
                $("#formBatch")[0].reset();
                Swal.fire({
                    icon: 'success',
                    title: 'Good Job!',
                    text: 'Batch added successfully!',                  
                    showConfirmButton: false,
                    timer: 5000
                  }); 
                  window.location.href = "productview?id="+bid;
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
    
      $('#issuedate').datetimepicker({
      format: 'DD-MM-YYYY',
      todayHighlight: true
  }); 

  $('#testdate').datetimepicker({
    format: 'DD-MM-YYYY',
    todayHighlight: true
}); 

$('#validdate').datetimepicker({
  format: 'DD-MM-YYYY',
  todayHighlight: true
}); 
    
});