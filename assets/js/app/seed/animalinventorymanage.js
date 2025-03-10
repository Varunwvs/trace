$(document).ready(function(){
    var dtAnimalInventory = $('#dtAnimalInventory').DataTable({
      "processing": true,
      "serverSide": true,
      "ordering": true,
      "responsive": true,
      "columnDefs": [{ targets: [0], className: 'dt-center valign dt-w3' },
                      { targets: [1], className: 'dt-center valign dt-w20' },
                      { targets: [2,3], className: 'dt-center valign dt-w20' }],
      dom: 'Bfrtip',
        buttons: [
            {extend:'copy', text:'<i class="fas fa-copy text-info"></i> Copy', titleAttr: 'Copy'}, 
            {extend:'csv', text:'<i class="fas fa-file-excel text-primary"></i> CSV <i class="fas fa-download text-dark"></i>', titleAttr:'csv'}, 
            {extend:'excel', text:'<i class="fas fa-file-excel text-primary"></i> Excel <i class="fas fa-download text-dark"></i>', titleAttr:'excel'}, 
            {extend:'pdf', text:'<i class="fas fa-file-pdf text-danger"></i> PDF <i class="fas fa-download text-dark"></i>', titleAttr:'pdf'}, 
            {extend:'print', text:'<i class="fas fa-print text warning"></i> Print', titleAttr:'print'}
        ], 
      "order": [],
        // Load data from an Ajax source
        "ajax": {
            "url": "LiveStockManagementController/dtAnimalInventory/",
            "type": "POST"
        },
  });


});

$(document).on('click', '.open-modal', function() {
    var id = $(this).data("id"); // Get ID from clicked button

    $.ajax({
        url: "LiveStockManagementController/getAnimalInventoryDetails", // Backend URL
        type: "POST",
        data: {id: id},
        dataType: "json",
        success: function(response){
            if(response.status === "success") {
                $('#modal_animal_id').text(response.data.animal_code);
                $('#modal_stock_feed_supplements').text(response.data.stock_feed_supplements);
                $('#modal_medication_vaccine').text(response.data.medication_vaccine);
                $('#modal_equipment_machinery').text(response.data.equipment_machinery);
                $('#modal_fencing_shelter').text(response.data.fencing_shelter);
                $('#modal_farm_labor').text(response.data.farm_labor);

                $('#inventoryModal').modal('show'); 

            } else {
                alert("Data not found!");
            }
        }
    });


  
});






