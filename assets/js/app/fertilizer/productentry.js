$(document).on('click','#greenlabel',function(){
	$(".glabel").toggleClass("hidden");
});
//Get the subcategory
$('#p_category').change(function(){ 
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
          $('#sub_category').find('option').not(':first').remove();

          // Add options
          $.each(response,function(index,data){
             $('#sub_category').append('<option value="'+data['subcategoryid']+'|'+data['subcategoryname']+'">'+data['subcategoryname']+'</option>');
          });
        }
    });
    return false;
});

//Get the items/product
$('#sub_category').change(function(){ 
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
          $('#p_name').find('option').not(':first').remove();

          // Add options
          $.each(response,function(index,data){
            $('#p_name').append('<option value="'+data['itemid']+'|'+data['itemname']+'">'+data['itemname']+'</option>');
          });
        }
    });
    return false;
});

//Get the uomid and netweight
$('#p_name').change(function(){ 
    var idss=$(this).val();
    var ids = idss.split("|");
    id= ids[0];
    var subidss = $('#sub_category').val();
    var subids = subidss.split("|");
    subid= subids[0];
    $.ajax({
        url : 'FertilizerController/getUomids',
        method : "POST",
        data : {id: id, subid:subid},
        async : true,
        dataType : 'json',
        success: function(response){             
          // Add options
          $.each(response,function(index,data){
            var uid = data['UomID'];                                  
            if(uid==='1'){
                uomname = "gram";
                uomw ="gm";
            }
            if(uid==='2'){
                uomname = "kilogram";
                uomw ="kg";
            }
            if(uid==='3'){
                uomname = "milliliter";
                uomw ="ml";
            }
            if(uid==='4'){
                uomname = "liter";
                uomw ="ltr";
            }
            $('#unit_w').val(uomname);
            $('#uomid').val(uid);
            $('#uomw').val(uomw);
          });
        }
    });
    $.ajax({
        url : 'FertilizerController/getNWs',
        method : "POST",
        data : {id: id, subid:subid},
        async : true,
        dataType : 'json',
        success: function(response){             
          // Add options
          $.each(response,function(index,data){
            var nid = data['packetsize'];
            var itid = data['itemid']; 
            var suid = data['subcategoryid'];
                       
            $.ajax({
                url : 'FertilizerController/getNW',
                data : {itid: itid, suid:suid},
                dataType : 'json',
                success: function(response){                      
                  // Add options
                //   $.each(response,function(index,data){ 
                //     // $('#net_w').append('<option value="'+data['nwname']+'">'+data['nwname']+'</option>');
                //     $('#net_w').append('<option value="'+data['nwname']+'" '+((data['nwname']==nid) ? 'selected="true"' : '')+'>'+data['nwname']+'</option>');
                //   });
                    if(suid === '3' && (itid==='5' || itid==='6' || itid==='7' || itid==='8' || itid==='9' || itid==='10' || itid==='11' || itid==='12')){
                        $('#net_w').empty();
                        $('#net_w').append('<option value="0.25" '+((data['nwname']==nid)
                        ? 'selected="true"' : '')+'>0.25</option> <option value="0.5" '+((data['nwname']==nid)
                        ? 'selected="true"' : '')+'>0.5</option><option value="0.75" '+((data['nwname']==nid)
                        ? 'selected="true"' : '')+'>0.75</option><option value="1" selected>1</option>');
                        $('#net_w').attr("style", "pointer-events: all;");
                    }
                    else if(suid === '4' && (itid==='10' || itid==='8' || itid==='9' || itid==='10' || itid==='11' || itid==='12' || itid==='13' || itid==='14'))
                    {
                        $('#net_w').empty();
                        $('#net_w').append('<option value="0.25" '+((data['nwname']==nid)
                        ? 'selected="true"' : '')+'>0.25</option> <option value="0.5" '+((data['nwname']==nid)
                        ? 'selected="true"' : '')+'>0.5</option><option value="0.75" '+((data['nwname']==nid)
                        ? 'selected="true"' : '')+'>0.75</option><option value="1" selected>1</option>');
                        $('#net_w').attr("style", "pointer-events: all;");
                    }
                    else{
                        $('#net_w').empty();
                        $('#net_w').append('<option value="'+data['packetsize']+'">'+data['packetsize']+'</option>');
                        $('#net_w').attr("style", "pointer-events: none;");
                    }
                }
            });            
          });
        }
    });
    return false;
});

//Fetch UPC number
$(document).on('click','#btnClick',function(){
	$.post("FertilizerController/showupc",
      {get_count:true},
      function(result){
        $("#upc").val(result);
      }
    );
});

