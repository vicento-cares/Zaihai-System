<script type="text/javascript">
    // Global Variables for Realtime
	var realtime_get_recent_applicator_in;

	// DOMContentLoaded function
	document.addEventListener("DOMContentLoaded", () => {
		get_car_maker_dropdown_in_search();
		get_car_model_dropdown_in_search();
		get_applicator_no_datalist_in_search();
		get_terminal_name_datalist_in_search();
		get_location_datalist_in_search();
		get_recent_applicator_in();
		realtime_get_recent_applicator_in = setInterval(get_recent_applicator_in, 10000);
	});

	const get_car_maker_dropdown_in_search = () => {
		$.ajax({
			url: '../process/shop/applicator_in_out/aio_g_p.php',
			type: 'GET',
			cache: false,
			data: {
				method: 'get_car_maker_dropdown_in_search'
			},  
			success: response => {
				document.getElementById("ai_car_maker_search").innerHTML = response;
			}
		});
	}

	const get_car_model_dropdown_in_search = () => {
		$.ajax({
			url: '../process/shop/applicator_in_out/aio_g_p.php',
			type: 'GET',
			cache: false,
			data: {
				method: 'get_car_model_dropdown_in_search'
			},  
			success: response => {
				document.getElementById("ai_car_model_search").innerHTML = response;
			}
		});
	}

	const get_applicator_no_datalist_in_search = () => {
		$.ajax({
			url: '../process/shop/applicator_in_out/aio_g_p.php',
			type: 'GET',
			cache: false,
			data: {
				method: 'get_applicator_no_datalist_in_search'
			},  
			success: response => {
				document.getElementById("ai_applicator_no_search_list").innerHTML = response;
			}
		});
	}

	const get_terminal_name_datalist_in_search = () => {
		$.ajax({
			url: '../process/shop/applicator_in_out/aio_g_p.php',
			type: 'GET',
			cache: false,
			data: {
				method: 'get_terminal_name_datalist_in_search'
			},  
			success: response => {
				document.getElementById("ai_terminal_name_search_list").innerHTML = response;
			}
		});
	}

	const get_location_datalist_in_search = () => {
		$.ajax({
			url: '../process/shop/applicator_in_out/aio_g_p.php',
			type: 'GET',
			cache: false,
			data: {
				method: 'get_location_datalist_in_search'
			},  
			success: response => {
				document.getElementById("ai_location_search_list").innerHTML = response;
			}
		});
	}

	var typingTimerAiApplicatorNoSearch;
	var typingTimerAiTerminalNameSearch;
    var typingTimerAiLocationSearch;
    var doneTypingInterval = 250; // Time in ms

    // On keyup, start the countdown
    document.getElementById("ai_applicator_no_search").addEventListener('keyup', e => {
        clearTimeout(typingTimerAiApplicatorNoSearch);
        typingTimerAiApplicatorNoSearch = setTimeout(doneTypingGetRecentApplicatorIn, doneTypingInterval);
    });

    // On keydown, clear the countdown
    document.getElementById("ai_applicator_no_search").addEventListener('keydown', e => {
        clearTimeout(typingTimerAiApplicatorNoSearch);
    });

	// On keyup, start the countdown
    document.getElementById("ai_terminal_name_search").addEventListener('keyup', e => {
        clearTimeout(typingTimerAiTerminalNameSearch);
        typingTimerAiTerminalNameSearch = setTimeout(doneTypingGetRecentApplicatorIn, doneTypingInterval);
    });

    // On keydown, clear the countdown
    document.getElementById("ai_terminal_name_search").addEventListener('keydown', e => {
        clearTimeout(typingTimerAiTerminalNameSearch);
    });

    // On keyup, start the countdown
    document.getElementById("ai_location_search").addEventListener('keyup', e => {
        clearTimeout(typingTimerAiLocationSearch);
        typingTimerAiLocationSearch = setTimeout(doneTypingGetRecentApplicatorIn, doneTypingInterval);
    });

    // On keydown, clear the countdown
    document.getElementById("ai_location_search").addEventListener('keydown', e => {
        clearTimeout(typingTimerAiLocationSearch);
    });

    // User is "finished typing," do something
    const doneTypingGetRecentApplicatorIn = () => {
        get_recent_applicator_in();
    }

    const get_recent_applicator_in = () => {
		let car_maker = document.getElementById('ai_car_maker_search').value;
		let car_model = document.getElementById('ai_car_model_search').value;
		let applicator_no = document.getElementById('ai_applicator_no_search').value;
		let terminal_name = document.getElementById('ai_terminal_name_search').value;
		let location = document.getElementById('ai_location_search').value;

		sessionStorage.setItem('zs_ai_car_maker_search', car_maker);
		sessionStorage.setItem('zs_ai_car_model_search', car_model);
		sessionStorage.setItem('zs_ai_applicator_no_search', applicator_no);
		sessionStorage.setItem('zs_ai_terminal_name_search', terminal_name);
		sessionStorage.setItem('zs_ai_location_search', location);

		$.ajax({
			type: "GET",
			url: "../process/shop/applicator_in_out/aio_g_p.php",
			cache: false,
			data: {
				method: "get_recent_applicator_in",
				car_maker: car_maker,
				car_model: car_model,
				applicator_no: applicator_no,
				terminal_name: terminal_name,
				location: location
			},
			success: (response) => {
                $('#recentApplicatorInData').html(response);
				let table_rows = parseInt(document.getElementById("recentApplicatorInData").childNodes.length);
				$('#count_view').html("Total: " + table_rows);
			}
		});
	}

	const export_recent_applicator_in = (table_id, separator = ',') => {
		let car_maker = sessionStorage.getItem('zs_ai_car_maker_search');
		let car_model = sessionStorage.getItem('zs_ai_car_model_search');
		let applicator_no = sessionStorage.getItem('zs_ai_applicator_no_search');
		let terminal_name = sessionStorage.getItem('zs_ai_terminal_name_search');
		let location = sessionStorage.getItem('zs_ai_location_search');

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
        var filename = 'ZaihaiSystem_ApplicatorIn';
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