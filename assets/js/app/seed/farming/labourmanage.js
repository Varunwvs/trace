$(document).ready(function(){
    var dtLabour = $('#dtLabour').DataTable({
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
            "url": "FarmerController/dtLabour/",
            "type": "POST"
        },
  });

});

$(document).on('click', '.open-modal', function (e) {
  e.preventDefault();
  var id = $(this).data("id");

  $.ajax({
      url: "FarmerController/get_labour_data",
      type: "POST",
      data: { id: id },
      dataType: "json",
      success: function(response) {
          if(response.status == "success") {
              $("#full_name").text(response.data.full_name);
              $("#dob").text(new Date(response.data.dob).toLocaleDateString('en-GB'));
              $("#contact_no").text(response.data.contact_no);
              $("#emergency_contact").text(response.data.emergency_contact);
              $("#blood_grp").text(response.data.blood_grp);
              $("#daily_wage").text(response.data.daily_wage);
              $("#skills").text(response.data.skills);
              $("#address").text(response.data.address);
              $("#notes").text(response.data.notes);
              
              if(response.data.govt_id) {
                  $("#govt_id").attr("href", "uploads/labour_govt_id/" + response.data.govt_id);
              } else {
                  $("#govt_id").text("No File Uploaded").removeAttr("href");
              }

              $("#viewModal").modal("show");
          } else {
              alert("No data found!");
          }
      },
      error: function() {
          alert("Something went wrong!");
      }
  });
});



