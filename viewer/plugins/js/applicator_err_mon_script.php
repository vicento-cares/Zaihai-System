<script type="text/javascript">
    // Global Variables for Realtime
	var realtime_get_recent_applicator_err_mon;

	// DOMContentLoaded function
	document.addEventListener("DOMContentLoaded", () => {
		get_car_maker_dropdown_out_search();
		get_car_model_dropdown_out_search();
		get_applicator_no_datalist_out_search();
		get_terminal_name_datalist_out_search();
		get_location_datalist_out_search();
		get_error_name_dropdown_out_search();
		get_recent_applicator_err_mon();
		realtime_get_recent_applicator_err_mon = setInterval(get_recent_applicator_err_mon, 10000);
	});

	const get_car_maker_dropdown_out_search = () => {
		$.ajax({
			url: '../process/error_monitoring/err_mon_g_p.php',
			type: 'GET',
			cache: false,
			data: {
				method: 'get_car_maker_dropdown_out_search'
			},  
			success: response => {
				document.getElementById("aem_car_maker_search").innerHTML = response;
			}
		});
	}

	const get_car_model_dropdown_out_search = () => {
		$.ajax({
			url: '../process/error_monitoring/err_mon_g_p.php',
			type: 'GET',
			cache: false,
			data: {
				method: 'get_car_model_dropdown_out_search'
			},  
			success: response => {
				document.getElementById("aem_car_model_search").innerHTML = response;
			}
		});
	}

	const get_applicator_no_datalist_out_search = () => {
		$.ajax({
			url: '../process/error_monitoring/err_mon_g_p.php',
			type: 'GET',
			cache: false,
			data: {
				method: 'get_applicator_no_datalist_out_search'
			},  
			success: response => {
				document.getElementById("aem_applicator_no_search_list").innerHTML = response;
			}
		});
	}

	const get_terminal_name_datalist_out_search = () => {
		$.ajax({
			url: '../process/error_monitoring/err_mon_g_p.php',
			type: 'GET',
			cache: false,
			data: {
				method: 'get_terminal_name_datalist_out_search'
			},  
			success: response => {
				document.getElementById("aem_terminal_name_search_list").innerHTML = response;
			}
		});
	}

	const get_location_datalist_out_search = () => {
		$.ajax({
			url: '../process/error_monitoring/err_mon_g_p.php',
			type: 'GET',
			cache: false,
			data: {
				method: 'get_location_datalist_out_search'
			},  
			success: response => {
				document.getElementById("aem_location_search_list").innerHTML = response;
			}
		});
	}

	const get_error_name_dropdown_out_search = () => {
		$.ajax({
			url: '../process/error_monitoring/err_mon_g_p.php',
			type: 'GET',
			cache: false,
			data: {
				method: 'get_error_name_dropdown_out_search'
			},  
			success: response => {
				document.getElementById("aem_error_name_search").innerHTML = response;
			}
		});
	}

	var typingTimerAoApplicatorNoSearch;
	var typingTimerAoTerminalNameSearch;
    var typingTimerAoLocationSearch;
    var doneTypingInterval = 250; // Time in ms

    // On keyup, start the countdown
    document.getElementById("aem_applicator_no_search").addEventListener('keyup', e => {
        clearTimeout(typingTimerAoApplicatorNoSearch);
        typingTimerAoApplicatorNoSearch = setTimeout(doneTypingGetRecentApplicatorErrMon, doneTypingInterval);
    });

    // On keydown, clear the countdown
    document.getElementById("aem_applicator_no_search").addEventListener('keydown', e => {
        clearTimeout(typingTimerAoApplicatorNoSearch);
    });

	// On keyup, start the countdown
    document.getElementById("aem_terminal_name_search").addEventListener('keyup', e => {
        clearTimeout(typingTimerAoTerminalNameSearch);
        typingTimerAoTerminalNameSearch = setTimeout(doneTypingGetRecentApplicatorErrMon, doneTypingInterval);
    });

    // On keydown, clear the countdown
    document.getElementById("aem_terminal_name_search").addEventListener('keydown', e => {
        clearTimeout(typingTimerAoTerminalNameSearch);
    });

    // On keyup, start the countdown
    document.getElementById("aem_location_search").addEventListener('keyup', e => {
        clearTimeout(typingTimerAoLocationSearch);
        typingTimerAoLocationSearch = setTimeout(doneTypingGetRecentApplicatorErrMon, doneTypingInterval);
    });

    // On keydown, clear the countdown
    document.getElementById("aem_location_search").addEventListener('keydown', e => {
        clearTimeout(typingTimerAoLocationSearch);
    });

    // User is "finished typing," do something
    const doneTypingGetRecentApplicatorErrMon = () => {
        get_recent_applicator_err_mon();
    }

    const get_recent_applicator_err_mon = () => {
		let car_maker = document.getElementById('aem_car_maker_search').value;
		let car_model = document.getElementById('aem_car_model_search').value;
		let applicator_no = document.getElementById('aem_applicator_no_search').value;
		let terminal_name = document.getElementById('aem_terminal_name_search').value;
		let location = document.getElementById('aem_location_search').value;
		let error_name = document.getElementById('aem_error_name_search').value;

		sessionStorage.setItem('zs_aem_car_maker_search', car_maker);
		sessionStorage.setItem('zs_aem_car_model_search', car_model);
		sessionStorage.setItem('zs_aem_applicator_no_search', applicator_no);
		sessionStorage.setItem('zs_aem_terminal_name_search', terminal_name);
		sessionStorage.setItem('zs_aem_location_search', location);

		$.ajax({
			type: "GET",
			url: "../process/error_monitoring/err_mon_g_p.php",
			cache: false,
			data: {
				method: "get_recent_applicator_out",
				car_maker: car_maker,
				car_model: car_model,
				applicator_no: applicator_no,
				terminal_name: terminal_name,
				location: location,
				error_name: error_name
			},
			success: (response) => {
                $('#recentApplicatorErrMonData').html(response);
				let table_rows = parseInt(document.getElementById("recentApplicatorErrMonData").childNodes.length);
				$('#count_view').html("Total: " + table_rows);
			}
		});
	}

	const export_recent_applicator_err_mon = (table_id, separator = ',') => {
		let car_maker = sessionStorage.getItem('zs_aem_car_maker_search');
		let car_model = sessionStorage.getItem('zs_aem_car_model_search');
		let applicator_no = sessionStorage.getItem('zs_aem_applicator_no_search');
		let terminal_name = sessionStorage.getItem('zs_aem_terminal_name_search');
		let location = sessionStorage.getItem('zs_aem_location_search');

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
        var filename = 'ZaihaiSystem_ApplicatorErrorMonitoring';
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
</script>