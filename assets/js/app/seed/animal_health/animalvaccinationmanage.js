$(document).ready(function(){
    var dtAnimalVaccination = $('#dtAnimalVaccination').DataTable({
      "processing": true,
      "serverSide": true,
      "ordering": true,
      "responsive": true,
      "columnDefs": [{ targets: [0], className: 'dt-center valign dt-w3' },
                      { targets: [1], className: 'dt-center valign dt-w20' },
                      { targets: [2,3,4,5], className: 'dt-center valign dt-w20' }],
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
            "url": "LiveStockManagementController/dtAnimalVaccination/",
            "type": "POST"
        },
  });


});

$(document).on('click', '.open-modal', function() {
    var animalId = $(this).data('id'); // Get the ID from the clicked button

    $.ajax({
        url: "LiveStockManagementController/getAnimalHealthDetails", // Your API or backend URL to fetch details
        type: "POST",
        data: { id: animalId },
        dataType: "json",
        success: function(response) {
            if (response.status == "success") {
            console.log(response);
            $('#modal_animal_id').text(response.data.animal_code);
            $('#modal_health_status').text(response.data.health_status);
            $('#modal_vaccination_type').text(response.data.vaccination_type);
            $('#modal_vaccination_date').text(response.data.vaccination_date);
            $('#modal_next_vaccination_due').text(response.data.next_vaccination_due);
            

            $('#animalModal').modal('show'); // Show modal
            }else{
                alert("Error fetching data.");
            }
        }
    });
});






