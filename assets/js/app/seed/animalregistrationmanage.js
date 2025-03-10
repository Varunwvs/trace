$(document).ready(function(){
    var dtAnimalRegister = $('#dtAnimalRegister').DataTable({
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
            "url": "LiveStockManagementController/dtAnimalRegister/",
            "type": "POST"
        },
  });


});

$(document).on("click", ".open-modal", function(e) { 

    e.preventDefault();
    var animalId = $(this).data('id');

    $.ajax({
        url: "LiveStockManagementController/getAnimalDetails",
        type: "POST",
        data: { id: animalId },
        dataType: "json",
        success: function(response) {
            if (response.status == "success") {
                $("#modal_animal_id").text(response.data.animal_id);
                $("#modal_species").text(response.data.species);
                $("#modal_breed").text(response.data.breed);
                $("#modal_dob").text(response.data.dob);
                $("#modal_gender").text(response.data.gender);
                $("#modal_parent_details").text(response.data.parent_details);
                $("#modal_ear_tag").text(response.data.ear_tag);
                $("#modal_farm_location").text(response.data.farm_location);
                $("#modal_owner").text(response.data.owner);
                
                // Check if the image exists
                if (response.data.photo) {
                    $("#modal_photo").attr("src", response.data.photo).show();
                } else {
                    $("#modal_photo").hide();
                }

                $("#animalModal").modal("show");
            } else {
                alert("Error fetching data.");
            }
        },
        error: function() {
            alert("Failed to fetch data.");
        }
    });
});





