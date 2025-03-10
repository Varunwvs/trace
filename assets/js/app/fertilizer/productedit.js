//Get the subcategory
$('#edit_p_category').change(function(){ 
    var idss=$(this).val();
    var ids = idss.split("|");
    id= ids[0];
    $.ajax({
        url : 'FertilizerController/getItemSubCategory',
        method : "POST",
        data : {id: id},
        async : true,
        dataType : 'json',
        success: function(response){   
          // Remove options 
          $('#edit_sub_category').find('option').not(':first').remove();
          var p_category = $('#edit_p_category').data('id');
          // Add options
          $.each(response,function(index,data){
             $('#edit_sub_category').append('<option value="'+data['subcategoryid']+'|'+data['subcategoryname']+'" '+((data['subcategoryid']==p_category) ? 'selected="true"' : '')+'>'+data['subcategoryname']+'</option>').trigger('change');
          });
        }
    });
    return false;
});

//Get the items/product
$('#edit_sub_category').change(function(){ 
    var idss=$(this).val();
    var ids = idss.split("|");
    id= ids[0];
    $.ajax({
        url : 'FertilizerController/getItem',
        method : "POST",
        data : {id: id},
        async : true,
        dataType : 'json',
        success: function(response){   
          // Remove options 
          $('#edit_p_name').find('option').not(':first').remove();
          var itemids = $('#edit_sub_category').data('id');
          // Add options
          $.each(response,function(index,data){
            $('#edit_p_name').append('<option value="'+data['itemid']+'|'+data['itemname']+'" '+((data['itemid']==itemids) ? 'selected="true"' : '')+'>'+data['itemname']+'</option>').trigger('change');
          });
        }
    });
    return false;
});

//Get the uomid and netweight
$('#edit_p_name').change(function(){ 
    var idss=$(this).val();
    var ids = idss.split("|");
    id= ids[0];
    $.ajax({
        url : 'FertilizerController/getUomids',
        method : "POST",
        data : {id: id},
        async : true,
        dataType : 'json',
        success: function(response){             
          // Add options
          $.each(response,function(index,data){
            var uid = data['UomID'];
                        
            $.ajax({
                url : 'FertilizerController/getUomid',
                dataType : 'json',
                success: function(response){                      
                  // Add options
                  $.each(response,function(index,data){ 
                     $('#edit_unit_w').append('<option value="'+data['uomid']+'|'+data['slug']+'" '+((data['uomid']==uid) ? 'selected="true"' : '')+'>'+data['uomname']+'</option>');
                  });
                }
            });
            $('#edit_net_w').val(data['packetsize']);
          });
        }
    });
    return false;
});

$(document).ready(function(){
    let id = $('#edit_pid').val();
    
    if(id){
      $.ajax({
        url: 'FertilizerController/getPrdinfo',
        type: 'post',
        data: {member_id : id},
        dataType: 'json',
        success:function(response) {
          $('#edit_cname').val(response.name);
          $('#edit_marketed_by').val(response.marketed_by);
          $('#edit_p_category').val(response.itemcategoryid+'|'+response.itemcategory).trigger('change');
          $("#edit_p_category").data('id',response.itemcategoryid);
          $('#edit_sub_category').val(response.subcategoryid+'|'+response.subcategory).trigger('change');
          $("#edit_sub_category").data('id',response.itemid);
          $('#edit_upc').val(response.p_code);
          $('#edit_p_name').val(response.itemid+'|'+response.p_name).trigger('change');
          $("#edit_p_name").data('id',response.itemid);
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
});//end of doc ready function