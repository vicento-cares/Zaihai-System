<script type="text/javascript">
	// DOMContentLoaded function
	document.addEventListener("DOMContentLoaded", () => {
		get_car_maker_dropdown_search();
		get_car_model_dropdown_search();
		get_applicator_no_datalist_search();
		get_location_datalist_search();
		get_applicator_no_dropdown();
		get_applicator_list();
	});

	const get_car_maker_dropdown_search = () => {
		$.ajax({
			url: '../process/shop/applicator_list/al_g_p.php',
			type: 'GET',
			cache: false,
			data: {
				method: 'get_car_maker_dropdown_search'
			},  
			success: response => {
				document.getElementById("al_car_maker_search").innerHTML = response;
			}
		});
	}

	const get_car_model_dropdown_search = () => {
		$.ajax({
			url: '../process/shop/applicator_list/al_g_p.php',
			type: 'GET',
			cache: false,
			data: {
				method: 'get_car_model_dropdown_search'
			},  
			success: response => {
				document.getElementById("al_car_model_search").innerHTML = response;
			}
		});
	}

	const get_applicator_no_datalist_search = () => {
		$.ajax({
			url: '../process/shop/applicator_list/al_g_p.php',
			type: 'GET',
			cache: false,
			data: {
				method: 'get_applicator_no_datalist_search'
			},  
			success: response => {
				document.getElementById("al_applicator_no_search_list").innerHTML = response;
			}
		});
	}

	const get_location_datalist_search = () => {
		$.ajax({
			url: '../process/shop/applicator_list/al_g_p.php',
			type: 'GET',
			cache: false,
			data: {
				method: 'get_location_datalist_search'
			},  
			success: response => {
				document.getElementById("al_location_search_list").innerHTML = response;
			}
		});
	}

	const get_applicator_no_dropdown = () => {
		$.ajax({
			url: '../process/me/applicator/a_g_p.php',
			type: 'GET',
			cache: false,
			data: {
				method: 'get_applicator_no_dropdown'
			},  
			success: response => {
				document.getElementById("al_applicator_no_master").innerHTML = response;
				document.getElementById("al_applicator_no_master_update").innerHTML = response;
			}
		});
	}

	const get_zaihai_stock_address_dropdown = opt => {
		var applicator_no = '';
		if (opt == 1) {
			applicator_no = document.getElementById("al_applicator_no_master").value;
		} else if (opt == 2) {
			applicator_no = document.getElementById("al_applicator_no_master_update").value;
		}
		$.ajax({
			url: '../process/me/applicator/a_g_p.php',
			type: 'GET',
			cache: false,
			data: {
				method: 'get_zaihai_stock_address_dropdown',
				applicator_no: applicator_no
			},  
			success: response => {
				if (opt == 1) {
					document.getElementById("al_location_master").innerHTML = response;
				} else if (opt == 2) {
					document.getElementById("al_location_master_update").innerHTML = response;
				}
			}
		});
	}

	var typingTimerAlApplicatorNoSearch;
    var typingTimerAlLocationSearch;
    var doneTypingInterval = 250; // Time in ms

    // On keyup, start the countdown
    document.getElementById("al_applicator_no_search").addEventListener('keyup', e => {
        clearTimeout(typingTimerAlApplicatorNoSearch);
        typingTimerAlApplicatorNoSearch = setTimeout(doneTypingGetApplicatorList, doneTypingInterval);
    });

    // On keydown, clear the countdown
    document.getElementById("al_applicator_no_search").addEventListener('keydown', e => {
        clearTimeout(typingTimerAlApplicatorNoSearch);
    });

    // On keyup, start the countdown
    document.getElementById("al_location_search").addEventListener('keyup', e => {
        clearTimeout(typingTimerAlLocationSearch);
        typingTimerAlLocationSearch = setTimeout(doneTypingGetApplicatorList, doneTypingInterval);
    });

    // On keydown, clear the countdown
    document.getElementById("al_location_search").addEventListener('keydown', e => {
        clearTimeout(typingTimerAlLocationSearch);
    });

    // User is "finished typing," do something
    const doneTypingGetApplicatorList = () => {
        get_applicator_list();
    }

    const get_applicator_list = () => {
		let car_maker = document.getElementById('al_car_maker_search').value;
		let car_model = document.getElementById('al_car_model_search').value;
		let status = document.getElementById('al_status_search').value;
		let applicator_no = document.getElementById('al_applicator_no_search').value;
		let location = document.getElementById('al_location_search').value;

		sessionStorage.setItem('zs_al_car_maker_search', car_maker);
		sessionStorage.setItem('zs_al_car_model_search', car_model);
		sessionStorage.setItem('zs_al_status_search', status);
		sessionStorage.setItem('zs_al_applicator_no_search', applicator_no);
		sessionStorage.setItem('zs_al_location_search', location);

		$.ajax({
			type: "GET",
			url: "../process/shop/applicator_list/al_g_p.php",
			cache: false,
			data: {
				method: "get_applicator_list",
				car_maker: car_maker,
				car_model: car_model,
				status: status,
				applicator_no: applicator_no,
				location: location
			},
			success: (response) => {
                $('#applicatorListData').html(response);
				let table_rows = parseInt(document.getElementById("applicatorListData").childNodes.length);
				$('#count_view').html("Total: " + table_rows);
			}
		});
	}

	const export_applicator_list = (table_id, separator = ',') => {
		let car_maker = sessionStorage.getItem('zs_al_car_maker_search');
		let car_model = sessionStorage.getItem('zs_al_car_model_search');
		let status = sessionStorage.getItem('zs_al_status_search');
		let applicator_no = sessionStorage.getItem('zs_al_applicator_no_search');
		let location = sessionStorage.getItem('zs_al_location_search');

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
        var filename = 'ZaihaiSystem_ApplicatorList';
		if (car_maker) {
			filename += '_' + car_maker;
		}
		if (car_model) {
			filename += '_' + car_model;
		}
		if (status) {
			filename += '_' + status;
		}
		if (applicator_no) {
			filename += '_' + applicator_no;
		}
		if (location) {
			filename += '_' + location;
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
		document.getElementById('al_car_maker_master').value = '';
		document.getElementById('al_car_model_master').value = '';
        document.getElementById('al_applicator_no_master').value = '';
        document.getElementById('al_location_master').value = '';

        document.getElementById('id_applicator_list_master_update').value = '';
		document.getElementById('al_car_maker_master_update').value = '';
		document.getElementById('al_car_model_master_update').value = '';
        document.getElementById('al_applicator_no_master_update').value = '';
        document.getElementById('al_location_master_update').value = '';
    }

	$("#new_applicator_list").on('show.bs.modal', e => {
        get_zaihai_stock_address_dropdown(1);
    });

	$("#new_applicator_list").on('hidden.bs.modal', e => {
        clear_applicator_details();
    });

    document.getElementById('new_applicator_list_form').addEventListener('submit', e => {
        e.preventDefault();
        add_applicator_list();
    });

    const add_applicator_list = () => {
		var car_maker = document.getElementById('al_car_maker_master').value;
		var car_model = document.getElementById('al_car_model_master').value;
        var applicator_no = document.getElementById('al_applicator_no_master').value;
        var location = document.getElementById('al_location_master').value;

        $.ajax({
            url: '../process/shop/applicator_list/al_p.php',
            type: 'POST',
            cache: false,
            data: {
                method: 'add_applicator_list',
				car_maker: car_maker,
				car_model: car_model,
                applicator_no: applicator_no,
                location: location
            }, success: function (response) {
                if (response == 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Succesfully Recorded!!!',
                        text: 'Success',
                        showConfirmButton: false,
                        timer: 1000
                    });
                    get_applicator_list();
                    $('#new_applicator_list').modal('hide');
                } else if (response == 'Applicator and location not found') {
                    Swal.fire({
                        icon: 'info',
                        title: 'Info',
                        text: 'Cannot add new record. Applicator and location not found on masterlist',
                        showConfirmButton: false,
                        timer: 2000
                    });
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

	const get_applicator_list_details = param => {
		var string = param.split('~!~');
        var id = string[0];
        var car_maker = string[1];
        var car_model = string[2];
		var applicator_no = string[3];
		var location = string[4];

        document.getElementById('id_applicator_list_master_update').value = id;
        document.getElementById('al_car_maker_master_update').value = car_maker;
        document.getElementById('al_car_model_master_update').value = car_model;
		document.getElementById('al_applicator_no_master_update').value = applicator_no;

		get_zaihai_stock_address_dropdown(2);

		setTimeout(() => {
            document.getElementById('al_location_master_update').value = location;
        }, 500);
	}

	// Get the form element
    var update_applicator_list_form = document.getElementById('update_applicator_list_form');

    // Add a submit event listener to the form
    update_applicator_list_form.addEventListener('submit', e => {
        e.preventDefault();

        // Get the button that triggered the submit event
        var button = document.activeElement;

        // Check the id or name of the button
        if (button.id === 'btnUpdateApplicatorList') {
            // Call the function for the first submit button
            update_applicator_list();
        } else if (button.id === 'btnDeleteApplicatorList') {
            // Call the function for the first submit button
            delete_applicator_list();
        }
    });

    const update_applicator_list = () => {
        var id = document.getElementById('id_applicator_list_master_update').value;
		var car_maker = document.getElementById('al_car_maker_master_update').value;
		var car_model = document.getElementById('al_car_model_master_update').value;
        var applicator_no = document.getElementById('al_applicator_no_master_update').value;
        var location = document.getElementById('al_location_master_update').value;

        $.ajax({
            url: '../process/shop/applicator_list/al_p.php',
            type: 'POST',
            cache: false,
            data: {
                method: 'update_applicator_list',
                id: id,
				car_maker: car_maker,
				car_model: car_model,
                applicator_no: applicator_no,
                location: location
            }, success: function (response) {
                if (response == 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Succesfully Recorded!!!',
                        text: 'Success',
                        showConfirmButton: false,
                        timer: 1000
                    });
                    clear_applicator_list_details();
                    get_applicator_list();
                    $('#update_applicator_list').modal('hide');
                } else if (response == 'Applicator and location not found') {
                    Swal.fire({
                        icon: 'info',
                        title: 'Info',
                        text: 'Record cannot be updated. Applicator and location not found on masterlist',
                        showConfirmButton: false,
                        timer: 2000
                    });
                } else if (response == 'Ready To Use Only') {
                    Swal.fire({
                        icon: 'info',
                        title: 'Info',
                        text: 'Record cannot be updated. Ready to use status only to continue',
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

    const delete_applicator_list = () => {
        var id = document.getElementById('id_applicator_list_master_update').value;
        $.ajax({
            url: '../process/shop/applicator_list/al_p.php',
            type: 'POST',
            cache: false,
            data: {
                method: 'delete_applicator_list',
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
                    clear_applicator_list_details();
                    get_applicator_list();
                    $('#update_applicator_list').modal('hide');
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
            url: '../process/import/imp_applicator_list.php',
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
                        get_applicator_list();
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