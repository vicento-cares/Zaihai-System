<script type="text/javascript">
    // DOMContentLoaded function
    document.addEventListener("DOMContentLoaded", () => {
		get_applicator_no_datalist_search();
        get_applicators();
    });

	const get_applicator_no_datalist_search = () => {
		$.ajax({
			url: '../process/me/applicator/a_g_p.php',
			type: 'GET',
			cache: false,
			data: {
				method: 'get_applicator_no_datalist_search'
			},  
			success: response => {
				document.getElementById("a_applicator_no_search_list").innerHTML = response;
			}
		});
	}

	var typingTimerTermApplicatorSearch;
	var typingTimerTermZaihaiStockAddressSearch;
    var doneTypingInterval = 250; // Time in ms

    // On keyup, start the countdown
    document.getElementById("a_applicator_no_search").addEventListener('keyup', e => {
        clearTimeout(typingTimerTermApplicatorSearch);
        typingTimerTermApplicatorSearch = setTimeout(doneTypingGetApplicators, doneTypingInterval);
    });

    // On keydown, clear the countdown
    document.getElementById("a_applicator_no_search").addEventListener('keydown', e => {
        clearTimeout(typingTimerTermApplicatorSearch);
    });

	// On keyup, start the countdown
    document.getElementById("a_zaihai_stock_address_search").addEventListener('keyup', e => {
        clearTimeout(typingTimerTermZaihaiStockAddressSearch);
        typingTimerTermZaihaiStockAddressSearch = setTimeout(doneTypingGetApplicators, doneTypingInterval);
    });

    // On keydown, clear the countdown
    document.getElementById("a_zaihai_stock_address_search").addEventListener('keydown', e => {
        clearTimeout(typingTimerTermZaihaiStockAddressSearch);
    });

    // User is "finished typing," do something
    const doneTypingGetApplicators = () => {
        get_applicators();
    }

    const get_applicators = () => {
		let applicator_no = document.getElementById('a_applicator_no_search').value;
		let zaihai_stock_address = document.getElementById('a_zaihai_stock_address_search').value;

		sessionStorage.setItem('zs_a_applicator_no_search', applicator_no);
		sessionStorage.setItem('zs_a_zaihai_stock_address_search', zaihai_stock_address);

		$.ajax({
			type: "GET",
			url: "../process/me/applicator/a_g_p.php",
			cache: false,
			data: {
				method: "get_applicators",
				applicator_no: applicator_no,
				zaihai_stock_address: zaihai_stock_address
			},
			success: (response) => {
                $('#applicatorsData').html(response);
				let table_rows = parseInt(document.getElementById("applicatorsData").childNodes.length);
				$('#count_view').html("Total: " + table_rows);
			}
		});
	}

	const export_applicators = (table_id, separator = ',') => {
		let applicator_no = sessionStorage.getItem('zs_a_applicator_no_search');
		let zaihai_stock_address = sessionStorage.getItem('zs_a_zaihai_stock_address_search');

        // Select rows from table_id
        var rows = document.querySelectorAll('table#' + table_id + ' tr');

        // Construct csv
        var csv = [];
        for (var i = 0; i < rows.length; i++) {
            var row = [], cols = rows[i].querySelectorAll('td, th');
            for (var j = 0; j < cols.length; j++) {
                var data = cols[j].innerText.replace(/(\r\n|\n|\r)/gm, '').replace(/(\s\s)/gm, ' ')
                data = data.replace(/"/g, '""');
                // Push escaped string
                row.push('"' + data + '"');
            }
            csv.push(row.join(separator));
        }

        var csv_string = csv.join('\n');

        // Download it
        var filename = 'ZaihaiSystem_Applicator';
		if (applicator_no) {
			filename += '_' + applicator_no;
		}
		if (zaihai_stock_address) {
			filename += '_' + zaihai_stock_address;
		}
		filename += '_' + new Date().toJSON().slice(0, 10) + '.csv';
        var link = document.createElement('a');
        link.style.display = 'none';
        link.setAttribute('target', '_blank');
        link.setAttribute('href', 'data:text/csv;charset=utf-8,%EF%BB%BF' + encodeURIComponent(csv_string));
        link.setAttribute('download', filename);
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }

    const clear_applicator_details = () => {
        document.getElementById('applicator_no_master').value = '';
        document.getElementById('zaihai_stock_address_master').value = '';

        document.getElementById('id_applicator_master_update').value = '';
        document.getElementById('applicator_no_master_update').value = '';
        document.getElementById('zaihai_stock_address_master_update').value = '';
    }

	$("#new_applicator").on('hidden.bs.modal', e => {
        clear_applicator_details();
    });

    document.getElementById('new_applicator_form').addEventListener('submit', e => {
        e.preventDefault();
        add_applicator();
    });

    const add_applicator = () => {
        var applicator_no = document.getElementById('applicator_no_master').value;
        var zaihai_stock_address = document.getElementById('zaihai_stock_address_master').value;

        $.ajax({
            url: '../process/me/applicator/a_p.php',
            type: 'POST',
            cache: false,
            data: {
                method: 'add_applicator',
                applicator_no: applicator_no,
                zaihai_stock_address: zaihai_stock_address
            }, success: function (response) {
                if (response == 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Succesfully Recorded!!!',
                        text: 'Success',
                        showConfirmButton: false,
                        timer: 1000
                    });
                    get_applicators();
                    $('#new_applicator').modal('hide');
                } else if (response == 'Already Exist') {
                    Swal.fire({
                        icon: 'info',
                        title: 'Info',
                        text: 'Cannot add new record. Your input was already existed on other record',
                        showConfirmButton: false,
                        timer: 2000
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error !!!',
                        text: 'Error',
                        showConfirmButton: false,
                        timer: 2000
                    });
                }
            }
        });
    }

	const get_applicator_details = param => {
		var string = param.split('~!~');
        var id = string[0];
        var applicator_no = string[1];
        var zaihai_stock_address = string[2];

        document.getElementById('id_applicator_master_update').value = id;
        document.getElementById('applicator_no_master_update').value = applicator_no;
        document.getElementById('zaihai_stock_address_master_update').value = zaihai_stock_address;
	}

	// Get the form element
    var update_applicator_form = document.getElementById('update_applicator_form');

    // Add a submit event listener to the form
    update_applicator_form.addEventListener('submit', e => {
        e.preventDefault();

        // Get the button that triggered the submit event
        var button = document.activeElement;

        // Check the id or name of the button
        if (button.id === 'btnUpdateApplicator') {
            // Call the function for the first submit button
            update_applicator();
        } else if (button.id === 'btnDeleteApplicator') {
            // Call the function for the first submit button
            delete_applicator();
        }
    });

    const update_applicator = () => {
        var id = document.getElementById('id_applicator_master_update').value;
        var applicator_no = document.getElementById('applicator_no_master_update').value;
        var zaihai_stock_address = document.getElementById('zaihai_stock_address_master_update').value;

        $.ajax({
            url: '../process/me/applicator/a_p.php',
            type: 'POST',
            cache: false,
            data: {
                method: 'update_applicator',
                id: id,
                applicator_no: applicator_no,
                zaihai_stock_address: zaihai_stock_address
            }, success: function (response) {
                if (response == 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Succesfully Recorded!!!',
                        text: 'Success',
                        showConfirmButton: false,
                        timer: 1000
                    });
                    clear_applicator_details();
                    get_applicators();
                    $('#update_applicator').modal('hide');
                } else if (response == 'Duplicate') {
                    Swal.fire({
                        icon: 'info',
                        title: 'Info',
                        text: 'Record cannot be updated. Your input was already existed on other record',
                        showConfirmButton: false,
                        timer: 2000
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error !!!',
                        text: 'Error',
                        showConfirmButton: false,
                        timer: 2000
                    });
                }
            }
        });
    }

    const delete_applicator = () => {
        var id = document.getElementById('id_applicator_master_update').value;
        $.ajax({
            url: '../process/me/applicator/a_p.php',
            type: 'POST',
            cache: false,
            data: {
                method: 'delete_applicator',
                id: id
            }, success: function (response) {
                if (response == 'success') {
                    Swal.fire({
                        icon: 'info',
                        title: 'Succesfully Deleted !!!',
                        text: 'Information',
                        showConfirmButton: false,
                        timer: 1000
                    });
                    clear_applicator_details();
                    get_applicators();
                    $('#update_applicator').modal('hide');
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error !!!',
                        text: 'Error',
                        showConfirmButton: false,
                        timer: 2000
                    });
                }
            }
        });
    }

    const upload_csv = () => {
        var file_form = document.getElementById('file_form');
        var form_data = new FormData(file_form);
        $.ajax({
            url: '../process/import/imp_applicator.php',
            type: 'POST',
            dataType: 'text',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            beforeSend: (jqXHR, settings) => {
                Swal.fire({
                    icon: 'info',
                    title: 'Uploading Please Wait...',
                    text: 'Info',
                    showConfirmButton: false,
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    allowEnterKey: false
                });
                jqXHR.url = settings.url;
                jqXHR.type = settings.type;
            },
            success: response => {
                setTimeout(() => {
                    swal.close();
                    if (response != '') {
                        Swal.fire({
                            icon: 'error',
                            title: 'Upload CSV Error',
                            text: `Error: ${response}`,
                            showConfirmButton: false,
                            timer: 2000
                        });
                    } else {
                        Swal.fire({
                            icon: 'info',
                            title: 'Upload CSV',
                            text: 'Uploaded and updated successfully',
                            showConfirmButton: false,
                            timer: 1000
                        });
                        load_st(1);
                    }
                    document.getElementById("file").value = '';
                }, 500);
            }
        })
        .fail((jqXHR, textStatus, errorThrown) => {
            console.log(jqXHR);
            swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
        });
    }
</script>