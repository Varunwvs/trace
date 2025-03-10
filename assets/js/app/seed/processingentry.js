$(document).ready(function() {
    var spinner = $('#loader');
    //Submit Form Using Ajax
    $(document).on('click','#submit',function(e){
        let bid = $('#pid').val();
      // remove the error 
      $("#batch_no").css({"border-color": "gray"});
      $(".text-danger").remove();
      // submit form
      $("#formProcessing").unbind('submit').bind('submit', function() {
        spinner.show();
        $(".text-danger").remove();
        var form = $(this);
        // validation
       
          //submi the form to server
          $.ajax({
            url : form.attr('action'),
            type : form.attr('method'),
            data : form.serialize(),
            dataType : 'json',
            success:function(response) {
              if(response.success == true) {
                spinner.hide();
                $("#formProcessing")[0].reset();
                Swal.fire({
                    icon: 'success',
                    title: 'Good Job!',
                    text: 'Processing added successfully!',                  
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
    }); // /add modal

  const preselectedLotId = $('#sourcing_lot_id').val();
    if (preselectedLotId) {
        setTimeout(function() {
            $('#sourcing_lot_id').val(preselectedLotId).trigger('change');
        }, 5);
    }


     // Add more sourcing lot
 
        // Set data-index for the first default row
        if ($('.sourcing-row').length === 1) {
            $('.sourcing-row').first().data('index', 0);
        }
    
        // $('#add-more-sourcing').click(function () {
        //     var sourcingIndex = $('.sourcing-row').length; // Get the next unique index
        //     console.log('Sourcing Index:', sourcingIndex);
    
        //     var sourcingLotOptions = sourcingData.map(lot => 
        //         `<option value="${lot.lot_reference_no}">${lot.lot_reference_no}</option>`
        //     ).join('');
            
        //     var newSourcingRow = `
        //         <div class="sourcing-row mt-3" data-index="${sourcingIndex}">
        //             <div class="row">
        //                 <div class="col-md-4">
        //                     <label class="form-label">Sourcing Lot No.</label>
        //                     <select class="form-control sourcing-lot" name="sourcing_lot_id[${sourcingIndex}]" required>
        //                         <option value="">Select Sourcing Lot No.</option>
        //                         ${sourcingLotOptions}
        //                     </select>
        //                 </div>
        //                 <div class="col-md-4">
        //                     <label class="form-label">Vendor Name</label>
        //                     <input type="text" class="form-control vendor_name" name="vendor_name[${sourcingIndex}]" readonly>
        //                     <input type="hidden" class="vendor_id" name="vendor_id[${sourcingIndex}]">
        //                 </div>
        //                 <div class="col-md-4">
        //                     <label class="form-label">Raw Material Name</label>
        //                     <input type="text" class="form-control raw_material" name="raw_material[${sourcingIndex}]" readonly>
        //                     <input type="hidden" class="raw_material_id" name="raw_material_id[${sourcingIndex}]">
        //                 </div>
        //             </div>
        //             <div class="processing-rows mt-3"></div>
        //             <button type="button" class="btn btn-success add-process mt-3">Add More Processing</button>
        //             <button type="button" class="btn btn-danger remove-sourcing mt-3">Remove Sourcing</button>
        //         </div>
        //     `;
    
        //     $('#sourcing-dynamic-fields').append(newSourcingRow);
        // });
    
        $('#add-more-sourcing').click(function () {
            var sourcingIndex = $('.sourcing-row').length; // Get the next unique index
            console.log('Sourcing Index:', sourcingIndex);
        
            var sourcingLotOptions = sourcingData.map(lot => 
                `<option value="${lot.lot_reference_no}">${lot.lot_reference_no}</option>`
            ).join('');
        
            var unitDropdownOptions = unitsData.map(unit => 
                `<option value="${unit.uomid}">${unit.uomname}</option>`
            ).join('');
        
            var defaultProcessRow = `
                <div class="row process-row mt-3">
                    <div class="col-md-2 ">
                        <label class="form-label">Process Name</label>
                        <input type="text" class="form-control" name="process_name[${sourcingIndex}][]" required>
                    </div>
                    <div class="col-md-2 ">
                        <label class="form-label">Process Type</label>
                        <select class="form-control" name="process_type[${sourcingIndex}][]" required>
                            <option value="0">Select process type</option>
                            <option value="cleaning">Cleaning</option>
                            <option value="sorting">Sorting</option>
                            <option value="grading">Grading</option>
                            <option value="coating">Coating</option>
                            <option value="packing">Packing</option>
                        </select>
                    </div>
                    <div class="col-md-2 ">
                        <label class="form-label">Process Qty</label>
                        <input type="number" class="form-control" name="process_qty[${sourcingIndex}][]" required>
                    </div>
                    <div class="col-md-2 ">
                        <label class="form-label">Final Qty</label>
                        <input type="number" class="form-control" name="final_qty[${sourcingIndex}][]" required>
                    </div>
                    <div class="col-md-2 ">
                        <label class="form-label">Wastage</label>
                        <input type="number" class="form-control" name="wastage[${sourcingIndex}][]" required>
                    </div>
                    <div class="col-md-2 ">
                        <label class="form-label">Unit</label>
                        <select class="form-control" name="uom[${sourcingIndex}][]" required>
                            <option value="">Select Unit</option>
                            ${unitDropdownOptions}
                        </select>
                    </div>
                    <div class="col-md-2 mt-2">
                        <button type="button" class="btn btn-danger remove-process">Remove</button>
                    </div>
                </div>
            `;
        
            var newSourcingRow = `
                <div class="sourcing-row mt-3" data-index="${sourcingIndex}">
                    <div class="row">
                        <div class="col-md-4">
                            <label class="form-label">Sourcing Lot No.</label>
                            <select class="form-control sourcing-lot" name="sourcing_lot_id[${sourcingIndex}]" required>
                                <option value="">Select Sourcing Lot No.</option>
                                ${sourcingLotOptions}
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Vendor Name</label>
                            <input type="text" class="form-control vendor_name" name="vendor_name[${sourcingIndex}]" readonly>
                            <input type="hidden" class="vendor_id" name="vendor_id[${sourcingIndex}]">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Raw Material Name</label>
                            <input type="text" class="form-control raw_material" name="raw_material[${sourcingIndex}]" readonly>
                            <input type="hidden" class="raw_material_id" name="raw_material_id[${sourcingIndex}]">
                        </div>
                    </div>
        
                    <div class="processing-rows mt-3">
                        ${defaultProcessRow}
                    </div>
        
                    <button type="button" class="btn btn-success add-process mt-3">Add More Processing</button>
                    <button type="button" class="btn btn-danger remove-sourcing mt-3">Remove Sourcing</button>
                </div>
            `;
        
            $('#sourcing-dynamic-fields').append(newSourcingRow);
        });
        
        // Add processing row
        $(document).on('click', '.add-process', function () {
            var sourcingRow = $(this).closest('.sourcing-row');
            var sourcingIndex = sourcingRow.data('index');
            
            if (sourcingIndex === undefined) {
                sourcingIndex = 0; // Default to 0 if not set
            }
        
            var processIndex = sourcingRow.data('process-index') || 0;
            sourcingRow.data('process-index', processIndex + 1);
        
            var unitDropdownOptions = unitsData.map(unit => 
                `<option value="${unit.uomid}">${unit.uomname}</option>`
            ).join('');
        
            var newProcessRow = `
                <div class="row process-row mt-3">
                    <div class="col-md-2 ">
                        <label class="form-label">Process Name</label>
                        <input type="text" class="form-control" name="process_name[${sourcingIndex}][]" required>
                    </div>
                    <div class="col-md-2 ">
                        <label class="form-label">Process Type</label>
                        <select class="form-control" name="process_type[${sourcingIndex}][]" required>
                            <option value="0">Select process type</option>
                            <option value="cleaning">Cleaning</option>
                            <option value="sorting">Sorting</option>
                            <option value="grading">Grading</option>
                            <option value="coating">Coating</option>
                            <option value="packing">Packing</option>
                        </select>
                    </div>
                    <div class="col-md-2 ">
                        <label class="form-label">Process Qty</label>
                        <input type="number" class="form-control" name="process_qty[${sourcingIndex}][]" required>
                    </div>
                    <div class="col-md-2 ">
                        <label class="form-label">Final Qty</label>
                        <input type="text" class="form-control" name="final_qty[${sourcingIndex}][]" required>
                    </div>
                    <div class="col-md-2 ">
                        <label class="form-label">Wastage</label>
                        <input type="text" class="form-control" name="wastage[${sourcingIndex}][]" required>
                    </div>
                    <div class="col-md-2 ">
                        <label class="form-label">Unit</label>
                        <select class="form-control" name="uom[${sourcingIndex}][]" required>
                            <option value="">Select Unit</option>
                            ${unitDropdownOptions}
                        </select>
                    </div>
                    <div class="col-md-2 mt-3"><button type="button" class="btn btn-danger remove-process">Remove</button></div>
                </div>
            `;
        
            sourcingRow.find('.processing-rows').append(newProcessRow);
        });
        
 
    
    
    
    

    // Remove sourcing lot
    $(document).on('click', '.remove-sourcing', function () {
        $(this).closest('.sourcing-row').remove();
    });

    // Fetch vendor & material details on sourcing lot change
    $(document).on('change', '.sourcing-lot', function () {
        var lotId = $(this).val();
        var parent = $(this).closest('.sourcing-row');

        if (lotId) {
            $.ajax({
                url: 'SeedController/getVendorsAndMaterials',
                type: 'POST',
                data: { lot_reference_no: lotId },
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        const data = response.data[0];
                        parent.find('.vendor_name').val(data.vendor_name);
                        parent.find('.raw_material').val(data.raw_material_name);
                        parent.find('.vendor_id').val(data.vendor_id);
                        parent.find('.raw_material_id').val(data.raw_material_id);
                    } else {
                        alert('No data found for the selected Lot No.');
                    }
                },
                error: function () {
                    alert('Error fetching lot details.');
                }
            });
        }
    });



    $(document).on('click', '.remove-process', function () {
        $(this).closest('.process-row').remove();
    });
    




  });


 



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

$('#generate_processed_lot_no').click(function() {
    $.ajax({
        url: 'SeedController/generate_unique_processed_lot_no', // Backend endpoint to generate unique lot number
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            console.log
            if(response.success) {
                $('#processed_lot_no').val(response.processed_lot_no); // Set the generated lot number
            } else {
                alert("Failed to generate unique processed lot number.");
            }
        },
        error: function() {
            alert("An error occurred while generating processed lot number.");
        }
    });
});



// $(document).ready(function () {

    
//     const preselectedLotId = $('#sourcing_lot_id').val();
//     if (preselectedLotId) {
//         $('#sourcing_lot_id').trigger('change');
//         console.log(preselectedLotId);
//     }
//   // Handle change event for sourcing_lot_id
//   $('#sourcing_lot_id').change(function () {
//       const lotId = $(this).val();
//       if (lotId) {
//           $.ajax({
//               url: 'SeedController/getVendorsAndMaterials', // Update with your controller method
//               type: 'POST',
//               data: { lot_reference_no: lotId },
//               dataType: 'json',
//               success: function (response) {
//                   if (response.success) {
//                       $('#dynamic-fields').empty(); // Clear existing rows
//                       response.data.forEach((item, index) => {
//                           appendDynamicVendorRow(item, index);
//                       });
//                   } else {
//                       alert(response.message || 'No data found for this lot.');
//                   }
//               },
//               error: function () {
//                   alert('An error occurred while fetching data.');
//               },
//           });
//       } else {
//           $('#dynamic-fields').empty(); // Clear fields if no lot is selected
//       }
//   });

//   // Function to add dynamic rows for vendor and raw material
//   function appendDynamicVendorRow(item, index) {
//     const vendorHtml = `
//         <div class="vendor-row" data-index="${index}">
//             <div class="row">
//                 <div class="col-md-4">
//                     <div class="form-group">
//                         <label class="form-label">Vendor Name</label>
//                         <input type="hidden" name="vendor_id[]" value="${item.vendor_id}"> <!-- Hidden Vendor ID -->
//                         <input type="text" class="form-control" value="${item.vendor_name}" readonly>
//                     </div>
//                 </div>
//                 <div class="col-md-4">
//                     <div class="form-group">
//                         <label class="form-label">Raw Material Name</label>
//                         <input type="hidden" name="raw_material_id[]" value="${item.raw_material_id}"> <!-- Hidden Raw Material ID -->
//                         <input type="text" class="form-control" value="${item.raw_material_name}" readonly>
//                     </div>
//                 </div>
//                 <div class="col-md-4 mt-4">
//                     <button type="button" class="btn btn-success add-process-row">Add Processing Details</button>
//                 </div>
//             </div>
//             <div class="process-rows" data-vendor-index="${index}">
//                 <!-- Process-related fields will be added here -->
//                  <div class="col-md-2">
//                   <div class="form-group">
//                       <label class="form-label">Process Name</label>
//                       <input type="text" class="form-control" name="process_name[${vendorIndex}][]" required>
//                   </div>
//               </div>
//               <div class="col-md-2">
//                     <div class="form-group">
//                         <label class="form-label">Process Type</label>
//                         <select class="form-control" name="process_type[${vendorIndex}][]" required>
//                             <option value="type1">Select process type</option>    
//                             <option value="type1">Cleaning</option>
//                             <option value="type2">Sorting</option>
//                             <option value="type3">Grading</option>
//                             <option value="type4">Coating</option>
//                             <option value="type4">Packing</option>
//                         </select>
//                     </div>
//                 </div>
//               <div class="col-md-2">
//                   <div class="form-group">
//                       <label class="form-label">Process Qty</label>
//                       <input type="number" class="form-control" name="process_qty[${vendorIndex}][]" required>
//                   </div>
//               </div>
//               <div class="col-md-2">
//                   <div class="form-group">
//                       <label class="form-label">Final Qty</label>
//                       <input type="number" class="form-control" name="final_qty[${vendorIndex}][]" required>
//                   </div>
//               </div>
//               <div class="col-md-2">
//                   <div class="form-group">
//                       <label class="form-label">Wastage</label>
//                       <input type="number" class="form-control" name="wastage[${vendorIndex}][]" required>
//                   </div>
//               </div>
//                <div class="col-md-2">
//                     <div class="form-group">
//                         <label class="form-label">UOM</label>
//                         <select class="form-control" name="uom">
//                             <option value="type1">Select UOM</option>    
//                             <option value="type1">Metric Tons</option>
//                             <option value="type2">Quintal</option>
//                             <option value="type3">Kilogram</option>
//                             <option value="type4">Tons</option>
//                             <option value="type4">Liter</option>
//                             <option value="type4">Number</option>
//                             <option value="type4">Meters</option>
//                         </select>
//                     </div>
//                 </div>
//               <div class="col-md-2 mb-5">
//                   <button type="button" class="btn btn-danger remove-process-row">Remove</button>
//               </div>
//             </div>
//         </div>
//     `;
//     $('#dynamic-fields').append(vendorHtml);
// }


//   // Function to add process-related fields for each vendor
//   function appendProcessFields(vendorIndex) {
//       const processHtml = `
//           <div class="row process-row">
//               <div class="col-md-2">
//                   <div class="form-group">
//                       <label class="form-label">Process Name</label>
//                       <input type="text" class="form-control" name="process_name[${vendorIndex}][]" required>
//                   </div>
//               </div>
//               <div class="col-md-2">
//                     <div class="form-group">
//                         <label class="form-label">Process Type</label>
//                         <select class="form-control" name="process_type[${vendorIndex}][]" required>
//                             <option value="type1">Select process type</option>    
//                             <option value="type1">Cleaning</option>
//                             <option value="type2">Sorting</option>
//                             <option value="type3">Grading</option>
//                             <option value="type4">Coating</option>
//                             <option value="type4">Packing</option>
//                         </select>
//                     </div>
//                 </div>
//               <div class="col-md-2">
//                   <div class="form-group">
//                       <label class="form-label">Process Qty</label>
//                       <input type="number" class="form-control" name="process_qty[${vendorIndex}][]" required>
//                   </div>
//               </div>
//               <div class="col-md-2">
//                   <div class="form-group">
//                       <label class="form-label">Final Qty</label>
//                       <input type="number" class="form-control" name="final_qty[${vendorIndex}][]" required>
//                   </div>
//               </div>
//               <div class="col-md-2">
//                   <div class="form-group">
//                       <label class="form-label">Wastage</label>
//                       <input type="number" class="form-control" name="wastage[${vendorIndex}][]" required>
//                   </div>
//               </div>
//                <div class="col-md-2">
//                     <div class="form-group">
//                         <label class="form-label">UOM</label>
//                         <select class="form-control" name="uom">
//                             <option value="type1">Select UOM</option>    
//                             <option value="type1">Metric Tons</option>
//                             <option value="type2">Quintal</option>
//                             <option value="type3">Kilogram</option>
//                             <option value="type4">Tons</option>
//                             <option value="type4">Liter</option>
//                             <option value="type4">Number</option>
//                             <option value="type4">Meters</option>
//                         </select>
//                     </div>
//                 </div>
//               <div class="col-md-2 mb-5">
//                   <button type="button" class="btn btn-danger remove-process-row">Remove</button>
//               </div>
//           </div>
//       `;
//       $(`.process-rows[data-vendor-index="${vendorIndex}"]`).append(processHtml);
//   }

//   // Handle Add More button for process fields
//   $(document).on('click', '.add-process-row', function () {
//       const vendorIndex = $(this).closest('.vendor-row').data('index');
//       appendProcessFields(vendorIndex);
//   });

//   // Handle Remove button for process fields
//   $(document).on('click', '.remove-process-row', function () {
//       $(this).closest('.process-row').remove();
//   });
// });





