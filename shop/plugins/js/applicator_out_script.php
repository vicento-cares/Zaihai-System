<script type="text/javascript">
    // Global Variables for Realtime
	var realtime_get_recent_applicator_out;

	// DOMContentLoaded function
	document.addEventListener("DOMContentLoaded", () => {
		get_car_maker_dropdown_out_search();
		get_car_model_dropdown_out_search();
		get_applicator_no_datalist_out_search();
		get_terminal_name_datalist_out_search();
		get_location_datalist_out_search();
		get_recent_applicator_out();
		realtime_get_recent_applicator_out = setInterval(get_recent_applicator_out, 10000);
	});

	const get_car_maker_dropdown_out_search = () => {
		$.ajax({
			url: '../process/shop/applicator_in_out/aio_g_p.php',
			type: 'GET',
			cache: false,
			data: {
				method: 'get_car_maker_dropdown_out_search'
			},  
			success: response => {
				document.getElementById("ao_car_maker_search").innerHTML = response;
			}
		});
	}

	const get_car_model_dropdown_out_search = () => {
		$.ajax({
			url: '../process/shop/applicator_in_out/aio_g_p.php',
			type: 'GET',
			cache: false,
			data: {
				method: 'get_car_model_dropdown_out_search'
			},  
			success: response => {
				document.getElementById("ao_car_model_search").innerHTML = response;
			}
		});
	}

	const get_applicator_no_datalist_out_search = () => {
		$.ajax({
			url: '../process/shop/applicator_in_out/aio_g_p.php',
			type: 'GET',
			cache: false,
			data: {
				method: 'get_applicator_no_datalist_out_search'
			},  
			success: response => {
				document.getElementById("ao_applicator_no_search_list").innerHTML = response;
			}
		});
	}

	const get_terminal_name_datalist_out_search = () => {
		$.ajax({
			url: '../process/shop/applicator_in_out/aio_g_p.php',
			type: 'GET',
			cache: false,
			data: {
				method: 'get_terminal_name_datalist_out_search'
			},  
			success: response => {
				document.getElementById("ao_terminal_name_search_list").innerHTML = response;
			}
		});
	}

	const get_location_datalist_out_search = () => {
		$.ajax({
			url: '../process/shop/applicator_in_out/aio_g_p.php',
			type: 'GET',
			cache: false,
			data: {
				method: 'get_location_datalist_out_search'
			},  
			success: response => {
				document.getElementById("ao_location_search_list").innerHTML = response;
			}
		});
	}

	var typingTimerAoApplicatorNoSearch;
	var typingTimerAoTerminalNameSearch;
    var typingTimerAoLocationSearch;
    var doneTypingInterval = 250; // Time in ms

    // On keyup, start the countdown
    document.getElementById("ao_applicator_no_search").addEventListener('keyup', e => {
        clearTimeout(typingTimerAoApplicatorNoSearch);
        typingTimerAoApplicatorNoSearch = setTimeout(doneTypingGetRecentApplicatorOut, doneTypingInterval);
    });

    // On keydown, clear the countdown
    document.getElementById("ao_applicator_no_search").addEventListener('keydown', e => {
        clearTimeout(typingTimerAoApplicatorNoSearch);
    });

	// On keyup, start the countdown
    document.getElementById("ao_terminal_name_search").addEventListener('keyup', e => {
        clearTimeout(typingTimerAoTerminalNameSearch);
        typingTimerAoTerminalNameSearch = setTimeout(doneTypingGetRecentApplicatorOut, doneTypingInterval);
    });

    // On keydown, clear the countdown
    document.getElementById("ao_terminal_name_search").addEventListener('keydown', e => {
        clearTimeout(typingTimerAoTerminalNameSearch);
    });

    // On keyup, start the countdown
    document.getElementById("ao_location_search").addEventListener('keyup', e => {
        clearTimeout(typingTimerAoLocationSearch);
        typingTimerAoLocationSearch = setTimeout(doneTypingGetRecentApplicatorOut, doneTypingInterval);
    });

    // On keydown, clear the countdown
    document.getElementById("ao_location_search").addEventListener('keydown', e => {
        clearTimeout(typingTimerAoLocationSearch);
    });

    // User is "finished typing," do something
    const doneTypingGetRecentApplicatorOut = () => {
        get_recent_applicator_out();
    }

    const get_recent_applicator_out = () => {
		let car_maker = document.getElementById('ao_car_maker_search').value;
		let car_model = document.getElementById('ao_car_model_search').value;
		let applicator_no = document.getElementById('ao_applicator_no_search').value;
		let terminal_name = document.getElementById('ao_terminal_name_search').value;
		let location = document.getElementById('ao_location_search').value;

		sessionStorage.setItem('zs_ao_car_maker_search', car_maker);
		sessionStorage.setItem('zs_ao_car_model_search', car_model);
		sessionStorage.setItem('zs_ao_applicator_no_search', applicator_no);
		sessionStorage.setItem('zs_ao_terminal_name_search', terminal_name);
		sessionStorage.setItem('zs_ao_location_search', location);

		$.ajax({
			type: "GET",
			url: "../process/shop/applicator_in_out/aio_g_p.php",
			cache: false,
			data: {
				method: "get_recent_applicator_out",
				car_maker: car_maker,
				car_model: car_model,
				applicator_no: applicator_no,
				terminal_name: terminal_name,
				location: location
			},
			success: (response) => {
                $('#recentApplicatorOutData').html(response);
				let table_rows = parseInt(document.getElementById("recentApplicatorOutData").childNodes.length);
				$('#count_view').html("Total: " + table_rows);
			}
		});
	}

	const export_recent_applicator_out = (table_id, separator = ',') => {
		let car_maker = sessionStorage.getItem('zs_ao_car_maker_search');
		let car_model = sessionStorage.getItem('zs_ao_car_model_search');
		let applicator_no = sessionStorage.getItem('zs_ao_applicator_no_search');
		let terminal_name = sessionStorage.getItem('zs_ao_terminal_name_search');
		let location = sessionStorage.getItem('zs_ao_location_search');

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
        var filename = 'ZaihaiSystem_ApplicatorOut';
		if (car_maker) {
			filename += '_' + car_maker;
		}
		if (car_model) {
			filename += '_' + car_model;
		}
		if (applicator_no) {
			filename += '_' + applicator_no;
		}
		if (terminal_name) {
			filename += '_' + terminal_name;
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

	document.getElementById("ao_location").addEventListener("change", e => {
		e.preventDefault();
		document.getElementById("ao_location").disabled = true;
		document.getElementById("ao_applicator_no").disabled = false;
		document.getElementById("ao_applicator_no").focus();
	});

	document.getElementById("ao_applicator_no").addEventListener("change", e => {
		e.preventDefault();
		document.getElementById("ao_applicator_no").disabled = true;
		document.getElementById("ao_terminal_name").disabled = false;
		document.getElementById("ao_terminal_name").focus();
	});

	document.getElementById("ao_terminal_name").addEventListener("change", e => {
		e.preventDefault();
		document.getElementById("ao_terminal_name").disabled = true;
		out_applicator();
	});

	const display_applicator_in_out_result = (id, type, message) => {
		var duration = 0;
		var error_message = 'Error: ';
		if (type == 'error') {
			duration = 5000;
			message = error_message + message;
			document.getElementById(id).classList.add('text-red');
		} else {
			duration = 3000;
		}
		document.getElementById(id).innerHTML = message;
		setTimeout(() => {
			document.getElementById(id).innerHTML = '';
			document.getElementById(id).classList.remove('text-red');
		}, duration);
	}

	const out_applicator = () => {
		let location = document.getElementById("ao_location").value;
		let applicator_no = document.getElementById("ao_applicator_no").value;
		let terminal_name = document.getElementById("ao_terminal_name").value;
		$.ajax({
			type: "POST",
			url: "../process/shop/applicator_in_out/aio_p.php",
			cache: false,
			data: {
				method: "out_applicator",
				location: location,
				applicator_no: applicator_no,
				terminal_name: terminal_name
			},
			success: (response) => {
				if (response == 'success') {
					display_applicator_in_out_result('out_applicator_result', '', 'Applicator Out Succesfully!!!');
					get_recent_applicator_out();
				} else {
					display_applicator_in_out_result('out_applicator_result', 'error', response);
				}
				document.getElementById("ao_location").value = '';
				document.getElementById("ao_applicator_no").value = '';
				document.getElementById("ao_terminal_name").value = '';
				document.getElementById("ao_location").disabled = false;
				document.getElementById("ao_location").focus();
			}
		});
	}
</script>