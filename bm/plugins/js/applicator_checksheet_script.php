<script type="text/javascript">
    // Global Variables for Realtime
	var realtime_get_recent_applicator_in_pending;

    // DOMContentLoaded function
    document.addEventListener("DOMContentLoaded", () => {
		get_car_maker_dropdown_in_search();
		get_car_model_dropdown_in_search();
		get_applicator_no_datalist_in_search();
		get_terminal_name_datalist_in_search();
		get_location_datalist_in_search();
        get_recent_applicator_in_pending();
        realtime_get_recent_applicator_in_pending = setInterval(get_recent_applicator_in_pending, 15000);
    });

	const get_car_maker_dropdown_in_search = () => {
		$.ajax({
			url: '../process/shop/applicator_in_out/aio_g_p.php',
			type: 'GET',
			cache: false,
			data: {
				method: 'get_car_maker_dropdown_in_search',
				page: 'checksheet'
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
				method: 'get_car_model_dropdown_in_search',
				page: 'checksheet'
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
				method: 'get_applicator_no_datalist_in_search',
				page: 'checksheet'
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
				page: 'checksheet'
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
				page: 'checksheet'
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
        get_recent_applicator_in_pending();
    }

    const get_recent_applicator_in_pending = () => {
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
			url: "../process/inspector/applicator_checksheet/ac_g_p.php",
			cache: false,
			data: {
				method: "get_recent_applicator_in_pending",
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

	const export_recent_applicator_in_pending = (table_id, separator = ',') => {
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
        var filename = 'ZaihaiSystem_ApplicatorInPending';
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

	const get_zaihai_stock_address_dropdown = applicator_no => {
		$.ajax({
			url: '../process/me/applicator/a_g_p.php',
			type: 'GET',
			cache: false,
			data: {
				method: 'get_zaihai_stock_address_dropdown',
				applicator_no: applicator_no
			},  
			success: response => {
				document.getElementById("ai_location").innerHTML = response;
			}
		});
	}

	const get_line_address_dropdown = terminal_name => {
		$.ajax({
			url: '../process/me/terminal/term_g_p.php',
			type: 'GET',
			cache: false,
			data: {
				method: 'get_line_address_dropdown',
				terminal_name: terminal_name
			},  
			success: response => {
				document.getElementById("line_address_ac_i").innerHTML = response;
			}
		});
	}

    const get_applicator_in_pending_details = param => {
        var string = param.split('~!~');
        var applicator_no = string[0];
        var terminal_name = string[1];

		$.ajax({
			type: "GET",
			url: "../process/shop/applicator_in_out/aio_g_p.php",
			cache: false,
			data: {
				method: "get_applicator_in_pending_details",
				applicator_no: applicator_no,
				terminal_name: terminal_name
			},
			success: (response) => {
				try {
                    let response_array = JSON.parse(response);
                    if (response_array.message == 'success') {
                        document.getElementById('serial_no_ac_i').innerHTML = response_array.serial_no;
						document.getElementById('equipment_no_ac_i').innerHTML = response_array.equipment_no;
                        document.getElementById('machine_no_split_ac_i').innerHTML = response_array.applicator_no;
						document.getElementById('machine_no_ac_i').value = applicator_no;
						document.getElementById('terminal_name_ac_i').innerHTML = response_array.terminal_name;
						document.getElementById('inspection_date_time_ac_i').value = response_array.inspection_date_time;
						document.getElementById('inspection_date_ac_i').innerHTML = response_array.inspection_date;
						document.getElementById('inspection_time_ac_i').innerHTML = response_array.inspection_time;
						document.getElementById('inspection_shift_ac_i').innerHTML = response_array.inspection_shift;
						document.getElementById('inspected_by_ac_i').innerHTML = response_array.inspected_by;
						document.getElementById('inspected_by_no_ac_i').value = response_array.inspected_by_no;
						get_zaihai_stock_address_dropdown(applicator_no);
						get_line_address_dropdown(response_array.terminal_name);
						$('#applicator_checksheet').modal("show");
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error !!!',
                            text: 'Error: ' + response_array.message,
                            showConfirmButton: false,
                            timer: 2000
                        });
                        console.log(response);
                    }
                } catch (e) {
                    console.log(response);
                }
			}
		});
	}

	document.getElementById("adjustment_content_ac_i").addEventListener('change', function() {
		var adjustment_content = document.getElementById("adjustment_content_ac_i").value;
		if (adjustment_content != '') {
			document.getElementById("adjustment_content_remarks_ac_i").disabled = false;
		} else {
			document.getElementById("adjustment_content_remarks_ac_i").value = '';
			document.getElementById("adjustment_content_remarks_ac_i").disabled = true;
		}
	});

	$("#applicator_checksheet").on('show.bs.modal', e => {
        load_adjustment_content_remarks_textarea();
    });

    const load_adjustment_content_remarks_textarea = () => {
        setTimeout(() => {
            var max_length = document.getElementById("adjustment_content_remarks_ac_i").getAttribute("maxlength");
            var adjustment_content_remarks_length = document.getElementById("adjustment_content_remarks_ac_i").value.length;
            var adjustment_content_remarks_count = `${adjustment_content_remarks_length} / ${max_length}`;
            document.getElementById("adjustment_content_remarks_ac_i_count").innerHTML = adjustment_content_remarks_count;
        }, 100);
    }

    const count_adjustment_content_remarks_char = () => {
        var max_length = document.getElementById("adjustment_content_remarks_ac_i").getAttribute("maxlength");
        var adjustment_content_remarks_length = document.getElementById("adjustment_content_remarks_ac_i").value.length;
        var adjustment_content_remarks_count = `${adjustment_content_remarks_length} / ${max_length}`;
        document.getElementById("adjustment_content_remarks_ac_i_count").innerHTML = adjustment_content_remarks_count;
    }

	const clear_checked_radio_button = name => {
		var element = document.getElementsByName(name);
		for (var i = 0; i < element.length; i++) {
			element[i].checked = false;
		}
	}

	// Radio Button Value Checker 1
	var cont_1_ac_i = document.getElementsByName("cont_1_ac_i");
	var prev_cont_1_ac_i = null;
	for (var i = 0; i < cont_1_ac_i.length; i++) {
		cont_1_ac_i[i].addEventListener('change', function() {
			if (this !== prev_cont_1_ac_i) {
				prev_cont_1_ac_i = this;
			}
			document.getElementById("cont_1s_ac_i").value = '';
			document.getElementById("cont_1r_ac_i").value = '';
			if (this.value == 2) {
				document.getElementById("cont_1s_ac_i").disabled = false;
				document.getElementById("cont_1r_ac_i").disabled = false;
			} else if (this.value == 3) {
				document.getElementById("cont_1s_ac_i").disabled = true;
				document.getElementById("cont_1r_ac_i").disabled = false;
			} else {
				document.getElementById("cont_1s_ac_i").disabled = true;
				document.getElementById("cont_1r_ac_i").disabled = true;
			}
		});
	}

	// Radio Button Value Checker 2
	var cont_2_ac_i = document.getElementsByName("cont_2_ac_i");
	var prev_cont_2_ac_i = null;
	for (var i = 0; i < cont_2_ac_i.length; i++) {
		cont_2_ac_i[i].addEventListener('change', function() {
			if (this !== prev_cont_2_ac_i) {
				prev_cont_2_ac_i = this;
			}
			document.getElementById("cont_2s_ac_i").value = '';
			document.getElementById("cont_2r_ac_i").value = '';
			if (this.value == 2) {
				document.getElementById("cont_2s_ac_i").disabled = false;
				document.getElementById("cont_2r_ac_i").disabled = false;
			} else if (this.value == 3) {
				document.getElementById("cont_2s_ac_i").disabled = true;
				document.getElementById("cont_2r_ac_i").disabled = false;
			} else {
				document.getElementById("cont_2s_ac_i").disabled = true;
				document.getElementById("cont_2r_ac_i").disabled = true;
			}
		});
	}

	// Radio Button Value Checker 3
	var cont_3_ac_i = document.getElementsByName("cont_3_ac_i");
	var prev_cont_3_ac_i = null;
	for (var i = 0; i < cont_3_ac_i.length; i++) {
		cont_3_ac_i[i].addEventListener('change', function() {
			if (this !== prev_cont_3_ac_i) {
				prev_cont_3_ac_i = this;
			}
			document.getElementById("cont_3s_ac_i").value = '';
			document.getElementById("cont_3r_ac_i").value = '';
			if (this.value == 2) {
				document.getElementById("cont_3s_ac_i").disabled = false;
				document.getElementById("cont_3r_ac_i").disabled = false;
			} else if (this.value == 3) {
				document.getElementById("cont_3s_ac_i").disabled = true;
				document.getElementById("cont_3r_ac_i").disabled = false;
			} else {
				document.getElementById("cont_3s_ac_i").disabled = true;
				document.getElementById("cont_3r_ac_i").disabled = true;
			}
		});
	}

	// Radio Button Value Checker 4
	var cont_4_ac_i = document.getElementsByName("cont_4_ac_i");
	var prev_cont_4_ac_i = null;
	for (var i = 0; i < cont_4_ac_i.length; i++) {
		cont_4_ac_i[i].addEventListener('change', function() {
			if (this !== prev_cont_4_ac_i) {
				prev_cont_4_ac_i = this;
			}
			document.getElementById("cont_4s_ac_i").value = '';
			document.getElementById("cont_4r_ac_i").value = '';
			if (this.value == 2) {
				document.getElementById("cont_4s_ac_i").disabled = false;
				document.getElementById("cont_4r_ac_i").disabled = false;
			} else if (this.value == 3) {
				document.getElementById("cont_4s_ac_i").disabled = true;
				document.getElementById("cont_4r_ac_i").disabled = false;
			} else {
				document.getElementById("cont_4s_ac_i").disabled = true;
				document.getElementById("cont_4r_ac_i").disabled = true;
			}
		});
	}

	// Radio Button Value Checker 5
	var cont_5_ac_i = document.getElementsByName("cont_5_ac_i");
	var prev_cont_5_ac_i = null;
	for (var i = 0; i < cont_5_ac_i.length; i++) {
		cont_5_ac_i[i].addEventListener('change', function() {
			if (this !== prev_cont_5_ac_i) {
				prev_cont_5_ac_i = this;
			}
			document.getElementById("cont_5s_ac_i").value = '';
			document.getElementById("cont_5r_ac_i").value = '';
			if (this.value == 2) {
				document.getElementById("cont_5s_ac_i").disabled = false;
				document.getElementById("cont_5r_ac_i").disabled = false;
			} else if (this.value == 3) {
				document.getElementById("cont_5s_ac_i").disabled = true;
				document.getElementById("cont_5r_ac_i").disabled = false;
			} else {
				document.getElementById("cont_5s_ac_i").disabled = true;
				document.getElementById("cont_5r_ac_i").disabled = true;
			}
		});
	}

	// Radio Button Value Checker 6
	var cont_6_ac_i = document.getElementsByName("cont_6_ac_i");
	var prev_cont_6_ac_i = null;
	for (var i = 0; i < cont_6_ac_i.length; i++) {
		cont_6_ac_i[i].addEventListener('change', function() {
			if (this !== prev_cont_6_ac_i) {
				prev_cont_6_ac_i = this;
			}
			document.getElementById("cont_6s_ac_i").value = '';
			document.getElementById("cont_6r_ac_i").value = '';
			if (this.value == 2) {
				document.getElementById("cont_6s_ac_i").disabled = false;
				document.getElementById("cont_6r_ac_i").disabled = false;
			} else if (this.value == 3) {
				document.getElementById("cont_6s_ac_i").disabled = true;
				document.getElementById("cont_6r_ac_i").disabled = false;
			} else {
				document.getElementById("cont_6s_ac_i").disabled = true;
				document.getElementById("cont_6r_ac_i").disabled = true;
			}
		});
	}

	// Radio Button Value Checker 7
	var cont_7_ac_i = document.getElementsByName("cont_7_ac_i");
	var prev_cont_7_ac_i = null;
	for (var i = 0; i < cont_7_ac_i.length; i++) {
		cont_7_ac_i[i].addEventListener('change', function() {
			if (this !== prev_cont_7_ac_i) {
				prev_cont_7_ac_i = this;
			}
			document.getElementById("cont_7s_ac_i").value = '';
			document.getElementById("cont_7r_ac_i").value = '';
			if (this.value == 2) {
				document.getElementById("cont_7s_ac_i").disabled = false;
				document.getElementById("cont_7r_ac_i").disabled = false;
			} else if (this.value == 3) {
				document.getElementById("cont_7s_ac_i").disabled = true;
				document.getElementById("cont_7r_ac_i").disabled = false;
			} else {
				document.getElementById("cont_7s_ac_i").disabled = true;
				document.getElementById("cont_7r_ac_i").disabled = true;
			}
		});
	}

	// Radio Button Value Checker 8
	var cont_8_ac_i = document.getElementsByName("cont_8_ac_i");
	var prev_cont_8_ac_i = null;
	for (var i = 0; i < cont_8_ac_i.length; i++) {
		cont_8_ac_i[i].addEventListener('change', function() {
			if (this !== prev_cont_8_ac_i) {
				prev_cont_8_ac_i = this;
			}
			document.getElementById("cont_8s_ac_i").value = '';
			document.getElementById("cont_8r_ac_i").value = '';
			if (this.value == 2) {
				document.getElementById("cont_8s_ac_i").disabled = false;
				document.getElementById("cont_8r_ac_i").disabled = false;
			} else if (this.value == 3) {
				document.getElementById("cont_8s_ac_i").disabled = true;
				document.getElementById("cont_8r_ac_i").disabled = false;
			} else {
				document.getElementById("cont_8s_ac_i").disabled = true;
				document.getElementById("cont_8r_ac_i").disabled = true;
			}
		});
	}

	// Radio Button Value Checker 9
	var cont_9_ac_i = document.getElementsByName("cont_9_ac_i");
	var prev_cont_9_ac_i = null;
	for (var i = 0; i < cont_9_ac_i.length; i++) {
		cont_9_ac_i[i].addEventListener('change', function() {
			if (this !== prev_cont_9_ac_i) {
				prev_cont_9_ac_i = this;
			}
			document.getElementById("cont_9s_ac_i").value = '';
			document.getElementById("cont_9r_ac_i").value = '';
			if (this.value == 2) {
				document.getElementById("cont_9s_ac_i").disabled = false;
				document.getElementById("cont_9r_ac_i").disabled = false;
			} else if (this.value == 3) {
				document.getElementById("cont_9s_ac_i").disabled = true;
				document.getElementById("cont_9r_ac_i").disabled = false;
			} else {
				document.getElementById("cont_9s_ac_i").disabled = true;
				document.getElementById("cont_9r_ac_i").disabled = true;
			}
		});
	}

	// Radio Button Value Checker 10
	var cont_10_ac_i = document.getElementsByName("cont_10_ac_i");
	var prev_cont_10_ac_i = null;
	for (var i = 0; i < cont_10_ac_i.length; i++) {
		cont_10_ac_i[i].addEventListener('change', function() {
			if (this !== prev_cont_10_ac_i) {
				prev_cont_10_ac_i = this;
			}
			document.getElementById("cont_10s_ac_i").value = '';
			document.getElementById("cont_10r_ac_i").value = '';
			if (this.value == 2) {
				document.getElementById("cont_10s_ac_i").disabled = false;
				document.getElementById("cont_10r_ac_i").disabled = false;
			} else if (this.value == 3) {
				document.getElementById("cont_10s_ac_i").disabled = true;
				document.getElementById("cont_10r_ac_i").disabled = false;
			} else {
				document.getElementById("cont_10s_ac_i").disabled = true;
				document.getElementById("cont_10r_ac_i").disabled = true;
			}
		});
	}

	$("#applicator_checksheet").on('hidden.bs.modal', e => {
		var radio_button_arr = ["cont_1_ac_i", "cont_2_ac_i", "cont_3_ac_i", "cont_4_ac_i", "cont_5_ac_i", "cont_6_ac_i", "cont_7_ac_i", "cont_8_ac_i", "cont_9_ac_i", "cont_10_ac_i"];
		for (var i = 0; i < radio_button_arr.length; i++) {
			clear_checked_radio_button(radio_button_arr[i]);
		}

		var radio_button_arr = ["cont_1s_ac_i", "cont_2s_ac_i", "cont_3s_ac_i", "cont_4s_ac_i", "cont_5s_ac_i", "cont_6s_ac_i", "cont_7s_ac_i", "cont_8s_ac_i", "cont_9s_ac_i", "cont_10s_ac_i"];
		for (var i = 0; i < radio_button_arr.length; i++) {
			document.getElementById(radio_button_arr[i]).value = '';
			document.getElementById(radio_button_arr[i]).disabled = true;
		}

		var radio_button_arr = ["cont_1r_ac_i", "cont_2r_ac_i", "cont_3r_ac_i", "cont_4r_ac_i", "cont_5r_ac_i", "cont_6r_ac_i", "cont_7r_ac_i", "cont_8r_ac_i", "cont_9r_ac_i", "cont_10r_ac_i"];
		for (var i = 0; i < radio_button_arr.length; i++) {
			document.getElementById(radio_button_arr[i]).value = '';
			document.getElementById(radio_button_arr[i]).disabled = true;
		}

        document.getElementById('adjustment_content_remarks_ac_i').value = '';
		clear_checked_radio_button("cross_section_result_ac_i");
    });

	document.getElementById('applicator_checksheet_form').addEventListener('submit', e => {
        e.preventDefault();
        make_checksheet();
    });

	const get_checked_radio_button = name => {
		var element = document.getElementsByName(name);
		var value = '';
		for (var i = 0; i < element.length; i++) {
			if (element[i].checked)
				value = element[i].value;
		}
		return value;
	}

	const make_checksheet = () => {
		let location = document.getElementById("ai_location").value;
		let line_address = document.getElementById("line_address_ac_i").value;
		let applicator_no = document.getElementById("machine_no_ac_i").value;
		let terminal_name = document.getElementById("terminal_name_ac_i").innerHTML;

		let serial_no = document.getElementById("serial_no_ac_i").innerHTML;
		let equipment_no = document.getElementById("equipment_no_ac_i").innerHTML;
		let inspection_date_time = document.getElementById("inspection_date_time_ac_i").value;
		let inspection_shift = document.getElementById("inspection_shift_ac_i").innerHTML;

		let ac1 = parseInt(get_checked_radio_button("cont_1_ac_i"));
		let ac2 = parseInt(get_checked_radio_button("cont_2_ac_i"));
		let ac3 = parseInt(get_checked_radio_button("cont_3_ac_i"));
		let ac4 = parseInt(get_checked_radio_button("cont_4_ac_i"));
		let ac5 = parseInt(get_checked_radio_button("cont_5_ac_i"));
		let ac6 = parseInt(get_checked_radio_button("cont_6_ac_i"));
		let ac7 = parseInt(get_checked_radio_button("cont_7_ac_i"));
		let ac8 = parseInt(get_checked_radio_button("cont_8_ac_i"));
		let ac9 = parseInt(get_checked_radio_button("cont_9_ac_i"));
		let ac10 = parseInt(get_checked_radio_button("cont_10_ac_i"));

		let ac1_s = document.getElementById("cont_1s_ac_i").value;
		let ac2_s = document.getElementById("cont_2s_ac_i").value;
		let ac3_s = document.getElementById("cont_3s_ac_i").value;
		let ac4_s = document.getElementById("cont_4s_ac_i").value;
		let ac5_s = document.getElementById("cont_5s_ac_i").value;
		let ac6_s = document.getElementById("cont_6s_ac_i").value;
		let ac7_s = document.getElementById("cont_7s_ac_i").value;
		let ac8_s = document.getElementById("cont_8s_ac_i").value;
		let ac9_s = document.getElementById("cont_9s_ac_i").value;
		let ac10_s = document.getElementById("cont_10s_ac_i").value;

		let ac1_r = document.getElementById("cont_1r_ac_i").value;
		let ac2_r = document.getElementById("cont_2r_ac_i").value;
		let ac3_r = document.getElementById("cont_3r_ac_i").value;
		let ac4_r = document.getElementById("cont_4r_ac_i").value;
		let ac5_r = document.getElementById("cont_5r_ac_i").value;
		let ac6_r = document.getElementById("cont_6r_ac_i").value;
		let ac7_r = document.getElementById("cont_7r_ac_i").value;
		let ac8_r = document.getElementById("cont_8r_ac_i").value;
		let ac9_r = document.getElementById("cont_9r_ac_i").value;
		let ac10_r = document.getElementById("cont_10r_ac_i").value;

		let adjustment_content = document.getElementById("adjustment_content_ac_i").value;
		let adjustment_content_remarks = document.getElementById("adjustment_content_remarks_ac_i").value;
		let cross_section_result = parseInt(get_checked_radio_button("cross_section_result_ac_i"));
		let inspected_by = document.getElementById("inspected_by_ac_i").innerHTML;
		let inspected_by_no = document.getElementById("inspected_by_no_ac_i").value;

		document.getElementById("btnMakeAc").disabled = true;

		$.ajax({
			type: "POST",
			url: "../process/inspector/applicator_checksheet/ac_p.php",
			cache: false,
			data: {
				method: "make_checksheet",
				location: location,
				line_address: line_address,
				applicator_no: applicator_no,
				terminal_name: terminal_name,
				serial_no: serial_no,
				equipment_no: equipment_no,
				inspection_date_time: inspection_date_time,
				inspection_shift: inspection_shift,
				adjustment_content: adjustment_content,
				adjustment_content_remarks: adjustment_content_remarks,
				cross_section_result: cross_section_result,
				inspected_by: inspected_by,
				inspected_by_no: inspected_by_no,
				ac1: ac1,
				ac2: ac2,
				ac3: ac3,
				ac4: ac4,
				ac5: ac5,
				ac6: ac6,
				ac7: ac7,
				ac8: ac8,
				ac9: ac9,
				ac10: ac10,
				ac1_s: ac1_s,
				ac2_s: ac2_s,
				ac3_s: ac3_s,
				ac4_s: ac4_s,
				ac5_s: ac5_s,
				ac6_s: ac6_s,
				ac7_s: ac7_s,
				ac8_s: ac8_s,
				ac9_s: ac9_s,
				ac10_s: ac10_s,
				ac1_r: ac1_r,
				ac2_r: ac2_r,
				ac3_r: ac3_r,
				ac4_r: ac4_r,
				ac5_r: ac5_r,
				ac6_r: ac6_r,
				ac7_r: ac7_r,
				ac8_r: ac8_r,
				ac9_r: ac9_r,
				ac10_r: ac10_r
			},
			success: (response) => {
				if (response == 'success') {
					$('#applicator_checksheet').modal("hide");
					get_recent_applicator_in_pending();
					Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Make Checksheet Done Succesfully!!!',
                        showConfirmButton: false,
                        timer: 2000
                    });
				} else {
					Swal.fire({
                        icon: 'error',
                        title: 'Error !!!',
                        text: 'Error: ' + response,
                        showConfirmButton: false,
                        timer: 2000
                    });
				}
				document.getElementById("btnMakeAc").disabled = false;
			}
		});
	}
</script>