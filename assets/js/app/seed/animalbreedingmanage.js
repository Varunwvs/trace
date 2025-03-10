$(document).ready(function(){
    var dtAnimalBreeding = $('#dtAnimalBreeding').DataTable({
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
            "url": "LiveStockManagementController/dtAnimalBreeding/",
            "type": "POST"
        },
  });


});

$(document).on('click', '.open-modal', function() {
    var id = $(this).data("id"); // Get ID from clicked button

    $.ajax({
        url: "LiveStockManagementController/getAnimalBreedingDetails", // Backend URL
        type: "POST",
        data: {id: id},
        dataType: "json",
        success: function(response){
            if(response.status === "success") {
                $("#animal_id").text(response.data.animal_code);
                $("#mating_date").text(response.data.mating_date);
                $("#breeding_method").text(response.data.breeding_method);
                $("#stud_id").text(response.data.stud_id);
                $("#pregnancy_confirmation_date").text(response.data.pregnancy_confirmation_date);
                $("#expected_due_date").text(response.data.expected_due_date);
                $("#birthing_date").text(response.data.birthing_date);
                $("#litter_size").text(response.data.litter_size);
                $("#survival_rate").text(response.data.survival_rate + "%");
                $("#newborn_registration").text(response.data.newborn_registration);

                $("#breedingDetailsModal").modal("show"); // Open modal
            } else {
                alert("Data not found!");
            }
        }
    });


  
});






