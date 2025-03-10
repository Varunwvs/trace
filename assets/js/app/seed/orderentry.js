document.addEventListener("DOMContentLoaded", function () {
    // Fetch the last order number from the backend when the page loads
    $.ajax({
        url: 'FarmerController/get_last_order_number', // Replace with your backend endpoint
        type: 'GET',
        dataType: 'json',
        success: function (response) {
            if (response.order_no) {
                // Set the new order number in the input field
                $('#order_no').val(response.order_no);
            } else {
                alert('Failed to fetch order number. Please try again.');
            }
        },
        error: function () {
            alert('An error occurred while fetching the order number.');
        }
    });
});

$(document).ready(function () {
    $('#customer_id').change(function () {
        var customerId = $(this).val();

        if (customerId) {
            $.ajax({
                url: 'FarmerController/get_customer_address', 
                type: 'POST',
                data: { customer_id: customerId },
                dataType: 'json',
                success: function (response) {
                    if (response.status === 'success') {
                        $('#bill_to').val(response.address);
                        $('#ship_to').val(response.address);
                    } else {
                        alert('Failed to fetch address. Please try again.');
                    }
                },
                error: function () {
                    alert('An error occurred while fetching the address.');
                }
            });
        } else {
            $('#bill_to').val('');
            $('#ship_to').val('');
        }
    });

    //to get batch numbers
    $(document).on('focus', '#batch_no', function () {
        $(this).autocomplete({
            source: 'FarmerController/get_batch_numbers', 
            minLength: 2, // Minimum characters before searching
            select: function (event, ui) {
                // When a batch number is selected, populate it in the batch_no field
                $(this).val(ui.item.value);

                // Update the table row batch_no field if necessary
                // $(this).closest('tr').find('#batch_no').val(ui.item.value);

                return false; // Prevent default behavior
            }
        });
    });


    // Function to calculate the amount and subtotal
    function calculateTotals() {
        let subtotal = 0;

        // Loop through all rows to calculate amount and subtotal
        $('tbody.details tr').each(function () {
            const qty = parseFloat($(this).find('input[name="qty"]').val()) || 0;
            const price = parseFloat($(this).find('input[name="price"]').val()) || 0;

            const amount = qty * price;
            $(this).find('input[name="amount"]').val(amount.toFixed(2)); // Update amount column

            subtotal += amount;
        });

        // Update the subtotal field
        $('#subtotal').val(subtotal.toFixed(2));
    }

    // Event listener for qty or price changes to calculate the amount
    $(document).on('input', 'input[name="qty"], input[name="price"]', function () {
        calculateTotals();
    });

    // Event listener for adding a new row
    $(document).on('click', '#addmoreorder', function () {

        var unitOptions = unitsData.map(unit => 
            `
            <option value="${unit.uomid}">${unit.uomname}</option>`
        ).join('');

        const newRow = `
            <tr>
                <td><input class="form-control" type="text" name="batch_no" id="batch_no"></td>
                <td><input class="form-control" type="text" name="product_name" id="product_name"></td>
                <td> 
                    <div style="display: flex; gap: 5px;">
                        <input class="form-control" type="text" name="serial_no_from" id="serial_no_from" placeholder="From">
                        <input class="form-control" type="text" name="serial_no_to" id="serial_no_to" placeholder="To">
                    </div>
                </td>
                <td><input class="form-control" type="text" name="qty" id="qty"></td>
                <td>
                    <select class="form-control" name="uom" id="uom">
                        <option value="">Select Unit</option>
                            ${unitOptions}
                        </select>
                </td>
                <td><input class="form-control" type="text" name="price" id="price"></td>
                <td><input class="form-control" type="text" name="amount" id="amount" readonly></td>
                <td><button type="button" class="btn btn-danger" id="removerow" title="Remove Order">-</button></td>
            </tr>
        `;

        // Append the new row to the table body
        $('tbody.details').append(newRow);
    });

    $(document).on('click', '#removerow', function () {
        const row = $(this).closest('tr');
        
        // Remove the row
        row.remove();

        // Recalculate totals after removing the row
        calculateTotals();
    });

});