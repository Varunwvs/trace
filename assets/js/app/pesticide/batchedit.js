
$(document).ready(function(){
    let id = $('#edit_bid').val();
    
    if(id){
      $.ajax({
        url: 'PesticideController/getBatchinfo',
        type: 'post',
        data: {member_id : id},
        dataType: 'json',
        success:function(response) {
          $('#edit_batch_no').val(response.batch_no);
          $('#edit_mfg_date').val(response.mfd_date);
          $('#edit_exp_date').val(response.exp_date);          
          $(".editModal").append('<input type="hidden" name="member_id" id="member_id" value="'+response.id+'"/>');
          $("#formBatch").unbind('submit').bind('submit', function() {
          var form = $(this);
          // validation
          var edit_batch_no = $("#edit_batch_no").val();
          var edit_mfg_date = $("#edit_mfg_date").val();
          var edit_exp_date = $("#edit_exp_date").val();
            
            if(edit_batch_no == "") {
                $("#edit_batch_no").closest('.form-group').addClass('has-error');
                $("#edit_batch_no").after('<p class="text-danger error-text">Batch number is required!</p>');
            } else {
                $("#edit_batch_no").closest('.form-group').removeClass('has-error');
                $("#edit_batch_no").closest('.form-group').addClass('has-success');                   
            }
            if(edit_mfg_date == "") {
                $("#mfgdate").closest('.form-group').addClass('has-error');
                $("#mfgdate").after('<p class="text-danger error-text">select mfg date!</p>');
            } else {
                $("#mfgdate").closest('.form-group').removeClass('has-error');
                $("#mfgdate").closest('.form-group').addClass('has-success');                   
            }
            if(edit_exp_date == "") {
                $("#expdate").closest('.form-group').addClass('has-error');
                $("#expdate").after('<p class="text-danger error-text">select expiry date!</p>');
            } else {
                $("#expdate").closest('.form-group').removeClass('has-error');
                $("#expdate").closest('.form-group').addClass('has-success');                   
            }
          if(edit_batch_no && edit_mfg_date && edit_exp_date) {
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
                    text: 'Batch updated successfully!',                  
                    showConfirmButton: false,
                    timer: 5000
                  }) 
                } else {
                  $(function() {
                    const Toast = Swal.mixin({
                      toast: true,
                      position: 'top',
                      target:"#formBatch",
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
});//end of doc ready function

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