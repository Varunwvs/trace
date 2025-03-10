$(document).ready(function() {
    let id = $('#edit_pid').val();
    
    if(id){
      $.ajax({
        url: 'SeedController/tgetPrdinfo',
        type: 'post',
        data: {member_id : id},
        dataType: 'json',
        success:function(response) {
          $('#edit_cname').val(response.name);
          $('#edit_marketed_by').val(response.marketed_by);
        //   $('#edit_p_category').val(response.p_category);
          $('#edit_p_category').val(response.catid+'|'+response.p_category).trigger('change.select2');
              // Call function to load subcategories on page load
            // loadSubCategories(response.catid, response.subcatid + '|' + response.sub_category);
            var selectedSubCategory = response.subcatid + '|' + response.sub_category ;
            loadSubCategories(response.catid, selectedSubCategory);
            // Trigger change event to update subcategories when category is changed
            $('#edit_p_category').change(function () {
                var idss = $(this).val();
                var ids = idss.split("|");
                var id = ids[0];
                loadSubCategories(id, null);
            });

console.log(selectedSubCategory);
            function loadSubCategories(categoryId, selectedSubCategory) {
                $.ajax({
                    url: 'SeedController/getSourcingSubCategory',
                    method: "POST",
                    data: { id: categoryId },
                    async: true,
                    dataType: 'json',
                    success: function (response) {

                        // Remove old options
                        $('#edit_sub_category').find('option').not(':first').remove();
        
                        // Add new options
                        $.each(response, function (index, data) {
                            var optionValue = data['id'] + '|' + data['sub_name'];
                            $('#edit_sub_category').append('<option value="' + optionValue + '">' + data['sub_name'] + '</option>');
                        });
        
                        // If editing, set the subcategory value
                        if (selectedSubCategory) {
                          console.log("Setting selected subcategory:", selectedSubCategory);
                          $('#edit_sub_category').val(selectedSubCategory).trigger('change.select2');
                      }
                    }
                });
              }


          $('#edit_sub_category').val(response.sub_category);
          $('#edit_upc').val(response.p_code);
          $('#edit_p_name').val(response.p_name);
          $('#edit_b_name').val(response.b_name); 
          $('#edit_registration_no').val(response.registration_no); 
          
          $('#edit_unit_w').val(response.uomid+'|'+response.unit_w).trigger('change.select2');
          $('#edit_net_w').val(response.net_w);  
           
          $('#edit_prd_leaflet').val(response.prd_leaflet); 
          $('#edit_prd_video').val(response.prd_video); 

          $('#edit_prod_description').val(response.prod_description); 
          $('#edit_usage_instructions').val(response.usage_instructions); 

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
          $('#edit_genpur').val(response.genpur);
          $('#edit_weedseed').val(response.weedseed);
          $(".editModal").append('<input type="hidden" name="member_id" id="member_id" value="'+response.id+'"/>');

        //   blue label
        $('#edit_blkind').val(response.blkind);
        $('#edit_blvariety').val(response.blvariety);
        $('#edit_blseedclass').val(response.blseedclass);
        $('#blsign').val(response.blsign);
        if (response.blsign) {
          let filePath = `uploads/blimg/${response.blsign}`;
          $(".blsign-pcontent").html(
              `<a style="color: #29875a !important; text-decoration: none !important;" href="${filePath}" target="_blank"><span class="fa fa-eye"></span> View File</a>`
          );
      } else {
          $(".blsign-pcontent").html('<p class="text-muted">No file uploaded</p>');
      }

        let edit_gi_checkbox = response.gi_checkbox;
          if(edit_gi_checkbox=='1'){
                $('#edit_show_gitag').prop("checked", true);
                document.querySelector('.gitag_content').classList.remove('hidden'); 
                document.querySelector('.gitag_toggle_row').classList.remove('hidden');

          }else{
            $('#edit_show_gitag').prop("checked", false);
          }   

          let edit_fssai_checkbox = response.fssai_checkbox;
          if(edit_fssai_checkbox=='1'){
                $('#edit_show_fssai').prop("checked", true);
                document.querySelector('.fssai_content').classList.remove('hidden'); 
                document.querySelector('.fssai_toggle_row').classList.remove('hidden');

          }else{
            $('#edit_show_fssai').prop("checked", false);
          } 

          let edit_usfda_checkbox = response.usfda_checkbox;
          if(edit_usfda_checkbox=='1'){
                $('#edit_show_usfda').prop("checked", true);
                document.querySelector('.usfda_content').classList.remove('hidden'); 
                document.querySelector('.usfda_toggle_row').classList.remove('hidden');

          }else{
            $('#edit_show_usfda').prop("checked", false);
          } 


          $('#edit_gi_geographical_area').val(response.gi_geographical_area);
        $('#edit_gi_latitude').val(response.gi_latitude);
        $('#edit_gi_longitude').val(response.gi_longitude);
        $('#edit_gi_origin_country').val(response.gi_origin_country);
        $('#edit_gi_fssai_license_no').val(response.gi_fssai_license_no);
        $('#edit_gi_description').val(response.gi_description);
        $('#edit_gi_product_specifications').val(response.gi_product_specifications);
        $('#edit_gi_processing_facility').val(response.gi_processing_facility);
        $('#gi_packed_date').datetimepicker('date', moment(response.gi_packed_date, 'YYYY-MM-DD').format('DD-MM-YYYY'));
        $('#gi_expire_date').datetimepicker('date', moment(response.gi_expire_date, 'YYYY-MM-DD').format('DD-MM-YYYY'));
        
        // console.log(response.gi_source_info)
        $('#gi_source_info').val(response.gi_source_info);
        if (response.gi_source_info) {
          let filePath = `uploads/gi_source_info/${response.gi_source_info}`;
          $(".gi_source_info-pcontent").html(
              `<a style="color: #29875a !important; text-decoration: none !important;" href="${filePath}" target="_blank"><span class="fa fa-eye"></span> View File</a>`
          );
      } else {
          $(".gi_source_info-pcontent").html('<p class="text-muted">No file uploaded</p>');
      }

      $('#gi_authorities_certificate').val(response.gi_authorities_certificate);
      if (response.gi_authorities_certificate) {
        let filePath = `uploads/gi_authorities_certificate/${response.gi_authorities_certificate}`;
        $(".gi_authorities_certificate-pcontent").html(
            `<a style="color: #29875a !important; text-decoration: none !important;" href="${filePath}" target="_blank"><span class="fa fa-eye"></span> View File</a>`
        );
    } else {
        $(".gi_authorities_certificate-pcontent").html('<p class="text-muted">No file uploaded</p>');
    }
        

        $('#edit_fs_license_no').val(response.fs_license_no);
        $('#edit_fs_allergens').val(response.fs_allergens);
        $('#edit_fs_allergen_warning').val(response.fs_allergen_warning);

        $('#fs_ingredients').val(response.fs_ingredients);
        if (response.fs_ingredients) {
          let filePath = `uploads/fs_ingredients/${response.fs_ingredients}`;
          $(".fs_ingredients-pcontent").html(
              `<a style="color: #29875a !important; text-decoration: none !important;" href="${filePath}" target="_blank"><span class="fa fa-eye"></span> View File</a>`
          );
      } else {
          $(".pcontent").html('<p class="text-muted">No file uploaded</p>');
      }

      $('#fs_nutri_info').val(response.fs_nutri_info);
      if (response.fs_nutri_info) {
        let filePath = `uploads/fs_nutri_info/${response.fs_nutri_info}`;
        $(".fs_nutri_info-pcontent").html(
            `<a style="color: #29875a !important; text-decoration: none !important;" href="${filePath}" target="_blank"><span class="fa fa-eye"></span> View File</a>`
        );
    } else {
        $(".fs_ingredients-pcontent").html('<p class="text-muted">No file uploaded</p>');
    }

        $('#edit_us_fda_no').val(response.us_fda_no);
        $('#edit_us_allergens').val(response.us_allergens);
        $('#edit_us_allergen_warning').val(response.us_allergen_warning);
        $('#edit_us_storage_info').val(response.us_storage_info);

        $('#us_ingredients').val(response.us_ingredients);
        if (response.fs_ingredients) {
          let filePath = `uploads/us_ingredients/${response.us_ingredients}`;
          $(".us_ingredients-pcontent").html(
              `<a style="color: #29875a !important; text-decoration: none !important;" href="${filePath}" target="_blank"><span class="fa fa-eye"></span> View File</a>`
          );
      } else {
          $(".us_ingredients-pcontent").html('<p class="text-muted">No file uploaded</p>');
      }

      $('#us_nutri_info').val(response.us_nutri_info);
      if (response.us_nutri_info) {
        let filePath = `uploads/us_nutri_info/${response.us_nutri_info}`;
        $(".us_nutri_info-pcontent").html(
            `<a style="color: #29875a !important; text-decoration: none !important;" href="${filePath}" target="_blank"><span class="fa fa-eye"></span> View File</a>`
        );
    } else {
        $(".us_nutri_info-pcontent").html('<p class="text-muted">No file uploaded</p>');
    }

   





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
              method: "POST",
              data: new FormData(this),
              contentType: false,
              cache: false,
              processData: false,
              dataType: "json",
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


$(document).on('click','#greenlabel',function(){
	$(".glabel").toggleClass("hidden");
});

$(document).on('click','#bluelabel',function(){
	$(".blabel").toggleClass("hidden");
});

//gi checkbox
document.getElementById('edit_show_gitag').addEventListener('change', function() {
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
  document.getElementById('edit_show_fssai').addEventListener('change', function() {
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
  document.getElementById('edit_show_usfda').addEventListener('change', function() {
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