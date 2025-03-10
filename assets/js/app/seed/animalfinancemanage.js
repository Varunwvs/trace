$(document).ready(function(){
    var dtAnimalFinance = $('#dtAnimalFinance').DataTable({
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
            "url": "LiveStockManagementController/dtAnimalFinance/",
            "type": "POST"
        },
  });


});

$(document).on('click', '.open-modal', function() {
    var id = $(this).data("id"); // Get ID from clicked button

    $.ajax({
        url: "LiveStockManagementController/getAnimalFinanceDetails", // Backend URL
        type: "POST",
        data: {id: id},
        dataType: "json",
        success: function(response){
            if(response.status === "success") {
                $('#modal_animal_id').text(response.data.animal_code);
                $('#modal_sale_date').text(response.data.sale_date);
                $('#modal_buyer_name').text(response.data.buyer_name);
                $('#modal_buyer_contact').text(response.data.buyer_contact);
                $('#modal_sale_price').text(response.data.sale_price);
                $('#modal_logistics_cost').text(response.data.logistics_cost);
                $('#modal_vet_expenses').text(response.data.vet_expenses);
                $('#modal_profit_loss').text(response.data.profit_loss);
                $('#modal_milk_meat_sales').text(response.data.milk_meat_sales);
                $('#modal_subsidies_loans').text(response.data.subsidies_loans);

                $('#saleModal').modal('show');

            } else {
                alert("Data not found!");
            }
        }
    });


  
});






