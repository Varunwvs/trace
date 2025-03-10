$(document).ready(function () {
    $('#loadData').click(function () {
        var date = $('#date').val();
        var slot = $('#morning').is(':checked') ? 'morning' : 'evening';

        // $.post('LiveStockManagementController/fetch_milking_data', { date: date, slot: slot }, function (data) {
        //     console.log(data);
        //     $('#milkingDataBody').html(data);
        // }, 'json');

        $.ajax({
            url: "LiveStockManagementController/fetch_milking_data",
            type: "POST",
            data: { date: date, slot: slot },
            dataType: "json",
            success: function(response) {
              
                if(response.success == true) {
                    var tableRows = "";

                    response.messages.forEach(function(row, index) {
                        tableRows += `<tr>
                            <td>${index + 1}</td>
                            <td>${row.animal_code}
                            <input type="hidden" name="milking[${row.id}][id]" value=" ${row.id}" class="form-control">
                            <input type="hidden" name="milking[${row.id}][animal_id]" value=" ${row.animal_id}" class="form-control"></td>
                            <td><input type="number" name="milking[${row.id}][milk_yield]" value="${row.milk_yield}" class="form-control"></td>
                            <td><input type="text" name="milking[${row.id}][snf]" value="${row.snf}" class="form-control"></td>
                            <td><input type="text" name="milking[${row.id}][fat]" value="${row.fat}" class="form-control"></td>
                            <td><input type="text" name="milking[${row.id}][contamination]" value="${row.contamination}" class="form-control"></td>
                        </tr>`;
                    });
            
                    $("#milkingDataBody").html(tableRows);

                    $("#fdate").val(response.date);
                    if (response.slot === "morning") {
                        $("#fmorning").prop("checked", true);
                    } else if (response.slot === "evening") {
                        $("#fevening").prop("checked", true);
                    }

                  } else {
                      Swal.fire({
                      icon: 'error',
                      title: 'Ooops...',
                      text: response.messages,
                      showConfirmButton: false,
                      timer: 5000,
                      showClass: {popup: 'animate__animated animate__fadeInDown'},
                      hideClass: {popup: 'animate__animated animate__fadeOutUp'}
                    })
                    } 
            },
            error: function(xhr, status, error) {
                alert("Error: " + xhr.responseText);
            }
        });

    });

    // Ensure only one checkbox is checked at a time
    $("input[name='slot']").change(function () {
        $("input[name='slot']").not(this).prop("checked", false);
    });

    $("#milkingForm").submit(function(e) {
        e.preventDefault(); // Prevent default form submission

        let date = $("#fdate").val();
        let morningChecked = $("#fmorning").prop("checked");
        let eveningChecked = $("#fevening").prop("checked");

        // Validate date
        if (date === "") {
            Swal.fire({
                icon: 'error',
                title: 'Ooops...',
                text: "Please select date",
                showConfirmButton: false,
                timer: 5000,
                showClass: {popup: 'animate__animated animate__fadeInDown'},
                hideClass: {popup: 'animate__animated animate__fadeOutUp'}
              })
            e.preventDefault(); // Stop form submission
            return;
        }

        // Validate slot selection (Only one should be selected)
        if (!morningChecked && !eveningChecked) {
            Swal.fire({
                icon: 'error',
                title: 'Ooops...',
                text: "Please select a slot (Morning or Evening)",
                showConfirmButton: false,
                timer: 5000,
                showClass: {popup: 'animate__animated animate__fadeInDown'},
                hideClass: {popup: 'animate__animated animate__fadeOutUp'}
              })
            e.preventDefault();
            return;
        }

        if (morningChecked && eveningChecked) {
            Swal.fire({
                icon: 'error',
                title: 'Ooops...',
                text: "You can select only one slot",
                showConfirmButton: false,
                timer: 5000,
                showClass: {popup: 'animate__animated animate__fadeInDown'},
                hideClass: {popup: 'animate__animated animate__fadeOutUp'}
              })
            e.preventDefault();
            return;
        }

    

        $.ajax({
            url: "LiveStockManagementController/save_milking_data",
            type: "POST",
            data: $(this).serialize(),
            dataType: "json",
            success: function(response) {
                if(response.success == true) {
                    $("#milkingForm")[0].reset();
                    Swal.fire({
                        icon: 'success',
                        title: 'Good Job!',
                        text: 'Saved successfully!',                  
                        showConfirmButton: false,
                        timer: 5000
                      }); 

                  } else {
                      Swal.fire({
                      icon: 'error',
                      title: 'Ooops...',
                      text: response.messages,
                      showConfirmButton: false,
                      timer: 5000,
                      showClass: {popup: 'animate__animated animate__fadeInDown'},
                      hideClass: {popup: 'animate__animated animate__fadeOutUp'}
                    })
                    } 
            },
            error: function(xhr, status, error) {
                alert("Error: " + xhr.responseText);
            }
        });
    });



});
