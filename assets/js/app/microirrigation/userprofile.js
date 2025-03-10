$(document).on('click', '.toggle-password', function() {
    $(this).toggleClass("fa-eye fa-eye-slash");
    var input = $("#edit_password");
    input.attr('type') === 'password' ? input.attr('type','text') : input.attr('type','password')
  });
  $(document).ready(function() {
    let id = $('#edit_cid').val();
    
    if(id){
      $.ajax({
        url: 'MicroirrigationController/getCominfo',
        type: 'post',
        data: {member_id : id},
        dataType: 'json',
        success:function(response) {
          $('#edit_cname').val(response.name);
          $('#edit_contact_person').val(response.contact_person);
          $('#edit_email').val(response.email);
          $('#edit_password').val(response.password);
          $('#edit_phone').val(response.contact);
          $('#edit_gst').val(response.gst);
          $('#edit_website').val(response.website);  
          $('#edit_state').val(response.state);
          $('#edit_city').val(response.city);  
          $('#edit_pincode').val(response.pincode);
          $('#edit_address').val(response.address);   
          $(".editModal").append('<input type="hidden" name="member_id" id="member_id" value="'+response.id+'"/>');
          $("#userForm").unbind('submit').bind('submit', function() {
          var form = $(this);
          // validation
          var edit_cname = $("#edit_cname").val();
            
          if(edit_cname == "") {
                $("#edit_cname").closest('.form-group').addClass('has-error');
                $("#edit_cname").after('<p class="text-danger error-text">Company name is required</p>');
          } else {
                $("#edit_cname").closest('.form-group').removeClass('has-error');
                $("#edit_cname").closest('.form-group').addClass('has-success');                   
          }
          if(edit_cname) {
            $.ajax({
              url: form.attr('action'),
              type: form.attr('method'),
              data: form.serialize(),
              dataType: 'json',
              success:function(response) {
                if(response.success == true) {
                  Swal.fire({
                    icon: 'success',
                    title: 'Good Job!',
                    text: 'Profile updated successfully!',                  
                    showConfirmButton: false,
                    timer: 5000
                  }) 
                } else {
                  $(function() {
                    const Toast = Swal.mixin({
                      toast: true,
                      position: 'top',
                      target:"#editMemForm",
                      showConfirmButton: false,
                      timer: 3000
                    });
                    Toast.fire({
                      icon: 'error',
                      title: 'Ooops! Something went wrong.'
                    });
                  });
                }
              } // /success
            }); // /ajax
          }
          return false;
        });     
        }//success ends
      });//ajax ends
    }else{
      alert("Error : Refresh the page again");
    }
  
      
    });