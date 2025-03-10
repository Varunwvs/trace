//Get the subcategory
$('#p_category').change(function(){ 
    var idss=$(this).val();
    var ids = idss.split("|");
    id= ids[0];
    $.ajax({
        url : 'TarpaulinController/getItemSubCategory',
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
        url : 'TarpaulinController/getItem',
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
        url : 'TarpaulinController/getUomids',
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
            if(uid==='5'){
                uomname = "number";
                uomw ="num";
            }
            if(uid==='6'){
                uomname = "Meter";
                uomw ="mtr";
            }
            $('#unit_w').val(uomname);
            $('#uomid').val(uid);
            $('#uomw').val(uomw);
          });
        }
    });
    $.ajax({
        url : 'TarpaulinController/getNWs',
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
                url : 'TarpaulinController/getNW',
                data : {itid: itid, suid:suid},
                cache : false,
                dataType : 'json',
                success: function(response){     
                    if(suid==='49' && (itid==='1' || itid==='2' || itid==='3')){
                        $('#net_w').empty();
                        $('#net_w').append('<option value="1" selected>1</option> <option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option>');
                        $('#net_w').attr("style", "pointer-events: all;");
                        $('#uomlbl').html("Number of Pieces / Pack *");
                    }
                    else if(suid==='2' && itid==='1'){
                        $('#net_w').empty();
                        $('#net_w').append('<option value="63" selected>63mm Sprinkler Class II, 3.2kg/cm&sup2;</option> <option value="75">75mm Sprinkler Class I, 2.5kg/cm&sup2;</option>');
                        $('#net_w').attr("style", "pointer-events: all;");
                        $('#uomlbl').html("Number of Pieces / Pack *");
                    }                    
                    else{
                        $('#net_w').empty();
                        $('#net_w').append('<option value="100" selected>100</option> <option value="250">250</option><option value="500">500</option><option value="1000">1000</option>');
                        $('#net_w').attr("style", "pointer-events: all;");
                        $('#uomlbl').html("Length per bundle/Number of pipes/pack *");
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
	$.post("TarpaulinController/showupc",
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
            var cml = $("#cml").val();
            var cmlbis = $("#cmlbis").val();
            var licno = $("#licno").val();
            var gsm = $("#gsm").val();
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
            if(cml == "") {
                $("#cml").closest('.form-group').addClass('has-error');
                $("#cml").after('<br><p class="text-danger error-text">cml is required!</p>');
                
            } else {
                $("#cml").closest('.form-group').removeClass('has-error');
                $("#cml").closest('.form-group').addClass('has-success');                   
            }
            if(cmlbis == "") {
                $("#cmlbis").closest('.form-group').addClass('has-error');
                $("#cmlbis").after('<br><p class="text-danger error-text">CM L BIS No is required!</p>');
                
            } else {
                $("#cmlbis").closest('.form-group').removeClass('has-error');
                $("#cmlbis").closest('.form-group').addClass('has-success');                   
            }
            if(licno == "") {
                $("#licno").closest('.form-group').addClass('has-error');
                $("#licno").after('<br><p class="text-danger error-text">Licence No is required!</p>');
                
            } else {
                $("#licno").closest('.form-group').removeClass('has-error');
                $("#licno").closest('.form-group').addClass('has-success');                   
            }
            if(gsm == "") {
                $("#gsm").closest('.form-group').addClass('has-error');
                $("#gsm").after('<br><p class="text-danger error-text">GSM is required!</p>');
                
            } else {
                $("#gsm").closest('.form-group').removeClass('has-error');
                $("#gsm").closest('.form-group').addClass('has-success');                   
            }
            if(cname && marketed_by && p_category && sub_category && upc && p_name && b_name && unit_w && net_w && cml && cmlbis && licno && gsm) {
                $.ajax({
                    url : form.attr('action'),
                    type : form.attr('method'),
                    data : form.serialize(),
                    dataType : 'json',
                    success:function(response) {
                        // remove the error 
                        $(".form-group").removeClass('has-error').removeClass('has-success');
          
                        if(response.success == true) {
                            
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