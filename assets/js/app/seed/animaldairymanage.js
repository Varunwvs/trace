$(document).ready(function(){
    var dtAnimalDairy = $('#dtAnimalDairy').DataTable({
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
            "url": "LiveStockManagementController/dtAnimalDairy/",
            "type": "POST"
        },
  });


});

$(document).on('click', '.open-modal', function() {
    var id = $(this).data("id"); // Get ID from clicked button

    $.ajax({
        url: "LiveStockManagementController/getAnimalDairyDetails", // Backend URL
        type: "POST",
        data: {id: id},
        dataType: "json",
        success: function(response){
            if(response.status === "success") {
                $("#animal_id").text(response.data.animal_code);
                $("#milk_yield").text(response.data.milk_yield);
                // $("#milking_time").text(response.data.milking_time);
                // $("#fat_percentage").text(response.data.fat_percentage);
                // $("#snf_percentage").text(response.data.snf_percentage);
                // $("#contamination  ").text(response.data.contamination  );
                $("#storage_distribution").text(response.data.storage_distribution);
                $("#lactation_period  ").text(response.data.lactation_period  );
                // $("#milk_sales_revenue ").text(response.data.milk_sales_revenue );

                $("#milkProductionModal").modal("show");

            } else {
                alert("Data not found!");
            }
        }
    });


  
});






