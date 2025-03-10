$(document).ready(function() {
    let id = $('#edit_pid').val();
    
    if(id){
      $.ajax({
        url: 'AdminController/getPrdinfo',
        type: 'post',
        data: {member_id : id},
        dataType: 'json',
        success:function(response) {
          $('#edit_cname').val(response.name);
          $('#edit_marketed_by').val(response.marketed_by);
          $('#edit_p_category').val(response.p_category);
          $('#edit_sub_category').val(response.sub_category);
          $('#edit_upc').val(response.p_code);
          $('#edit_p_name').val(response.p_name);
          $('#edit_b_name').val(response.b_name); 
          $('#edit_unit_w').val(response.uomid+'|'+response.unit_w);
          $('#edit_net_w').val(response.net_w);  
          $('#edit_onlyprimary').val(response.onlyprimary);
          let op = response.onlyprimary;
          if(op==='1'){
            $('#edit_onlyprimary').prop("checked", true);
          }else{
            $('#edit_onlyprimary').prop("checked", false);
          }          
          $('#edit_prdlink').val(response.prdlink);
          $('#edit_mrp').val(response.mrp);
          $('#edit_germination').val(response.germination);   
          $('#edit_phypurity').val(response.phypurity);
          $('#edit_moisture').val(response.moisture);
          $('#edit_inertmatter').val(response.inertmatter);
          $('#edit_othercrop').val(response.othercrop);
          $(".editModal").append('<input type="hidden" name="member_id" id="member_id" value="'+response.id+'"/>');
          $("#formProduct").unbind('submit').bind('submit', function() {
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
                    text: 'Product updated successfully!',                  
                    showConfirmButton: false,
                    timer: 5000
                  }) 
                } else {
                  $(function() {
                    const Toast = Swal.mixin({
                      toast: true,
                      position: 'top',
                      target:"#formProduct",
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