$(document).ready(function(){
    var spinner = $('#loader');
    $(document).on('click','#submit',function(e){
        // reset the form 
        // $("#formProduct")[0].reset();
        // remove the error 
        $(".form-group").removeClass('has-error').removeClass('has-success');
        $(".text-danger").remove();
        $("#formProduct").unbind('submit').bind('submit', function() {
            spinner.show();
            $(".text-danger").remove();
            var form = $(this);
            var cname = $("#cname").val();
            var marketed_by = $("#marketed_by").val();
            var p_category = $("#p_category").val();
            var pcid = p_category.split("|");
            p_category= pcid[0];
            var sub_category = $("#sub_category").val();
            var scid = sub_category.split("|");
            sub_category= scid[0];
            var upc = $("#upc").val();
            var p_name = $("#p_name").val();
            var pnm = p_name.split("|");
            p_name= pnm[0];
            var b_name = $("#b_name").val();
            var bnm = b_name.split("|");
            b_name= bnm[0];
            var unit_w = $("#unit_w").val();
            var uw = unit_w.split("|");
            unit_w= uw[0];
            var net_w = $("#net_w").val();
            if(cname == "") {
                $("#cname").closest('.form-group').addClass('has-error');
                $("#cname").after('<p class="text-danger error-text">Company name is required!</p>');
            } else {
                $("#cname").closest('.form-group').removeClass('has-error');
                $("#cname").closest('.form-group').addClass('has-success');                   
            }
            if(marketed_by == "") {
                $("#marketed_by").closest('.form-group').addClass('has-error');
                $("#marketed_by").after('<p class="text-danger error-text">Marketed by/RC holder name is required!</p>');
            } else {
                $("#marketed_by").closest('.form-group').removeClass('has-error');
                $("#marketed_by").closest('.form-group').addClass('has-success');                   
            }
            if(p_category == "0") {
                $("#p_category").closest('.form-group').addClass('has-error');
                $("#p_category").after('<p class="text-danger error-text">Please select product category!</p>');
            } else {
                $("#p_category").closest('.form-group').removeClass('has-error');
                $("#p_category").closest('.form-group').addClass('has-success');                   
            }
            if(sub_category == "0") {
                $("#sub_category").closest('.form-group').addClass('has-error');
                $("#sub_category").after('<p class="text-danger error-text">Please select product sub category!</p>');
            } else {
                $("#sub_category").closest('.form-group').removeClass('has-error');
                $("#sub_category").closest('.form-group').addClass('has-success');                   
            }
            if(upc == "") {
                $(".input-group").closest('.form-group').addClass('has-error');
                $(".input-group").after('<br><p class="text-danger error-text">Click the button to generate upc!</p>');
            } else {
                $(".input-group").closest('.form-group').removeClass('has-error');
                $(".input-group").closest('.form-group').addClass('has-success');                   
            }
            if(p_name == "0") {
                $("#p_name").closest('.form-group').addClass('has-error');
                $("#p_name").after('<br><p class="text-danger error-text">Product name is required!</p>');
            } else {
                $("#p_name").closest('.form-group').removeClass('has-error');
                $("#p_name").closest('.form-group').addClass('has-success');                   
            }
            if(b_name == "") {
                $("#b_name").closest('.form-group').addClass('has-error');
                $("#b_name").after('<br><p class="text-danger error-text">Brand name is required!</p>');
            } else {
                $("#b_name").closest('.form-group').removeClass('has-error');
                $("#b_name").closest('.form-group').addClass('has-success');                   
            }
            if(unit_w == "0") {
                $("#unit_w").closest('.form-group').addClass('has-error');
                $("#unit_w").after('<br><p class="text-danger error-text">Please select unit of measurement!</p>');
            } else {
                $("#unit_w").closest('.form-group').removeClass('has-error');
                $("#unit_w").closest('.form-group').addClass('has-success');                   
            }
            if(net_w == "") {
                $("#net_w").closest('.form-group').addClass('has-error');
                $("#net_w").after('<br><p class="text-danger error-text">Net Weight is required!</p>');
            } else {
                $("#net_w").closest('.form-group').removeClass('has-error');
                $("#net_w").closest('.form-group').addClass('has-success');                   
            }
            if(cname && marketed_by && p_category && sub_category && upc && p_name && b_name && unit_w && net_w) {
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
                            $("#formProduct")[0].reset();
                            Swal.fire({
                                icon: 'success',
                                title: 'Good Job!',
                                text: 'Product added successfully!',                  
                                showConfirmButton: false,
                                timer: 5000
                            });                     
                            
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
});//end of doc ready function