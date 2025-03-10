$(document).ready(function() {
    //Submit Form Using Ajax
    var spinner = $('#loader');
    $(document).on('click','#submit',function(e){
        let bid = $('#bid').val();
    //  alert('Hi');
      // remove the error 
      $(".form-control form-control-sm").removeClass('has-error').removeClass('has-success');
      $(".text-danger").remove();
      // submit form
      $("#formContainer").unbind('submit').bind('submit', function() {
          spinner.show();
        $(".text-danger").remove();
        var form = $(this);
        // validation
        //var ucc = $("#ucc").val();
        // if(ucc == "") {
        //   $("#ucc").closest('.form-control form-control-sm').addClass('has-error');
        //   $("#ucc").after('<td class="text-danger text-center" colspan="11">Please enter batch no<br></td>');
        // } else {
        //   $("#ucc").closest('.form-control form-control-sm').removeClass('has-error');
        //   $("#ucc").closest('.form-control form-control-sm').addClass('has-success');        
        // }
  
       // if(ucc) {
          //submi the form to server
          $.ajax({
            url : form.attr('action'),
            type : form.attr('method'),
            data : form.serialize(),
            dataType : 'json',
            success:function(response) {
  
              // remove the error 
              $(".form-control form-control-sm").removeClass('has-error').removeClass('has-success');
  
              if(response.success == true) {
                  spinner.hide();
                Swal.fire({
                  icon: 'success',
                  title: 'Good Job!',
                  text: 'Container Saved Successfully',
                  //footer: '<a href="'+response.messages+'" target="_blank" class="btn btn-primary"><i class="fa fa-print"></i> Print Invoice</a>',
                  showConfirmButton: false,
                  timer: 5000
                })
                // reset the form
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
                })
                }  // /else
            } // success  
          }); // ajax subit         
        //} /// if
        return false;
      }); // /submit form for create member
    }); // /add modal
  });
  $(document).on('click','#btnClick',function(){
    $.post("MicroirrigationController/showucc",
        {get_count:true},
        function(result){
          $("#ucc").val(result);
        }
      );
  });
  
  $(document).on('change keyup blur','#batchno',function(){
    var member_id = $(this).val();
    $.ajax({
        type: "POST", 
        url: "MicroirrigationController/getBinfo",
        data: {"member_id": member_id}, 
        dataType: 'json', 
        success: function(result){  
          if(member_id!='0'){ 
            $("#pid").val(result.pid);
            $("#bid").val(result.id);                 
          }
          else{
            $("#pid").val("");
              $("#bid").val("");
          }
        }      
      });
  });
  
  
  //Initialize Select2 Elements
  $(function () {
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })
  })