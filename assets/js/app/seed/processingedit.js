$(document).ready(function() {
    let processingId = $('#pid').val();
 
     if(processingId){
 
     $.ajax({
             url: "SeedController/getProcessingDataById",
             type: "POST",
             data: { id: processingId },
             dataType: "json",
             success: function (response) {
                if (!response.error) {
                    
                     // Set form values
                     $('#edit_processed_lot_no').val(response.processed_lot_no);
                     $('#edit_sourcing_lot_id').val(response.sourcing_lot_id).trigger('change');
                     $('#edit_vendor_id').val(response.vendor_name);
                     $('#edit_raw_material_id').val(response.raw_material_name);
                     $('#edit_process_name').val(response.process_name);
                     $('#edit_process_type').val(response.process_type).trigger('change');
                     $('#edit_process_qty').val(response.process_qty);
                     $('#edit_final_qty').val(response.final_qty);
                     $('#edit_wastage').val(response.wastage);
                     $('#edit_uom').val(response.uom).trigger('change');
 
                   
                 } else {
                     alert('Error: Unable to fetch processing details.');
                 }
             
             }
         });
     }
 

 });


 $(document).on('click','#submit',function(e){
  
    $("#formEditProcessing").unbind('submit').bind('submit', function() {
      $(".text-danger").remove();
      var form = $(this);
      // validation
     
        //submi the form to server
        $.ajax({
          url : 'SeedController/editProcessing',
          type : 'POST',
          data: new FormData(this),
          contentType: false,
          cache: false,
          processData: false,
          dataType : 'json',
          success:function(response) {
  
            if(response.success == true) {
              $("#formEditProcessing")[0].reset();
              Swal.fire({
                  icon: 'success',
                  title: 'Good Job!',
                  text: 'Processing Updated successfully!',                  
                  showConfirmButton: false,
                  timer: 5000
                }); 
                window.location.href = "processingmanage";
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
     
      return false;
    }); // /submit form for create member
  });