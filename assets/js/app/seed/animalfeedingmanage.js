$(document).ready(function(){
    var dtAnimalFeeding = $('#dtAnimalFeeding').DataTable({
      "processing": true,
      "serverSide": true,
      "ordering": true,
      "responsive": true,
      "columnDefs": [{ targets: [0], className: 'dt-center valign dt-w3' },
                      { targets: [1], className: 'dt-center valign dt-w20' },
                      { targets: [2,3,4], className: 'dt-center valign dt-w20' }],
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
            "url": "LiveStockManagementController/dtAnimalFeeding/",
            "type": "POST"
        },
  });


});

$(document).on('click', '.open-modal', function() {
    var id = $(this).data("id"); // Get ID from clicked button

    $.ajax({
        url: "LiveStockManagementController/getAnimalFeedingDetails", // Backend URL
        type: "POST",
        data: {id: id},
        dataType: "json",
        success: function(response){
            if(response.status === "success") {
                $("#animal_id").text(response.data.animal_code);
                $("#feed_intake").text(response.data.feed_intake);
                $("#feed_type").text(response.data.feed_type);
                $("#feeding_schedule").text(response.data.feeding_schedule);
                $("#water_intake").text(response.data.water_intake);
                $("#weight_tracking").text(response.data.weight_tracking);
                $("#special_diet").text(response.data.special_diet);

                $("#animalFeedingModal").modal("show");

            } else {
                alert("Data not found!");
            }
        }
    });


  
});






