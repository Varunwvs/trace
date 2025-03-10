$(document).ready(function(){
    var dtDealer = $('#dtDealer').DataTable({
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
            "url": "FarmerController/dtDealer/",
            "type": "POST"
        },
  });

  $(document).on("click", ".open-modal", function (e) {
    e.preventDefault();
    var dealerId = $(this).data("id");
    // console.log("Clicked! Dealer ID:", dealerId); // Debugging log

    $.ajax({
        url: "FarmerController/getDealerDetails",
        type: "POST",
        data: { id: dealerId },
        dataType: "json",
        success: function (response) {
            console.log(response); // Debugging log

            if (response.status == "success") {
                $("#company_name").text(response.data.company_name);
                $("#gstin").text(response.data.gstin);
                $("#pan").text(response.data.pan);
                $("#distribution_location").text(response.data.location_name);
                $("#contact_person").text(response.data.contact_person);
                $("#mobile").text(response.data.mobile);
                $("#email").text(response.data.email);
                $("#distributor_status").text(response.data.distributor_status);
                $("#address").text(response.data.address);

                $("#dealerModal").modal("show"); // Show modal
            } else {
                alert("Error: " + response.message);
            }
        },
        error: function () {
            alert("Failed to fetch dealer details.");
        }
    });
});


});





