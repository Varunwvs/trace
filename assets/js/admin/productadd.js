$(document).on('click','#btnClick',function(){
	$.post("AdminController/showupc",
      {get_count:true},
      function(result){
        $("#upc").val(result);
      }
    );
});

$(document).on('click','#greenlabel',function(){
	$(".glabel").toggleClass("hidden");
});

$(document).ready(function() {
    //Submit Form Using Ajax
    $("#submit").on('click', function(e) {
      // remove the error 
      $("#upc").css({"border-color": "gray"});
      $(".text-danger").remove();
      // submit form
      $("#formProduct").unbind('submit').bind('submit', function() {
        $(".text-danger").remove();
        var form = $(this);
        // validation
        var upc = $("#upc").val();
        if(upc == "") {
          $("#upc").css({"border-color": "red"});
        } else {
          $("#upc").css({"border-color": "gray"});       
        }
  
        if(upc) {
          //submi the form to server
          $.ajax({
            url : form.attr('action'),
            type : form.attr('method'),
            data : form.serialize(),
            dataType : 'json',
            success:function(response) {
  
              // remove the error 
              $("#upc").css({"border-color": "gray"});
  
              if(response.success == true) {
                $("#formProduct")[0].reset();
                Swal.fire({
                  icon: 'success',
                  title: 'Good Job!',
                  text: 'Product added successfully!',                  
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
  });//end doc ready function