$(document).on('click','#btnClick',function(){
	$.post("SeedController/showupc",
      {get_count:true},
      function(result){
        $("#upc").val(result);
      }
    );
});

$(document).on('click','#greenlabel',function(){
	$(".glabel").toggleClass("hidden");
});

$(document).on('click','#bluelabel',function(){
	$(".blabel").toggleClass("hidden");
});

$(document).ready(function(){
  //Get the subcategory
  $('#p_category').change(function(){ 
    var idss=$(this).val();
    var ids = idss.split("|");
    id= ids[0];
    $.ajax({
        url : 'SeedController/getItemSubCategory',
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
        url : 'SeedController/getItem',
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
        url : 'SeedController/getUomids',
        method : "POST",
        data : {id: id, subid:subid},
        async : true,
        dataType : 'json',
        success: function(response){             
          // Add options
          $.each(response,function(index,data){
            var uid = data['UomID'];        
            if(uid==='0'){
                uomname = "millimeter";
                uomw ="mm";
            }
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
            $('#net_w').val(data['packetsize']);
          });
        }
    });    
    return false;
  });

  $("#formProduct").unbind('submit').bind('submit', function(e) {
    $(".text-danger").remove();
    var form = $(this);
    e.preventDefault();
    // validation
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
      //submi the form to server
      $.ajax({
        url: "SeedController/addProduct",
        method: "POST",
        data: new FormData(this),
        contentType: false,
        cache: false,
        processData: false,
        dataType: "json",
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
    } /// if
    return false;
  }); // /submit form for create member
});//end of doc ready function

$(function () {
  $('#gi_packed_date').datetimepicker({
      format: 'DD-MM-YYYY',
      todayHighlight: true
  }); 
  
  $('#gi_expire_date').datetimepicker({
      format: 'DD-MM-YYYY',
      todayHighlight: true
  }); 
  
});

//gi checkbox
document.getElementById('show_gitag').addEventListener('change', function() {
  var gitagContent = document.querySelector('.gitag_content');
  var gitagToggleRow = document.querySelector('.gitag_toggle_row');
  
  // Toggle visibility of both GI Tag section and toggle row based on checkbox state
  if(this.checked) {
      gitagContent.classList.remove('hidden'); // Show the GI Tag section
      gitagToggleRow.classList.remove('hidden'); // Show the "Add GI Tag Information" toggle
  } else {
      gitagContent.classList.add('hidden'); // Hide the GI Tag section
      gitagToggleRow.classList.add('hidden'); // Hide the "Add GI Tag Information" toggle
  }

});
document.getElementById('gitag_toggle').addEventListener('click', function() {
  var gitagContent = document.querySelector('.gitag_content');
  gitagContent.classList.toggle('hidden'); // Toggle visibility
});

//FSSAI checkbox
document.getElementById('show_fssai').addEventListener('change', function() {
  var fssaiContent = document.querySelector('.fssai_content');
  var fssaiToggleRow = document.querySelector('.fssai_toggle_row');
  
 
  if(this.checked) {
    fssaiContent.classList.remove('hidden'); 
    fssaiToggleRow.classList.remove('hidden'); 
  } else {
    fssaiContent.classList.add('hidden'); 
    fssaiToggleRow.classList.add('hidden'); 
  }
});

document.getElementById('fssai_toggle').addEventListener('click', function() {
  var fssaiContent = document.querySelector('.fssai_content');
  fssaiContent.classList.toggle('hidden'); // Toggle visibility
});

//US FDA checkbox
document.getElementById('show_usfda').addEventListener('change', function() {
  var usfdaContent = document.querySelector('.usfda_content');
  var usfdaToggleRow = document.querySelector('.usfda_toggle_row');
  
 
  if(this.checked) {
    usfdaContent.classList.remove('hidden'); 
    usfdaToggleRow.classList.remove('hidden'); 
  } else {
    usfdaContent.classList.add('hidden'); 
    usfdaToggleRow.classList.add('hidden'); 
  }
});
document.getElementById('usfda_toggle').addEventListener('click', function() {
  var usfdaContent = document.querySelector('.usfda_content');
  usfdaContent.classList.toggle('hidden'); // Toggle visibility
});


