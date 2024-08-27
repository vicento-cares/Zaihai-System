<script type="text/javascript">
    // DOMContentLoaded function
    document.addEventListener("DOMContentLoaded", () => {
		get_terminal_name_datalist_search();
        get_terminals();
    });

	const get_terminal_name_datalist_search = () => {
		$.ajax({
			url: '../process/me/terminal/term_g_p.php',
			type: 'GET',
			cache: false,
			data: {
				method: 'get_terminal_name_datalist_search'
			},  
			success: response => {
				document.getElementById("term_terminal_name_search_list").innerHTML = response;
			}
		});
	}

	var typingTimerTermTerminalSearch;
	var typingTimerTermLineAddressSearch;
    var doneTypingInterval = 250; // Time in ms

    // On keyup, start the countdown
    document.getElementById("term_terminal_name_search").addEventListener('keyup', e => {
        clearTimeout(typingTimerTermTerminalSearch);
        typingTimerTermTerminalSearch = setTimeout(doneTypingGetTerminals, doneTypingInterval);
    });

    // On keydown, clear the countdown
    document.getElementById("term_terminal_name_search").addEventListener('keydown', e => {
        clearTimeout(typingTimerTermTerminalSearch);
    });

	// On keyup, start the countdown
    document.getElementById("term_line_address_search").addEventListener('keyup', e => {
        clearTimeout(typingTimerTermLineAddressSearch);
        typingTimerTermLineAddressSearch = setTimeout(doneTypingGetTerminals, doneTypingInterval);
    });

    // On keydown, clear the countdown
    document.getElementById("term_line_address_search").addEventListener('keydown', e => {
        clearTimeout(typingTimerTermLineAddressSearch);
    });

    // User is "finished typing," do something
    const doneTypingGetTerminals = () => {
        get_terminals();
    }

    const get_terminals = () => {
		let terminal_name = document.getElementById('term_terminal_name_search').value;
		let line_address = document.getElementById('term_line_address_search').value;

		sessionStorage.setItem('zs_term_terminal_name_search', terminal_name);
		sessionStorage.setItem('zs_term_line_address_search', line_address);

		$.ajax({
			type: "GET",
			url: "../process/me/terminal/term_g_p.php",
			cache: false,
			data: {
				method: "get_terminals",
				terminal_name: terminal_name,
				line_address: line_address
			},
			success: (response) => {
                $('#terminalsData').html(response);
				let table_rows = parseInt(document.getElementById("terminalsData").childNodes.length);
				$('#count_view').html("Total: " + table_rows);
			}
		});
	}

	const export_terminals = (table_id, separator = ',') => {
		let terminal_name = sessionStorage.getItem('zs_term_terminal_name_search');
		let line_address = sessionStorage.getItem('zs_term_line_address_search');

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
        var filename = 'ZaihaiSystem_Terminal';
		if (terminal_name) {
			filename += '_' + terminal_name;
		}
		if (line_address) {
			filename += '_' + line_address;
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

    const clear_terminal_details = () => {
        document.getElementById('terminal_name_master').value = '';
        document.getElementById('line_address_master').value = '';

        document.getElementById('id_terminal_master_update').value = '';
        document.getElementById('terminal_name_master_update').value = '';
        document.getElementById('line_address_master_update').value = '';
    }

	$("#new_terminal").on('hidden.bs.modal', e => {
        clear_terminal_details();
    });

    document.getElementById('new_terminal_form').addEventListener('submit', e => {
        e.preventDefault();
        add_terminal();
    });

    const add_terminal = () => {
        var terminal_name = document.getElementById('terminal_name_master').value;
        var line_address = document.getElementById('line_address_master').value;

        $.ajax({
            url: '../process/me/terminal/term_p.php',
            type: 'POST',
            cache: false,
            data: {
                method: 'add_terminal',
                terminal_name: terminal_name,
                line_address: line_address
            }, success: function (response) {
                if (response == 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Succesfully Recorded!!!',
                        text: 'Success',
                        showConfirmButton: false,
                        timer: 1000
                    });
                    get_terminals();
                    $('#new_terminal').modal('hide');
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

	const get_terminal_details = param => {
		var string = param.split('~!~');
        var id = string[0];
        var terminal_name = string[1];
        var line_address = string[2];

        document.getElementById('id_terminal_master_update').value = id;
        document.getElementById('terminal_name_master_update').value = terminal_name;
        document.getElementById('line_address_master_update').value = line_address;
	}

	// Get the form element
    var update_terminal_form = document.getElementById('update_terminal_form');

    // Add a submit event listener to the form
    update_terminal_form.addEventListener('submit', e => {
        e.preventDefault();

        // Get the button that triggered the submit event
        var button = document.activeElement;

        // Check the id or name of the button
        if (button.id === 'btnUpdateTerminal') {
            // Call the function for the first submit button
            update_terminal();
        } else if (button.id === 'btnDeleteTerminal') {
            // Call the function for the first submit button
            delete_terminal();
        }
    });

    const update_terminal = () => {
        var id = document.getElementById('id_terminal_master_update').value;
        var terminal_name = document.getElementById('terminal_name_master_update').value;
        var line_address = document.getElementById('line_address_master_update').value;

        $.ajax({
            url: '../process/me/terminal/term_p.php',
            type: 'POST',
            cache: false,
            data: {
                method: 'update_terminal',
                id: id,
                terminal_name: terminal_name,
                line_address: line_address
            }, success: function (response) {
                if (response == 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Succesfully Recorded!!!',
                        text: 'Success',
                        showConfirmButton: false,
                        timer: 1000
                    });
                    clear_terminal_details();
                    get_terminals();
                    $('#update_terminal').modal('hide');
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

    const delete_terminal = () => {
        var id = document.getElementById('id_terminal_master_update').value;
        $.ajax({
            url: '../process/me/terminal/term_p.php',
            type: 'POST',
            cache: false,
            data: {
                method: 'delete_terminal',
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
                    clear_terminal_details();
                    get_terminals();
                    $('#update_terminal').modal('hide');
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
            url: '../process/import/imp_terminal.php',
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