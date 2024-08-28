<script type="text/javascript">
    // DOMContentLoaded function
    document.addEventListener("DOMContentLoaded", () => {
		get_applicator_no_datalist_search();
        get_applicator_no_dropdown();
        get_terminal_name_datalist_search();
        get_terminal_name_dropdown();
        get_applicator_terminal();
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
				document.getElementById("at_applicator_no_search_list").innerHTML = response;
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
				document.getElementById("at_applicator_no_master").innerHTML = response;
                document.getElementById("at_applicator_no_master_update").innerHTML = response;
			}
		});
	}

    const get_terminal_name_datalist_search = () => {
		$.ajax({
			url: '../process/me/terminal/term_g_p.php',
			type: 'GET',
			cache: false,
			data: {
				method: 'get_terminal_name_datalist_search'
			},  
			success: response => {
				document.getElementById("at_terminal_name_search_list").innerHTML = response;
			}
		});
	}

    const get_terminal_name_dropdown = () => {
		$.ajax({
			url: '../process/me/terminal/term_g_p.php',
			type: 'GET',
			cache: false,
			data: {
				method: 'get_terminal_name_dropdown'
			},  
			success: response => {
				document.getElementById("at_terminal_name_master").innerHTML = response;
                document.getElementById("at_terminal_name_master_update").innerHTML = response;
			}
		});
	}

	var typingTimerAtApplicatorSearch;
	var typingTimerAtTerminalNameSearch;
    var doneTypingInterval = 250; // Time in ms

    // On keyup, start the countdown
    document.getElementById("at_applicator_no_search").addEventListener('keyup', e => {
        clearTimeout(typingTimerAtApplicatorSearch);
        typingTimerAtApplicatorSearch = setTimeout(doneTypingGetApplicatorTerminal, doneTypingInterval);
    });

    // On keydown, clear the countdown
    document.getElementById("at_applicator_no_search").addEventListener('keydown', e => {
        clearTimeout(typingTimerAtApplicatorSearch);
    });

	// On keyup, start the countdown
    document.getElementById("at_terminal_name_search").addEventListener('keyup', e => {
        clearTimeout(typingTimerAtTerminalNameSearch);
        typingTimerAtTerminalNameSearch = setTimeout(doneTypingGetApplicatorTerminal, doneTypingInterval);
    });

    // On keydown, clear the countdown
    document.getElementById("at_terminal_name_search").addEventListener('keydown', e => {
        clearTimeout(typingTimerAtTerminalNameSearch);
    });

    // User is "finished typing," do something
    const doneTypingGetApplicatorTerminal = () => {
        get_applicator_terminal();
    }

    const get_applicator_terminal = () => {
		let applicator_no = document.getElementById('at_applicator_no_search').value;
		let terminal_name = document.getElementById('at_terminal_name_search').value;

		sessionStorage.setItem('zs_at_applicator_no_search', applicator_no);
		sessionStorage.setItem('zs_at_terminal_name_search', terminal_name);

		$.ajax({
			type: "GET",
			url: "../process/me/applicator_terminal/at_g_p.php",
			cache: false,
			data: {
				method: "get_applicator_terminal",
				applicator_no: applicator_no,
				terminal_name: terminal_name
			},
			success: (response) => {
                $('#applicatorTerminalData').html(response);
				let table_rows = parseInt(document.getElementById("applicatorTerminalData").childNodes.length);
				$('#count_view').html("Total: " + table_rows);
			}
		});
	}

	const export_applicator_terminal = (table_id, separator = ',') => {
		let applicator_no = sessionStorage.getItem('zs_at_applicator_no_search');
		let terminal_name = sessionStorage.getItem('zs_at_terminal_name_search');

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
        var filename = 'ZaihaiSystem_ApplicatorTerminal';
		if (applicator_no) {
			filename += '_' + applicator_no;
		}
		if (terminal_name) {
			filename += '_' + terminal_name;
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

    const clear_applicator_terminal_details = () => {
        document.getElementById('at_applicator_no_master').value = '';
        document.getElementById('at_terminal_name_master').value = '';

        document.getElementById('id_applicator_terminal_master_update').value = '';
        document.getElementById('at_applicator_no_master_update').value = '';
        document.getElementById('at_terminal_name_master_update').value = '';
    }

	$("#new_applicator_terminal").on('hidden.bs.modal', e => {
        clear_applicator_terminal_details();
    });

    document.getElementById('new_applicator_terminal_form').addEventListener('submit', e => {
        e.preventDefault();
        add_applicator_terminal();
    });

    const add_applicator_terminal = () => {
        var applicator_no = document.getElementById('at_applicator_no_master').value;
        var terminal_name = document.getElementById('at_terminal_name_master').value;

        $.ajax({
            url: '../process/me/applicator_terminal/at_p.php',
            type: 'POST',
            cache: false,
            data: {
                method: 'add_applicator_terminal',
                applicator_no: applicator_no,
                terminal_name: terminal_name
            }, success: function (response) {
                if (response == 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Succesfully Recorded!!!',
                        text: 'Success',
                        showConfirmButton: false,
                        timer: 1000
                    });
                    get_applicator_terminal();
                    $('#new_applicator_terminal').modal('hide');
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

	const get_applicator_terminal_details = param => {
		var string = param.split('~!~');
        var id = string[0];
        var applicator_no = string[1];
        var terminal_name = string[2];

        document.getElementById('id_applicator_terminal_master_update').value = id;
        document.getElementById('at_applicator_no_master_update').value = applicator_no;
        document.getElementById('at_terminal_name_master_update').value = terminal_name;
	}

	// Get the form element
    var update_applicator_terminal_form = document.getElementById('update_applicator_terminal_form');

    // Add a submit event listener to the form
    update_applicator_terminal_form.addEventListener('submit', e => {
        e.preventDefault();

        // Get the button that triggered the submit event
        var button = document.activeElement;

        // Check the id or name of the button
        if (button.id === 'btnUpdateApplicatorTerminal') {
            // Call the function for the first submit button
            update_applicator_terminal();
        } else if (button.id === 'btnDeleteApplicatorTerminal') {
            // Call the function for the first submit button
            delete_applicator_terminal();
        }
    });

    const update_applicator_terminal = () => {
        var id = document.getElementById('id_applicator_terminal_master_update').value;
        var applicator_no = document.getElementById('at_applicator_no_master_update').value;
        var terminal_name = document.getElementById('at_terminal_name_master_update').value;

        $.ajax({
            url: '../process/me/applicator_terminal/at_p.php',
            type: 'POST',
            cache: false,
            data: {
                method: 'update_applicator_terminal',
                id: id,
                applicator_no: applicator_no,
                terminal_name: terminal_name
            }, success: function (response) {
                if (response == 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Succesfully Recorded!!!',
                        text: 'Success',
                        showConfirmButton: false,
                        timer: 1000
                    });
                    clear_applicator_terminal_details();
                    get_applicator_terminal();
                    $('#update_applicator_terminal').modal('hide');
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

    const delete_applicator_terminal = () => {
        var id = document.getElementById('id_applicator_terminal_master_update').value;
        $.ajax({
            url: '../process/me/applicator_terminal/at_p.php',
            type: 'POST',
            cache: false,
            data: {
                method: 'delete_applicator_terminal',
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
                    clear_applicator_terminal_details();
                    get_applicator_terminal();
                    $('#update_applicator_terminal').modal('hide');
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
            url: '../process/import/imp_applicator_terminal.php',
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
                        get_applicator_terminal();
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