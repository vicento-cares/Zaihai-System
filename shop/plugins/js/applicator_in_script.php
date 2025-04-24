<script type="text/javascript">
    // Global Variables for Realtime
	var realtime_get_recent_applicator_in;

	// DOMContentLoaded function
	document.addEventListener("DOMContentLoaded", () => {
		// get_car_maker_dropdown_in_search();
		// get_car_model_dropdown_in_search();
		get_applicator_no_datalist_in_search();
		get_terminal_name_datalist_in_search();
		get_location_datalist_in_search();
		get_borrowed_by_dropdown();
		get_recent_applicator_in();
		realtime_get_recent_applicator_in = setInterval(get_recent_applicator_in, 30000);
	});

	// const get_car_maker_dropdown_in_search = () => {
	// 	$.ajax({
	// 		url: '../process/shop/applicator_in_out/aio_g_p.php',
	// 		type: 'GET',
	// 		cache: false,
	// 		data: {
	// 			method: 'get_car_maker_dropdown_in_search'
	// 		},  
	// 		success: response => {
	// 			document.getElementById("ai_car_maker_search").innerHTML = response;
	// 		}
	// 	});
	// }

	// const get_car_model_dropdown_in_search = () => {
	// 	$.ajax({
	// 		url: '../process/shop/applicator_in_out/aio_g_p.php',
	// 		type: 'GET',
	// 		cache: false,
	// 		data: {
	// 			method: 'get_car_model_dropdown_in_search'
	// 		},  
	// 		success: response => {
	// 			document.getElementById("ai_car_model_search").innerHTML = response;
	// 		}
	// 	});
	// }

	const get_applicator_no_datalist_in_search = () => {
		$.ajax({
			url: '../process/shop/applicator_in_out/aio_g_p.php',
			type: 'GET',
			cache: false,
			data: {
				method: 'get_applicator_no_datalist_in_search',
				page: 'shop'
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
				method: 'get_terminal_name_datalist_in_search',
				page: 'shop'
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
				method: 'get_location_datalist_in_search',
				page: 'shop'
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
				location: location,
				page: 'shop'
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

	$('#applicator_in').on('show.bs.modal', function (e) {
		setTimeout(() => {
			document.getElementById("ai_location_before").focus();
		}, 200);
	});

	$('#applicator_in').on('hidden.bs.modal', function (e) {
		document.getElementById('ai_opt_scan').checked = true;
		document.getElementById('ai_opt_scan_div').classList.remove('d-none');
		document.getElementById('ai_opt_borrowed_div').classList.add('d-none');
		document.getElementById("ai_borrowed_by_location").value = '';
		document.getElementById("ai_borrowed_by_remarks").value = '';
		reset_applicator_in_fields(1);
		document.getElementById("ai_applicator_no").disabled = true;
		document.getElementById("ai_terminal_name").disabled = true;
	});

	const get_borrowed_by_dropdown = () => {
		$.ajax({
			url: '../process/me/car_maker/cm_g_p.php',
			type: 'GET',
			cache: false,
			data: {
				method: 'get_borrowed_by_dropdown'
			},  
			success: response => {
				document.getElementById("ai_borrowed_by_location").innerHTML = response;
			}
		});
	}

	const toggle_opt_divs = () => {
		const scanDiv = document.getElementById('ai_opt_scan_div');
		const borrowedDiv = document.getElementById('ai_opt_borrowed_div');
		
		const ai_location_before = document.getElementById("ai_location_before").value;
		const ai_borrowed_by_location = document.getElementById("ai_borrowed_by_location").value;
		const ai_borrowed_by_remarks = document.getElementById("ai_borrowed_by_remarks").value;
		const ai_applicator_no = document.getElementById("ai_applicator_no").value;
		const ai_terminal_name = document.getElementById("ai_terminal_name").value;

		// Check if any of the input fields have a value
		const hasValue = ai_location_before || ai_borrowed_by_location || ai_borrowed_by_remarks || ai_applicator_no || ai_terminal_name;

		if (hasValue) {
			if (document.getElementById('ai_opt_scan').checked) {
				scanDiv.classList.remove('d-none');
				borrowedDiv.classList.add('d-none');
				document.getElementById("ai_borrowed_by_location").value = '';
				document.getElementById("ai_borrowed_by_remarks").value = '';
				reset_applicator_in_fields(1);
				document.getElementById("ai_applicator_no").disabled = true;
				document.getElementById("ai_terminal_name").disabled = true;
			} else if (document.getElementById('ai_opt_borrowed').checked) {
				document.getElementById('ai_opt_scan').checked = true;
				document.getElementById('ai_opt_borrowed').checked = false;
			}
		} else {
			if (document.getElementById('ai_opt_scan').checked) {
				scanDiv.classList.remove('d-none');
				borrowedDiv.classList.add('d-none');
				document.getElementById("ai_applicator_no").disabled = true;
				document.getElementById("ai_location_before").focus();
			} else if (document.getElementById('ai_opt_borrowed').checked) {
				scanDiv.classList.add('d-none');
				borrowedDiv.classList.remove('d-none');
				document.getElementById("ai_applicator_no").disabled = false;
			}
		}
	}

	var delay = (function () {
        var timer = 0;
        return function (callback, ms) {
            clearTimeout(timer);
            timer = setTimeout(callback, ms);
        };
    })();

	sessionStorage.setItem('zs_ai_location_before', '');
	sessionStorage.setItem('zs_ai_applicator_no', '');
	sessionStorage.setItem('zs_ai_terminal_name', '');

	document.getElementById("ai_location_before").addEventListener("input", e => {
		delay(function () {
			if (document.getElementById("ai_location_before").value.length < 256) {
				document.getElementById("ai_location_before").value = "";
			}
			let ai_location_before = sessionStorage.getItem('zs_ai_location_before');
			if (ai_location_before != '') {
				document.getElementById("ai_location_before").value = ai_location_before;
				sessionStorage.setItem('zs_ai_location_before', '');
			}
		}, 150);
	});

	document.getElementById("ai_location_before").addEventListener("change", e => {
		e.preventDefault();
		sessionStorage.setItem('zs_ai_location_before', e.target.value);
		document.getElementById("ai_location_before").disabled = true;
		document.getElementById("ai_applicator_no").disabled = false;
		document.getElementById("ai_applicator_no").focus();
	});

	// Get references to the select elements
	const borrowedBySelect = document.getElementById("ai_borrowed_by_location");
	const remarksSelect = document.getElementById("ai_borrowed_by_remarks");

	// Function to check if both selects have values
	function checkSelects() {
		if (borrowedBySelect.value && remarksSelect.value) {
			document.getElementById("ai_applicator_no").focus();
		}
	}

	// Add event listeners to both select elements
	borrowedBySelect.addEventListener("change", checkSelects);
	remarksSelect.addEventListener("change", checkSelects);

	document.getElementById("ai_applicator_no").addEventListener("input", e => {
		delay(function () {
            if (document.getElementById("ai_applicator_no").value.length < 256) {
                document.getElementById("ai_applicator_no").value = "";
            }
			let ai_applicator_no = sessionStorage.getItem('zs_ai_applicator_no');
			if (ai_applicator_no != '') {
				document.getElementById("ai_applicator_no").value = ai_applicator_no;
				sessionStorage.setItem('zs_ai_applicator_no', '');
			}
        }, 130);
	});

	document.getElementById("ai_applicator_no").addEventListener("change", e => {
		e.preventDefault();
		sessionStorage.setItem('zs_ai_applicator_no', e.target.value);
		document.getElementById("ai_applicator_no").disabled = true;
		document.getElementById("ai_terminal_name").disabled = false;
		document.getElementById("ai_terminal_name").focus();
	});

	document.getElementById("ai_terminal_name").addEventListener("input", e => {
		delay(function () {
            if (document.getElementById("ai_terminal_name").value.length < 256) {
                document.getElementById("ai_terminal_name").value = "";
            }
			let ai_terminal_name = sessionStorage.getItem('zs_ai_terminal_name');
			if (ai_terminal_name != '') {
				document.getElementById("ai_terminal_name").value = ai_terminal_name;
				sessionStorage.setItem('zs_ai_terminal_name', '');
			}
        }, 130);
	});

	document.getElementById("ai_terminal_name").addEventListener("change", e => {
		e.preventDefault();
		sessionStorage.setItem('zs_ai_terminal_name', e.target.value);
		document.getElementById("ai_terminal_name").disabled = true;
		in_applicator();
	});

	const reset_applicator_in_fields = opt => {
		document.getElementById("ai_location_before").value = '';
		document.getElementById("ai_applicator_no").value = '';
		document.getElementById("ai_terminal_name").value = '';
		sessionStorage.setItem('zs_ai_terminal_name', '');
		if (opt == 1) {
			document.getElementById("ai_location_before").disabled = false;
			document.getElementById("ai_location_before").focus();
		} else if (opt == 2) {
			document.getElementById("ai_applicator_no").disabled = false;
			document.getElementById("ai_applicator_no").focus();
		}
	}

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

	const get_checked_radio_button = name => {
		var element = document.getElementsByName(name);
		var value = '';
		for (var i = 0; i < element.length; i++) {
			if (element[i].checked)
				value = element[i].value;
		}
		return value;
	}

	const in_applicator = () => {
		let location_before = "";
		let opt = parseInt(get_checked_radio_button("ai_opt"));

		if (opt == 1) {
			location_before = document.getElementById("ai_location_before").value;
		} else if (opt == 2) {
			let ai_borrowed_by_location = document.getElementById("ai_borrowed_by_location").value;
			let ai_borrowed_by_remarks = document.getElementById("ai_borrowed_by_remarks").value;
			if (ai_borrowed_by_location != '' && ai_borrowed_by_remarks != '') {
				location_before = "Borrowed By " + ai_borrowed_by_location + " " + ai_borrowed_by_remarks;
			}
		}

		let applicator_no = document.getElementById("ai_applicator_no").value;
		let terminal_name = document.getElementById("ai_terminal_name").value;

		$.ajax({
			type: "POST",
			url: "../process/shop/applicator_in_out/aio_p.php",
			cache: false,
			data: {
				method: "in_applicator",
				location_before: location_before,
				applicator_no: applicator_no,
				terminal_name: terminal_name
			},
			success: (response) => {
				if (response == 'success') {
					get_recent_applicator_in();
					display_applicator_in_out_result('in_applicator_result', '', 'Pending Applicator In Succesfully!!!');
				} else {
					display_applicator_in_out_result('in_applicator_result', 'error', response);
				}
				reset_applicator_in_fields(opt);
			}
		});
	}
</script>