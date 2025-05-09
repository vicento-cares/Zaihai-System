<script type="text/javascript">
    // DOMContentLoaded function
    document.addEventListener("DOMContentLoaded", () => {
        get_car_maker_dropdown_search();
		get_car_model_dropdown_search();
		get_applicator_no_datalist_search();
        get_applicator_no_dropdown();
        get_car_maker_dropdown();
		get_car_model_dropdown();
        get_applicators();
    });

    const get_car_maker_dropdown_search = () => {
		$.ajax({
			url: '../process/me/applicator/a_g_p.php',
			type: 'GET',
			cache: false,
			data: {
				method: 'get_car_maker_dropdown_search'
			},  
			success: response => {
				document.getElementById("a_car_maker_search").innerHTML = response;
			}
		});
	}

	const get_car_model_dropdown_search = () => {
		$.ajax({
			url: '../process/me/applicator/a_g_p.php',
			type: 'GET',
			cache: false,
			data: {
				method: 'get_car_model_dropdown_search'
			},  
			success: response => {
				document.getElementById("a_car_model_search").innerHTML = response;
			}
		});
	}

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

    const get_applicator_no_dropdown = () => {
		$.ajax({
			url: '../process/me/applicator_terminal/at_g_p.php',
			type: 'GET',
			cache: false,
			data: {
				method: 'get_applicator_no_dropdown'
			},  
			success: response => {
				document.getElementById("a_applicator_no_master").innerHTML = response;
                document.getElementById("a_applicator_no_master_update").innerHTML = response;
			}
		});
	}

    const get_car_maker_dropdown = () => {
		$.ajax({
			url: '../process/me/car_maker/cm_g_p.php',
			type: 'GET',
			cache: false,
			data: {
				method: 'get_car_maker_dropdown'
			},  
			success: response => {
				document.getElementById("a_car_maker_master").innerHTML = response;
                document.getElementById("a_car_maker_master_update").innerHTML = response;
			}
		});
	}

	const get_car_model_dropdown = () => {
		$.ajax({
			url: '../process/me/car_maker/cm_g_p.php',
			type: 'GET',
			cache: false,
			data: {
				method: 'get_car_model_dropdown'
			},  
			success: response => {
                document.getElementById("a_car_model_master").innerHTML = response;
				document.getElementById("a_car_model_master_update").innerHTML = response;
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
        let car_maker = document.getElementById('a_car_maker_search').value;
        let car_model = document.getElementById('a_car_model_search').value;
		let applicator_no = document.getElementById('a_applicator_no_search').value;
		let zaihai_stock_address = document.getElementById('a_zaihai_stock_address_search').value;

        sessionStorage.setItem('zs_a_car_maker_search', car_maker);
        sessionStorage.setItem('zs_a_car_model_search', car_model);
		sessionStorage.setItem('zs_a_applicator_no_search', applicator_no);
		sessionStorage.setItem('zs_a_zaihai_stock_address_search', zaihai_stock_address);

		$.ajax({
			type: "GET",
			url: "../process/me/applicator/a_g_p.php",
			cache: false,
			data: {
				method: "get_applicators",
                car_maker: car_maker,
                car_model: car_model,
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

    const export_applicators = () => {
        let car_maker = sessionStorage.getItem('zs_a_car_maker_search');
        let car_model = sessionStorage.getItem('zs_a_car_model_search');
		let applicator_no = sessionStorage.getItem('zs_a_applicator_no_search');
		let zaihai_stock_address = sessionStorage.getItem('zs_a_zaihai_stock_address_search');
        window.open('../process/export/exp_applicator.php?car_maker=' + car_maker + "&car_model=" + car_model + "&applicator_no=" + applicator_no + "&zaihai_stock_address=" + zaihai_stock_address, '_blank');
    }

	const export_applicators_shown = (table_id, separator = ',') => {
        let car_maker = sessionStorage.getItem('zs_a_car_maker_search');
        let car_model = sessionStorage.getItem('zs_a_car_model_search');
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
        if (car_maker) {
			filename += '_' + car_maker;
		}
        if (car_model) {
			filename += '_' + car_model;
		}
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
        document.getElementById('a_car_maker_master').value = '';
        document.getElementById('a_car_model_master').value = '';
        document.getElementById('a_applicator_no_master').value = '';
        document.getElementById('a_zaihai_stock_address_master').value = '';

        document.getElementById('id_applicator_master_update').value = '';
        document.getElementById('a_car_maker_master_update').value = '';
        document.getElementById('a_car_model_master_update').value = '';
        document.getElementById('a_applicator_no_master_update').value = '';
        document.getElementById('a_zaihai_stock_address_master_update').value = '';
    }

	$("#new_applicator").on('hidden.bs.modal', e => {
        clear_applicator_details();
    });

    document.getElementById('new_applicator_form').addEventListener('submit', e => {
        e.preventDefault();
        add_applicator();
    });

    const add_applicator = () => {
        var car_maker = document.getElementById('a_car_maker_master').value;
        var car_model = document.getElementById('a_car_model_master').value;
        var applicator_no = document.getElementById('a_applicator_no_master').value;
        var zaihai_stock_address = document.getElementById('a_zaihai_stock_address_master').value;

        $.ajax({
            url: '../process/me/applicator/a_p.php',
            type: 'POST',
            cache: false,
            data: {
                method: 'add_applicator',
                car_maker: car_maker,
                car_model: car_model,
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
        var car_maker = string[1];
        var car_model = string[2];
        var applicator_no = string[3];
        var zaihai_stock_address = string[4];

        document.getElementById('id_applicator_master_update').value = id;
        document.getElementById('a_car_maker_master_update').value = car_maker;
        document.getElementById('a_car_model_master_update').value = car_model;
        document.getElementById('a_applicator_no_master_update').value = applicator_no;
        document.getElementById('a_zaihai_stock_address_master_update').value = zaihai_stock_address;
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
        var car_maker = document.getElementById('a_car_maker_master_update').value;
        var car_model = document.getElementById('a_car_model_master_update').value;
        var applicator_no = document.getElementById('a_applicator_no_master_update').value;
        var zaihai_stock_address = document.getElementById('a_zaihai_stock_address_master_update').value;

        $.ajax({
            url: '../process/me/applicator/a_p.php',
            type: 'POST',
            cache: false,
            data: {
                method: 'update_applicator',
                id: id,
                car_maker: car_maker,
                car_model: car_model,
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
                } else if (response == 'Record Not Found') {
                    Swal.fire({
                        icon: 'info',
                        title: 'Info',
                        text: 'Record cannot be updated. Record Not Found',
                        showConfirmButton: false,
                        timer: 2000
                    });
                } else if (response == 'Ready To Use Only') {
                    Swal.fire({
                        icon: 'info',
                        title: 'Info',
                        text: 'Record cannot be updated. Ready to use status only on Applicator List to continue',
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
                } else if (response == 'Ready To Use Only') {
                    Swal.fire({
                        icon: 'info',
                        title: 'Info',
                        text: 'Record cannot be deleted. Ready to use status only on Applicator List to continue',
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

    const upload_csv = opt => {
        let file_form;
        let url;

        if (opt == 1) {
            file_form = document.getElementById('file_form');
            url = '../process/import/imp_applicator.php';
        } else if (opt == 2) {
            file_form = document.getElementById('file_form2');
            url = '../process/import/imp_applicator_update.php';
        }

        let form_data = new FormData(file_form);

        $.ajax({
            url: url,
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
                        get_applicators();
                    }
                    document.getElementById("file").value = '';
                    document.getElementById("file2").value = '';
                }, 500);
            }
        })
        .fail((jqXHR, textStatus, errorThrown) => {
            console.log(jqXHR);
            swal('System Error', `Call IT Personnel Immediately!!! They will fix it right away. Error: url: ${jqXHR.url}, method: ${jqXHR.type} ( HTTP ${jqXHR.status} - ${jqXHR.statusText} ) Press F12 to see Console Log for more info.`, 'error');
        });
    }
</script>