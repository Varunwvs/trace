$(document).on('click', '.toggle-password', function() {
  $(this).toggleClass("fa-eye fa-eye-slash");
  var input = $("#password");
  input.attr('type') === 'password' ? input.attr('type','text') : input.attr('type','password')
});

$(document).ready(function() {
    //Submit Form Using Ajax
    $("#submit").on('click', function(e) {
      // remove the error 
      $("#cname").css({"border-color": "gray"});
      $(".text-danger").remove();
      // submit form
      $("#userForm").unbind('submit').bind('submit', function() {
        $(".text-danger").remove();
        var form = $(this);
        // validation
        var cname = $("#cname").val();
        if(cname == "") {
          $("#cname").css({"border-color": "red"});
        } else {
          $("#cname").css({"border-color": "gray"});       
        }
  
        if(cname) {
          //submi the form to server
          $.ajax({
            url : form.attr('action'),
            type : form.attr('method'),
            data : form.serialize(),
            dataType : 'json',
            success:function(response) {
  
              // remove the error 
              $("#cname").css({"border-color": "gray"});
  
              if(response.success == true) {
                $("#userForm")[0].reset();
                Swal.fire({
                  icon: 'success',
                  title: 'Good Job!',
                  text: 'RC Holder Added Successfully!',                  
                  showConfirmButton: false,
                  timer: 5000
                })  
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